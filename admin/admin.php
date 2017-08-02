<?php
 /**
  * Class to implement ProjectManager Administration panel
  *
  * @author Kolja Schleich
  * @package ProjectManager
  * @subpackage ProjectManagerAdmin
  */
class ProjectManagerAdmin extends ProjectManager {
	/**
	 * project ID
	 *
	 * @var int
	 */
	private $project_id = 0;
	
	/**
	 * map update schedule
	 *
	 * @param string
	 */
	private $map_update_schedule;
	
	/**
	 * dataset ID
	 *
	 * @var int
	 */
	private $dataset_id = false;
	
	
	/**
	 * load admin area
	 *
	 * @param boolean $init
	 */
	public function __construct($init=true) {
		parent::__construct($init);
		
		/*
		 * Profile Hook
		 *
		 * 1) Add dataset upon user registration
		 * 2) Add dataset form to own and other profile pages
		 * 3) Update dataset upon saving profile (own and others)
		 */
		add_action( 'show_user_profile', array(&$this, 'profileHook') );
		add_action( 'edit_user_profile', array(&$this, 'profileHook') );
		add_action( 'personal_options_update', array($this, 'updateProfile') );
		add_action( 'edit_user_profile_update', array($this, 'updateProfile') );
		
		require_once( ABSPATH . 'wp-admin/includes/template.php' );
		add_action( 'admin_menu', array(&$this, 'menu') );
		
		//add_action('admin_enqueue_scripts', array(&$this, 'loadScripts') );
		add_action('admin_enqueue_scripts', array(&$this, 'loadStyles'), 1 );
		add_action('wp_dashboard_setup', array( $this, 'registerDashboardWidget'));
		
		// add cron schedules
		add_filter( 'cron_schedules', array( &$this, 'addCronSchedules' ) ); 
		
		// add admin notices
		add_action('admin_notices', array(&$this, 'showAdminNotices'));
		
		// cleanup backups that are older than 24 hours
		wp_mkdir_p( $this->getBackupPath() );
		$this->cleanupOldFiles($this->getBackupPath(), 24);
	}
	

	/**
	 * show admin notices about recommended plugins
	 *
	 */
	public function showAdminNotices() {
		$options = get_option('projectmanager');
		$plugin_messages = array();
		
		// Save ignored notices
		if ( !isset($options['ignore_notices']) ) $options['ignore_notices'] = array();
		if ( isset($_GET['projectmanager_ignore_notice']) ) {
			$options['ignore_notices'][] = $_GET['projectmanager_ignore_notice'];
		}
		
		// Fancy Slideshows
		if( !is_plugin_active("sponsors-slideshow-widget/sponsors-slideshow-widget.php") ) {
			$plugin_messages['slideshows'] = sprintf(__( "You can extend ProjectManager with fancy slideshows by using the <a href='%s' target='_blank'>Fancy Slideshows Plugin</a>. (<a href='%s'>Ignore</a>)", 'projectmanager' ), 'https://wordpress.org/plugins/sponsors-slideshow-widget/', admin_url()."index.php?projectmanager_ignore_notice=slideshows");
		}
		
		// Display notifications
		if( count($plugin_messages) > 0 ) {
			foreach($plugin_messages as $key => $message) {
				if ( !in_array($key, $options['ignore_notices']) )
					echo '<div class="update-nag"><p><strong>'.$message.'</strong></p></div>';
			}
		}
		
		// update option with ignored notices
		update_option('projectmanager', $options);
	}
	
	
	/**
	 * add cron schedules
	 *
	 * @param arry $schedules
	 * @return array
	 */
	public function addCronSchedules( $schedules ) {
		// add a 'weekly' interval
		$schedules['weekly'] = array(
			'interval' => 604800,
			'display' => __('Once Weekly', 'projectmanager')
		);
		// add a 'monthly' interval
		$schedules['monthly'] = array(
			'interval' => 2635200,
			'display' => __('Once a month', 'projectmanager')
		);
		return $schedules;
	}
	
	
	/**
	 * retrieve path to project backups
	 *
	 * @param string|false $file
	 * @return string
	 */
	public function getBackupPath( $file = false ) {
		$base = WP_CONTENT_DIR.'/uploads/projects/backups';
		if ( $file )
			return $base .'/'. basename($file);
		else
			return $base;
	}
	
	
	/**
	 * get admin menu for subpage
	 *
	 * @return array
	 */
	public function getMenu() {
		$project = get_project();
		
		$menu = array(
			'settings' => array( 'title' => __( 'Settings', 'projectmanager' ), 'cap' => 'edit_projects_settings', 'page' => 'project-settings_%d' ),
			'formfields' => array( 'title' => __( 'Form Fields', 'projectmanager' ), 'cap' => 'edit_formfields', 'page' => 'project-formfields_%d' ),
			'categories' => array( 'title' => __( 'Categories', 'projectmanager' ), 'cap' => 'edit_categories', 'page' => 'project-categories_%d' ),
			'dataset' => array( 'title' => __( 'Add Dataset', 'projectmanager' ), 'cap' => 'edit_datasets', 'page' => 'project-dataset_%d' ),
			'newsletter' => array( 'title' => __( 'Newsletter', 'projectmanager' ), 'cap' => 'project_send_newsletter', 'page' => 'project-newsletter_%d' ),
			'import' => array( 'title' => __( 'Import/Export', 'projectmanager' ), 'cap' => 'import_datasets', 'page' => 'project-import_%d' )
		);
		
		return $menu;
	}


