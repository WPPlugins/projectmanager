<?php
/**
 * ProjectManagerShortcodes API: ProjectManagerShortcodes class
 *
 * @author Kolja Schleich
 * @package ProjectManager
 * @subpackage ProjectManagerShortcodes
 */
 
/**
 * Class to implement shortcode functions
 *
 */
class ProjectManagerShortcodes extends ProjectManager {
	/**
	 * control global search is displayed only once
	 *
	 * @var boolean
	 */
	private $display_global_search = true;
	
	
	/**
	 * initialize shortcodes
	 *
	 */
	public function __construct() {
		add_shortcode( 'dataset', array(&$this, 'displayDataset') );
		add_shortcode( 'project', array(&$this, 'displayProject') );
		add_shortcode( 'dataset_form', array(&$this, 'displayDatasetForm') );
		add_shortcode( 'projectmanager_counter', array(&$this, 'displayCounter') );
		add_shortcode( 'testimonials', array(&$this, 'displayTestimonials') );
		add_shortcode( 'projectmanager_search', array(&$this, 'displayGlobalSearchResults') );
		add_shortcode( 'projectmanager_map', array(&$this, 'displayWorldMap') );
		
		add_action( 'projectmanager_selections', array(&$this, 'displaySelections') );
		add_action( 'projectmanager_searchform', array(&$this, 'displaySearchForm') );
	}
	
	
	/**
	 * Load template for user display.
	 * 
	 * Checks first the current theme directory for a template before defaulting to the plugin
	 *
	 * @param string $template Name of the template file (without extension)
	 * @param array $vars Array of variables name=>value available to display code (optional)
	 * @return string the content
	 */
	private function loadTemplate( $template, $vars = array() ) {
		extract($vars);
		
		ob_start();
		if ( file_exists( TEMPLATEPATH . "/projectmanager/$template.php")) {
			include(TEMPLATEPATH . "/projectmanager/$template.php");
		} elseif ( file_exists(PROJECTMANAGER_PATH . "/templates/$template.php") ) {
			include(PROJECTMANAGER_PATH . "/templates/$template.php");
		} else {
			$loaded = false;
			/**
			 * Fires when template is loaded.
			 *
			 * Templates are first searched for in the theme directory in a subdirecory *projectmanager*, secondly in the projectmanager templates directory.
			 * Lastly, this filter is used to extend the template search path.
			 *
			 * @param array $paths
			 * @return array
			 * @category wp-filter
			 */
			$template_paths = apply_filters('projectmanager_template_paths', array());
			if ( count($template_paths) > 0 ) {
				foreach ( $template_paths AS $path ) {
					if ( file_exists( $path . "/$template.php" ) ) {
						include($path . "/$template.php");
						$loaded = true;
					}
				}
			}
			
			if ( !$loaded ) {
				$this->setMessage( sprintf(__('Could not load template %s.php', 'projectmanager'), $template), true );
				$this->printMessage();
			}
		}
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
	
	
	/**
	 * display world map with number of datasets using Interactive Maps Plugin
	 *
	 * [projectmanager_map project_id="x"]
	 *
	 * - project_id is the ID of the project to display
	 *
	 * @param array $atts
	 * @return string
	 */
	public function displayWorldMap( $atts ) {
		extract(shortcode_atts(array(
			'project_id' => 0
		), $atts ));
		
		// prevent display for private project
		$project = get_project($project_id);
		if ( $project->is_private == 1 )
			return '';
		
		$map = new PM_Map(intval($project_id));
		return $map->display();
	}
	
	
	/**
	 * Display search formular
	 *
	 * This function is called via do_action('projectmanager_searchform') and loads the template searcform.php
	 *
	 * @param array $atts
	 */
	public function displaySearchForm( $atts ) {
		extract(shortcode_atts(array(
			'project_id' => 0,
			'template' => ''
		), $atts ));
		
		$project = get_project(intval($project_id));
		
		// prevent display for private project
		if ( $project->is_private == 0 ) {
			$filename = ($template != "") ? 'searchform-'.$template : 'searchform';
			$out = ( !isset($_GET['show_'.$project->id]) ) ? $this->loadTemplate( $filename, array('project' => $project) ) : '';
			echo $out;
		}
	}
		
	
	/**
	 * Display selections dropdown 
	 *
	 * This function is called via do_action('projectmanager_selections') and loads the template selections.php
	 *
	 * @param int $project_id
	 */
	public function displaySelections( $project_id = false ) {
		$project = get_project($project_id);
		
		// prevent display for private project
		if ( $project->is_private == 0 )
			echo $this->loadTemplate( 'selections', array( 'project' => $project ) );
	}
	
	
	/**
	 * Display dataset form
	 *
	 * [dataset_form project_id="x" template=""]
	 *
	 * - project_id is the ID of the project to display
	 * - template is the template file without extension
	 *
	 * @param array $atts
	 * @return string
	 */
	public function displayDatasetForm( $atts ) {
		global $project, $current_user;

		extract(shortcode_atts(array(
			'project_id' => 0,
			'template' => '',
		), $atts ));

		$project = get_project(intval($project_id));
		
		// prevent display for private project
		if ( $project->is_private == 1 )
			return '';
		
		$project->loadFormFields(true, true); // make sure that all formfields are loaded
				
		$captcha = (isset($project->captcha['use']) && $project->captcha['use'] == 1) ? true : false;		
		// Generate captcha if form has not been submitted
		if (!isset($_POST['insertDataset']) && $captcha) {
			$captcha = $this->generateCaptcha( $project->captcha['length'], $project->captcha['nlines'], $project->captcha['ndots'], $project->captcha['letters'] );
		}
		
		$message = "";
		$error = false;
		if (isset($_POST['insertDataset'])) {
			require_once (PROJECTMANAGER_PATH . '/admin/admin.php');	
			$admin = new ProjectManagerAdmin(false);
			$error = $admin->addDatasetShortcode();
			$message = $admin->getMessage();
		}
		
		// Dataset activation
		if ( isset($_GET['activate']) ) {
			if ( $this->activateDataset(intval($_GET['id']), $_GET['activate']) ) {
				$message = __( 'Confirmation successful', 'projectmanager' );
			} else {
				$message = __( 'Confirmation failed', 'projectmanager' );
				$error = true;
			}
		}
		
		$edit = false;
		$dataset = (object) array('id' => 'new', 'cat_ids' => array(), 'user_id' => $current_user->ID);
		$meta_data = array();

		$form_class = '';
		foreach ( $project->getData("formfields") AS $formfield ) {
			if ($formfield->width < 100) {
				$form_class = 'grid-input';
				break;
			}
		}
		
		$this->loadTinyMCE(); 
		$this->setMessage( $message, $error );
		
		$filename = ($template == "") ? 'dataset-form' : 'dataset-form-'.$template;
		$out = $this->loadTemplate( $filename, array('dataset' => $dataset, 'project' => $project, 'meta_data' => $meta_data, 'edit' => $edit, 'captcha' => $captcha, 'message' => $message, 'error' => $error, 'form_class' => $form_class) );

		return $out;
	}
	
	
	/**
	 * Display the project in a page or post as list.
	 *
	 * [project id="x" template="table|gallery"]
	 *
	 * - id is the ID of the project to display
	 * - template is the template file without extension. Default values are "table" or "gallery".
	 *
	 * It follows a list of optional attributes
	 *
	 * - cat_id: specify a category to only display those datasets. all datasets will be displayed if missing
	 * - orderby: 'order', 'id' or 'formfield_X' where x is the formfield ID (default 'name')
	 * - order: 'asc' or 'desc' (default 'asc')
	 * - single: control if link to sigle dataset is displayed. Either 'true' or 'false' (default 'true')
	 * - selections: control wether or not selection panel is dislayed (default 'true')
	 *
	 * @param array $atts
	 * @return string
	 */
	public function displayProject( $atts ) {
		global $project;
		
		// Stop to display global search results
		if ($this->isGlobalSearch() && $this->display_global_search) {
			$this->displayGlobalSearchResults( true );
			return "";
		}
		
		extract(shortcode_atts(array(
			'id' => 0,
			'template' => 'table',
			'cat_id' => 0,
			'orderby' => false,
			'order' => false,
			'single' => 'true',
			'selections' => 'true',
			'searchform' => 'true',
			'results' => true,
			'field_id' => 0,
			'field_value' => '',
			'show_title' => 'false'
		), $atts ));

		$project = get_project(intval($id));

		// prevent display for private project
		if ( $project->is_private == 1 )
			return '';
		
		$project->searchform = $searchform == 'true';
		$project->selections = $selections == 'true';
		$project->show_title = $show_title == 'true';
		
		if ( !isset($_GET["show_".$project->id]) ) {
			$project->hasDetails($single == 'true');
			
			if (intval($field_id) > 0 && !empty($field_value)) $meta = array(intval($field_id) => $field_value); else $meta = array();
			$query_args = array( 'cat_id' => $cat_id, 'limit' => $results, 'orderby' => $orderby, 'order' => $order, 'random' => $orderby == 'rand', 'meta' => $meta, 'status' => 'active');
			$project->getDatasets($query_args);
		}
		
		$out = $this->loadTemplate( $template, array('project' => $project) );
		
		return $out;
	}
	
	
	/**
	 * Display global search results.
	 *
	 * It is automatically invoked from ProjectManagerShortcodes::displayProject() but can also be used on a separate page with the shortcode [projectmanager_search]
	 *
	 * @param boolean $echo
	 * @return string|void
	 */
	public function displayGlobalSearchResults( $echo = false ) {
		global $dataset, $project;
		
		$this->display_global_search = false;
		
		$out = "";
		if (!$this->isGlobalSearch())
			return "";
				
		$template = isset($_GET['template']) ? htmlspecialchars($_GET['template']) : 'table';
		
		foreach ($this->getProjects() AS $project) {
			$project = get_project($project);
			$project->show_title = true;
			$project->searchform = false;
			$project->selections = false;
				
			if ( !isset($_GET["show_".$project->id]) ) {			
				$project->getDatasets();
			}
			
			if ( $project->is_private == 0 && ($project->datasets || $project->isSelectedDataset()) )
				$out .= $this->loadTemplate( $template, array('project' => $project) );		
		}
		
		if ( $echo )
			echo $out;
		else
			return $out;
	}
	
	
	/**
	 * Display a single dataset. Loaded by function list and gallery
	 *
	 *	[dataset id="1" template="" ]
	 *
	 * - id is the ID of the dataset to display
	 * - template is the name of a template (without extension). Will use default template dataset.php if missing or empty
	 *
	 * @param array $atts
	 * @return string
	 */
	public function displayDataset( $atts ) {
		global $dataset;
			
		extract(shortcode_atts(array(
			'id' => 0,
			'template' => ''
		), $atts ));

		// get global project
		$project = get_project();
		$dataset = get_dataset(intval($id));
		
		// make sure that within a project only datasets belonging to this project are displayed
		if (!is_null($project) && $dataset->project_id != $project->id)
			$dataset = false;

		// prevent display for private project
		$project = get_project($dataset->project_id);
		if ( $project->is_private == 1 )
			return '';
		
		$filename = ( empty($template) ) ? 'dataset' : 'dataset-'.$template;
		$out = $this->loadTemplate( $filename, array('dataset' => $dataset) );

		return $out;
	}
	
	
	/**
	 * Display the number of datasets in given project
	 *
	 *	[projectmanager_counter project_id="1" field="datasets|countries"]
	 *
	 * - project_id is the ID of the project
	 * - field
	 * - text optional text
	 *
	 * @param array $atts
	 * @return string
	 */
	public function displayCounter( $atts ) {
		extract(shortcode_atts(array(
			'project_id' => 0,
			'field' => 'datasets',
			'text' => '',
		), $atts ));
		
		$project = get_project(intval($project_id));
		
		// prevent display for private project
		if ( $project->is_private == 1 )
			return '';
		
		$field = explode("_", $field);
		
		$num = 0;
		if ( $field[0] == 'datasets' ) { 
			$num = $project->num_datasets_total;
		}
	
		if ( $field[0] == 'countries' ) {
			$formfield_id = isset($field[1]) ? intval($field[1]) : false;
			$num = $project->getNumCountries($formfield_id);
		}
		
		if ($text == "")
			return "<span class='projectmanager_counter'>".$num."</span>";
		else
			return "<div class='projectmanager_counter'><p><span class='text'>". $text."</span> <span class='number'>".$num."</span></p></div>";
	}

	
	/**
	 * Display Testimonials
	 *
	 *	[testimonials project_id="x" number= comment= country= city= ncol= title= sign_page_id= list_page_id= template=]
	 *
	 * - project_id is the ID of the project to display
	 * - number is the number of random datasets
	 * - comment, country, city are the formfield IDs for those dataset
	 * - ncol is the number of columns
	 * - sign_page_id is the page ID containing the petition signing form. Can be also an anker if formular is on the same page
	 * - list_page_id is the page ID containing a list of all supporters
	 * - template should be either empty or "intro"
	 *
	 * @param array $atts
	 * @return string
	 */
	public function displayTestimonials( $atts ) {
		global $project;//, $dataset;
		
		// Stop to display global search results
		if ($this->isGlobalSearch() && $this->display_global_search) {
			$this->displayGlobalSearchResults( true );
			return "";
		}
		
		extract(shortcode_atts(array(
			'project_id' => 0,
			'number' => 6,
			'comment' => 0,
			'city' => 0,
			'country' => 0,
			'ncol' => 3,
			'sign_page_id' => 0,
			'list_page_id' => 0,
			'template' => '',
			'searchform' => 'true',
			'selections' => 'true',
			'single' => 'true',
			'show_title' => false
		), $atts ));
		
		$project = get_project(intval($project_id));
		
		// prevent display for private project
		if ( $project->is_private == 1 )
			return '';
		
		$map = new PM_Map($project->id);
		
		$project->searchform = ( $searchform == 'true' ) ? true : false;
		$project->selections = ( $selections == 'true' ) ? true : false;
		$project->show_title = $show_title;

		if (!empty($sign_page_id))
			$project->sign_petition_href = is_numeric($sign_page_id) ? esc_url(get_permalink($sign_page_id)) : htmlspecialchars($sign_page_id);
		else
			$project->sign_petition_href = "";
		
		$project->list_page_href = (!empty($list_page_id)) ? esc_url(get_permalink(intval($list_page_id))) : '';

		if ( !isset($_GET["show_".$project->id]) ) {
			$comment_field = $project->getData("formfields", "id", intval($comment), 1);
			
			if ($template == "intro") $project->setNumCols($ncol);
			$project->num_countries = $project->getNumCountries(intval($country));
			$project->hasDetails($single == 'true');
			
			$query_args = ($template == "intro") ? array('limit' => intval($number), 'random' => true, 'status' => 'active') : array('limit' => true, 'orderby' => 'id', 'order' => 'DESC', 'random' => false, 'status' => 'active');
			$datasets = $project->getDatasets( $query_args );
					
			foreach ($datasets AS $i => $dataset) {
				// Trim comment in intro template
				if ( $template == "intro" ) {
					$more = "[...]";
				} else {
					$more = "<a href='".esc_url(get_permalink())."?show_".$project->id."=".$dataset->id."&order_".$project->id."=".$project->getDatasetOrder()."&orderby_".$project->id."=".$project->getDatasetOrderBy()."'>[...]</a>";
				}
				$dataset->comment = $dataset->textExcerpt($dataset->getData("form_field_id", $comment_field->id, 1), explode(";", $comment_field->options), $more);			
				$dataset->country = $map->getCountryName($dataset->getData("form_field_id", intval($country), 1));
				$dataset->city = $dataset->getData("form_field_id", intval($city), 1);
							
				$datasets[$i] = $dataset;
			}
			$project->datasets = $datasets;
		}
		
		$template = ($template == "") ? "testimonials" : "testimonials-".$template;
		$out = $this->loadTemplate( $template, array('project' => $project) );
		
		return $out;
	}
}
?>