	/**
	 * adds menu to the admin interface
	 *
	 */
	public function menu() {
		$options = get_option('projectmanager');
		if( !isset($options['dbversion']) || $options['dbversion'] != PROJECTMANAGER_DBVERSION )
			$update = true;
		else
			$update = false;

		if ( !$update && $projects = $this->getProjects() ) {
			foreach( $projects AS $project ) {
				if ( isset($project->navi_link) && 1 == $project->navi_link ) {
					$icon = $project->menu_icon;
					$page = add_menu_page( $project->title, $project->title, 'view_projects', 'project_' . $project->id, array(&$this, 'display'), $this->getIconURL($icon) );

					add_action("admin_print_scripts-$page", array(&$this, 'loadScripts') );
					add_action("admin_print_scripts-$page", array(&$this, 'loadStyles') );
					
					$page = add_submenu_page('project_' . $project->id, __($project->title, 'projectmanager'), __('Overview','projectmanager'), 'view_projects', 'project_' . $project->id, array(&$this, 'display'));
					add_action("admin_print_scripts-$page", array(&$this, 'loadScripts') );
					add_action("admin_print_scripts-$page", array(&$this, 'loadStyles') );
					
					foreach ( $this->getMenu() AS $menu ) {
						$page = add_submenu_page('project_' . $project->id, $menu['title'], $menu['title'], $menu['cap'], sprintf($menu['page'], $project->id), array(&$this, 'display'));
						add_action("admin_print_scripts-$page", array(&$this, 'loadScripts') );
						add_action("admin_print_scripts-$page", array(&$this, 'loadStyles') );
					}
				}
			}
		}
		
		// Add global Projects Menu
		$page = add_menu_page(__('Projects', 'projectmanager'), __('Projects', 'projectmanager'), 'view_projects', 'projectmanager', array(&$this, 'display'), PROJECTMANAGER_URL.'/admin/icons/menu/databases.png');
		add_action("admin_print_scripts-$page", array(&$this, 'loadScripts') );
		add_action("admin_print_scripts-$page", array(&$this, 'loadStyles') );
		
		add_submenu_page('projectmanager', __('Projects', 'projectmanager'), __('Overview','projectmanager'),'view_projects', 'projectmanager', array(&$this, 'display'));
		$page = add_submenu_page('projectmanager', __( 'Settings'), __('Settings'), 'projectmanager_settings', 'projectmanager-settings', array( &$this, 'display') );
		add_action("admin_print_scripts-$page", array(&$this, 'loadScripts') );
		add_action("admin_print_scripts-$page", array(&$this, 'loadStyles') );
		$page = add_submenu_page('projectmanager', __( 'Documentation', 'projectmanager'), __('Documentation', 'projectmanager'), 'view_projects', 'projectmanager-documentation', array( &$this, 'display') );
		add_action("admin_print_scripts-$page", array(&$this, 'loadScripts') );
		add_action("admin_print_scripts-$page", array(&$this, 'loadStyles') );
				
		$plugin = 'projectmanager/projectmanager.php';
		add_filter( 'plugin_action_links_' . $plugin, array( &$this, 'pluginActions' ) );
	}
	
	
	/**
	* Register ProjectManager Dashboard Widget
	*
	*/
	public static function registerDashboardWidget() {
		wp_add_dashboard_widget(
			'projectmanager_dashboard',
			__('ProjectManager Latest Support News', 'projectmanager'),
			array(
				'ProjectManagerAdmin',
				'latestSupportNews'
			)
		);
	}
	/**
	 * Display latest news from ProjectManager Support on WordPress.org
	 *
	 */
	public static function latestSupportNews() {
		$options = get_option('projectmanager');
		echo '<div class="rss-widget">';

		wp_widget_rss_output(array(
			'url' => 'http://wordpress.org/support/rss/plugin/projectmanager',
			'show_author' => $options['dashboard_widget']['show_author'],
			'show_date' => $options['dashboard_widget']['show_date'],
			'show_summary' => $options['dashboard_widget']['show_summary'],
			'items' => $options['dashboard_widget']['num_items']
		));

		echo '</div>';
	}
	
	
	/**
	 * show admin menu
	 *
	 */
	public function display() {
		global $projectmanager, $project;
		
		$options = get_option('projectmanager');

		// Update Plugin Version
		if ( $options['version'] != PROJECTMANAGER_VERSION ) {
			$options['version'] = PROJECTMANAGER_VERSION;
			update_option('projectmanager', $options);
		}

		if( !isset($options['dbversion']) || $options['dbversion'] != PROJECTMANAGER_DBVERSION ) {
			include_once ( dirname (__FILE__) . '/upgrade.php' );
			projectmanager_upgrade_page();
			return;
		}
	
		$project_id = 0;
		if ( isset($_GET['project_id']) ) {
			$project_id = intval($_GET['project_id']);
		} else if ( isset($_GET['page']) ) {
			$page = explode("_", $_GET['page']);
			if (isset($page[1])) $project_id = intval($page[1]);
		}
		$this->project_id = $project_id;
		$project = get_project($project_id);
		
		switch ($_GET['page']) {
			case 'projectmanager-settings':
				$this->displayGlobalSettingsPage();
				break;
			case 'projectmanager-documentation':
			  include_once( dirname(__FILE__) . '/documentation.php' );
			  break;
			case 'projectmanager':
				$page = isset($_GET['subpage']) ? $_GET['subpage'] : '';
				switch($page) {
					case 'show-project':
						$this->displayProjectPage();
						break;
					case 'settings':
						$this->displaySettingsPage();
						break;
					case 'dataset':
						$this->displayDatasetPage();
						break;
					case 'formfields':
						$this->displayFormfieldsPage();
						break;
					case 'categories':
						$this->displayCategoryPage();
						break;
					case 'import':
						$this->displayImportPage();
						break;
					case 'newsletter':
						$this->displayNewsletterPage();
						break;
					default:
						$this->displayIndexPage();
						break;
				}
				break;
			
			default:
				$page = explode("_", $_GET['page']);
				switch ($page[0]) {
					case 'project':
						$this->displayProjectPage();
						break;
					case 'project-settings':
						$this->displaySettingsPage();
						break;
					case 'project-dataset':
						$this->displayDatasetPage();
						break;
					case 'project-formfields':
						$this->displayFormfieldsPage();
						break;
					case 'project-categories':
						$this->displayCategoryPage();
						break;
					case 'project-import':
						$this->displayImportPage();
						break;
					case 'project-newsletter':
						$this->displayNewsletterPage();
						break;
				}
		}
	}
	
	
	/**
	 * Display project index page
	 *
	 */
	private function displayIndexPage() {
		if ( current_user_can( 'view_projects' ) ) {
			
			// Add Project
			if ( isset($_POST['updateProjectManager']) ) {
				if ( 'project' == $_POST['updateProjectManager'] ) {
					check_admin_referer('projectmanager_manage-projects');
					$this->addProject( htmlspecialchars($_POST['project_title']) );
				}
				$this->printMessage();
			}  
			
			// Delete Projects
			if ( isset($_POST['doaction']) || isset($_POST['doaction2']) ) {
				$action = isset($_POST['doaction']) ? $_POST['action'] : $_POST['action2'];
				
				check_admin_referer('projectmanager_projects-bulk');
				if ( current_user_can('delete_projects') ) {
					if ( 'delete' == $action ) {
						foreach ( $_POST['project'] AS $project_id ) {
							$this->delProject( intval($project_id) );
						}
						$this->setMessage( sprintf(_n( "%d project deleted", "%d projects deleted", count($_POST['project']), 'projectmanager'), count($_POST['project'])) );
						$this->printMessage();
					}
				} else {
					$this->setMessage(__("You don't have permission to perform this task", 'projectmanager'), true);
					$this->printMessage();
				}
			}
			
			include_once( dirname(__FILE__) . '/index.php' );
		} else {
			echo '<div class="error"><p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p></div>';
		}
	}
	
	
	/**
	 * Display project main page
	 *
	 */
	private function displayProjectPage() {
		global $current_user;
		
		$project = get_project();

		if ( current_user_can( 'view_projects' ) ) {
			// Create Dataset PDF file
			if ( isset($_GET['projectmanager_pdf']) ) {
				if ( !current_user_can('view_pdf') ) {
					ob_end_flush();
					$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
					$this->printMessage();
				} else {
					ob_end_clean();
					$this->createPDF( intval($_GET['projectmanager_pdf']) );
				}
			}
			
			// Send Email confirmation
			if ( isset($_GET['sendconfirmation']) ) {
				if ( current_user_can( 'projectmanager_send_confirmation' ) ) {
					$dataset = get_dataset(intval($_GET['sendconfirmation']));
					$pdf_file = $this->createPDF($dataset->id, false);
					if ( $project->sendConfirmation($dataset, $pdf_file) )
						$this->setMessage( __( 'E-Mail confirmation has been sent', 'projectmanager' ) );
					else
						$this->setMessage( __( 'An error occured while trying to send E-Mail confirmation. Did you set the frontend page containing the dataset form?', 'projectmanager' ), true );
					
					// Delete dataset details PDF file
					@unlink($pdf_file);
					
					unset($dataset);
				} else {
					$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
				}
				
				$this->printMessage();
			}
			
			// Send Newsletter
			if ( isset($_POST['sendnewsletter']) ) {
				if ( current_user_can( 'project_send_newsletter' ) ) {
					$project->sendNewsletter( $_POST['newsletter_from_email'], $_POST['newsletter_from_name'], $_POST['newsletter_subject'], $_POST['newsletter_message'], $_POST['newsletter_to_field']);
				} else {
					$this->setMessage(__('You are not allowed to perform this task', 'projectmanager'), true);
				}
			}
			
			if ( isset($_POST['updateProjectManager']) ) {
				/*
				* Add or Edit Dataset
				*/
				if ( 'dataset' == $_POST['updateProjectManager'] ) {
					if ( current_user_can( 'edit_datasets' ) ) {
						check_admin_referer( 'projectmanager_edit-dataset' );
						
						$sticky = isset($_POST['sticky']) ? 1 : 0;
						$category = isset($_POST['category']) ? $_POST['category'] : '';
							
						if ( intval($_POST['dataset_id']) == 0 ) {
							$this->addDataset( intval($_POST['project_id']), $category, $_POST['form_field'], intval($_POST['user_id']), $sticky );
						} else {
							// make sure that dataset editing is not disabled
							if ( $project->no_edit == 0 ) {
								$this->editDataset( intval($_POST['project_id']), $category, intval($_POST['dataset_id']), $_POST['form_field'], intval($_POST['user_id']), $sticky );
							} else {
								$this->setMessage(__('You are not allowed to perform this task', 'projectmanager'), true);
							}
						}
					} else {
						$this->setMessage(__('You are not allowed to perform this task', 'projectmanager'), true);
					}
					
					$this->printMessage();
				}
			}

			/*
			 * bulk actions
			 */
			if ( isset($_POST['doaction']) || isset($_POST['doaction2']) ) {
				$action = isset($_POST['doaction']) ? $_POST['action'] : $_POST['action2'];
				
				// save dataset order
				if ( 'save_order' == $action ) {
					if ( current_user_can( 'edit_dataset_order' ) ) {
						$offset = ( intval($_POST['current_page']) - 1 ) * $project->per_page;
						$this->saveDatasetOrder($_POST['dataset_id'], $offset);
					} else {
						$this->setMessage(__('You are not allowed to perform this task', 'projectmanager'), true);
					}
				}
				
				// send E-Mail confirmation
				if ( 'sendconfirmation' == $action ) {
					if ( current_user_can( 'projectmanager_send_confirmation' ) ) {
						$sent = array();
						foreach ( $_POST['dataset'] AS $dataset_id ) {
							$dataset = get_dataset(intval($dataset->id));
							$pdf_file = $this->createPDF($dataset->id, false);
							if ( $project->sendConfirmation($dataset, $pdf_file) )
								$sent[] = $dataset_id;
					
							// Delete dataset details PDF file
							@unlink($pdf_file);
						}
						if ( count($sent) == 0 )
							$this->setMessage(__('An error occured while trying to send E-Mail confirmation. Did you set the frontend page containing the dataset form?', 'projectmanager'), true);
						else
							$this->setMessage(sprintf(__( 'E-Mail confirmations have been sent to the following dataset IDs: %s', 'projectmanager'), implode(', ', $sent)));
						
						$this->printMessage();
					} else {
						$this->setMessage(__('You are not allowed to perform this task', 'projectmanager'), true);
					}
				}
				
				if ( $project->no_edit == 0 ) {
					check_admin_referer('projectmanager_dataset-bulk');
					// delete datasets
					if ( 'delete' == $action ) {
						if ( !current_user_can('delete_datasets') ) {
							$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
						} else {
							if (isset($_POST['dataset'])) {
								$i = 0;
								foreach ( $_POST['dataset'] AS $dataset_id ) {
									$dataset = get_dataset($dataset_id);
									if ( $dataset->user_id == $current_user->ID || current_user_can('delete_other_datasets') ) {
										$this->delDataset( $dataset->id );
										$i++;
									}
								}
								$this->setMessage( sprintf(_n( "%d dataset deleted", "%d datasets deleted", $i, 'projectmanager'), $i) );
							}
						}
					} elseif ( 'duplicate' == $action ) {
						// duplicate datasets
						if ( !current_user_can('edit_datasets') ) {
							$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
						} else {
							if (isset($_POST['dataset'])) {
								foreach ( $_POST['dataset'] AS $dataset_id ) {
									$this->duplicateDataset( intval($dataset_id) );
								}
								$this->setMessage( sprintf(_n( "%d dataset duplicated", "%d datasets duplicated", count($_POST['dataset']), 'projectmanager'), count($_POST['dataset'])) );
							}
						}
					}
				} else {
					$this->setMessage(__('You are not allowed to perform this task', 'projectmanager'), true);
				}
				$this->printMessage();
			}
			
			$menu_page_url = ( $project->navi_link == 1 ) ? menu_page_url(sprintf( "project_%d", $project->id ), 0) : menu_page_url('projectmanager', 0)."&amp;subpage=show-project&amp;project_id=".$project->id;
			
			$datasets = $project->getDatasets();

			include_once( dirname(__FILE__) . '/show-project.php' );
		} else {
			echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';
		}
	}
	
	
	/**
	 * Display Dataset page
	 *
	 */
	private function displayDatasetPage() {
		global $current_user;
		
		$project = get_project();
		
		$error = false;
		if ( !isset($_GET['view']) && !current_user_can( 'edit_datasets' ) )
			$error = true;
		if ( $project->no_edit == 1 && isset($_GET['edit']) )
			$error = true;
		
		if ( isset($_GET['edit']) ) {
			$dataset = get_dataset( intval($_GET['edit']) );
			if ( $dataset->user_id != $current_user->ID && !current_user_can( 'edit_other_datasets' ) ) $error = true;
		}

		if ( $error ) {
			echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';
		} else {
			$options = get_option('projectmanager');
			$meta_data = array();
			if ( isset($_GET['edit']) ) {
				$form_title = __('Edit Dataset','projectmanager');				
				
				foreach ($dataset->getData() AS $data) {
					$meta_data[$data->form_field_id] = $data->value;
				}
			}  else {
				$dataset = new Dataset(); // create new empty Dataset object
				$form_title = __('Add Dataset','projectmanager');
			}

			$is_profile_page = false;
			$menu_page_url = ( $project->navi_link == 1 ) ? menu_page_url(sprintf( "project_%d", $project->id ), 0) : menu_page_url('projectmanager', 0)."&amp;subpage=show-project&amp;project_id=".$project->id;

			//$this->loadTinyMCE();
			
			/*
			$form_class = '';
			foreach ( $project->getData("formfields") AS $formfield ) {
				if ($formfield->width < 100) {
					$form_class = 'grid-input';
					break;
				}
			}
			*/
			
			include_once( dirname(__FILE__) . '/dataset.php' );
		}
	}
	
	
	/**
	 * Display Project settings page
	 *
	 */
	private function displaySettingsPage() {
		if ( current_user_can( 'edit_projects_settings' ) ) {
			$project = get_project();
			
			$tab = 0;
			if ( isset($_POST['saveSettings']) ) {
				check_admin_referer('projectmanager_manage-settings');

				$this->editProject( htmlspecialchars($_POST['project_title']), intval($_POST['project_id']) );
				$this->saveSettings( $_POST['settings'], intval($_POST['project_id']) );

				$this->printMessage();
				$project->reloadSettings();
				
				// Set active tab
				$tab = intval($_POST['active-tab']);
			}

			if ( isset($_GET['regenerate_thumbnails']) ) {
				$this->regenerateThumbnails();
				$this->setMessage( __( 'Image thumbnails regenerated. You should not reload this page, otherwise thumbnails will be again regenerated.', 'projectmanager' ) );
				$this->printMessage();
					
				$tab = 1;
			}

			$menu_page_url = ( $project->navi_link == 1 ) ? menu_page_url(sprintf( "project-settings_%d", $project->id ), 0) : menu_page_url('projectmanager', 0)."&amp;subpage=settings&amp;project_id=".$project->id;

			if ( isset($project->map['update_schedule']) )
				$this->map_update_schedule = $project->map['update_schedule'];

			if ( isset($_GET['cleanUnusedFiles']) ) $tab = 6;
			
			include_once( dirname(__FILE__) . '/settings.php' );
		} else {
			echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';
		}
	}
	
	
	/**
	 * Display Project formfields page
	 *
	 */
	private function displayFormfieldsPage() {
		global $project;
		
		if ( current_user_can( 'edit_formfields' ) ) {
			/*
			 * Download Formular as PDF
			 */
			if ( isset($_POST['downloadFormPDF']) && isset($_POST['project_id']) ) {
				$options = get_option('projectmanager');
				if ($_POST['exportkey'] ==	$options['exportkey']) {
					ob_end_clean();
					$this->createFormPDF( intval($_POST['project_id']) );
					unset($options['exportkey']);
					update_option('projectmanager', $options);
				} else {
					ob_end_flush();
					$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
					$this->printMessage();
				}
			}

			/*
			 * save formfields
			 */
			if ( isset($_POST['saveFormFields']) ) {
				check_admin_referer('projectmanager_manager-formfields');
				$this->setFormFields( intval($_POST['project_id']), $_POST['formfields'] );

				$this->printMessage();
			}

			/*
			 * add new formfields
			 */
			if (isset($_POST['addFormField'])) {
				check_admin_referer('projectmanager_manager-formfields');
				$formfields = isset($_POST['formfields']) ? $_POST['formfields'] : array();
				// Save existing formfields
				$this->setFormFields( intval($_POST['project_id']), $formfields );
				
				// add new formfields
				$add_formfield_number = intval($_POST['add_formfields_number']);
				if ( $add_formfield_number < 1 ) $add_formfield_number = 1;
				for ( $i = 1; $i <= $add_formfield_number; $i++ ) {
					$this->addFormField(intval($_POST['project_id']));
				}
			}

			/*
			 * delete formfields
			 */
			if (isset($_POST['doaction']) || isset($_POST['doaction2'])) {
				$action = isset($_POST['doaction']) ? $_POST['action'] : $_POST['action2'];
				
				check_admin_referer('projectmanager_manager-formfields');
				if ( 'delete' == $action ) {
					if ( !current_user_can('edit_formfields') ) {
						$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
						$this->printMessage();
					} else {
						foreach ( $_POST['del_formfield'] AS $f_id ) {
							$this->delFormField( intval($f_id) );
						}
						$this->setMessage( __("Formfields deleted", 'projectmanager'), false );
						$this->printMessage();
					}
				}
			}

			// load formfield data
			$project->loadData("formfields");

			$menu_page_url = ( $project->navi_link == 1 ) ? menu_page_url(sprintf( "project-formfields_%d", $project->id ), 0) : menu_page_url('projectmanager', 0)."&amp;subpage=formfields&amp;project_id=".$project->id;

			// set exportkey for PDF export
			$options = get_option('projectmanager');
			$options['exportkey'] = uniqid(rand(), true);
			update_option('projectmanager', $options);
			
			include_once( dirname(__FILE__) . '/formfields.php' );
		} else {
			echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';
		}
	}
	
	
	/**
	 * Display Project categories page
	 *
	 */
	private function displayCategoryPage() {
		global $project;
		
		if ( current_user_can( 'edit_categories' ) ) {
			if ( isset($_GET['edit']) ) {
				$form_title = __('Edit Category', 'projectmanager');
				$cat = $project->getData("categories", "id", intval($_GET['edit']), 1);
			} else {
				$form_title = __('Add Category', 'projectmanager');
				$cat = (object) array( 'title' => '', 'id' => 0 );
			}

			/*
			 * add or edit categories
			 */
			if ( isset($_POST['updateProjectManager']) AND !isset($_POST['deleteit']) ) {
				if ( 'category' == $_POST['updateProjectManager'] ) {
					check_admin_referer('projectmanager_manage-categories');
					
					if ( $_POST['cat_id'] == 0 )
						$this->addCategory( htmlspecialchars($_POST['title']) );
					else
						$this->editCategory( htmlspecialchars($_POST['title']), intval($_POST['cat_id']) );
					
					$project->loadCategories(true);
				}
			}
			
			// bulk actions
			if ( isset($_POST['doaction']) || isset($_POST['doaction2']) ) {
				$action = isset($_POST['doaction']) ? $_POST['action'] : $_POST['action2'];
				
				check_admin_referer('projectmanager_categories-bulk');
				if ( current_user_can('edit_categories') ) {
					if ( 'delete' == $action ) {
						foreach ( $_POST['category'] AS $cat_id ) {
							$this->delCategory( intval($cat_id) );
						}
						$this->setMessage( sprintf(_n( "%d category deleted", "%d categories deleted", count($_POST['category']), 'projectmanager'), count($_POST['category'])) );
						$this->printMessage();
					}
				} else {
					$this->setMessage(__("You don't have permission to perform this task", 'projectmanager'), true);
					$this->printMessage();
				}
			}

			// load categories
			$project->loadData("categories");

			$menu_page_url = ( $project->navi_link == 1 ) ? menu_page_url(sprintf( "project-categories_%d", $project->id ), 0) : menu_page_url('projectmanager', 0)."&amp;subpage=categories&amp;project_id=".$project->id;
			
			include_once( dirname(__FILE__) . '/categories.php' );
		} else {
			echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';
		}
	}
	
	
	/**
	 * Display Project import page
	 *
	 */
	private function displayImportPage() {
		global $project, $current_user;
		
		if ( current_user_can( 'import_datasets' ) ) {
			if ( isset($_POST['projectmanager_export']) ) {
				$options = get_option('projectmanager');
				if ($_POST['exportkey'] ==	$options['exportkey']) {
					ob_end_clean();
					
					if ( $_POST['export_type'] == 'project' )
						$this->exportProject( $_POST['project_id'] );
					else
						$this->exportData(intval($_POST['project_id']), htmlspecialchars($_POST['export_type']));
					
					unset($options['exportkey']);
					update_option('projectmanager', $options);
				} else {
					ob_end_flush();
					$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
					$this->printMessage();
				}
			}

			// set exportkey
			$options = get_option('projectmanager');
			$options['exportkey'] = uniqid(rand(), true);
			update_option('projectmanager', $options);

			$media_filename = $project->title."_Media_".date("Y-m-d").".zip";
			$media_filename = $this->getBackupPath($media_filename);

			// clean up media zip file
			if (file_exists($media_filename))
				@unlink($media_filename);

			$tab = 0;
			
			// Import data here. Data export is handled in /projectmanager.php
			if ( isset($_POST['import_datasets']) ) {
				check_admin_referer( 'projectmanager_import-datasets' );
				$this->importDatasets( $project->id, $_FILES['projectmanager_import'], $_POST['delimiter'], $_POST['cols'] );
				$this->printMessage();
				
				// Set active tab
				$tab = intval($_POST['active-tab']);
			} elseif ( isset($_POST['import_media']) ) {
				check_admin_referer( 'projectmanager_import-media' );
				$this->importMedia();
				$this->printMessage();
				
				// Set active tab
				$tab = intval($_POST['active-tab']);
			} elseif ( isset($_POST['import_project']) ) {
				check_admin_referer( 'projectmanager_import-project' );
				$this->importProject();
				$this->printMessage();
				
				// Set active tab
				$tab = intval($_POST['active-tab']);
			}

			$formfields = $project->getData("formfields");
			
			include_once( dirname(__FILE__) . '/import.php' );
		} else {
			echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';
		}
	}
	
	
	/**
	 * Display Newsletter page
	 *
	 */
	private function displayNewsletterPage() {
		$project = get_project();
		
		if ( current_user_can( 'project_send_newsletter' ) ) {
			$options_field = $project->getNewsletterOptionsFormField();
			
			if ( count($project->getData("formfields", "type", "email")) == 0 ) {
				echo '<p style="text-align: center;">'.__("You have to add at least one email formfield to use this feature", "projectmanager").'</p>';
			} else {
				$menu_page_url = ( $project->navi_link == 1 ) ? menu_page_url(sprintf( "project_%d", $project->id ), 0) : menu_page_url('projectmanager', 0)."&amp;subpage=show-project&amp;project_id=".$project->id;
				
				include_once( dirname(__FILE__) . '/newsletter.php' );
			}
		} else {
			echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';
		}
	}
	
	
	/**
	 * Display global settings page (e.g. color scheme options)
	 *
	 */
	private function displayGlobalSettingsPage() {
		$options = get_option('projectmanager');

		$tab = 0;
		if ( current_user_can( 'projectmanager_settings' ) ) {
			if ( isset($_POST['updateProjectManager']) ) {
				check_admin_referer('projetmanager_manage-global-league-options');
				$options['colors']['headers'] = htmlspecialchars($_POST['color_headers']);
				$options['colors']['rows'] = array( htmlspecialchars($_POST['color_rows_alt']), htmlspecialchars($_POST['color_rows']) );
				$options['colors']['boxheader'] = array( htmlspecialchars($_POST['color_boxheader1']), htmlspecialchars($_POST['color_boxheader2']) );
				$options['dashboard_widget']['num_items'] = intval($_POST['dashboard']['num_items']);
				$options['dashboard_widget']['show_author'] = isset($_POST['dashboard']['show_author']) ? 1 : 0;
				$options['dashboard_widget']['show_date'] = isset($_POST['dashboard']['show_date']) ? 1 : 0;
				$options['dashboard_widget']['show_summary'] = isset($_POST['dashboard']['show_summary']) ? 1 : 0;
				
				update_option( 'projectmanager', $options );
				$this->setMessage(__( 'Settings saved', 'leaguemanager' ));
				$this->printMessage();
				
				// Set active tab
				$tab = intval($_POST['active-tab']);
			}
			require_once (dirname (__FILE__) . '/settings-global.php');
		} else {
			echo '<p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p>';
		}
	}
	
	
	/**
	 * print breadcrumb navigation
	 *
	 * @param string $page_title
	 */
	public function printBreadcrumb( $page_title ) {
		global $project;
		
		echo '<p class="projectmanager_breadcrumb alignright wp-clearfix">';
		echo '<a href="admin.php?page=projectmanager">'.__( 'Projectmanager', 'projectmanager' ).'</a> &raquo; ';
		
		if ( $page_title != $project->title )
			echo '<a href="admin.php?page=projectmanager&subpage=show-project&amp;project_id='.$project->id.'">'.$project->title.'</a> &raquo; ';
			
		echo $page_title;
			
		echo '</p>';
	}
	
	
	/**
	 * display link to settings page in plugin table
	 *
	 * @param array $links array of action links
	 * @return array
	 */
	public function pluginActions( $links ) {
		$settings_link = '<a href="admin.php?page=projectmanager-settings">' . __('Settings') . '</a>';
		array_unshift( $links, $settings_link );
	
		return $links;
	}
	
	
	/**
	 * load Javacript
	 */
	public function loadScripts() {
		wp_register_script( 'projectmanager', PROJECTMANAGER_URL.'/admin/js/functions.js', array( 'sack', 'scriptaculous', 'prototype', 'iris', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-datepicker', 'jquery-ui-accordion', 'jquery-ui-tabs', 'jquery-ui-tooltip', 'jquery-effects-core', 'jquery-effects-slide', 'jquery-effects-explode', 'thickbox' ), PROJECTMANAGER_VERSION );
		wp_enqueue_script( 'projectmanager' );
		wp_enqueue_script( 'projectmanager_ajax', PROJECTMANAGER_URL.'/js/ajax.js', array('jquery', 'sack') );
		wp_enqueue_script( 'projectmanager_wp-media', PROJECTMANAGER_URL.'/admin/js/wp-media.js', array('jquery') );
	}

	
	/**
	 * load CSS styles
	 */
	public function loadStyles() {
		wp_enqueue_style('thickbox');
	
		wp_register_style('jquery-ui', PROJECTMANAGER_URL . "/css/jquery/jquery-ui.min.css", false, '1.11.4', 'all');
		wp_register_style('jquery-ui-structure', PROJECTMANAGER_URL . "/css/jquery/jquery-ui.structure.min.css", array('jquery-ui'), '1.11.4', 'all');
		wp_register_style('jquery-ui-theme', PROJECTMANAGER_URL . "/css/jquery/jquery-ui.theme.min.css", array('jquery-ui', 'jquery-ui-structure'), '1.11.4', 'all');
		wp_enqueue_style('jquery-ui-structure');
		wp_enqueue_style('jquery-ui-theme');
		
		wp_register_style('jquery_ui_css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css', false, '1.0', 'screen');
		//wp_enqueue_style('jquery_ui_css');
		
		wp_enqueue_style('projectmanager', PROJECTMANAGER_URL . "/style.css", false, '1.0', 'all');
		wp_enqueue_style('projectmanager_admin', PROJECTMANAGER_URL . "/admin/style.css", false, '1.0', 'all');
	}
	
	
	/**
	 * get icon URl
	 *  
	 * First check if custom directory 'projectmanager/icons' exists in template directory
	 * If not load default dir.
	 *  
	 * @param string $icon
	 * @param string $dir
	 * @return string
	 */
	public function getIconURL( $icon, $dir = 'menu' ) {
		if ( file_exists(TEMPLATEPATH . "/projectmanager/icons/".$icon))
			return get_template_directory_uri() . "/projectmanager/icons/".$icon;
		elseif ( file_exists(PROJECTMANAGER_PATH.'/admin/icons/'.$dir.'/sw/'.$icon) )
			return PROJECTMANAGER_URL.'/admin/icons/'.$dir.'/sw/'.$icon;
		else
			return PROJECTMANAGER_URL.'/admin/icons/'.$dir.'/databases.png';
	}
	
	
	/**
	 * get checklist for groups.
	 *
	 * @param array $selected_cats array of selected category IDs
	 */
	public function categoryChecklist( $selected_cats ) {
		global $project;
		
		echo '<ul class="projectmanager-categorychecklist">';
		foreach ( $project->getData("categories") AS $category ) {
			echo "<li><input type='checkbox' id='in-category-".$category->id."' name='category[]' value='".$category->id."'";
			if ( in_array($category->id, $selected_cats) ) echo " checked='checked'";
			echo " /><label class='selectit' for='in-category-".$category->id."'>".$category->title."</label></li>";
		}
		echo '</ul>';
	}
	

	/**
	 * get dropdown for groups.
	 *
	 * @param array $selected_cats array of selected category IDs
	 */
	public function categoryDropdown( $selected_cats ) {
		global $project;
		
		// allow passing "cat_id" to url to auto-select specific category, e.g. for LeagueManager match statistics
		if (isset($_GET['cat_id'])) $selected_cats[0] = intval($_GET['cat_id']);
		
		echo "<select size='1' name='category'>";
		echo "<option value=''>".__('None', 'projectmanager')."</option>";
		foreach ( $project->getData("categories") AS $category ) {
			echo "<option value='".$category->id."' ".selected( $category->id, $selected_cats[0], false ).">".$category->title."</option>";
		}
		echo "</select>";
	}


	/**
	 * get possible sorting options for datasets
	 *
	 * @param string $selected
	 */
	public function datasetOrderbyOptions( $selected ) {
		$options = array( 'id' => __('ID', 'projectmanager'), 'order' => __('Custom Order', 'projectmanager'), 'formfields' => __('Formfields', 'projectmanager') );
				
		foreach ( $options AS $option => $title ) {
			$select = ( $selected == $option ) ? ' selected="selected"' : '';
			echo '<option value="'.$option.'"'.$select.'>'.$title.'</option>';
		}
	}
	
	
	/**
	 * get possible order options
	 *
	 * @param string $selected
	 */
	public function datasetOrderOptions( $selected ) {
		$options = array( 'ASC' => __('Ascending','projectmanager'), 'DESC' => __('Descending','projectmanager') );
		
		foreach ( $options AS $option => $title ) {
			$select = ( $selected == $option ) ? ' selected="selected"' : '';
			echo '<option value="'.$option.'"'.$select.'>'.$title.'</option>';
		}
	}
	
	
	/**
	 * get possible sorting options for categories
	 *
	 * @param string $selected
	 */
	public function categoryOrderbyOptions( $selected ) {
		$options = array( 'id' => __('ID', 'projectmanager'), 'title' => __('Name', 'projectmanager') );
		
		foreach ( $options AS $option => $title ) {
			$select = ( $selected == $option ) ? ' selected="selected"' : '';
			echo '<option value="'.$option.'"'.$select.'>'.$title.'</option>';
		}
	}
	
	
	/**
	 * add new project
	 *
	 * @param string $title
	 * @return boolean
	 */
	public function addProject( $title ) {
		global $wpdb;
	
		if ( !current_user_can('edit_projects') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}

		$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_projects} (title) VALUES ('%s')", htmlspecialchars($title) ) );
		
		$project = get_project($wpdb->insert_id);
		// create media directory for project
		wp_mkdir_p( $project->getFilePath() );
		
		$this->setMessage( __('Project added','projectmanager') );
		
		/**
		 * Fired when a new Project is added
		 *
		 * @param int $project_id
		 * @category wp-action
		 */
		do_action('projectmanager_add_project', $project->id);
		
		return true;
	}
	
	
	/**
	 * edit project
	 *
	 * @param string $title
	 * @param int $project_id
	 * @return boolean
	 */
	public function editProject( $title, $project_id ) {
		global $wpdb;

		if ( !current_user_can('edit_projects') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projects} SET `title` = '%s' WHERE `id` = '%d'", htmlspecialchars($title), intval($project_id) ) );
		$this->setMessage( __('Project updated','projectmanager') );
		
		/**
		 * Fired when a Project is modified
		 *
		 * @param int $project_id
		 * @category wp-action
		 */
		do_action('projectmanager_edit_project', intval($project_id));
		
		return true;
	}
	
	
	/**
	 * delete project
	 *
	 * @param int $project_id
	 */
	public function delProject( $project_id ) {
		global $wpdb;
		
		if ( !current_user_can('delete_projects') ) 
			return false;

		// Remove parent ID from children
		$wpdb->query( $wpdb->prepare("UPDATE {$wpdb->projectmanager_projects} SET `parent_id` = 0 WHERE `parent_id` = '%d'", $project_id) );
		
		$project = get_project(intval($project_id));
		$datasets = $wpdb->get_results($wpdb->prepare("SELECT `id` FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d'", $project->id));
		foreach ( $datasets AS $dataset )
			$this->delDataset( $dataset->id );
		
		$wpdb->query( $wpdb->prepare("DELETE FROM {$wpdb->projectmanager_categories} WHERE `project_id` = '%d'", $project->id ) );
		$wpdb->query( $wpdb->prepare("DELETE FROM {$wpdb->projectmanager_projectmeta} WHERE `project_id` = '%d'", $project->id) );
		$wpdb->query( $wpdb->prepare("DELETE FROM {$wpdb->projectmanager_projects} WHERE `id` = '%d'", $project->id) );
		
		$this->removeDir($project->getFilePath());
		
		/**
		 * Fired when a Project is deleted
		 *
		 * @param int $project_id
		 * @category wp-action
		 */
		do_action('projectmanager_del_project', $project->id);
	}

	
	/**
	 * save Project Settings
	 *
	 * @param array $settings
	 * @param int $project_id
	 */
	public function saveSettings( $settings, $project_id ) {
		global $wpdb;

		if ( !current_user_can('edit_projects_settings') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}

		$project = get_project(intval($project_id));
		$settings['default_image'] = $project->default_image;
		
		// delete project's default image
		if (isset($settings['del_default_image']) && $settings['del_default_image'] == 1) {
			$this->delImage($project->default_image);
			$settings['default_image'] = "";
			unset($settings['del_default_image']);
		}
		
		/*
		 * upload new default image and create thumbnails
		 */
		if ( isset($_FILES['project_default_image']) && $_FILES['project_default_image']['name'] != '' && file_exists($_FILES['project_default_image']['tmp_name']) ) {
			$file = $_FILES['project_default_image'];

			if ( $this->isSupportedImage($file['name']) ) {
				if ( $file['size'] > 0 ) {
					$filename = $this->uploadFile($file, true);
					if ( $filename !== false ) {
						// delete old image if present
						if ( $project->default_image != "" && $project->default_image != basename($filename) ) $this->delImage($project->default_image);
						
						if (file_exists($filename)) {
							// create thumbnails
							$this->createThumbnails($filename, $project);
						}
						// set image filename in settings
						$settings['default_image'] = basename($filename);
					}
				}
			} else {
				$this->setMessage( __('The file type is not supported.','projectmanager'), true );
			}
		}
		
		$settings['is_private'] = isset($settings['is_private']) ? intval($settings['is_private']) : 0;
		$settings['per_page'] = intval($settings['per_page']);
		$settings['navi_link'] = isset($settings['navi_link']) ? intval($settings['navi_link']) : 0;
		$settings['profile_hook'] = isset($settings['profile_hook']) ? intval($settings['profile_hook']) : 0;
		$settings['gallery_num_cols'] = intval($settings['gallery_num_cols']);
		$settings['page_id'] =  intval($settings['page_id']);
		$settings['scramble_email'] = isset($settings['scramble_email']) ? intval($settings['scramble_email']) : 0;
		$settings['tiny_size'] = array( 'width' => intval($settings['tiny_size']['width']), 'height' => intval($settings['tiny_size']['height']) );
		$settings['thumb_size'] = array( 'width' => intval($settings['thumb_size']['width']), 'height' => intval($settings['thumb_size']['height']) );
		$settings['medium_size'] = array( 'width' => intval($settings['medium_size']['width']), 'height' => intval($settings['medium_size']['height']) );
		$settings['large_size'] = array( 'width' => intval($settings['large_size']['width']), 'height' => intval($settings['large_size']['height']) );
		$settings['crop_image']['tiny'] = isset($settings['crop_image']['tiny']) ? 1 : 0;
		$settings['crop_image']['thumb'] = isset($settings['crop_image']['thumb']) ? 1 : 0;
		$settings['crop_image']['medium'] = isset($settings['crop_image']['medium']) ? 1 : 0;
		$settings['crop_image']['large'] = isset($settings['crop_image']['large']) ? 1 : 0;
		$settings['no_edit'] = isset($settings['no_edit']) ? intval($settings['no_edit']) : 0;
		$settings['form_submit_message'] = strip_tags($settings['form_submit_message']);
		$settings['dataset_activation'] = isset($settings['dataset_activation']) ? 1 : 0;
		$settings['datasetform_page_id'] = intval($settings['datasetform_page_id']);
		$settings['email_confirmation'] = isset($settings['email_confirmation']) ? intval($settings['email_confirmation']) : 0;
		$settings['email_confirmation_sender'] = htmlspecialchars($settings['email_confirmation_sender']);
		$settings['email_confirmation_subject'] = strip_tags($settings['email_confirmation_subject']);
		$settings['email_confirmation_text'] = isset($settings['email_confirmation_text']) ? strip_tags($settings['email_confirmation_text']) : '';
		$settings['email_confirmation_pdf'] = isset($settings['email_confirmation_pdf']) ? intval($settings['email_confirmation_pdf']) : 0;
		$settings['notify_new_datasets'] = isset($settings['notify_new_datasets']) ? 1 : 0;
		$settings['email_notification_subject'] = strip_tags($settings['email_notification_subject']);
		$settings['email_notification_text'] = isset($settings['email_notification_text']) ? strip_tags($settings['email_notification_text']) : '';
		$settings['email_notification_pdf'] = isset($settings['email_notification_pdf']) ? intval($settings['email_notification_pdf']) : 0;
		$use_captcha = (isset($settings['captcha']['use']) && $settings['captcha']['use'] == 1) ? 1 : 0;
		$settings['captcha'] = array( 'use' => $use_captcha, 'timeout' => intval($settings['captcha']['timeout']), 'length' => intval($settings['captcha']['length']), 'nlines' => intval($settings['captcha']['nlines']), 'ndots' => intval($settings['captcha']['ndots']), 'letters' => strip_tags(htmlspecialchars($settings['captcha']['letters'])) );
		
		if ( $settings['email_confirmation'] == 0 ) $settings['dataset_activation'] = 0;
		
		if ( isset($settings['slideshow']) ) {
			$settings['slideshow'] = array( 'dataset_orderby' => $settings['slideshow']['dataset_orderby'], 'dataset_order' => $settings['slideshow']['dataset_order'], 'num_datasets' => intval($settings['slideshow']['num_datasets']), 'dataset_ids' => $settings['slideshow']['dataset_ids'] );
		}
		
		if ( isset($settings['map']) && $settings['map']['field'] != "" && isset($settings['map']['update_schedule']) ) {
			$map = new PM_Map($project->id);
			
			$settings['map'] = array( 'field' => intval($settings['map']['field']), 'dataset_label' => htmlspecialchars($settings['map']['dataset_label']), 'update_schedule' => htmlspecialchars($settings['map']['update_schedule']) );
			
			$this->map_update_schedule = $settings['map']['update_schedule'];
					
			// update map data now
			if ( $settings['map']['update_schedule'] == 'manually' ) {
				$settings['map']['data'] = $map->updateData();
			} else {
				$settings['map']['data'] = $map->getData();
			}
		}
		
		// save parent_id in separate column
		$parent_id = intval($settings['parent_id']);
		unset($settings['parent_id']);
		
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projects} SET `settings` = '%s', `parent_id` = '%d' WHERE `id` = '%d'", maybe_serialize($settings), $parent_id, $project->id ) );
		$this->setMessage(__('Settings saved', 'projectmanager'));
		
		/**
		 * Fired when Project settings are saved
		 *
		 * @param int $project_id
		 * @category wp-action
		 */
		do_action('projectmanager_save_settings', $project->id);
		
		// Schedule map data update
		if ( isset($settings['map']) && $settings['map']['field'] != "" && isset($settings['map']['update_schedule']) ) {
			if ( in_array($settings['map']['update_schedule'], array('manually', 'on-load')) ) {
				$this->unscheduleMapUpdate( );
			} else {
				$this->scheduleMapUpdate( );
			}
		}
	}
	
	
	/**
	 * schedule cron job to update map data
	 */
	public function scheduleMapUpdate( ) {	
		$this->unscheduleMapUpdate( );
		
		$args = array('project_id' => $this->project_id);
		wp_schedule_event( $this->getScheduleStartTime(), $this->map_update_schedule, 'projectmanager_update_map_data', $args );
	}
	
	
	/**
	 * un-schedule cron job to update map data
	 */
	public function unscheduleMapUpdate( ) {
		$args = array('project_id' => $this->project_id);
		wp_clear_scheduled_hook( 'projectmanager_update_map_data', $args );
		
	}
	
	
	/**
	 * get next schedule map update
	 *
	 * @param boolean $gmt
	 */
	public function getNextScheduledMapUpdate( $gmt = false ) {
		$args = array('project_id' => $this->project_id);
		$time = wp_next_scheduled( 'projectmanager_update_map_data', $args );

		if ( ! $time )
			return 0;

		if ( ! $gmt )
			$time += get_option( 'gmt_offset' ) * 3600;

		return $time;
	}
	
	
	/**
	 * get map data update schedules
	 *
	 * @return array
	 */
	public function getMapUpdateSchedules() {
		$schedules = array( 'on-load' => __( 'On page load', 'projectmanager' ), 'manually' => __( 'Manually Now', 'projectmanager' ), 'hourly' => __( 'Once Hourly', 'projectmanager' ), 'twicedaily' => __( 'Twice per day', 'projectmanager' ), 'daily' => __( 'Once Daily', 'projectmanager'), 'weekly' => __( 'Once Weekly', 'projectmanager' ), 'monthly' => __( 'Once a Month', 'projectmanager' ) );
		
		return $schedules;
	}
	
	
	/**
	 * get schedule start time
	 *
	 * @param string $date
	 * @return timestamp
	 */
	public function getScheduleStartTime( $date = 0 ) {
		// return 0 if schedule is set to manually
		if ( in_array($this->map_update_schedule, array('manually', 'on-load')) )
			return 0;
	
		if ( $date == 0 ) {
			// run schedule at night
			$date = strtotime( '3am' );
			// Convert to UTC
			$date -= get_option( 'gmt_offset' ) * 3600;
		}
		
		// if the scheduled time already passed today then start at the next interval instead
		//if ( $date <= current_time("timestamp") )
		if ( $date <= strtotime( 'now' ) )
			$date = $this->getScheduleStartTime($date + $this->getScheduleInterval());
		
		return $date;
	}
	
	
	/**
	 * get schedule interval
	 *
	 * @return int
	 */
	public function getScheduleInterval() {
		// return 0 if schedule is set to manually
		if ( in_array($this->map_update_schedule, array('manually', 'on-load')) )
			return 0;
		
		$schedules = wp_get_schedules();
		return $schedules[$this->map_update_schedule]['interval'];
	}
	
	
	/**
	 * import datasets from CSV file
	 *
	 * @param int $project_id
	 * @param array $file CSV file
	 * @param string $delimiter
	 * @param array $cols column assignments
	 */
	public function importDatasets( $project_id, $file, $delimiter, $cols ) {
		global $wpdb;
		
		if ( !current_user_can('import_datasets') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}

		if ($delimiter == ",") {
			$this->setMessage(__('Dataset columns must not be separated by comma as multiple categories use this delimiter', 'projectmanager'), true);
			return false;
		}
		
		$project = get_project(intval($project_id));

		if ( $file['size'] > 0 ) {
			/*
			* Upload CSV file to image directory, temporarily
			*/
			$new_file = $project->getFilePath(basename($file['name']));
			if ( move_uploaded_file($file['tmp_name'], $new_file) ) {
				$handle = @fopen($new_file, "r");
				if ($handle) {
					if ( "TAB" == $delimiter ) $delimiter = "\t"; // correct tabular delimiter
					
					$i = 0; $l=0; // initialize dataset & line counter
					while (!feof($handle)) {
						$buffer = fgets($handle, 4096);
						$line = explode($delimiter, $buffer);
						  
						if ( $l > 0 && count($line) > 1 ) {
							$categories = empty($line[0]) ? '' : explode(",", $line[0]);
							$sticky = 0;
							/*
    						 * get Category IDs from titles
    						 */						
							$cat_ids = array();
    						if ( !empty($categories) ) {
								foreach ( $categories AS $category ) {
									$cat_ids[] = $project->getCategoryID($category);
								}
                			}
                
    						// assign column values to form fields
							$meta = array();
    						foreach ( $cols AS $col => $form_field_id ) {
    							$meta[$form_field_id] = $line[$col];
								
								$formfield = $project->getData("formfields", "id", $form_field_id, 1);
								if ( $formfield->type == 'country' ) {
									// check if country code has been passed based on length of meta value
									if ( strlen($meta[$form_field_id]) > 3 ) {
										// Check if country code is present in () in meta value
										if ( preg_match("/.+\(([A-Za-z]+)\)/", $meta[$form_field_id], $matches) ) {
											$meta[$form_field_id] = $matches[1];
										} else {
											// Try to get country code from meta value
											$meta[$form_field_id] = $project->getCountryCode($meta[$form_field_id]);
										}
									}
								}
								
								if ( in_array($formfield->type, array('checkbox', 'project') ) ) {
									$meta[$form_field_id] = explode(",", $meta[$form_field_id]);
								}
								
								if ( $formfield->type == "radio" ) {
									$meta[$form_field_id] = array( 'value' => $meta[$form_field_id] );
								}
    						}
    	
    						$dataset_id = $this->addDataset($project->id, $cat_ids, $meta, $user_id = false, $sticky, $import = true);
							
							if (!$this->isError())
								$i++;
   						}
						
						$l++;
					}
					fclose($handle);
					
					$this->setMessage(sprintf(__( '%d Datasets successfully imported', 'projectmanager' ), $i));
				} else {
					$this->setMessage( __('The file is not readable', 'projectmanager'), true );
				}
			} else {
				$this->setMessage(sprintf( __('The uploaded file could not be moved to %s.' ), $project->getFilePath()) );
			}
			@unlink($new_file); // remove file from server after import is done
		} else {
			$this->setMessage( __('The uploaded file seems to be empty', 'projectmanager'), true );
		}
	}
	
	
	/**
	 * import media to webserver
	 *
	 */
	public function importMedia() {
		if ( !current_user_can('import_datasets') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		$project = get_project();
		
		if (!isset($_FILES['projectmanager_media_zip']) || empty($_FILES['projectmanager_media_zip']['name'])) {
			$this->setMessage(__('You have to select a media file in zip format', 'projectmanager'), true);
			return false;
		} else {
			$media_file = $_FILES['projectmanager_media_zip'];
			$file = $this->uploadFile($media_file, true );
		
			if (file_exists($file)) {
				if ($this->unzipFiles($file, $project->getFilePath())) {
					$this->setMessage(__('Media file have been successfully imported', 'projectmanager'));
					// remove zip file
					@unlink($file);
				} else {
					$this->setMessage(__('Media zip file could not be unpacked','projectmanager'), true);
				}
			}
		}
	}
	
	
	/**
	 * import database to webserver
	 *
	 */
	public function importProject() {
		if ( !current_user_can('import_datasets') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		if (!isset($_FILES['projectmanager_project_database']) || empty($_FILES['projectmanager_project_database']['name'])) {
			$this->setMessage(__('You have to select a project export file in php format', 'projectmanager'), true);
			return false;
		} else {
			$media_file = $_FILES['projectmanager_project_database'];
			$file = $this->uploadFile($media_file, true );
		
			if (file_exists($file)) {
				$project = get_project($this->project_id);
				if ( $project ) {
					$pid = $project->id;
					require_once($file);
					$this->setMessage(__('Project has been successfully imported', 'projectmanager'));
				}
				// remove zip file
				@unlink($file);
			}
		}
	}
	
	
	/**
	 * check if dataset with given user ID exists
	 *
	 * @param int $project_id
	 * @param int $user_id
	 * @return boolean
	 */
	private function datasetExists( $project_id, $user_id ) {
		global $wpdb;

		$count= $wpdb->get_var( $wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d' AND `user_id` = '%d'", intval($project_id), intval($user_id)) );

		if ( $count > 0 )
			return true;
		
		return false;
	}


	/**
	 * export data
	 *
	 * @param int $project_id
	 * @param string $type
	 * @return file
	 */
	public function exportData( $project_id, $type = "data-csv" ) {		
		wp_mkdir_p( $this->getBackupPath() );
		
		if ( !current_user_can('import_datasets') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			$this->printMessage();
			return false;
		}

		$project = get_project(intval($project_id));		
		$map = new PM_Map($project->id);
		
		// Initialize array with media files
		$media = array();
		$media_filename = sanitize_title($project->title)."_Media_".date("Y-m-d").".zip";
		
		$filename = $project->title."_".date("Y-m-d").".xls";
		
		/*
		* Generate Header
		*/
		$contents = __('Categories','projectmanager');
		foreach ( $project->getData("formfields") AS $form_field ) {
			if (!in_array($form_field->type, array('paragraph', 'title', 'signature')))
				$contents .= "\t".utf8_decode($form_field->label);
		}
		
		// add default project image
		if ($project->default_image != "") {
			$media[] = $project->getImagePath($project->default_image);
			$media[] = $project->getImagePath($project->default_image, "large");
			$media[] = $project->getImagePath($project->default_image, "medium");
			$media[] = $project->getImagePath($project->default_image, "thumb");
			$media[] = $project->getImagePath($project->default_image, "tiny");
		}
		
		if ( $type == 'data-pdf' )
			$pdf = new PDF();
	
		$datasets = $project->getDatasets( array("limit" => false, "orderby" => "id") );
		foreach ( $datasets  AS $dataset ) {	
			$contents .= "\n".implode(",", $dataset->categories);
			
			if ( $type == 'data-pdf' ) {
				$pdf->setDatasetID($dataset->id);
				//$pdf->AliasNbPages();
				$pdf->AddPage();
				$pdf->printDatasetContent();
			} else {
				foreach ( $dataset->getData() AS $meta ) {
					// Add media files to array
					if (($meta->type == "file" || $meta->type == "video") && $meta->value != "") {
						$media[] = $project->getFilePath($meta->value);
					}
					if ( in_array($meta->type, array("image", "dataset-image", "header-image")) && $meta->value != "") {
						$media[] = $project->getImagePath($meta->value);
						$media[] = $project->getImagePath($meta->value, "large");
						$media[] = $project->getImagePath($meta->value, "medium");
						$media[] = $project->getImagePath($meta->value, "thumb");
						$media[] = $project->getImagePath($meta->value, "tiny");
					}
					
					// Remove line breaks
					if ( is_string($meta->value) ) {
						$meta->value = str_replace("\r\n", "", stripslashes($meta->value));
						$meta->value = strip_tags($meta->value);
					}
					
					if ( is_array($meta->value) ) {
						$meta->value = implode(",", $meta->value);
					}
					
					if ( $meta->type == 'country' )
						$meta->value = $map->getCountryName($meta->value) . " (".$meta->value.")";
					
					$contents .= "\t".utf8_decode($meta->value);
				}
			}
		}
		
		if ($type == 'data-pdf') {
			$pdf->Output("D", $project->title."_".date("Y-m-d").".pdf", false);
		}
		if ($type == "media") {
			// create zip Archive of media files
			$ret = $this->createZip($media, $this->getBackupPath($media_filename));
			
			if ($ret) {
				header("Content-Description: File Transfer");
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=\"".$media_filename."\"");
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($this->getBackupPath($media_filename)));
				ob_end_flush();
				@readfile($this->getBackupPath($media_filename));
				exit();
			} else {
				$this->setMessage(__('No media files found to export', 'projectmanager'), true);
				$this->printMessage();
			}
		}
		if ($type == "data-csv") {
			header('Content-Type: text/csv');
			header('Content-Disposition: inline; filename="'.$filename.'"');
			echo $contents;
			exit();
		}
	}
	
	
	/**
	 * Export complete project
	 *
	 * @param int $project_id
	 * @return file
	 */
	public function exportProject( $project_id ) {
		global $wpdb;
		
		if ( !current_user_can('import_datasets') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			$this->printMessage();
			return false;
		}
		
		$project = get_project(intval($project_id));
		
		$filename = $project->title."_".date("Y-m-d")."_SQL.php";
		
		$contents = "<?php\n";
		$contents .= "/*\n";
		$contents .= "* Database export of ProjectManager Project " . $project->title . "\n";
		$contents .= "* Date: " . date("Y-m-d H:i") . "\n";
		$contents .= "*/\n\n";	
		
		$contents .= "global \$wpdb, \$current_user;\n\n";
		/*
		 * Project
		 */
		$contents .= "// Update Project Settings \n"; 
		$contents .= $wpdb->prepare ( "\$wpdb->query(\"UPDATE {\$wpdb->projectmanager_projects} SET `settings` = '%s' WHERE `id` = \".intval(\$pid));\n\n", maybe_serialize($project->getSettings()) );
		
		/*
		 * Formfields
		 */
		$contents .= "// Create FormFields \n";
		$contents .= "\$formfield_ids = array();\n";
		foreach ( $project->getData("formfields") AS $formfield ) {
			$contents .= $wpdb->prepare( "\$wpdb->query( \"INSERT INTO {\$wpdb->projectmanager_projectmeta} (`label`, `label_type`, `type`, `show_on_startpage`, `show_in_profile`, `order`, `order_by`, `mandatory`, `unique`, `private`, `options`, `project_id`, `width`, `newline`) VALUES ( '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', \".intval(\$pid).\", '%d', '%d')\" );\n", $formfield->label, $formfield->label_type, $formfield->type, $formfield->show_on_startpage, $formfield->show_in_profile, $formfield->order, $formfield->order_by, $formfield->mandatory, $formfield->unique, $formfield->private, $formfield->options, $formfield->width, $formfield->newline );
			$contents .= "\$formfield_ids[".$formfield->id."] = \$wpdb->insert_id;\n\n";
		}
		
		/*
		 * Categories
		 */
		$contents .= "// Create Categories \n";
		foreach ( $project->getData("categories") AS $category ) {
			$contents .= $wpdb->prepare( "\$wpdb->query( \"INSERT INTO {\$wpdb->projectmanager_categories} (`title`, `project_id`) VALUES ( '%s', \".intval(\$pid).\")\" );\n", htmlspecialchars($category->title) );
		}
		$contents .= "\n";
		
		/*
		 * Datasets
		 */
		$contents .= "// Create Datasets \n";
		$datasets = $project->getDatasets(array("limit" => false, "orderby" => "id", "order" => "ASC"));
		foreach ( $datasets AS $dataset ) {
			$contents .= $wpdb->prepare( "\$wpdb->query( \"INSERT INTO {\$wpdb->projectmanager_dataset} (sticky, cat_ids, project_id, user_id, `order`) VALUES ('%d', '', \".intval(\$pid).\", \".intval(\$current_user->ID).\", \".\$this->getMaxDatasetOrder().\")\");\n", $dataset->sticky );
			$contents .= "\$d_id = \$wpdb->insert_id;\n";
			foreach ( $dataset->getData() AS $meta ) {
				$contents .= $wpdb->prepare( "\$wpdb->query( \"INSERT INTO {\$wpdb->projectmanager_datasetmeta} (`form_id`, `dataset_id`, `value`) VALUES (\".\$formfield_ids[".$meta->form_field_id."].\", \".\$d_id.\", '%s')\" );\n", $meta->value );
			}
			$contents .= "\n";
		}	
		
		$contents .= "?>";
		
		header('Content-Type: text/php');
		header('Content-Disposition: inline; filename="'.$filename.'"');
		echo $contents;
		exit();
	}
	
	
	/**
	 * make sure that meta value is unique
	 *
	 * @param int $project_id
	 * @param array $formfield_id
	 * @param string $value
	 * @param int $dataset_id
	 * @return boolean
	 */
	private function datasetMetaValueIsUnique($project_id, $formfield_id, $value, $dataset_id = false) {
		global $wpdb;
		
		if ( !$dataset_id ) $dataset_id = $this->dataset_id;
		
		$data = $wpdb->get_results( $wpdb->prepare("SELECT dataset.id AS dataset_id, data.value AS value FROM {$wpdb->projectmanager_dataset} AS dataset LEFT JOIN {$wpdb->projectmanager_datasetmeta} AS data ON dataset.id = data.dataset_id WHERE dataset.project_id = '%d' AND data.form_id = '%d' AND data.value = '%s'", $project_id, $formfield_id, $value) );
		foreach ($data AS $d) {
			if ($value == $d->value && $d->dataset_id != $dataset_id)
				return false;
		}
		
		return true;
	}	
	
	
	/**
	 * check submitted form data
	 *
	 * @param Project $project
	 * @param array $dataset_meta
	 * @param boolean $import
	 */
	private function checkSubmittedFormData($project, $dataset_meta, $import = false) {
		$this->error = false;

		// Initialize error messages
		$msg = array();
		// Check each formfield for mandatory and unique values
		foreach ($dataset_meta AS $formfield_id => $dataset_meta_value) {
			$formfield = $project->getData("formfields", "id", $formfield_id, 1);
			
			if ( !in_array($formfield->type, array( 'paragraph', 'title' )) ) {
				$formfield_options = explode(";", $formfield->options);
				
				// check if there is a maximum input length given
				$match = preg_grep("/max:/", $formfield_options);
				if (count($match) == 1) {
					$max = explode(":", $match[0]);
					$max = $max[1];
				} else {
					$max = 0;
				}
			
				// make sure that mandatory fields are not empty
				if ( $formfield->mandatory == 1 && $formfield->type != "signature" ) {
					if ( $formfield->type == "date" ) {
						if ( array_key_exists('day', $dataset_meta) && array_key_exists('month', $dataset_meta) && array_key_exists('year', $dataset_meta) ) {
							if ( $dataset_meta[$formfield->id]['day'] == '00' || $dataset_meta[$formfield->id]['month'] == '00' || $dataset_meta[$formfield->id]['year'] == '0000' ) {
								$msg[] = sprintf(__("Mandatory field %s is incorrect", 'projectmanager'), $formfield->label);
								$this->error = true;
							}
						}
					} elseif ( in_array($formfield->type, array("checkbox", "project")) ) {
						if ( isset($dataset_meta[$formfield->id]) )
							$dataset_meta[$formfield->id] = array_values($dataset_meta[$formfield->id]);
						else
							$dataset_meta[$formfield->id] = array();
						
						if ( (count($dataset_meta[$formfield->id]) == 1 && $dataset_meta[$formfield->id][0] == "") || !isset($dataset_meta[$formfield->id]) || empty($dataset_meta[$formfield->id]) ){
							$msg[] = sprintf(__("Mandatory field %s is missing", 'projectmanager'), $formfield->label);
							$this->error = true;
						}
					} elseif ( $formfield->type == "radio" ) {
						if ( !isset($dataset_meta[$formfield->id]['value']) || ($dataset_meta[$formfield->id]['value'] == 'Other' && $dataset_meta[$formfield->id]['custom-value'] == "") ) {
							$msg[] = sprintf(__("Mandatory field %s is missing", 'projectmanager'), $formfield->label);
							$this->error = true;
						}
					} elseif ( in_array($formfield->type, array('file', 'image', 'dataset-image', 'header-image', 'video')) ) {
						if ( !isset($_FILES['form_field']['name'][$formfield->id]) && !$import) {
							$msg[] = sprintf(__("Mandatory field %s is missing", 'projectmanager'), $formfield->label);
							$this->error = true;
						}
					} else {
						if( !isset($dataset_meta[$formfield->id]) || (isset($dataset_meta[$formfield->id]) && $dataset_meta[$formfield->id] == "") ) {
							$msg[] = sprintf(__("Mandatory field %s is empty", 'projectmanager'), $formfield->label);
							$this->error = true;
						}
					}
				}
	
				// make sure unique fields have no match in database
				if ($formfield->unique == 1) {
					if (!$this->datasetMetaValueIsUnique($project->id, $formfield->id, $dataset_meta[$formfield->id])) {
						if ( $formfield->type == "email" )
							$msg[] = sprintf(__("Provided %s `%s` is not a valid e-mail address", 'projectmanager'), $formfield->label, $dataset_meta[$formfield->id]);
						else
							$msg[] = sprintf(__("Provided %s `%s` is not allowed", 'projectmanager'), $formfield->label, $dataset_meta[$formfield->id]);
						
						$this->error = true;
					}
				}
				
				// check email validity
				if ($formfield->type == "email" && $dataset_meta[$formfield->id] != "") {
					if (!filter_var($dataset_meta[$formfield->id], FILTER_VALIDATE_EMAIL)) {
						$msg[] = sprintf(__("Provided %s `%s` is not a valid e-mail address", 'projectmanager'), $formfield->label, $dataset_meta[$formfield->id]);
						$this->error = true;
					}
				}
				
				// check that provided input is not longer than $max
				if ($max > 0 && strlen($dataset_meta[$formfield->id]) > $max) {
					$msg[] = sprintf(__("Provided %s is longer than the allowed length of %s characters", 'projectmanager'), $formfield->label, $max);
					$this->error = true;
				}
			}
		}
		
		if ( $this->error ) {
			$message = __( 'The following error occured while submitting the data', 'projectmanager' );
			$message .= '<ul>';
			foreach ( $msg AS $m ) {
				$message .= '<li>'.$m.'</li>';
			}
			$message .= '</ul>';
			$this->setMessage($message, true);
		}
	}
	
	
	/**
	 * get maximum number of order
	 *
	 * @return int
	 */
	public function getMaxDatasetOrder() {
		global $wpdb, $project;
		
		$project = get_project($this->project_id);
		$num = $wpdb->get_var($wpdb->prepare("SELECT MAX(`order`) FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d'", $project->id));
		return $num + 1;
	}
	
	
	/**
	 * add new dataset
	 *
	 * @param int $project_id
	 * @param array $cat_ids
	 * @param array $dataset_meta
	 * @param false|int $user_id
	 * @param int $sticky
	 * @param boolean $import
	 * @return int the dataset ID
	 */
	public function addDataset( $project_id, $cat_ids, $dataset_meta = false, $user_id = false, $sticky = 0, $import = false ) {
		global $wpdb, $current_user;

		//$project = get_project(intval($project_id));
		$project = get_project();
		
		// make sure that $cat_ids is an array
		$cat_ids = (array) $cat_ids;
		
		if ( !$user_id ) $user_id = intval($current_user->ID);
		if ( $user_id == 0 ) $user_id = -1;

		/*
		 * do some checks if user is allowed only if user is logged in
		 */
		if ($current_user->ID != 0) {
			// Negative check on capability
			if ( ( !is_admin() && !current_user_can('projectmanager_user') ) || is_admin() && ( !current_user_can('edit_datasets') || ($import && !current_user_can('import_datasets')) ) ) {
				$message = __("You don't have permission to perform this task", 'projectmanager');
				$this->setMessage($message, true);
				$this->error = true;
				return false;
			}

			// dataset with current user ID already exists and user cannot add multiple datasets
			if ( $this->datasetExists($project_id, $current_user->ID) && !current_user_can('add_multiple_datasets') ) {
				$message = __("You don't have permission to perform this task", 'projectmanager');
				$this->setMessage($message, true );
				$this->error = true;
				return false;
			}
		}
		
		// Set default dataset status
		if ( $project->dataset_activation == 1 && !is_admin() ) {
			$status = 'pending';
			// generate 64 character hexadecimal activation key
			$activationkey = str_shuffle(md5(uniqid(rand(), true)).md5(uniqid(rand(), true)));
		} else {
			$status = 'active';
			$activationkey = '';
		}
		
		$this->error = false;
		// check submitted form data for mandatory fields; omit this if we are adding a dataset for another user
		if ( $current_user->ID == $user_id )
			$this->checkSubmittedFormData($project, $dataset_meta, $import);
		
		// stop if an error occured
		if ($this->error) return false;
		
		$sql = $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_dataset} (sticky, cat_ids, project_id, user_id, `order`, `status`, `activationkey`) VALUES ('%s', '%s', '%d', '%d', '%d', '%s', '%s')", $sticky, maybe_serialize($cat_ids), $project_id, $user_id, $this->getMaxDatasetOrder(), $status, $activationkey );
		$wpdb->query( $sql );
		$dataset_id = $wpdb->insert_id;
		
		if ( $dataset_meta && $dataset_id ) {
			foreach ( $dataset_meta AS $meta_id => $meta_value ) {
				$meta_id = intval($meta_id);
				$formfield = $project->getData("formfields", "id", $meta_id, 1);
				
				// Manage file upload - Not available in dataset import
				if ( !$import && in_array($formfield->type, array('file', 'image', 'video', 'dataset-image', 'header-image')) ) {
					if (isset($_FILES['form_field'])) {
						$file = array(
							'name' => $_FILES['form_field']['name'][$meta_id],
							'tmp_name' => $_FILES['form_field']['tmp_name'][$meta_id],
							'size' => $_FILES['form_field']['size'][$meta_id],
							'type' => $_FILES['form_field']['type'][$meta_id]
						);
						if ( !empty($file['name']) ) {
							$upload = true;
							// check supported image types
							if ( in_array($formfield->type, array('image', 'dataset-image', 'header-image')) && !$this->isSupportedImage($file['name']) ) {
								$upload = false;
								$this->setMessage( __('The file type is not supported.','projectmanager'), true );
								$this->printMessage();
							}
							if ( $upload )
								$filename = $this->uploadFile($file);
							else
								$filename = '';
							
							$meta_value = basename($filename);
						} else {
							$meta_value = "";
						}
					} else {
						$meta_value = "";
					}		
					
					// Create Thumbails for Image
					if ( in_array($formfield->type, array('image', 'dataset-image', 'header-image')) && !empty($meta_value) ) {
						$new_file = $project->getFilePath($meta_value);
						// create thumbnails
						$this->createThumbnails($new_file, $project);
					}		
				} elseif ( 'numeric' == $formfield->type || 'currency' == $formfield->type ) {
					$meta_value += 0; // convert value to numeric type
				}
				
				if ( 'radio' == $formfield->type ) {
					if ( $meta_value['value'] == "Other" )
						$meta_value = $meta_value['custom-value'];
					else
						$meta_value = $meta_value['value'];
				}
				
				if ( is_array($meta_value) ) {
					// form field value is a date
					if ( $formfield->type == 'date' ) {
						// If no javascript is active dates will be passed from 3 selection menus
						if ( array_key_exists('day', $meta_value) && array_key_exists('month', $meta_value) && array_key_exists('year', $meta_value) ) {
							$meta_value = sprintf("%s-%s-%s", $meta_value['year'], $meta_value['month'], $meta_value['day']);
						} else {
							// Active javascript enables datepicker field, which passes one value
							$meta_value = $meta_value['date'];
						}
					} else {
						if ( array_key_exists('hour', $meta_value) && array_key_exists('minute', $meta_value) ) {
							$meta_value = sprintf("%s:%s", $meta_value['hour'], $meta_value['minute']);
						}
					}
				}

				$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_datasetmeta} (form_id, dataset_id, value) VALUES ('%d', '%d', '%s')", $meta_id, $dataset_id, maybe_serialize($meta_value) ) );
			}
			
			// Check for unsubmitted form data, e.g. checkbox list
			if ($form_fields = $project->getData('formfields')) {
				foreach ( $form_fields AS $formfield ) {
					if ( !in_array($formfield->type, array('paragraph', 'title')) && !array_key_exists($formfield->id, $dataset_meta) ) {
						$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_datasetmeta} (form_id, dataset_id, value) VALUES ('%d', '%d', '')", $formfield->id, $dataset_id ) );
					}
				}
			}
		} else {
			// Populate empty meta value for new registered user
			foreach ( $project->getData('formfields') AS $formfield ) {
				if ( !in_array($formfield->type, array('paragraph', 'title')) ) {
					$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_datasetmeta} (form_id, dataset_id, value) VALUES ('%d', '%d', '')", $formfield->id, $dataset_id ) );
				}
			}
		}

		$this->setMessage( __( 'New dataset added to the database.', 'projectmanager' ) );
		
		/**
		 * Fired when a new Dataset is added
		 *
		 * @param int $dataset_id
		 * @category wp-action
		 */
		do_action('projectmanager_add_dataset', $dataset_id);
		
		return $dataset_id;
	}
		
		
	/**
	 * edit dataset
	 *
	 * @param int $project_id
	 * @param array $cat_ids
	 * @param int $dataset_id
	 * @param array $dataset_meta
	 * @param int $user_id
	 * @param int $sticky
	 * @param boolean $is_profile
	 */
	public function editDataset( $project_id, $cat_ids, $dataset_id, $dataset_meta = false, $user_id, $sticky = 0, $is_profile = false ) {
		global $wpdb, $current_user;
		
		$project = get_project(intval($project_id));
		$dataset = get_dataset(intval($dataset_id));
		$sticky = $is_profile ? $dataset->sticky : $sticky;
		
		// make sure that $cat_ids is an array
		$cat_ids = (array) $cat_ids;
		
		$this->dataset_id = $dataset->id;
		$user_id = intval($user_id);
		
		// Check if user has either cap 'edit_datasets' or 'projectmanager_user'
		if ( !current_user_can('edit_datasets') && !current_user_can('projectmanager_user') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			$this->error = true;
			return false;
		}

		// check if user has cap 'edit_other_datasets' and user_id of dataset is different to current user id
		if ( !current_user_can('edit_other_datasets') && $dataset->user_id != $current_user->ID ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			$this->error = true;
			return false;
		}
		
		$this->error = false;
		// check submitted form data for mandatory fields
		$this->checkSubmittedFormData($project, $dataset_meta);
		
		// stop if an error occured
		if ($this->error) return false;
		
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_dataset} SET `sticky` = '%d', `cat_ids` = '%s', `user_id` = '%d' WHERE `id` = '%d'", $sticky, maybe_serialize($cat_ids), $user_id, $dataset->id ) );
			
		if ( $dataset_meta ) {
			foreach ( $dataset_meta AS $meta_id => $meta_value ) {
				$meta_id = intval($meta_id);
				$formfield = $project->getData("formfields", "id", $meta_id, 1);
				
				// Manage file upload
				if ( in_array($formfield->type, array('file', 'image', 'video', 'dataset-image', 'header-image')) ) {
					if (isset($_FILES['form_field'])) {						
						$file = array(
							'name' => $_FILES['form_field']['name'][$meta_id],
							'tmp_name' => $_FILES['form_field']['tmp_name'][$meta_id],
							'size' => $_FILES['form_field']['size'][$meta_id],
							'type' => $_FILES['form_field']['type'][$meta_id],
							'current' => $meta_value['current']
						);
						
						$delete = (isset($meta_value['del']) && 1 == $meta_value['del']) ? true : false;
						$overwrite = isset($meta_value['overwrite']) ? true : false;
						
						$meta_value = $this->editFile($file, $overwrite, $delete, $formfield->type, $dataset->id);
					} else {
						$meta_value = "";
					}
					
					// Create Thumbnails for Image
					if ( in_array($formfield->type, array('image', 'dataset-image', 'header-image')) && !empty($meta_value) ) {
						$new_file = $project->getFilePath($meta_value);
						// create thumbnails
						$this->createThumbnails($new_file, $project);
					}		
				} elseif ( 'numeric' == $formfield->type || 'currency' == $formfield->type ) {
					$meta_value += 0; // convert value to numeric type
				}
					
				if ( 'radio' == $formfield->type ) {
					if ( $meta_value['value'] == "Other" )
						$meta_value = $meta_value['custom-value'];
					else
						$meta_value = $meta_value['value'];
				}
				
				if ( is_array($meta_value) ) {
					// form field value is a date
					if ( $formfield->type == 'date' ) {
						// If no javascript is active dates will be passed from 3 selection menus
						if ( array_key_exists('day', $meta_value) && array_key_exists('month', $meta_value) && array_key_exists('year', $meta_value) ) {
							$meta_value = sprintf("%s-%s-%s", $meta_value['year'], $meta_value['month'], $meta_value['day']);
						} else {
							// Active javascript enables datepicker field, which passes one value
							$meta_value = $meta_value['date'];
						}
					} else {
						if ( array_key_exists('hour', $meta_value) && array_key_exists('minute', $meta_value) ) {
							$meta_value = sprintf("%s:%s", $meta_value['hour'], $meta_value['minute']);
						}
					}
				}
					
				if ( 1 == $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_datasetmeta} WHERE `dataset_id` = '%d' AND `form_id` = '%d'", $dataset->id, $meta_id)) )
					$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_datasetmeta} SET `value` = '%s' WHERE `dataset_id` = '%d' AND `form_id` = '%d'", maybe_serialize($meta_value), $dataset->id, $meta_id ) );
				else
					$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_datasetmeta} (form_id, dataset_id, value) VALUES ( '%d', '%d', '%s' )", $meta_id, $dataset->id, maybe_serialize($meta_value) ) );
			}
		
			// Check for unsubmitted form data, e.g. checkbox list
			if ($form_fields = $project->getData('formfields')) {
				foreach ( $form_fields AS $formfield ) {
					if ( !in_array($formfield->type, array('paragraph', 'title')) && !array_key_exists($formfield->id, $dataset_meta) ) {
						$exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_datasetmeta} WHERE `dataset_id` = '%d' AND `form_id` = '%d'", $dataset->id, $formfield->id));
						if ($exists == 1) 
							$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_datasetmeta} SET `value` = '' WHERE `dataset_id` = '%d' AND `form_id` = '%d'", $dataset->id, $formfield->id ) );
						else	
							$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_datasetmeta} (form_id, dataset_id, value) VALUES ('%d', '%d', '')", $formfield->id, $dataset_id ) );
					}
				}
			}
		}
		
		// remove Wordpress Cache for dataset
		wp_cache_delete( $dataset->id, 'datasets' );
		wp_cache_delete( $dataset->id, 'dataset_meta' );
		
		$this->setMessage( __('Dataset updated.', 'projectmanager') );
		
		/**
		 * Fired when a Dataset is modified
		 *
		 * @param int $dataset_id
		 * @category wp-action
		 */
		do_action('projectmanager_edit_dataset', $dataset->id);
	}
		
	
	/**
	 * duplicate dataset
	 * 
	 * @param int $dataset_id
	 * @return boolean
	 */
	public function duplicateDataset( $dataset_id ) {
		global $wpdb;
		
		if ( !current_user_can('edit_datasets') )
			return false;
		
		$dataset = get_dataset( intval($dataset_id) );
		$meta = $dataset->getData();
		
		$meta_data = array();
		foreach ( $meta AS $m ) {
		  $meta_data[$m->form_field_id] = $m->value;
		}
		
		$this->addDataset($dataset->project_id, maybe_unserialize($dataset->cat_ids), $meta_data, $dataset->user_id, $dataset->sticky);
		$id = $wpdb->insert_id;
		
		return true;
	}
  

	/**
	 * save dataset order
	 *
	 * @param array $datasets
	 * @param int $offset page offset
	 * @return boolean
	 */
	public function saveDatasetOrder( $datasets, $offset ) {
		global $wpdb;
		
		if ( !current_user_can( 'edit_dataset_order' ) )
			return false;
		
		$project = get_project($this->project_id);
		$js = 1 == intval($_POST['js-active']);
		
		$i = 1 + $offset;
		foreach ( $datasets AS $dataset_id ) {	
			$order = ( $js ) ? $i : $_POST['dataset_order'][$dataset_id];
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_dataset} SET `order` = '%d' WHERE `id` = '%d'", $order, $dataset_id ) );
			$i++;
		}
		
		$this->setMessage( __( 'Dataset order saved', 'projectmanager' ) );
		
		return true;
	}
	
	
	/**
	 * delete dataset
	 *
	 * @param int $dataset_id
	 * @return boolean
	 */
	public function delDataset( $dataset_id ) {
		global $wpdb, $current_user;
			
		$dataset = get_dataset(intval($dataset_id)); 

		if ( !current_user_can('delete_datasets') || ( !current_user_can('delete_other_datasets') && $dataset->user_id != $current_user->ID ) ) 
			return false;
		
		// Delete files		
		foreach ( $dataset->getData() AS $dataset_meta ) {
			if ( in_array($dataset_meta->type, array('file', 'video')) ) {
				@unlink($dataset->getFilePath($dataset_meta->value));
			} elseif ( in_array($dataset_meta->type, array('image', 'dataset-image', 'header-image')) ) {
				$this->delImage($dataset_meta->value, $dataset->id);
			}
		}
		
		$wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->projectmanager_datasetmeta} WHERE `dataset_id` = '%d'", $dataset->id) );
		$wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->projectmanager_dataset} WHERE `id` ='%d'", $dataset->id) );
		
		/**
		 * Fired when a Dataset is deleted
		 *
		 * @param int $dataset_id
		 * @category wp-action
		 */
		do_action('projectmanager_del_dataset', $dataset->id);
		
		return true;
	}
	
	
	/**
	 * check if file is used by another dataset
	 *
	 * @param string $file
	 * @param int $dataset_id
	 * @return boolean
	 */
	private function fileIsUsed( $file, $dataset_id ) {
		global $wpdb;
		
		$project = get_project($this->project_id);
		if ( basename($file) == $project->default_image ) return true;
		
		/* 
		* check that file is not used by another dataset of the project
		*/
		$formfields = $project->getData("formfields");
		$search = array();
		foreach ( $formfields AS $formfield ) {
			$search[] = sprintf("`form_id` = '%d'", $formfield->id);
		}
		
		$query = $wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_datasetmeta} WHERE `value` = '%s' AND `dataset_id` != '%d' AND (".implode(" OR ", $search).")", basename($file), $dataset_id);
		$c = $wpdb->get_var($query);
		if ( $c > 0 ) return true;
		
		return false;
	}
	
	
	/**
	 * delete file
	 *
	 * @param string $file
	 * @param int $dataset_id
	 * @return boolean
	 */
	public function delFile( $file, $dataset_id = false ) {
		$project = get_project($this->project_id);
		
		if ( $this->isImage($file) ) {
			return $this->delImage( $file, $dataset_id );
		} else {
			// don't delete file if it is used by another dataset
			if ( $this->fileIsUsed($file, $dataset_id) ) return false;
			
			@unlink( $project->getFilePath(basename($file)) );
			return true;
		}
	}
	
	
	/**
	 * delete image along with thumbnails from server
	 *
	 * @param string $image
	 * @param int $dataset_id
	 * @return boolean
	 *
	 */
	public function delImage( $image, $dataset_id = false ) {
		$project = get_project($this->project_id);
		
		// don't delete file if it is used by another dataset
		if ( $this->fileIsUsed($image, $dataset_id) ) return false;
		
		/*
		 * delete fancy slideshow resized images
		 */
		$imageurl = $project->getFileURL( basename($image) );
		$slideshow_options = get_option( 'fancy_slideshows' );
		if ( isset($slideshow_options['resized_images'][md5($imageurl)]) ) {
			foreach ( $slideshow_options['resized_images'][md5($imageurl)] AS $container => $img ) {
				@unlink( $img['path'] );
			}
		}
		
		$sizes = array( 'tiny', 'thumb', 'medium', 'large', 'full' );
		foreach ( $sizes AS $size ) {
			@unlink( $project->getImagePath($image, $size) );
		}

		return true;
	}
	
	
	/**
	 * crop image
	 *
	 * @param string $imagepath
	 * @param array $dest_size
	 * @param string $size
	 * @param boolean $crop
	 * @param boolean $force_resize
	 * @return string image url
	 */
	private function resizeImage ( $imagepath, $dest_size, $size, $crop = false, $force_resize = false ) {
		$project = get_project($this->project_id);
		$options = get_option('projectmanager');
		
		// load image editor
		$image = wp_get_image_editor( $imagepath );
		
		$imageurl = $project->getImageURL( $imagepath );
		
		// editor will return an error if the path is invalid - save original image url
		if ( is_wp_error( $image ) ) {
			return $imageurl;
		} else {
			// create destination file name
			$destination_file = $project->getImagePath($imagepath, $size);
			$this->destination_file = $destination_file;

			// resize only if the image does not exists
			if ( !file_exists($destination_file) || $force_resize ) {			
				// resize image, optionally with cropping enabled
				$image->resize( $dest_size['width'], $dest_size['height'], $crop );
				// save image
				$saved = $image->save( $destination_file );
				// return original url if an error occured
				 if ( is_wp_error( $saved ) ) {
					return $imageurl;
				}
			}
			
			$new_img_url = dirname($imageurl) . '/' . basename($destination_file);
			
			// record resized images with key using md5 hash of path to original image
			if ( isset($saved) && !in_array(basename($new_img_url), $options['resized_images'][$project->id][md5($imagepath)]) )
				$options['resized_images'][$project->id][md5($imagepath)][] = basename($new_img_url);
			
			update_option('projectmanager', $options);
			
			return esc_url($new_img_url);
		}
	}
	
	
	/**
	 * Create different thumbnail sizes
	 *
	 * @param string $filename
	 * @param Project $project
	 * @param boolean $force_resize
	 */
	private function createThumbnails($filename, $project, $force_resize = false) {
		$this->project = $project;
		
		$options = get_option('projectmanager');
		/*
		 * create resized image records
		 */
		if ( !isset($options['resized_images']) )
			$options['resized_images'] = array();
	
		if ( !isset($options['resized_images'][$project->id]) ) {
			$options['resized_images'][$project->id] = array();
		}
		
		if ( !isset($options['resized_images'][$project->id][md5($filename)]) ) {
			$options['resized_images'][$project->id][md5($filename)] = array();
		}
		update_option('projectmanager', $options);
			
		// create different thumbnails
		$sizes = array( 'tiny' => $project->tiny_size, 'thumb' => $project->thumb_size, 'medium' => $project->medium_size, 'large' => $project->large_size );
		foreach ( $sizes AS $size => $dest_size ) {
			$crop = ( $project->crop_image[$size] == 1 ) ? true : false;
			$imageurl = $this->resizeImage( $filename, $dest_size, $size, $crop, $force_resize );
		}
	}
	
	
	/**
	 * regenerate all thumbnails of current project
	 *
	 */
	public function regenerateThumbnails() {
		global $wpdb;
		
		if ( !current_user_can('edit_projects_settings') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		$project = get_project($this->project_id);
		
		/*
		 * regenerate project default image thumbnails
		 */
		if ( $project->default_image != '' ) {
			$this->createThumbnails($project->getImagePath($project->default_image), $project, true);
		}
		
		/*
		 * regenerate dataset image thumbnails
		 */
		$datasets = $project->getDatasets(array('limit' => false, 'orderby' => 'id', 'order' => 'ASC'));
		foreach ( $datasets AS $dataset ) {
			// get image-type meta values
			foreach (array('image', 'dataset-image', 'header-image') AS $type) {
				$meta = $dataset->getData("type", $type);
				foreach ( $meta AS $m ) {
					if ( $m->value != "" ) {
						$this->createThumbnails($project->getImagePath($m->value), $project, true);
					}
				}
			}
		}

		$this->setMessage( __( 'Project thumbnails regenerated. You should not reload this page, otherwise thumbnails will be again regenerated.', 'projectmanager' ) );
		$this->printMessage();
	}
	
	
	/**
	 * list or remove unused media files
	 *
	 */
	public function cleanUnusedMediaFiles( ) {
		global $wpdb;
		
		$project = get_project($this->project_id);
		
		$dir = $project->getFilePath();
		$files = array_diff(scandir($dir), array('.','..'));
		$img_sizes = array( 'tiny', 'thumb', 'medium', 'large' );
		// get all thumbnail images
		$thumbs = array();
		foreach ( $img_sizes AS $size ) {
			$thumbs = array_merge($thumbs, preg_grep("/".$size."\_/", $files));
		}
		// remove thumbnail images from filelist
		$files = array_diff($files, $thumbs);
		
		// get formfield ids of current project
		$form_id_sql = array();
		foreach ( $project->getData("formfields") AS $formfield ) {
			$form_id_sql[] = $wpdb->prepare("`form_id` = '%s'", $formfield->id);
		}
		
		// check for default project image
		$file = $project->default_image;
		if ( !empty( $file ) ) {
			$files = array_diff($files, array($file));
			
			$file_info = pathinfo( $project->getFilePath($file) );
			// remove fancy slideshow widget thumbnails of default image
			$files = array_diff($files, preg_grep("/".str_replace(".{$file_info['extension']}", "", basename($file))."-\d+x\d+.+/", $files));
		}
		
		// check if file is used
		foreach ( $files AS $key => $file ) {
			$query = $wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_datasetmeta} WHERE `value` = '%s' AND (".implode(" OR ", $form_id_sql).")", basename($file));
			$num = $wpdb->get_var( $query );
			
			if ( $num > 0 ) {
				$file_info = pathinfo( $project->getFilePath($file) );
				// remove file from list
				unset($files[$key]);
				// remove fancy slideshow widget thumbnails
				$files = array_diff($files, preg_grep("/".str_replace(".{$file_info['extension']}", "", basename($file))."-\d+x\d+.+/", $files));
			}
		}
		
		if ( isset($_POST['delete_unused_files']) ) {
			check_admin_referer('projectmanager_delete-unused-media-files');
			
			foreach ( $files AS $file ) {
				$this->delFile($file);
			}
			echo "<div class='box success updated fade'>";
			echo "<p>".__( 'Unused media files deleted', 'projectmanager' )."</p>";
			echo "</div>";
		} else {
			echo "<div class='box fade'>";
			if ( count($files) == 0 ) {
				echo "<p>".__( 'Congratulations! This project has no orphaned media files.', 'projectmanager' )."</p>";
			} else {
				echo "<p>".__( 'The following files do not do not seem to be used. If this is true you can subsequently delete them.', 'projectmanager' )."</p>";
				echo "<ul>";
				foreach ( $files AS $file ) {
					echo "<li style='margin-left: 2em;'>".$project->getFilePath($file)."</li>";
				}
				echo "</ul>";
				echo "<form action='' method='post'>";
				echo "<input type='submit' class='button-primary' value='".__('Delete unused media files', 'projectmanager')."' />";
				wp_nonce_field( 'projectmanager_delete-unused-media-files' ); 
				echo "<input type='hidden' name='delete_unused_files' value='yes' />";
				echo "</form>";
			}
			echo "</div>";
		}
		
		//return $files;
	}
	

	/**
	 * check if image type is supported
	 *
	 * @param string $image
	 * @return boolean
	 */
	public function isSupportedImage( $image ) {
		if ( in_array($this->getFileType($image), $this->getSupportedImageTypes()) )
			return true;
		
		return false;
	}
	
	
	/**
	 * check if file is image
	 *
	 * @param string $filename
	 * @return boolean
	 */
	public function isImage( $filename ) {
		if ( in_array($this->getFileType($filename), $this->getSupportedImageTypes()) )
			return true;
		
		return false;
	}
	
	
	/**
	 * get image type of supplied image
	 *
	 * @param string $image
	 * @return string
	 */
	public function getFileType( $image ) {
		$project = get_project($this->project_id);
		$file = $project->getFilePath($image);
		$file_info = pathinfo($file);
		return strtolower($file_info['extension']);
	}
	
	
	/**
	 * Upload file to webserver
	 * 
	 * @param array $file
	 * @param boolean $overwrite
	 * @return string|false
	 */
	private function uploadFile( $file, $overwrite = false ) {
		$project = get_project($this->project_id);
		
		$new_file = $project->getFilePath(basename($file['name']));
		$info = pathinfo( $new_file );
		// make sure that file extension is lowercase
		$new_file = str_replace($info['extension'], strtolower($info['extension']), $new_file);
		
		if ( file_exists($new_file) && !$overwrite ) {
			$this->setMessage( __('File exists and is not uploaded. Set the overwrite option if you want to replace it.','projectmanager'), true );
		} else {
			if ( !move_uploaded_file($file['tmp_name'], $new_file) ) {
				$this->setMessage( sprintf( __('The uploaded file could not be moved to %s.' ), $project->getFilePath() ), true );
			} else {
				return $new_file;
			}
		}
		
		return false;
	}
	
	
	/**
	 * Set File for editing datasets
	 * 
	 * @param array $file
	 * @param boolean $overwrite
	 * @param boolean $del
	 * @param string $field_type
	 * @param int $dataset_id
	 * @return string
	 */
	private function editFile( $file, $overwrite, $del, $field_type, $dataset_id ) {	
		$filename = false;
		$del_existing = false;
		if ( !empty($file['name']) ) {
			$overwrite = !empty($overwrite) ? true : false;
			$upload = true;
			// check supported image types
			if ( in_array($field_type, array('image', 'dataset-image', 'header-image')) && !$this->isSupportedImage($file['name']) ) {
				$upload = false;
				$this->setMessage( __('The file type is not supported.','projectmanager'), true );
				$this->printMessage();
			}
			
			if ( $upload ) {
				$filename = $this->uploadFile($file, $overwrite);
				// Delete existing file if it is different to new file
				if ( $file['current'] != '' && basename($file['current']) != basename($filename) ) {
					$del_existing = true;
				}
			} else {
				$filename = '';
			}
		}
		
		if ( $del || $del_existing ) {
			if ( in_array($field_type, array('image', 'dataset-image', 'header-image')) ) {
				$this->delImage($file['current'], $dataset_id);
			} else {
				$this->delFile(basename($file['current']), $dataset_id);
			}
		}
		
		if ( $del )
			$meta_value = '';
		else
			$meta_value = !empty($filename) ? basename($filename) : $file['current'];
			
		return $meta_value;
	}
	
	
	/**
	 * add new Form Field
	 *
	 * @param int $project_id
	 * @param array $formfield
	 * @return int the formfield ID
	 */
	public function addFormField( $project_id, $formfield = false ) {
		global $wpdb;
		
		if ( !current_user_can('edit_formfields') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		$project_id = intval($project_id);
		
		if (!$formfield) {
			$formfield = array();
			$formfield['name'] = '';
			$formfield['type'] = 'text'; 
			$formfield['label_type'] = 'label';
			$formfield['show_in_profile'] = 1;
			$formfield['show_on_startpage'] = 1;
			$formfield['newline'] = 1;
			$formfield['options'] = '';
			$formfield['width'] = 100;
			$formfield['parent_id'] = 0;
		}		
		
		$order_by = (isset($formfield['orderby']) && $formfield['orderby'] == 1) ? 1 : 0;
		$mandatory = (isset($formfield['mandatory']) && $formfield['mandatory'] == 1) ? 1 : 0;
		$unique = (isset($formfield['unique']) && $formfield['unique'] == 1) ? 1 : 0;
		$private = (isset($formfield['private']) && $formfield['private'] == 1) ? 1 : 0;
		$show_on_startpage = (isset($formfield['show_on_startpage']) && $formfield['show_on_startpage'] == 1) ? 1 : 0;
		$show_in_profile = (isset($formfield['show_in_profile']) && $formfield['show_in_profile']) ? 1 : 0;
		$newline = (isset($formfield['newline']) && $formfield['newline'] == 1) ? 1 : 0;
		$parent_id = intval($formfield['parent_id']);

		if ( in_array($formfield['type'], array('paragraph', 'title')) ) {
			$order_by = $mandatory = $unique = $private = $show_on_startpage = 0;
		}
		
		// get maximum order number
		$max_order_sql = $wpdb->prepare("SELECT MAX(`order`) AS `order` FROM {$wpdb->projectmanager_projectmeta} WHERE `project_id` = '%d'", $project_id);
		if (isset($formfield['order']) && $formfield['order'] != '') {
			$order = $formfield['order'];
		} else {
			$max_order_sql = $wpdb->get_results($max_order_sql, ARRAY_A);
			$order = $max_order_sql[0]['order'] +1;
		}

		$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_projectmeta} (`label`, `label_type`, `type`, `show_on_startpage`, `show_in_profile`, `order`, `order_by`, `mandatory`, `unique`, `private`, `options`, `project_id`, `width`, `newline`, `parent_id`) VALUES ( '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%d', '%d');", $formfield['name'], $formfield['label_type'], $formfield['type'], $show_on_startpage, $show_in_profile, $order, $order_by, $mandatory, $unique, $private, $formfield['options'], $project_id, $formfield['width'], $newline, $parent_id ) );
		$formfield_id = $wpdb->insert_id;
				
		/*
		* Populate default values for every dataset
		*/
		if ( $datasets = $wpdb->get_results( $wpdb->prepare("SELECT `id` FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d'", $project_id) ) ) {
			foreach ( $datasets AS $dataset ) {
				$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_datasetmeta} (form_id, dataset_id, value) VALUES ( '%d', '%d', '' );", $formfield_id, $dataset->id ) );
			}
		}
		return $formfield_id;
	}
	
	
	/**
	 * edit Form Field
	 *
	 * @param array $formfield
	 */
	public function editFormField( $formfield ) {
		global $wpdb;
		
		if ( !current_user_can('edit_formfields') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}

		// make sure $formfield_id is numeric
		$formfield_id = intval($formfield['id']);
		
		$order_by = (isset($formfield['orderby']) && $formfield['orderby'] == 1) ? 1 : 0;
		$mandatory = (isset($formfield['mandatory']) && $formfield['mandatory'] == 1) ? 1 : 0;
		$unique = (isset($formfield['unique']) && $formfield['unique'] == 1) ? 1 : 0;
		$private = (isset($formfield['private']) && $formfield['private'] == 1) ? 1 : 0;
		$show_on_startpage = (isset($formfield['show_on_startpage']) && $formfield['show_on_startpage'] == 1) ? 1 : 0;
		$show_in_profile = (isset($formfield['show_in_profile']) && $formfield['show_in_profile']) ? 1 : 0;
		$newline = (isset($formfield['newline']) && $formfield['newline'] == 1) ? 1 : 0;
		$parent_id = intval($formfield['parent_id']);
		
		if ( in_array($formfield['type'], array('paragraph', 'title')) ) {
			$order_by = $mandatory = $unique = $private = $show_on_startpage = 0;
		}
		
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projectmeta} SET `label` = '%s', `label_type` = '%s', `type` = '%s', `show_on_startpage` = '%d', `show_in_profile` = '%d', `order` = '%d', `order_by` = '%d', `mandatory` = '%d', `unique` = '%d', `private` = '%d', `options` = '%s', `width` = '%d', `newline` = '%d', `parent_id` = '%d' WHERE `id` = '%d' LIMIT 1 ;", $formfield['name'], $formfield['label_type'], $formfield['type'], $show_on_startpage, $show_in_profile, $formfield['order'], $order_by, $mandatory, $unique, $private, $formfield['options'], $formfield['width'], $newline, $parent_id, $formfield_id ) );
	}
	
	
	/**
	 * delete Form Field
	 *
	 * @param int $formfield_id
	 * @return boolean
	 */
	public function delFormField( $formfield_id ) {
		global $wpdb;
		
		if ( !current_user_can('edit_formfields') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		// make sure $formfield_id is numeric
		$formfield_id = intval($formfield_id);
		
		// delete formfield metadata from options
		$options = get_option('projectmanager');
		unset($options['form_field_options'][$formfield_id]);
		update_option('projectmanager', $options);
		
		// Remove parent ID from children
		$wpdb->query( $wpdb->prepare("UPDATE {$wpdb->projectmanager_projectmeta} SET `parent_id` = 0 WHERE `parent_id` = '%d'", $formfield_id) );
		
		// delete formfield and formfield data
		$wpdb->query( $wpdb->prepare("DELETE FROM {$wpdb->projectmanager_projectmeta} WHERE `id` = '%d'", $formfield_id) );
		$wpdb->query( $wpdb->prepare("DELETE FROM {$wpdb->projectmanager_datasetmeta} WHERE `form_id` = '%d'", $formfield_id) );
		
		return true;
	}
	
	
	/**
	 * save Form Fields
	 *
	 * @param int $project_id
	 * @param array $formfields
	 */
	public function setFormFields( $project_id, $formfields ) {
		global $wpdb;
		
		if ( !current_user_can('edit_formfields') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}

		$project_id = intval($project_id);

		if ( !empty($formfields) ) {
			foreach ( $wpdb->get_results( "SELECT `id`, `project_id` FROM {$wpdb->projectmanager_projectmeta}" ) AS $form_field) {
				if ( !array_key_exists( $form_field->id, $formfields ) ) {
					if ( $project_id == $form_field->project_id )
						$this->delFormField($form_field->id);
				}
			}
			
			$i = 1;
			foreach ( $formfields AS $id => $formfield ) {
				$formfield['id'] = $id;
				
				// Set formfield order from order of fields if javascript is active
				if ( $_POST['js-active'] == 1 )
					$formfield['order'] = $i;
				
				$this->editFormField( $formfield );
				
				$i++;
			}
		} else {
			$wpdb->query( $wpdb->prepare("DELETE FROM {$wpdb->projectmanager_projectmeta} WHERE `project_id` = '%d'", $project_id)  );
		}
		
		$this->setMessage( __('Form Fields updated', 'projectmanager') );
		
		/**
		 * Fired when formfields are saved
		 *
		 * @param int $project_id
		 * @category wp-action
		 */
		do_action('projectmanager_save_formfields', $project_id);
	}
	
	
	/**
	 * add new category
	 *
	 * @param string $title
	 * @return int the category ID
	 */
	public function addCategory( $title ) {
		global $wpdb;
		
		if ( !current_user_can('edit_categories') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->projectmanager_categories} (`title`, `project_id`) VALUES ( '%s', '%d');", htmlspecialchars($title), $this->project_id	) );
		$cat_id = $wpdb->insert_id;
		
		$this->setMessage( __( 'Category added', 'projectmanager' ) );
		$this->printMessage();
		
		return $cat_id;
	}
	
	
	/**
	 * edit category
	 *
	 * @param string $title
	 * @param int $id
	 */
	public function editCategory( $title, $id ) {
		global $wpdb;
		
		if ( !current_user_can('edit_categories') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_categories} SET `title` = '%s' WHERE `id` = '%d'", htmlspecialchars($title), $id ) );
		
		$this->setMessage( __( 'Category edited', 'projectmanager' ) );
		$this->printMessage();
	}
	
	
	/**
	 * delete category
	 *
	 * @param int $id
	 */
	public function delCategory( $id ) {
		global $wpdb;
		
		if ( !current_user_can('edit_categories') ) {
			$this->setMessage( __("You don't have permission to perform this task", 'projectmanager'), true );
			return false;
		}
		
		$wpdb->query( $wpdb->prepare("DELETE FROM {$wpdb->projectmanager_categories} WHERE `id` = '%d'", intval($id) ) );
	}
	
	
	/**
	 * hook dataset input fields into profile
	 *
	 */
	public function profileHook() {
		global $current_user, $wpdb;
		
		if ( !current_user_can('projectmanager_user') )
			return false;
		
		$options = get_option('projectmanager');

		$projects = array();
		foreach ( $this->getProjects() AS $project ) {
			if ( isset($project->profile_hook) && 1 == $project->profile_hook ) 
				$projects[] = $project;
		}

		if ( !empty($projects) ) {
			foreach ( $projects AS $project ) {
				$project = get_project($project);
			
				$user_id = (isset($_GET['user_id'])) ? intval($_GET['user_id']) : intval($current_user->ID);
				
				$is_profile_page = true;
				$dataset = $wpdb->get_row( $wpdb->prepare("SELECT `id`, `sticky`, `cat_ids`, `project_id`, `user_id`, `order`, `status`, `activationkey` FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d' AND `user_id` = '%d' LIMIT 1", $project->id, $user_id) );
				$dataset = get_dataset($dataset);
					
				if ( $dataset ) {
					$dataset->cat_ids = array_keys($dataset->categories);
					$meta_data = array();
					foreach ($dataset->getData() AS $data) {
						$meta_data[$data->form_field_id] = $data->value;
					}
					
					echo '<h3>'.$project->title.'</h3>';
					echo '<input type="hidden" name="project_id['.$dataset->id.']" value="'.$project->id.'" /><input type="hidden" name="dataset_id[]" value="'.$dataset->id.'" /><input type="hidden" name="user_id" value="'.$user_id.'" />';
				
					//$this->loadTinyMCE();
					include( dirname(__FILE__). '/dataset-form.php' );
				}
			}
		}
	}
	
	
	/**
	 * update Profile settings
	 *
	 * @param int $user_id
	 */
	public function updateProfile($user_id) {
		// only saves if the current user can edit user profiles
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;		

		#print_r($_POST);
		foreach ( (array)$_POST['dataset_id'] AS $id ) {
			$id = intval($id);
			$project_id = intval($_POST['project_id'][$id]);
			$this->project_id = $project_id;
			$sticky = 0;
			
			$this->editDataset( $project_id, $_POST['category'][$id], $id, $_POST['form_field'][$id], $user_id, $sticky, true );
		}
	}
	
	
	/**
	 * create PDF of a dataset
	 *
	 * @param int $dataset_id
	 * @param boolean $download
	 * @return string|false
	 */
	public function createPDF( $dataset_id, $download = true ) {
		$filename = "Dataset_ID-".$dataset_id.".pdf";
		$pdf = new PDF();
		$pdf->setDatasetID($dataset_id);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->printDatasetContent();
		if ( $download ) {
			$pdf->Output("D", $filename, false);
			return false;
		} else {
			$pdf->Output("F", $this->getFilePath($filename), false);
			return $this->getFilePath($filename);
		}
	}
	
	
	/**
	 * create PDF of dataset form
	 *
	 * @param int $project_id
	 * @param boolean $download
	 * @return string|false
	 */
	public function createFormPDF( $project_id, $download = true ) {
		$project = get_project($project_id);
		$filename = $project->title."_Form.pdf";
		
		$pdf = new PDF();
		$pdf->setProjectID($project_id);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->printForm();
		if ( $download ) {
			$pdf->Output("D", $filename, false);
			return false;
		} else {
			$pdf->Output("F", $project->getFilePath($filename), false);
			return $project->getFilePath($filename);
		}
	}
	
	
	/**
	 * add dataset from shortcode from
	 *
	 * @return boolean
	 */
	public function addDatasetShortcode() {
		$project = get_project();
		$options = get_option('projectmanager');
		
		if (isset($_POST['projectmanager_captcha'])) {
			$captcha = (isset($project->captcha['use']) && $project->captcha['use'] == 1) ? true : false;
			$captcha_timeout = intval($project->captcha['timeout']);
		
			$captcha_filename = $_POST['projectmanager_captcha_id'];
			$code = isset($options['captcha'][$captcha_filename]) ? $options['captcha'][$captcha_filename]['code'] : '';
			$captcha_time = isset($options['captcha'][$captcha_filename]) ? $options['captcha'][$captcha_filename]['time'] : 0;
				
			$now = time();
			// if timeout is specified in minutes
			if ($captcha_timeout > 0 && ($now - $captcha_time)/60 > $captcha_timeout) {
				$this->setMessage(__('Your session has expired', 'projectmanager'), true);
			} elseif ($code == "") {
				$this->setMessage(__('Something went wrong with the captcha', 'projectmanager'), true);
			} elseif ($_POST['projectmanager_captcha'] != $code) {
				$this->setMessage(__('Wrong Captcha Code', 'projectmanager'), true);
			}
				
			// delete captcha and data if an error occured
			if ($this->isError()) {
				// delete captcha image and unset options
				@unlink($this->getCaptchaPath($captcha_filename));
				unset($options['captcha'][$captcha_filename]);
				update_option('projectmanager', $options);
			} else {
				check_admin_referer( 'projectmanager_insert_dataset' );
				$category = isset($_POST['category']) ? $_POST['category'] : '';
				$dataset_id = $this->addDataset( intval($_POST['project_id']), $category, $_POST['form_field'], intval($_POST['user_id']) );
				
				if (!$this->isError()) {
					$message = ( $project->form_submit_message != "" ) ? htmlspecialchars(strip_tags(stripslashes($project->form_submit_message))) : __('Dataset added to the database', 'projectmanager');
					$this->setMessage($message);
					
					$pdf_file = $this->createPDF($dataset_id, false);
					
					// Send e-mail confirmation
					if ( $project->email_confirmation != 0 && $dataset_id ) {
						$project->sendConfirmation(get_dataset($dataset_id), $pdf_file);
						
						if ( ! $project->sendConfirmation(get_dataset($dataset_id), $pdf_file) )
							$this->setMessage( $this->getMessage() . "<p>" . __( 'An error occured while trying to send E-Mail confirmation.' ) . "</p>", true );
					}
					
					// Send notification about new dataset
					if ( $project->notify_new_datasets == 1 && $project->email_confirmation_sender != '' && $dataset_id && $project->email_notification_subject != "" && $project->email_confirmation_text != '' ) {
						$project->sendNotification($pdf_file);
					}
					
					// Delete dataset details PDF file
					@unlink($pdf_file);
				
					if ($captcha) {
						// delete captcha image and unset options
						@unlink($this->getCaptchaPath($captcha_filename));
						unset($options['captcha'][$captcha_filename]);
						update_option('projectmanager', $options);
					}
				}
			}
		}
		
		// returns false on success
		return $this->isError();
	}
	
	
	/**
	 * show database columns of ProjectManager
	 */
	private function showDatabaseColumns() {
		global  $wpdb;
		
		$tables = array($wpdb->projectmanager_projects, $wpdb->projectmanager_categories, $wpdb->projectmanager_projectmeta, $wpdb->projectmanager_dataset, $wpdb->projectmanager_datasetmeta, $wpdb->projectmanager_countries);
		
		foreach( $tables AS $table ) {
			$results = $wpdb->get_results("SHOW COLUMNS FROM {$table}");
			$columns = array();
			foreach ( $results AS $result ) {
				$columns[] = "<li>".$result->Field." ".$result->Type.", NULL: ".$result->Null.", Default: ".$result->Default.", Extra: ".$result->Extra."</li>";
			}
			echo "<p>Table ".$table."<ul>";
			echo implode("", $columns);
			echo "</ul></p>";
		}
	}
}
?>