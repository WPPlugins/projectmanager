<?php
/**
 * Project API: Project class
 *
 * @author Kolja Schleich
 * @package ProjectManager
 * @subpackage Project
 */
 
/**
 * Class to implement the Project object
 *
 */
final class Project {
	/**
	 * Project ID
	 *
	 * @var int
	 */
	public $id;
	
	/**
	 * Parent Project ID
	 *
	 * @var int
	 */
	public $parent_id = 0;
	
	/**
	 * Project Title
	 *
	 * @var string
	 */
	public $project_title;
	
	/** 
	 * private flag
	 *
	 * @var int
	 */
	public $is_private = 0;
	
	/**
	 * Current Project Title
	 *
	 * @var int
	 */
	public $title;
	
	/**
	 * datasets per page
	 *
	 * @var int
	 */
	public $per_page = 15;
	
	/**
	 * what field to order datasets by
	 *
	 * @var string
	 */
	public $dataset_orderby = "id";
	
	/**
	 * how to order datasets
	 *
	 * @var string
	 */
	public $dataset_order = "ASC";
	 
	/**
	 * what field to order categories by
	 *
	 * @var string
	 */
	public $category_orderby = "title";
	 
	/**
	 * how to order categories
	 *
	 * @var string
	 */
	public $category_order = "ASC";
	
	/**
	 * how to select categories
	 *
	 * @var string
	 */
	public $category_selections = "multiple";
	
	/**
	 * set navigation link?
	 *
	 * @var int 0 or 1
	 */
	public $navi_link = 0;
	
	/**
	 * hook into profile
	 *
	 * @var int 0 or 1
	 */
	public $profile_hook = 0;
	
	/**
	 * menu icon
	 *
	 * @var string
	 */
	public $menu_icon = "databases.png";
	
	/**
	 * number of columns in gallery view
	 *
	 * @var int
	 */
	public $gallery_num_cols = 4;
	
	/**
	 * project page ID
	 *
	 * @var int
	 */
	public $page_id = 0;
	
	/**
	 * scramble email in frontend?
	 *
	 * @var int 0 or 1
	 */
	public $scramble_email = 1;
	
	/**
	 * default dataset image
	 *
	 * @var string
	 */
	public $default_image = "";
	
	/**
	 * tiny image size
	 *
	 * @var array
	 */
	public $tiny_size = array("width" => 80, "height" => 50);
	
	/**
	 * thumbnail image size
	 *
	 * @var array
	 */
	public $thumb_size = array("width" => 100, "height" => 100);
	
	/**
	 * medium image size
	 *
	 * @var array
	 */
	public $medium_size = array("width" => 300, "height" => 300);
	
	/**
	 * large image size
	 *
	 * @var array
	 */
	public $large_size = array("width" => 1024, "height" => 1024);
	
	/**
	 * crop images?
	 *
	 * @var array with 0 or 1's
	 */
	public $crop_image = array('tiny' => 1, 'thumb' => 1, 'medium' => 0, 'large' => 0);
	
	/**
	 * set dataset editing
	 *
	 * @var int 0 (yes) or 1 (no)
	 */
	public $no_edit = 0;
	
	/**
	 * require dataset activation
	 *
	 * @var int 0 or 1
	 */
	public $dataset_activation = 0;
	
	/**
	 * dataset form page ID
	 *
	 * @var int
	 */
	public $datasetform_page_id = 0;
	
	/**
	 * dataset form submit message
	 *
	 * @var string
	 */
	public $form_submit_message = "";
	
	/**
	 * E-Mail field to send confirmation to
	 *
	 * @var int
	 */
	public $email_confirmation = 0;
	
	/**
	 * E-Mail confirmation sender mail
	 *
	 * @var string
	 */
	public $email_confirmation_sender = "";
	
	/**
	 * E-Mail confirmation subject
	 *
	 * @var string
	 */
	public $email_confirmation_subject = "";
	
	/**
	 * E-Mail confirmation text
	 *
	 * @var string
	 */
	public $email_confirmation_text = "";
	
	/**
	 * attach PDF to E-Mail confirmation
	 *
	 * @var int 0 or 1
	 */
	public $email_confirmation_pdf = 0;
	
	/**
	 * notify admin about new datasets
	 *
	 * @var int 0 or 1
	 */
	public $notify_new_datasets = 0;
	
	/**                                                          
	 * Notification E-Mail Subject
	 *
	 * @var string
	 */
	public $email_notification_subject = "";
	
	/**
	 * Notification E-Mail text
	 *
	 * @var string
	 */
	public $email_notification_text = "";
	
	/**
	 * attach PDF to E-Mail notification?
	 *
	 * @var int 0 or 1
	 */
	public $email_notification_pdf = 0;
	
	/**
	 * captcha settings
	 *
	 * @var array
	 */
	public $captcha = array('use' => 0, 'timeout' => 30, 'length' => 6, 'ndots' => 300, 'nlines' => 0, 'letters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890');
	
	/**
	 * slideshow settings
	 *
	 * @var array
	 */
	public $slideshow = array( 'dataset_orderby' => 'id', 'dataset_order' => 'DESC', 'page_id' => '', 'num_datasets' => 5, 'dataset_ids' => '' );
	
	/**
	 * map settings
	 *
	 * @var array
	 */
	public $map = array('field' => '', 'dataset_label' => '', 'update_schedule' => 'manually', 'data' => array('last_updated' => 0, 'num_datasets_by_region' => 0, 'num_datasets_regions' => 0, 'num_datasets_by_country' => 0));
	
	/**
	 * settings keys
	 *
	 * @var array
	 */
	private $settings_keys = array();
	
	/**
	 * number of pages
	 *
	 * @var int
	 */
	public $num_pages = 1;
	
	/**
	 * number of datasets
	 *
	 * @var int
	 */
	public $num_datasets = 0;

	/**
	 * total number of datasets
	 *
	 * @var int
	 */
	public $num_datasets_total = 0;
	
	/**
	 * pagination
	 *
	 * @var string
	 */
	public $pagination = '';
	
	/**
	 * dataset Objects
	 *
	 * @var array
	 */
	public $datasets = array();
	
	/**
	 * current dataset index
	 *
	 * @var int
	 */
	public $current_dataset = -1;
	
	/**
	 * loop control
	 *
	 * @var boolean
	 */
	public $in_the_loop = false;
	
	/**
	 * formfields
	 *
	 * @var array
	 */
	public $formfields = array();
	
	/**
	 * number of formfields
	 *
	 * @var int
	 */
	public $num_formfields = 0;
	
	/**
	 * categories
	 *
	 * @var array
	 */
	public $categories = array();
	
	/**
	 * number of categories
	 *
	 * @var int
	 */
	public $num_categories = 0;

	/**
	 * query arguments
	 *
	 * @var array
	 */
	private $query_args = array();

	/**
	 * dataset query arguments
	 *
	 * @var array
	 */
	private $dataset_query_args = array( 'limit' => true, 'sticky' => true, 'count' => false, 'orderby' => 'id', 'order' => 'ASC', 'random' => false, 'meta' => array(), 'ids' => array(), 'status' => false, 'formfield_id' => 0, 'cat_id' => 0, 'offsets' => false, 'override_order' => false );
	
	/**
	 * dataset query argument types
	 *
	 * @var array
	 */
	private $dataset_query_args_types = array( 'limit' => 'numeric', 'sticky' => 'boolean', 'count' => 'boolean', 'orderby' => 'string', 'order' => 'string', 'random' => 'boolean', 'meta' => 'array', 'ids' => 'array_numeric', 'status' => 'string', 'formfield_id' => 'numeric', 'cat_id' => 'numeric', 'offsets' => 'boolean', 'override_order' => 'boolean' );
	
	/**
	 * reporting message
	 *
	 * @var string
	 */
	private $message = '';
	
	/**
	 * error control
	 *
	 * @var boolean
	 */
	private $error = false;
	
	/**
	 * dataset offsets
	 *
	 * @var array
	 */
	private $dataset_offsets = array();
	
	/**
	 * control if datasets have detailed values (i.e. show_on_startpage = 0 for some formfields)
	 *
	 * @var boolean
	 */
	private $hasDetails = null;
	
	/**
	 * width in percent of datasets for multicolumn views
	 *
	 * @var int
	 */
	public $dataset_width = 100;
	
	/**
	 * dataset is selected
	 *
	 * @var boolean
	 */
	public $is_selected_dataset = false;
	
	
	/**
	 * retrieve project instance
	 *
	 * @param int $project_id
	 * @return Project|false
	 */
	public static function get_instance($project_id) {
		global $wpdb;

		$project_id = (int) $project_id;
		if ( ! $project_id )
			return false;

		$project = wp_cache_get( $project_id, 'projects' );
		
		if ( ! $project ) {
			$project = $wpdb->get_row( $wpdb->prepare( "SELECT `id`, `parent_id`, `title`, `settings` FROM $wpdb->projectmanager_projects WHERE id = %d LIMIT 1", $project_id ) );
			
			if ( !$project ) return false;
		
			$project = new Project( $project );
			
			wp_cache_add( $project->id, $project, 'projects' );
		}
		
		return $project;
	}
	
	
	/**
	 * Constructor
	 *
	 * @param object $project Project object
	 */
	public function __construct( $project ) {
		if (isset($project->settings)) {
			$project = (object) array_merge( (array)$project, (array)maybe_unserialize($project->settings) );
			$project->settings_keys = array_keys((array)maybe_unserialize($project->settings));
			unset($project->settings);
		}
		
		foreach ( get_object_vars( $project ) as $key => $value )
			$this->$key = $value;
		
		$this->title = stripslashes($this->title);
		$this->project_title = $this->title;
		
		$this->setCatID();
		
		$this->setQueryArgs();
		$this->setDatasetQueryArgs();
		
		$this->setCurrentPage();
		$this->getNumDatasets(true);
		
		if ( $this->gallery_num_cols == 0 ) $this->gallery_num_cols = 4;
		$this->dataset_width = 100/$this->gallery_num_cols;
		
		$this->is_selected_dataset = $this->isSelectedDataset();
	}
	
	
	/**
	 * set detault dataset query arguments
	 */
	private function setDatasetQueryArgs() {
		/*
		* get country selection
		*/
		$country_filter = array();
		foreach ( $matches = preg_grep("/country_".$this->id."_\d+/", array_keys($_GET)) AS $key ) {
			$x = explode("_", $key);
			if (!empty($_GET[$key])) {
				$country_filter[$x[2]] = $_GET[$key];
				$this->setQueryArg($key, $_GET[$key]);
			}
		}
		
		/*
		foreach ( $matches = preg_grep("/country_\d+/", array_keys($_POST)) AS $key ) {
			$x = explode("_", $key);
			if (!empty($_POST[$key])) {
				$country_filter[$x[2]] = $_POST[$key];
			}
		}
		*/
	
		if (count($country_filter) > 0)
			$this->setDatasetQueryArg('meta', $country_filter, false);
		
		$this->setDatasetOrder();
		
		// set number of datasets per page
		$this->setDatasetQueryArg('limit', $this->per_page);
		
		// get only active datasets in frontend
		if ( !is_admin() ) $this->setDatasetQueryArg( 'status', 'active' );
	}
	
	
	/**
	 * set default query arguments
	 *
	 */
	private function setQueryArgs() {
		if (is_admin()) $this->setQueryArg('project_id', $this->id);
	}
	
	
	/**
	 * set query args
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	private function setQueryArg($key, $value) {
		$this->query_args[$key] = $value;
	}
	
	
	/**
	 * check if project is parent or child
	 *
	 * @return boolean
	 */
	public function isParent() {
		if ( $this->parent_id == 0)
			return true;
		
		return false;
	}
	
	
	/**
	 * get child projects
	 *
	 * @return array
	 */
	public function getChildren() {
		global $wpdb;
		
		$projects = $wpdb->get_results( $wpdb->prepare("SELECT `id`, `parent_id`, `title`, `settings` FROM {$wpdb->projectmanager_projects} WHERE `parent_id` = '%d' ORDER BY `title` ASC", $this->id) );
		
		$class = '';
		foreach ( $projects AS $i => $project ) {
			get_project($project);
			
			$class = ( 'alternate' == $class ) ? '' : 'alternate';
			$project->cssClass = $class;
			
			$projects[$i] = $project;
		}
		
		return $projects;
	}
	
	
	/**
	 * check if project has children
	 *
	 * @return boolean
	 */
	public function hasChildren() {
		global $wpdb;
		
		$num = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_projects} WHERE `parent_id` = '%d'", $this->id) );
		
		if ( $num > 0 )
			return true;
		
		return false;
	}
	
	
	/**
	 * set dataset query argument
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param boolean $replace - used for arrays to add arguments or replace with values
	 */
	public function setDatasetQueryArg( $key, $value, $replace = true ) {
		if ($key == 'limit' && ($value === true || $value == "true")) $value = $this->per_page;

		/*
		 * sanitize query arg types
		 */
		if ($this->dataset_query_args_types[$key] == 'numeric')
			$value = intval($value);
		if ($this->dataset_query_args_types[$key] == 'boolean')
			$value = intval($value) == 1;
		
		if (is_array($this->dataset_query_args[$key]) && !$replace) {
			if (!is_array($value)) $value = array($value);
			$this->dataset_query_args[$key] = array_merge($this->dataset_query_args[$key], $value);
		} else {
			// make sure that ordering arguments are valid
			if ($key == 'order') $value = $this->getDatasetOrder($value);
			if ($key == 'orderby') $value = $this->getDatasetOrderBy($value);
			
			$this->dataset_query_args[$key] = $value;
		}
		
		// make sure that specific dataset query args are also correctly set for pagination
		if ( in_array($key, array('orderby', 'order', 'cat_id')) ) {
			if ( is_admin() )
				$this->setQueryArg($key, $value);
			else
				$this->setQueryArg($key.'_'.$this->id, $value);
		}
		
		// set project title
		if ($key == 'cat_id') {
			if ($value > 0) {
				if (is_admin())
					$this->title = $this->project_title .' - '. $this->getCategoryTitle($this->getCatID());
				else
					$this->title = $this->getCategoryTitle($this->getCatID());
			} else {
				$this->title = $this->project_title;
			}
		}
	}
	
	
	/**
	 * set number of pages
	 */
	public function setNumPages() {
		$this->num_pages = ( $this->num_datasets == 0 || $this->per_page == 0 ) ? 1 : ceil($this->num_datasets/$this->per_page);
	}
	
	
	/**
	 * retrieve current page
	 *
	 * @param int $current_page
	 */
	public function setCurrentPage($current_page = false) {
		global $wp;
		
		$key = "paged_".$this->id;
		if (isset($_GET['paged']))
			$current_page = intval($_GET['paged']);
		elseif (isset($wp->query_vars['paged']))
			$current_page = max(1, intval($wp->query_vars['paged']));
		elseif (isset($_GET[$key]))
			$current_page = intval($_GET[$key]);
		elseif (isset($wp->query_vars[$key]))
			$current_page = max(1, intval($wp->query_vars[$key]));
		elseif (is_numeric($current_page))
			$current_page = intval($current_page);
		
		// make sure that current page is not 0
		if (intval($current_page) == 0)
			$current_page = 1;

		$this->current_page = intval($current_page);
	}
	
	
	/**
	 * gets current category
	 * 
	 * @return int
	 */
	public function getCatID() {
		return intval($this->dataset_query_args['cat_id']);
	}
	
	
	/**
	 * check if category is selected
	 * 
	 * @return boolean
	 */
	public function isCategory() {
		if ( intval($this->dataset_query_args['cat_id']) > 0 )
			return true;
		
		return false;
	}
	
	
	/**
 	 * set current category
	 *
	 * @param int $cat_id
	 */
	public function setCatID( $cat_id = false ) {
		if ( intval($cat_id) > 0 ) {
			$cat_id = intval($cat_id);
		} elseif ( isset($_POST['cat_id']) && intval($_POST['cat_id']) > 0 ) {
			$cat_id = intval($_POST['cat_id']);
		} elseif ( isset($_GET['cat_id']) && intval($_GET['cat_id']) > 0 ) {
			$cat_id = intval($_GET['cat_id']);
		} elseif ( isset($_GET['cat_id_'.$this->id]) && intval($_GET['cat_id_'.$this->id]) > 0 ) {
			$cat_id = intval($_GET['cat_id_'.$this->id]);
		} else {
			$cat_id = 0;
		}
		
		$this->setDatasetQueryArg('cat_id', intval($cat_id));
	}
	
	
	/**
	 * get dataset IDs for category selection
	 *
	 * @return array An array of Dataset IDs
	 */
	public function getDatasetsInCategory() {
		global $wpdb;
		
		$selected_datasets = array();
		if ( $this->isCategory() ) {
			$sql = $wpdb->prepare("SELECT `id`, `cat_ids` FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d' ORDER BY `id` ASC", intval($this->id));
			
			$datasets = wp_cache_get( md5($sql), 'datasets' );
			if (!$datasets) {
				$datasets = $wpdb->get_results($sql);
				wp_cache_add( md5($sql), $datasets, 'datasets' );
			}
			
			foreach ( $datasets AS $dataset ) {
				$cat_ids = (array) maybe_unserialize($dataset->cat_ids);
				/*if ( !is_array($cat_ids) )
					$cat_ids = array($cat_ids);*/
				
				if ( in_array($this->getCatID(), $cat_ids) )
					$selected_datasets[] = intval($dataset->id);
			}
		}
		
		return $selected_datasets;
	}
	
	
	/**
	 * set default dataset order based on user selection of project settings
	 */
	public function setDatasetOrder() {
		// Selection in Admin Panel
		if ( isset($_POST['orderby']) && isset($_POST['order']) && !isset($_POST['doaction']) ) {
			$_orderby = htmlspecialchars($_POST['orderby']);
			$_order = htmlspecialchars($_POST['order']);

			$this->setDatasetQueryArg('override_order', true);
		}
		// Selection in Admin Panel - sortable table
		if ( isset($_GET['orderby']) && isset($_GET['order']) && !isset($_GET['doaction']) ) {
			$_orderby = htmlspecialchars($_GET['orderby']);
			$_order = htmlspecialchars($_GET['order']);

			$this->setDatasetQueryArg('override_order', true);
		}
		// Selection in Frontend - DEPRECATED
		elseif ( isset($_GET['orderby']) && isset($_GET['order']) && isset($_GET['project_id']) && $_GET['project_id'] == $this->id ) {
			$_orderby = htmlspecialchars($_GET['orderby']);
			$_order = htmlspecialchars($_GET['order']);
			
			$this->setDatasetQueryArg('override_order', true);
		}
		// Selection in Frontend
		elseif ( isset($_GET['orderby_'.$this->id]) && isset($_GET['order_'.$this->id])) {
			$_orderby = htmlspecialchars($_GET['orderby_'.$this->id]);
			$_order = htmlspecialchars($_GET['order_'.$this->id]);
			
			$this->setDatasetQueryArg('override_order', true);
		}
		// Project Settings
		else {
			$_orderby = $this->dataset_orderby;
			$_order = $this->dataset_order;
		}
		
		// set dataset query args
		$this->setDatasetQueryArg( 'order', $_order );
		$this->setDatasetQueryArg( 'orderby', $_orderby );
	}
	
	
	/**
	 * get dataset order
	 *
	 * @param string|false $order
	 * @return string
	 */
	public function getDatasetOrder($order = false) {
		if (empty($order)) $order = $this->dataset_query_args['order'];
		
		if (in_array($order, array("ASC", "DESC", "asc", "desc")))
			return $order;
		
		return "ASC";
	}
	
	
	/**
	 * get dataset orderby field
	 *
	 * @param string|false $orderby
	 * @return string
	 */
	public function getDatasetOrderBy( $orderby = false ) {
		if (empty($orderby)) $orderby = $this->dataset_query_args['orderby'];
		
		if ( $orderby == "category" )
			return $orderby;
		
		$tmp = explode("_", $orderby);
		if ( $tmp[0] == "formfields" || ($tmp[0] != "formfields" && $this->databaseColumnExists("datasets", $tmp[0])) ) {
			$this->setDatasetQueryArg("formfield_id", isset($tmp[1]) ? intval($tmp[1]) : 0);
			return $orderby;
		}
		
		return 'id';
	}
	
	
	/**
	 * set number of columns
	 *
	 * @param int $num_cols
	 */
	public function setNumCols($num_cols) {
		if (intval($num_cols) == 0) $num_cols = 4;
		$this->gallery_num_cols = intval($num_cols);
		$this->dataset_width = 100/$this->gallery_num_cols;
	}
	
	
	/**
	 * check if primary dataset image is present
	 *
	 * @return boolean
	 */
	public function hasDatasetImage() {
		$this->loadFormFields();
		
		if (count($this->getData("formfields", "type", "dataset-image")) > 0)
			return true;
		
		return false;
	}
	
	
	/**
	 * check if primary header image is present
	 *
	 * @return boolean
	 */
	public function hasDatasetHeaderImage() {
		$this->loadFormFields();
		
		if (count($this->getData("formfields", "type", "header-image")) > 0)
			return true;
		
		return false;
	}
	
	
	/**
	 * get formfield ID for slideshow description
	 *
	 * @return int|false
	 */
	public function getSlideshowDescriptionFormFieldID() {
		foreach ( $this->getData('formfields') AS $formfield ) {
			$formfield_options = explode(";", $formfield->options);
			$match = array_values(preg_grep("/slideshow:/", $formfield_options));
			
			if ( count($match) > 0 ) {
				$res = explode(":", $match[0]);
				if ( $res[1] == 'description' )
					return $formfield->id;
			}
		}
		
		return false;
	}
	
	
	/**
	 * get image path based on provided image size
	 *
	 * @param string $file
	 * @param string $size
	 * @return string
	 */
	public function getImagePath( $file, $size = 'full' ) {
		if ( $size == 'full' || empty($size) ) 
			return $this->getFilePath(basename($file));
		else
			return $this->getFilePath( $size . "_" . basename($file) );
	}
	
	
	/**
	 * get image url based on provided image size
	 *
	 * @param string $file
	 * @param string $size
	 * @return string
	 */
	public function getImageURL( $file, $size = 'full' ) {
		return $this->getFileURL( basename( $this->getImagePath( $file, $size ) ) );
	}
	
	
	/**
	 * get upload directory
	 *
	 * @param string|false $file
	 * @return string
	 */
	public function getFilePath( $file = false ) {
		$base = WP_CONTENT_DIR.'/uploads/projects/Project-'.$this->id;
			
		if ( $file ) {
			return $base .'/'. basename($file);
		} else {
			return $base;
		}
	}
	
	
	/**
	 * get url of upload directory
	 *
	 * @param string|false $file
	 * @return string
	 */
	public function getFileURL( $file = false ) {
		$base = WP_CONTENT_URL.'/uploads/projects/Project-'.$this->id;
			
		if ( $file ) {
			if (file_exists($this->getFilePath($file)))
				return esc_url($base .'/'. basename($file));
			else
				return false;
		} else {
			return esc_url($base);
		}
	}
	
	
	/**
	 * set a message
	 *
	 * @param string $message
	 * @param boolean $error
	 */
	public function setMessage( $message, $error = false ) {
		$this->error = $error;
		$this->message = $message;
	}
	

	/**
	 * print formatted success or error message
	 */
	public function printMessage() {
		if (!empty($this->message)) {
			if ( $this->error )
				echo "<div class='box error'><p>".$this->message."</p></div>";
			else
				echo "<div class='box success updated fade'><p><strong>".$this->message."</strong></p></div>";
		}
		
		$this->message = '';
	}

	
	/**
	 * reload settings from database
	 */
	public function reloadSettings() {
		global $wpdb;
		
		$result = $wpdb->get_row( $wpdb->prepare("SELECT `settings` FROM {$wpdb->projectmanager_projects} WHERE `id` = '%d'", intval($this->id)) );
		foreach ( maybe_unserialize($result->settings) as $key => $value )
			$this->$key = $value;
	}
	
	
	/**
	 * get settings
	 *
	 * @param false|string $key
	 * @return array
	 */
	public function getSettings($key=false) {
		$settings = array();
		foreach ($this->settings_keys AS $k)
			$settings[$k] = $this->$k;
		
		if ( $key )
			return (isset($settings[$key])) ? $settings[$key] : false;
		
		return $settings;
	}
	
	
	/**
	 * get dataset pagination
	 *
	 * @param int $current_page
	 * @return string
	 */
	public function getPageLinks($current_page = false) {
		// set number of pages and current page
		$this->setNumPages();
		$this->setCurrentPage($current_page);

		$base = is_admin() ? 'paged' : 'paged_'.$this->id;
		$page_links = paginate_links( array(
			'base' => add_query_arg( $base, '%#%' ),
			'format' => '',
			'prev_text' => '&#9668;',
			'next_text' => '&#9658;',
			'total' => $this->num_pages,
			'current' => $this->current_page,
			'add_args' => $this->query_args
		));
	
		if ( $page_links && is_admin() ) {
			/*$page_links = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s', 'projectmanager' ) . '</span>%s',
				number_format_i18n( ( $this->current_page - 1 ) * $this->per_page + 1 ),
				number_format_i18n( min( $this->current_page * $this->per_page,  $this->num_datasets ) ),
				number_format_i18n(  $this->num_datasets ),
				$page_links
			);*/
			$page_links = sprintf( '<span class="displaying-num">' . __( '%s Datasets', 'projectmanager' ) . '</span>%s',
				number_format_i18n(  $this->num_datasets ),
				$page_links
			);
		}
		
		$this->pagination = $page_links;
		return $page_links;
	}

	
	/**
	 * get array of form field types
	 *
	 * The Form Field Types can be extended via Wordpress filter projectmanager_formfields
	 *
	 * @param false|string $index
	 * @return array|string
	 */
	public function getFormFieldTypes($index = false) {
		$form_field_types = array(
			'name' => __('Dataset Name', 'projectmanager'),
			'text' => __('Text', 'projectmanager'),
			'textfield' => __('Textfield', 'projectmanager'),
			'tinymce' => __('TinyMCE Editor', 'projectmanager'),
			'email' => __('E-Mail', 'projectmanager'),
			'paragraph' => __( 'Paragraph', 'projectmanager' ),
			'title' => __( 'Title', 'projectmanager' ),
			'date' => __('Date', 'projectmanager'),
			'uri' => __('URL', 'projectmanager'),
			'select' => __('Selection', 'projectmanager'),
			'checkbox' => __( 'Checkbox List', 'projectmanager'),
			'radio' => __( 'Radio List', 'projectmanager'),
			'newsletter' => __( 'Newsletter Options', 'projectmanager' ),
			'file' => __('File', 'projectmanager'),
			'dataset-image' => __( 'Dataset Image', 'projectmanager' ),
			'header-image' => __( 'Title Image', 'projectmanager'),
			'image' => __( 'Image', 'projectmanager' ),
			'video' => __('Video', 'projectmanager'),
			'numeric' => __( 'Numeric', 'projectmanager' ),
			'currency' => __('Currency', 'projectmanager'),
			'country' => __('Country', 'projectmanager'),
			'signature' => __( 'Signature', 'projectmanager'),
			'project' => __( 'Internal Link', 'projectmanager' ),
			'time' => __('Time', 'projectmanager'),
			'wp_user' => __( 'WP User', 'projectmanager' ),
			'wp_media' => __( 'WP Media', 'projectmanager' )
		);
		/**
		 * Fires when formfield types are constructed to add custom field types
		 *
		 * @param array $formfields
		 * @return array
		 * @category wp-filter
		 */
		$form_field_types = apply_filters( 'projectmanager_formfields', $form_field_types );
		
		if ( $index )
			return $form_field_types[$index];
			
		return $form_field_types;
	}
	
	
	/**
	 * get formfield label types
	 *
	 * @param false|string $index
	 * @return array|string
	 */
	public function getFormFieldLabelTypes( $index = false ) {
		$label_types = array(
			'label' => __( 'Label', 'projectmanager' ),
			'paragraph' => __( 'Paragraph', 'projectmanager'),
			'title' => __( 'Title', 'projectmanager' )
		);
		
		if ( $index )
			return $label_types[$index];
		
		return $label_types;
	}
	
	
	/**
	 * check if country formfields exists
	 *
	 * @return boolean
	 */
	public function hasCountryFormField() {
		$this->loadFormFields();
		return count($this->getData("formfields", "type", "country")) > 0;
	}
	
	
	/**
	 * get only country-type formfields
	 *
	 * @return array
	 */
	public function getCountryFormFields() {
		$this->loadFormFields();
		return $this->getData("formfields", "type", "country");
	}
	
	
	/**
	 * get all countries
	 *
	 * @return array
	 */
	public function getCountries() {
		$map = new PM_Map($this->id);
		$countries = $map->countries;
		foreach ($countries AS $i => $country) {
			$countries[$i] = (object)$country;
		}
		
		return $countries;
	}
	
	
	/**
	 * get selected country
	 *
	 * @param int $field_id
	 * @return string
	 */
	public function getSelectedCountry($field_id) {
		$pattern = is_admin() ? "/country_".intval($field_id)."/" : "/country_".$this->id."_".intval($field_id)."/";
		
		if ($key = array_values(preg_grep($pattern, array_keys($_GET))))
			$selected_country = htmlspecialchars($_GET[$key[0]]);
		elseif ($key = array_values(preg_grep($pattern, array_keys($_POST))))
			$selected_country = htmlspecialchars($_POST[$key[0]]);
		else
			$selected_country = "";
		
		return $selected_country;
	}
	
	
	/**
	 * get first newsletter formfield
	 *
	 * @return int|false
	 */
	public function getNewsletterOptionsFormField() {
		$field = $this->getData("formfields", "type", "newsletter");
		
		if ( $field )
			return $field[0];
		
		return false;
	}
	
	
	/**
	 * get formfields
	 *
	 * @param false|int $child_of If empty all formfields are get, -1 gets parent formfields, otherwise children formfields are retrieved
	 * @return array
	 */
	public function getFormFields( $child_of = false ) {
		$this->loadFormFields();
		
		if ( $child_of ) {
			if ( $child_of == -1 )
				return $this->getData("formfields", "parent_id", 0);
			
			return $this->getData("formfields", "parent_id", $child_of);
		}
		
		return $this->getData("formfields");
	}
	
	
	/**
	 * check if formfields are set
	 *
	 * @return boolean
	 */
	public function hasFormFields() {
		if ( $this->num_formfields > 0 )
			return true;
		
		return false;
	}
	
	
	/**
	 * check if formfield has children
	 *
	 * @param int $formfield_id
	 * @return boolean
	 */
	public function hasFormFieldChildren( $formfield_id ) {
		$num = count($this->getFormFields($formfield_id));

		if ( $num > 0 )
			return true;
		
		return false;
	}
	
	
	/**
	 * print formfield list
	 *
	 * @param array $args an associative array of arguments
	 * @param string $output
	 */
	public function printFormFieldList( $args = array('child_of' => -1, 'class' => '', 'level' => 0), $output = 'table' ) {
		global $projectmanager;
		
		$class = $args['class'];
		$level = $args['level'];
		$margin = 10*$level;
		
		foreach( $this->getFormFields($args['child_of']) AS $form_field ) {
			$class = ( 'alternate' == $class ) ? '' : 'alternate';
			
			include(PROJECTMANAGER_PATH . '/admin/formfields-row.php');

			if ( $this->hasFormFieldChildren($form_field->id) ) {
				$args = array_merge($args, array('child_of' => $form_field->id, 'class' => $class, 'level' => $level+1));
				$class = $this->printFormFieldList( $args, $output );
			}
		}
	
		return $class;
	}
	
	
	/**
	 * load form fields for project from database
	 *
	 * @param boolean $reload force reload from database
	 * @param boolean $all force to get all fields independent of private status
	 */
	public function loadFormFields($reload=false, $all=false) {
		global $wpdb;
		
		$sql = "SELECT `id`, `parent_id`, `type`, `label`, `order`, `order_by`, `mandatory`, `unique`, `private`, `show_on_startpage`, `show_in_profile`, `label_type`, `options`, `width`, `newline`, `project_id` FROM {$wpdb->projectmanager_projectmeta} WHERE `project_id` = '%d'";
		if (!is_admin() && !$all) $sql .= " AND private = 0";
		$sql .= " ORDER BY `order` ASC;";
		
		$sql = $wpdb->prepare($sql, $this->id);
		
		$formfields = wp_cache_get( md5($sql), 'project_formfields' );
		if ( !$formfields ) {
			$formfields = $wpdb->get_results( $sql );
			wp_cache_add( md5($sql), $formfields, 'project_formfields' );
		}
		
		$fields = array();
		foreach ($formfields AS $i => $formfield) {
			$formfield->label = stripslashes($formfield->label);
			$formfield->options = stripslashes($formfield->options);
				
			/*
			 * Determine formfield classes
			 */
			$classes = array();
			if ( $formfield->newline == 1 ) {
				$classes[] = "fit";
			} else {
				$classes[] = "grid-input";
			}
				
			if ( $i > 0 && isset($formfields[$i-1]) && $formfields[$i-1]->newline == 0 )
				$classes[] = "grid-input";
			
			if ( $i > 0 && $formfields[$i-1]->newline == 1 )
				$classes[] = "clear";
			
			/*if ( $i > 0 && isset($formfields[$i+1]) && $formfields[$i+1]->newline == 1 )
				$classes[] = "fit";*/
			
			if ( !isset($formfields[$i+1]) ) {
				$classes[] = "fit";
			}
			
			$formfield->classes = $classes;
				
			/*
			 * Set formfield placeholder
			 */
			$options = explode(";", $formfield->options);
			// check if there is a maximum input length given
			$match = array_values(preg_grep("/max:/", $options));
			if (count($match) == 1) {
				$max = explode(":", $match[0]);
				$placeholder = sprintf(__("Maximum of %d characters", 'projectmanager'), $max[1]);
			} else {
				$placeholder = "";
			}
			$formfield->placeholder = $placeholder;
			
			$formfield->options_type = 'text';
			if ( $formfield->type == 'project' ) {
				$formfield->options_type = 'project';
			} else {
				$t = $this->getFormFieldTypes($formfield->type);
				if ( is_array($t) && isset($t['options_type']) ) {
					$formfield->options_type = $t['options_type'];
				}
			}
			
			$fields[$i] = get_object_vars($formfield);
		}
		$this->formfields = $fields;
		$this->num_formfields = count($this->formfields);
	}              
	
	
	/**
	 * load categories from database
	 *
	 * @param boolean $reload force reload from database
	 */
	public function loadCategories($reload=false) {
		global $wpdb;
		
		$orderby = $this->category_orderby;
		$order = $this->category_order;
		
		if (!in_array($orderby, array("title", "id")))
			$orderby = "id";
		
		if (!in_array($order, array("ASC", "DESC", "asc", "desc")))
			$order = "ASC";
		
		$categories = wp_cache_get( $this->id, 'project_categories' );
		
		if ( !$categories && !$reload ) {
			$sql = $wpdb->prepare( "SELECT `id`, `title`, `project_id` FROM {$wpdb->projectmanager_categories} WHERE `project_id` = '%d' ORDER BY `$orderby` $order", intval($this->id) );
			$categories = $wpdb->get_results($sql);
			
			wp_cache_add( $this->id, $categories, 'project_categories' );
		}
		
		$class = 'alternate';
		foreach ( $categories AS $i => $category ) {
			$class = ( 'alternate' == $class ) ? '' : 'alternate';
			
			$category->title = stripslashes($category->title);
			$category->class = $class;
			
			$categories[$i] = get_object_vars($category);
		}
		$this->categories = $categories;
		$this->num_categories = count($this->categories);
	}

	
	/**
	 * data loader
	 *
	 * @param string $param
	 */
	public function loadData($param) {
		if ($param == "formfields")
			$this->loadFormFields();
		
		if ($param == "categories")
			$this->loadCategories();
	}
	
	
	/**
	 * data getter
	 *
	 * @param string $param which parameter "formfields" or "categories"
	 * @param string $column
	 * @param string $search
	 * @param int $limit
	 * @return array
	 */
	public function getData($param, $column="", $search="", $limit=0) {
		// make sure that corresponding data is loaded from database
		$this->loadData($param);
		
		if ($param == "formfields")
			$data = $this->formfields;
		elseif ($param == "categories")
			$data = $this->categories;
		else
			return false;
		
		$data2 = $data;
		if (!empty($column)) {
			$data2 = array_column($data, $column);
		}
		
		if ( $search === 0 || !empty($search) ) {
			$d = array();
			foreach (array_keys($data2, $search) AS $key) {
				$d[] = $data[$key];
			}
			$data = $d;
		}

		foreach ($data AS $i => $d) {
			$data[$i] = (object)$d;
		}
		
		if (intval($limit) > 0) $data = array_slice($data, 0, $limit);
		if (intval($limit) == 1) $data = $data[0];
		
		return $data;
	}
	
	
	/**
	 * get categories
	 *
	 * @return array
	 */
	public function getCategories() {
		$this->loadCategories();
		return $this->getData("categories");
	}
	
	
	/**
	 * get category ID from title
	 *
	 * @param string $title
	 * @return int|false
	 */
	public function getCategoryID( $title ) {
		$this->loadCategories();
		
		$key = array_search($title, array_column($this->categories, "title"));
		if (is_numeric($key))
			return $this->categories[$key]['id'];
		
		return false;
	}

	
	/**
	 * get category title from ID
	 *
	 * @param int $id
	 * @return string
	 */
	public function getCategoryTitle( $id ) {
		$this->loadCategories();
		
		$key = array_search($id, array_column($this->categories, "id"));
		if (is_numeric($key))
			return $this->categories[$key]['title'];
		
		return '';
	}
	
	
	/**
	 * check if project has categories
	 *
	 * @return boolean
	 */
	public function hasCategories() {
		$this->loadCategories();
		return $this->num_categories > 0;
	}
	
	
	/**
	 * get number of countries datasets have
	 *
	 * @param int $formfield_id
	 * @return int
	 */
	public function getNumCountries($formfield_id=false) {
		global $wpdb;
		
		if (!$formfield_id) $formfield_id = $this->map['field'];
		
		$sql = $wpdb->prepare("SELECT value FROM {$wpdb->projectmanager_datasetmeta} WHERE form_id = '%d'", $formfield_id);
		$results = wp_cache_get( md5($sql), 'projectmanager' );
		if (!$results) {
			$results = $wpdb->get_results($sql);
			wp_cache_add( md5($sql), $results, 'projectmanager' );
		}
		
		
		$countries = array();
		foreach ($results AS $result) {
			$countries[] = $result->value;
		}
		$countries = array_unique($countries);
		
		return count($countries);
	}
	
	
	/**
	 * check if database column exists in database
	 *
	 * @param string $table
	 * @param string $column
	 * @return boolean
	 */
	private function databaseColumnExists($table, $column) {
		global $wpdb;
		
		if ($table == "datasets")
			$table = $wpdb->projectmanager_dataset;
		else
			return false;
		
		$sql = $wpdb->prepare("SHOW COLUMNS FROM {$table} LIKE %s", $column);
		
		$res = wp_cache_get( md5($sql), 'projectmanager' );
		
		if ( !$res ) {
			$num = $wpdb->query( $sql );
			$res = ( $num == 1 ) ? true : false;
			
			wp_cache_add( md5($sql), $res, 'projectmanager' );
		}
		
		return $res;
	}
	
	
	/**
	 * set PHPMailer options
	 *
	 * @param PHPMailer $mailer
	 */
	public function configureMailer(PHPMailer $mailer){
		$mailer->IsSMTP();
		$mailer->Host = "localhost"; // your SMTP server
		$mailer->Port = 25;
		$mailer->SMTPDebug = 0; // write 0 if you don't want to see client/server communication in page
		$mailer->CharSet  = "utf-8";
	}
	
	
	/**
	 * send newsletter
	 *
	 * @param string $from
	 * @param string $from_name
	 * @param string $subject
	 * @param string $message
	 * @param int $to_field
	 * @return boolean
	 */
	public function sendNewsletter( $from, $from_name, $subject, $message, $to_field ) {
		if ( !current_user_can( 'project_send_newsletter' ) )
			return false;
			
		check_admin_referer( 'projectmanager_newsletter' );
		
		$options_field = $this->getNewsletterOptionsFormField();
		
		$headers = array();
		$headers[] = "From: " . htmlspecialchars($from_name) . " <" . htmlspecialchars($from) . ">";
		
		$res = array();
		foreach ( $this->getDatasets( array("limit" => false, 'orderby' => 'id', 'order' => 'ASC') ) AS $dataset ) {
			$send = true;
			
			// exclude users, who selected not to receive newsletters
			if ( $options_field && in_array($dataset->getData("form_field_id", $options_field->id, 1), array("no", "No")) )
				$send = false;

			$to = $dataset->getData('form_field_id', intval($to_field), 1);
			if ( $send && !empty($to) ) {
				$subject = utf8_decode($subject);
				$message = wordwrap(str_replace("[name]", $dataset->name, utf8_decode($message)), 70);
				
				$res[] = wp_mail($to, $subject, $message, $headers);
			}
		}
		
		// get unique results
		$res = array_unique($res);
		if ( count($res) > 1 )
			return false;
		
		return $res;
	}
	
	
	/**
	 * send email confirmation
	 *
	 * @param Dataset $dataset
	 * @param string $pdf_file path to PDF file
	 * @return boolean
	 */
	public function sendConfirmation( $dataset, $pdf_file = false ) {
		//add_action( 'phpmailer_init', array(&$this, 'configureMailer'), 10, 1);

		$to = $dataset->getData('form_field_id', $this->email_confirmation, 1);
		$subject = utf8_decode($this->email_confirmation_subject);
		$message = wordwrap(str_replace("[name]", $dataset->name, utf8_decode($this->email_confirmation_text)), 70);
		
		// Add activation text and link to the email message
		if ( $this->dataset_activation == 1 ) {
			if ( is_admin() ) {
				// don't send email if the page ID is not set
				if ( $this->datasetform_page_id == 0 ) return false;
				
				$confirmation_url = get_permalink($this->datasetform_page_id);
			} else {
				$confirmation_url = get_permalink(get_the_ID());
			}
			$confirmation_url = add_query_arg( array('activate' => $dataset->getActivationKey(), 'id' => $dataset->id), $confirmation_url );
			
			if ( preg_match( "[CONFIRMATION_LINK]", $message ) ) {			
				$message = str_replace("[CONFIRMATION_LINK]", $confirmation_url, $message);
			} else {
				
			}
		}
		
		$headers = array();
		$headers[] = "From: " . get_bloginfo('name') . " <" . $this->email_confirmation_sender . ">";
		
		$res = wp_mail($to, $subject, $message, $headers, $pdf_file);
		
		return $res;
	}
	
	
	/**
	 * send notification email about new dataset
	 *
	 * @param string $pdf_file
	 * @return boolean
	 */
	public function sendNotification( $pdf_file = false ) {
		//add_action( 'phpmailer_init', array(&$this, 'configureMailer'), 10, 1);
		
		$to = $this->email_confirmation_sender;
		$subject = utf8_decode($this->email_notification_subject);
		$message = wordwrap(utf8_decode($this->email_notification_text), 70);
		$headers = array();
		$headers[] = "From: " . get_bloginfo('name') . " <no-reply@".$_SERVER['HTTP_HOST'].">";
		
		$res = wp_mail($to, $subject, $message, $headers, $pdf_file);

		return $res;
	}
	
	
	/**
	 * get number of datasets for specific project. This fucntion needs to be called after getDatasets
	 *
	 * @param boolean $all get all datasets or depending on current selection
	 */
	public function getNumDatasets( $all = false ) {
		global $wpdb;

		if ( $all === true ) {
			$this->num_datasets_total = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d'", $this->id) );
		} else {
			$this->num_datasets = $this->_getDatasets(array('count' => true));
		}
	}
	
	
	/**
	 * retrieve datasets depending on user action
	 *
	 * @param array $query_args
	 */
	public function getDatasets( $query_args = array() ) {
		// set query args
		foreach ($query_args AS $key => $value)
			$this->setDatasetQueryArg($key, $value, false);
		
		// get duplicated datasets
		if ( is_admin() && isset($_GET['dup']) && $_GET['dup'] != "" )
			$datasets = $this->getDuplicatedDatasets( htmlspecialchars($_GET['dup']) );
		elseif ( is_admin() && isset($_POST['search_up']) && isset($_POST['dup']) && $_POST['dup'] != "" )
			$datasets = $this->getDuplicatedDatasets( htmlspecialchars($_POST['dup']) );
		// get search results
		elseif ( $this->isSearch() && $this->getSearchString() )
			$datasets = $this->getSearchResults();
		// get random datasets
		elseif ( $this->dataset_query_args['random'] === true )
			$datasets = $this->getRandomDatasets( $query_args );
		// default dataset query
		else
			$datasets = $this->_getDatasets( $query_args );

		if (!$this->hasDetails()) {
			foreach ($datasets AS $i => $dataset) {
				$datasets[$i]->nameURL = $dataset->name;
			}
		}
		
		$this->datasets = $datasets;
		return $datasets;
	}
	
	
	/**
	 * core function to query datasets
	 *
	 * @param array $query_args
	 * @return array
	 */
	private function _getDatasets( $query_args = array() ) {
		global $wpdb;
		
		// set query args
		foreach ($query_args AS $key => $value)
			$this->setDatasetQueryArg($key, $value, false);
		
		extract($this->dataset_query_args, EXTR_SKIP);
		
		$args = array($this->id);

		// Start basic MySQL Query
		if ( $count === true )
			$sql = "SELECT COUNT(ID) FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d'";
		else
			$sql = "SELECT dataset.`id` AS id, `sticky`, `cat_ids`, `project_id`, `user_id`, `order`, `status`, `activationkey` FROM {$wpdb->projectmanager_dataset} AS dataset WHERE `project_id` = '%d'";

		// get datasets of specific categories. Returns emtpy array if no dataset is selected
		$ids = array_merge($ids, $this->getDatasetsInCategory());
			
		if ( count($ids) > 0 ) {
			$ids = array_map('intval',$ids);
			$sql .= " AND `id` IN(".implode(",", $ids).")";
		}
			
		if (!empty($status)) {
			$sql .= " AND `status` = '%s'";
			$args[] = $status;
		}
			
		if (count($meta) > 0) {
			foreach ($meta AS $key => $value) {
				$sql .= " AND `id` IN ( SELECT `dataset_id` FROM {$wpdb->projectmanager_datasetmeta} AS meta WHERE meta.form_id = '%d' AND meta.value = '%s' )";
				$args[] = intval($key);
				$args[] = $value;				
			}
		}
		
		if ( $count === true ) {
			$this->setDatasetQueryArg('count', false);
			
			$sql = $wpdb->prepare($sql, $args);
			
			// Use Wordpress Cache for counting datasets
			$datasets = wp_cache_get( md5($sql), 'num_datasets' );
			if (!$datasets) {
				$datasets = intval($wpdb->get_var($sql));
				wp_cache_add( md5($sql), $datasets, 'num_datasets' );
			}
		} else {
			$orderby = explode("_", $orderby);
			$orderby = $orderby[0];
			$orderby_categories = ( $orderby == "category" ) ? true : false;
			
			if ($orderby == "formfields" || $orderby == "category") $orderby = "id";

			// always order by sticky  descending first to have sticky datasets on top
			$sql .=  ( $sticky === true ) ? " ORDER BY sticky DESC, `$orderby` $order" : " ORDER BY `$orderby` $order";

			// Determine whether to sort by formfields or not
			$orderby_formfields = ($this->dataset_orderby == 'formfields' && !$this->dataset_query_args['override_order']) || !empty($formfield_id) ? true : false;
				
			$offset = intval($limit) > 0 ? ( $this->current_page - 1 ) * intval($limit) : 0;
			
			/*
			 * If datasets are ordered by formfields first get all
			 */
			if ( !$orderby_formfields && intval($limit) > 0 )
				$sql .= " LIMIT ".$offset.",".intval($limit).";";
			else
				$sql .= ";";
				
			$sql = $wpdb->prepare($sql, $args);
			
			$datasets = wp_cache_get( md5($sql), 'datasets' );
			
			if (!$datasets) {
				$datasets = $wpdb->get_results($sql);
				wp_cache_add( md5($sql), $datasets, 'datasets' );
			}
			
			// order datasets by formfields
			if ( $orderby_formfields === true ) $datasets = $this->orderDatasetsByFormFields($datasets, $formfield_id, $offset, $limit);
			
			// order datasets by first category
			if ( $orderby_categories === true ) $datasets = $this->orderDatasetsByCategory($datasets, $offset, $limit);
			
			if ( $datasets && !$offsets ) {
				// shuffle datasets again to further randomize order
				if ( $random === true ) shuffle($datasets);
				
				$class = 'alternate';
				foreach ( $datasets AS $i => $dataset ) {
					$dataset = get_dataset($dataset);
					
					$class = ( $class == '' ) ? 'alternate' : '';

					// complete dataset classes
					if ( $class != "" ) $dataset->cssClass[] = $class;
					//if ($this->gallery_num_cols != "" && 0 == ($i+1) % $this->gallery_num_cols ) $dataset->cssClass[] = "fit";
					$dataset->cssClass = implode(" ", $dataset->cssClass);
					
					// add url to single dataset in frontend
					if (!is_admin()) {
						$url = get_permalink();
						$url = add_query_arg("show_".$this->id, $dataset->id, $url);
						//$url = add_query_arg('project_id', $project_id, $url);
						$url = ($this->isCategory()) ? add_query_arg('cat_id', $this->getCatID(), $url) : $url;
						if (!isset($_GET['order_'.$this->id]))
							$url = add_query_arg('order_'.$this->id, $this->getDatasetOrder(), $url);
						if (!isset($_GET['orderby_'.$this->id]))
							$url = add_query_arg('orderby_'.$this->id, $this->getDatasetOrderBy(), $url);
						
						foreach ( $_GET AS $key => $value ) {
							if ( preg_match("/p_search_\d+/", $key) )
								$value = str_replace(" ", "+", $value);
							
							$url = add_query_arg( $key, $value, $url );
						}
					
						$dataset->URL = esc_url($url);
						$dataset->nameURL = $this->hasDetails() ? '<a href="'.esc_url($url).'">'.$dataset->name.'</a>' : $dataset->name;
						
						//$dataset->hasDetails = $this->hasDetails();
					} else {
						$dataset->nameURL = $dataset->name;
					}
					
					$datasets[$i] = $dataset;
				}
			}

			$this->getNumDatasets();
			$this->getPageLinks();
		}
		
		return $datasets;
	}
	
	
	/**
	 * check if dataset exists
	 *
	 * @param int $dataset_id
	 * @return boolean
	 */
	public function hasDataset( $dataset_id ) {
		 global $wpdb;
		 
		 $num = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d' AND `id` = '%d'", $this->id, $dataset_id) );
		 
		 if ( $num == 1 )
			 return true;
		 
		 return false;
	}
	
	
	/**
	 * check if datasets have details
	 * 
	 * @param boolean $single
	 * @return boolean
	 */
	public function hasDetails($single = true) {
		global $wpdb;
		
		if ( !$single ) {
			$this->hasDetails = false;
		} elseif (is_null($this->hasDetails)) {
			$num = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(ID) FROM {$wpdb->projectmanager_projectmeta} WHERE `project_id` = '%d' AND `show_on_startpage` = 0 AND `private` = 0", intval($this->id)) );
			
			$this->hasDetails = ( $num > 0 && !$this->isSelectedDataset() ) ? true : false;
		}
		
		return $this->hasDetails;
	}
	
	
	/**
	 * check if single dataset has been selected
	 *
	 * @return boolean
	 */
	public function isSelectedDataset() {
		// Frontend
		if ( isset($_GET["show_".$this->id]) ) {
			$this->current_dataset = intval($_GET["show_".$this->id]);
			return true;
		}
		
		// Backend
		if ( isset($_GET['view']) && isset($_GET['project_id']) ) {
			$this->current_dataset = intval($_GET["view"]);
			return true;
		}
		
		return false;
	}
	
	
	/**
	 * order datasets by chosen form fields
	 *
	 * @param array $datasets
	 * @param int $form_field_id
	 * @param int $offset
	 * @param int $limit
	 * @return array
	 */
	private function orderDatasetsByFormFields( $datasets, $form_field_id = 0, $offset = 0, $limit = 0 ) {
		/*
		 * Generate array of parameters to sort datasets by
		 */
		$to_sort = array();
		if ( intval($form_field_id) == 0 ) {
			foreach ( $this->getData("formfields") AS $form_field ) {
				if ( !in_array($form_field->type, array("paragraph", "title")) &&  1 == $form_field->order_by )
					$to_sort[] = $form_field->id;
			}
		} else {
			$to_sort[] = $form_field_id;
		}
	
		/*
		 * Only process datasets if there is anything to do
		 */
		if ( !empty($to_sort) ) {
			/*
			 * Generate order data
			 */
			$order = array();
			foreach ( $datasets AS $i => $dataset ) {
				$dataset = get_dataset($dataset);
				
				$i2 = 0;
				if ( $this->dataset_query_args["sticky"] === true ) {
					$order[$i2][$i] = $dataset->sticky; // Add sticky as first ordering element
					$i2++;
				}
				
				foreach ( $dataset->getData() AS $meta ) {
					if ( in_array($meta->form_field_id, $to_sort) ) {
						$order[$i2][$i] = is_string($meta->value) ? strtolower($meta->value) : $meta->value;
						$i2++;
					}
				}
				
				$datasets[$i] = $dataset;
			}
			
			
			/*
			* Create array of arguments for array_multisort
			*/
			$func_args = array();
			foreach ( $order AS $key => $row ) {
				// the first ordering element is sticky, which has to be order descending
				if ( $this->dataset_query_args["sticky"] === true && $key == 0 )
					$sort = SORT_DESC;
				else
					$sort = ( in_array($this->dataset_query_args['order'], array('DESC','desc')) ) ? SORT_DESC : SORT_ASC;
				
				array_push( $func_args, $row );
				array_push( $func_args, $sort );
			}
			
			
			/*
			* sort datasets with array_multisort
			*/
			$eval = 'array_multisort(';
			for ( $i = 0; $i < count($func_args); $i++ )
				$eval .= "\$func_args[$i],";
			
			$eval .= "\$datasets);";
			eval($eval);
		}
		
		// return only part of datasets corresponding to current offset and number of datasets
		if (intval($limit) > 0) $datasets = array_slice($datasets, $offset, intval($limit));
		
		return $datasets;
	}
	
	
	/**
	 * order datasets by first categories
	 *
	 * @param array $datasets
	 * @param int $cat_id
	 * @param int $offset
	 * @param int $limit
	 * @return array
	 */
	private function orderDatasetsByCategory( $datasets, $offset = 0, $limit = 0 ) {
		$categories = array();
		foreach ( $datasets AS $i => $dataset ) {
			$dataset = get_dataset($dataset);
			$categories[] = !empty($dataset->categories) ? array_values($dataset->categories)[0] : '';
		}

		$sort = ( in_array($this->dataset_query_args['order'], array('DESC','desc')) ) ? SORT_DESC : SORT_ASC;
		array_multisort($categories, $sort, $datasets);
		
		// return only part of datasets corresponding to current offset and number of datasets
		if (intval($limit) > 0) $datasets = array_slice($datasets, $offset, intval($limit));
		
		return $datasets;
	}
	
	
	/**
	 * get random datasets
	 *
	 * @param array $query_args
	 * @return array
	 */
	private function getRandomDatasets( $query_args = array() ) {
		// set query args
		foreach ($query_args AS $key => $value)
			$this->setDatasetQueryArg($key, $value, false);
		
		// get all datasets
		//$datasets = $this->_getDatasets( array( "limit" => false, "orderby" => "id", "order" => "ASC", "offsets" => true ) );
		$datasets = $this->_getDatasets( array( "limit" => false, "offsets" => true ) );
		
		$dataset_id = array();
		while(count($dataset_id) < $query_args['limit']) {
			$offset = mt_rand(0, count($datasets)-1);
			if ( !in_array($datasets[$offset]->id, $dataset_id) )
				$dataset_id[] = $datasets[$offset]->id;
		}
		
		$datasets = $this->_getDatasets( array( "ids" => $dataset_id, "random" => true, "cat_id" => 0, "offsets" => false ) );
		return $datasets;
	}
	
	
	/**
	 * get search results
	 *
	 * @param boolean limit - shall we get only perPage number of datasets or all?
	 * @param boolean $offsets - get dataset objects or only offsets?
	 * @return array
	 */
	private function getSearchResults( $limit = true, $offsets = false ) {
		global $wpdb, $projectmanager;
		
		$this->loadCategories();
		$this->loadFormFields();
		
		// remove category selection
		$this->setCatID(0);
		
		// retrieve search query
		$search = $this->getSearchString();
		// Run Search and save dataset IDs
		$datasets = $dataset_ids = array();	
		
		if ( $search ) {
			// run search for each word
			$search = explode("+", $search);
			foreach ($search AS $s) {
				// search in formfields
				if ($results = $this->searchFormfields(trim($s)))
					$dataset_ids = array_unique(array_merge($dataset_ids, $results));
			
				// search for categories
				if ($results = $this->searchCategories(trim($s)))
					$dataset_ids = array_unique(array_merge($dataset_ids, $results));
			}
				
			// Query Database
			if (count($dataset_ids) > 0) {
				$datasets = $this->_getDatasets(array('ids' => $dataset_ids, 'limit' => $limit, 'offsets' => $offsets));
				
				//$this->num_datasets = count($dataset_ids);
				
				// set project title
				if ($projectmanager->isGlobalSearch() || is_admin())
					$title = sprintf(__('%s &mdash; Search: %d of %d', 'projectmanager'), $this->project_title, $this->num_datasets, $this->num_datasets_total);
				else
					$title = sprintf(__('Search: %d of %d', 'projectmanager'), $this->num_datasets, $this->num_datasets_total);
				
				$this->title = $title;
			}
		}
		
		return $datasets;
	}
	/**
	 * search in all formfields of project
	 *
	 * @param string $search
	 * @return array|false
	 */
	private function searchFormfields($search) {
		global $wpdb;
	
		$dataset_ids = array();
		
		// Only perform search for non-empty query 
		if ( $search ) {
			// save search query
			$tmp = $search;
			foreach ($this->getData('formfields') AS $formfield) {
				if (!in_array($formfield->type, array('paragraph', 'title'))) {
					// search for country code in country name if formfield is country
					if ('country' == $formfield->type) {
						$country = $wpdb->get_results($wpdb->prepare("SELECT `id`, `code`, `name` FROM {$wpdb->projectmanager_countries} WHERE `name` REGEXP CONVERT( _utf8 '%s' USING latin1 ) OR `name_locale` REGEXP CONVERT( _utf8 '%s' USING latin1 ) ORDER BY `name` ASC", $search, $search) );
						if (count($country) > 0) {
							// set search query to country code
							$search = $country[0]->code;
						}
					}

					// search in each formfield value
					if ($search) {
						$sql = "SELECT t1.dataset_id AS id,
									t2.cat_ids,
									t2.project_id AS project_id
								FROM {$wpdb->projectmanager_datasetmeta} AS t1, {$wpdb->projectmanager_dataset} AS t2
								WHERE t1.value REGEXP CONVERT( _utf8 '%s' USING latin1 )
									AND t1.form_id = '%d'
									AND t2.project_id = '%d'
									AND t1.dataset_id = t2.id
								ORDER BY t1.dataset_id ASC";
						$datasets = $wpdb->get_results($wpdb->prepare($sql, $search, $formfield->id, $this->id));
						if ($datasets) {
							foreach ($datasets AS $dataset)
								$dataset_ids[] = $dataset->id;
						}
					}
				}
				
				// re-set search query to original value
				$search = $tmp;
			}
		}
	
		if (count($dataset_ids))
			return $dataset_ids;
		else
			return false;
	}
	/**
	 * search in categories
	 *
	 * @param string $search
	 * @return array|false
	 */
	private function searchCategories($search) {
		global $wpdb;

		$dataset_ids = $datasets = array();
	
		if ( $search ) {
			$datasets_sel = array();
			foreach ($this->getData('categories') AS $category) {
				if ( preg_match("/".$search."/", $category->title) ) {
					$this->setCatID($category->id);
					$datasets_sel = array_unique(array_merge($datasets_sel, $this->getDatasetsInCategory()));
				}
			}
			$this->setCatID(0);
				
			// Only proceed if datasets are in found categories
			if (count($datasets_sel) > 0) {
				//$datasets_sel = array_map('intval',$datasets_sel);
				$sql = "SELECT * FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '".intval($this->id)."' AND `id` IN(".implode(",", $datasets_sel).") ORDER BY `id` ASC";
				$datasets = $wpdb->get_results($sql);
				
				if ($datasets) {
					foreach ($datasets AS $dataset)
						$dataset_ids[] = $dataset->id;
						
					return $dataset_ids;
				}
			}
		}
	
		return false;
	}
	
	
	/**
	 * find duplicated dataset entries for a certain field
	 *
	 * @param string $field
	 * @return array|false
	 */
	private function getDuplicatedDatasets( $field ) {
		global $wpdb;
		
		$datasets = $this->_getDatasets( array( "limit" => false, "orderby" => "id", "order" => "ASC", "sticky" => false ) );
		
		$dup = array();
		foreach ( $datasets AS $dataset ) {
			$dataset = get_dataset($dataset);
			
			$tmp = explode("_", $field);
			$formfield_id = intval($tmp[1]);
			// get meta value of current dataset
			$meta_value = $dataset->getData("form_field_id", $formfield_id, 1);
			// get all datasets with same meta value
			if ( is_array($meta_value) ) {
				$results = array();
				foreach ( $meta_value AS $val ) {
					if ( !empty($val) ) {
						$res = $wpdb->get_results($wpdb->prepare("SELECT `dataset_id`, `value` FROM {$wpdb->projectmanager_datasetmeta} WHERE `form_id` = '%d' AND `value` REGEXP '%s'", $formfield_id, $val));
						$results = array_merge($results, $res);
					}
				}
			} else {
				$results = $wpdb->get_results($wpdb->prepare("SELECT `dataset_id`, `value` FROM {$wpdb->projectmanager_datasetmeta} WHERE `form_id` = '%d' AND `value` = '%s'", $formfield_id, $meta_value));
			}
				
			// Will always find at least one dataset, i.e. itself
			if ( count($results) > 1 ) {
				foreach ( $results AS $d ) {
					if ($d->value != "" && !in_array($d->dataset_id, $dup)) {
						$dup[] = $d->dataset_id;
					}
				}
			}
		}
		
		if ( count($dup) > 0 ) {
			$datasets_dup = $this->_getDatasets( array( "sticky" => false, "ids" => $dup, "orderby" => $field, "order" => "ASC" ) );
		} else {
			$datasets_dup = false;
		}
		
		//$this->num_datasets = count($dup);
					
		return $datasets_dup;
	}
	
	
	/**
	 * determine offset of dataset in all datasets
	 *
	 * @param int $dataset_id
	 * @return int
	 */
	public function getDatasetOffset( $dataset_id ) {
		// get all datasets
		if ($this->isSearch()) {
			$datasets = $this->getSearchResults( false, true );
		} else {
			$datasets = $this->_getDatasets( array('limit' => -1, 'offsets' => true) );
		}

		$dataset_offsets = array();
		foreach ( $datasets AS $o => $d ) {
			$dataset_offsets[$d->id] = $o;
		}
		
		$this->dataset_offsets = $dataset_offsets;
		
		// make sure that dataset offset is valid, otherwise return 0 to redirect to first page
		if (isset($this->dataset_offsets[$dataset_id]))
			return $this->dataset_offsets[$dataset_id];
		else
			return 0;
	}
	
	
	/**
	 * get dataset ID from offset
	 *
	 * @param int $offset
	 * @return int
	 */
	public function getDatasetID( $offset ) {
		return array_search($offset, $this->dataset_offsets);
	}
	
	
	/**
	 * check if there is a previous dataset
	 *
	 * @param int $offset
	 * @return boolean
	 */
	public function hasPreviousDataset( $offset ) {
		if ( $offset > 0 )
			return true;
	
		return false;
	}
	
	
	/**
	 * check if there is a next dataset
	 *
	 * @param int $offset
	 * @return boolean
	 */
	public function hasNextDataset( $offset ) {
		if ( $offset < count($this->dataset_offsets)-1 )
			return true;
		
		return false;
	}
	
	
	/**
	 * get page the dataset is on
	 *
	 * @param int $dataset_id
	 * @return int
	 */
	public function getDatasetPage( $dataset_id ) {
		if ( intval($this->per_page) <= 0 )
			return 1;
		
		if (isset($this->dataset_offsets[$dataset_id]))
			$number = $this->dataset_offsets[$dataset_id] + 1;
		else
			$number = 1;
		
		return ceil($number/$this->per_page);
	}
	
	
	/**
	 * check if search was performed
	 *
	 * @return boolean
	 */
	public function isSearch() {
		global $projectmanager;
		
		if ( isset($_POST['search_string']) && isset($_POST['project_id']) && $_POST['project_id'] == $this->id )
			return true;
		
		$search_string_ind = "search_string_".$this->id;
		if ( isset($_POST[$search_string_ind]) )
			return true;
		
		if ( isset($_GET['search']) && isset($_GET['project_id']) && $_GET['project_id'] == $this->id )
			return true;
		
		$search_string_ind = "p_search_".$this->id;
		if ( isset($_GET[$search_string_ind]) )
			return true;
		
		if ( $projectmanager->isGlobalSearch() )
			return true;
		
		return false;
	}
	
	
	/**
	 * get search string
	 *
	 * @return string
	 */
	public function getSearchString() {
		if ( $this->isSearch()) {
			$search_string_ind = "search_string_".$this->id;
			$search_string_ind_get = "p_search_".$this->id;
			
			if (isset($_GET['projectmanager_search_global']))
				return $_GET['projectmanager_search_global'];
			elseif (isset($_POST['search_string']))
				return $_POST['search_string'];
			elseif (isset($_POST[$search_string_ind]))
				return $_POST[$search_string_ind];
			elseif (isset($_GET['search']))
				return $_GET['search'];
			elseif (isset($_GET[$search_string_ind_get]))
				return $_GET[$search_string_ind_get];
		}
		
		return false;
	}
	
	
	/**
	 * get dataset checkbox list
	 *
	 * @param string $name
	 * @param array $selected
	 * @param string $label_type
	 * @param boolean $echo default true
	 * @return string
	 */
	public function printDatasetCheckboxList( $name, $selected, $label_type = "label", $echo = true ) {
		if ($datasets = $this->getDatasets(array('limit' => false, 'orderby' => 'id', 'order' => 'ASC'))) {
			$out = "<ul class='input-checkbox input-dataset-checkbox label-".$label_type."'>";
			foreach ( $datasets AS $dataset ) {
				$out .= "<li><input type='checkbox' name='".$name."[]' id='".sanitize_title($name)."_".$dataset->id."' value='".$dataset->id."'";
				if ( is_array($selected) && in_array($dataset->id, $selected) ) $out .= " checked='checked'";
				$out .= "/><label for='".sanitize_title($name)."_".$dataset->id."'>".$dataset->name."</label>";
			}
			$out .= "</ul>";
		} else {
			$out = sprintf(__('No datasets found in Project %s', 'projectmanager'), $this->title)."</li>";
		}
		
		if ( $echo )
			echo $out;
		else
			return $out;
	}
	
	
	/**
	 * get dataset dropdown list
	 *
	 * @param string $field_name
	 * @param array $selected
	 * @param string $label_type
	 * @param boolean $echo default true
	 * @return string
	 */
	public function printDatasetDropdown( $field_name, $selected, $label_type = "label", $echo = true ) {
		$field_name = htmlspecialchars($field_name);
		if (is_array($selected)) $selected = '';
		
		$out = '<select size="1" name="'.$field_name.'" id="'.sanitize_title($field_name).'_id" class="form-input input-select label-".$label_type."">';
		$out .= '<option value="">'.__( 'None', 'projectmanager' ).'</option>';
		
		if ( $this->hasCategories() ) {
			foreach( $this->getCategories() AS $category ) {
				$out .= '<optgroup label="'.$category->title.'">';
				$datasets = $this->getDatasets( array('cat_id' => $category->id, 'limit' => false, 'orderby' => 'id', 'order' => 'ASC') );
				foreach ( $datasets AS $dataset ) {
					$out .= '<option value="'.$dataset->id.'" '.selected($dataset->id, $selected, false).'>'.$dataset->name.'</option>';
				}
				$out .= '</optgroup>';
			}
		} else {
			$datasets = $this->getDatasets( array('cat_id' => 0, 'limit' => false, 'orderby' => 'id', 'order' => 'ASC') );
			foreach ( $datasets AS $dataset ) {
				$out .= '<option value="'.$dataset->id.'" '.selected($dataset->id, $selected, false).'>'.$dataset->name.'</option>';
			}
		}
		$out .= '</select>';
		
		if ( $echo )
			echo $out;
		else
			return $out;
	}
	
	
	/**
	 * display Form Field options as dropdown
	 *
	 * @param int $form_id
	 * @param int $selected
	 * @param int $dataset_id
	 * @param string $field_name
	 * @param string $label_type
	 * @param boolean $echo default true
	 * @return string
	 */
	public function printFormFieldDropDown( $form_id, $selected, $dataset_id, $field_name, $label_type = "label", $echo = true ) {
		$options = get_option('projectmanager');
		if (is_array($selected)) $selected = '';
		
		$formfield = $this->getData("formfields", "id", intval($form_id), 1);
		$options = explode(";", $formfield->options);

		$out = '';
		if ( count($options) > 1 ) {
			$out .= "<select size='1' class='form-input input-select label-".$label_type."' name='".htmlspecialchars($field_name)."' id='".sanitize_title($field_name)."_id'>";
			foreach ( $options AS $option_name ) {
				$out .= "<option value=\"".$option_name."\" ".selected($selected, $option_name, false).">".$option_name."</option>";
			}
			$out .= "</select>";
		}
		
		if ( $echo )
			echo $out;
		else
			return $out;
	}
	
	
	/**
	 * display Form Field options as checkbox list
	 *
	 * @param int $form_id
	 * @param array|string $selected
	 * @param int $dataset_id
	 * @param string $name
	 * @param string $label_type
	 * @param boolean $echo default true
	 * @return string
	 */
	public function printFormFieldCheckboxList( $form_id, $selected=array(), $dataset_id, $name, $label_type = "label", $echo = true ) {
		$name = htmlspecialchars($name);

		$formfield = $this->getData("formfields", "id", intval($form_id), 1);
		$options = explode(";", $formfield->options);
	
		if ( !is_array($selected) ) $selected = explode("|", $selected);
		
		$custom_option = array_values(array_diff($selected, $options));
		$out = '';
		if ( $options != "" && count($options) > 1 ) {
			$out .= "<ul class='form-input label-".$label_type." input-checkbox'>";
			$i = 0;
			foreach ( $options AS $id => $option_name ) {
				if ( $option_name != "" ) {
					$out .= "<li>";
					if ( count($selected) > 0 && in_array($option_name, $selected) || (count($custom_option) && $custom_option[0] != "" && $option_name == "Other") )
						$out .= "<input type='checkbox' name='".$name."[".$i."]' checked='checked' value=\"".$option_name."\" id='".sanitize_title($name)."_".$formfield->id."_".$id."'>";
					else
						$out .= "<input type='checkbox' name='".$name."[".$i."]' value=\"".$option_name."\" id='".sanitize_title($name)."_".$formfield->id."_".$id."'>";
					
					if ( $option_name == "Other" )
						$out .= "<label for='".sanitize_title($name)."_".$formfield->id."_".$id."'> ".__($option_name, 'projectmanager').": </label><input class='checkbox-input' type='text' name='".$name."[".$i."]' id='".sanitize_title($name)."_".$formfield->id."_".$id."_".$option_name."' value='".$custom_option[0]."' placeholder='' />";
					else
						$out .= "<label for='".sanitize_title($name)."_".$formfield->id."_".$id."'> ".$option_name."</label>";
					
					$out .= "</li>";
				}
				
				$i++;
			}
			$out .= "</ul>";
		}
		
		if ( $echo )
			echo $out;
		else
			return $out;
	}
	
	/**
	 * display Form Field options as radio list
	 *
	 * @param int $form_id
	 * @param int $selected
	 * @param int $dataset_id
	 * @param string $name
	 * @param string $label_type
	 * @param boolean $echo default true
	 * @return string
	 */
	public function printFormFieldRadioList( $form_id, $selected, $dataset_id, $name, $label_type = "label", $echo = true ) {
		$name = htmlspecialchars($name);
		$formfield = $this->getData("formfields", "id", intval($form_id), 1);
		$options = explode(";", $formfield->options);
		
		if ( in_array($selected, $options) ) {
			$custom_option = "";
		} else {
			$custom_option = $selected;
			$selected = "Other";
		}
		
		$out = '';
		if ( count($options) > 1 ) {
			$out .= "<ul class='form-input label-".$label_type." input-radio'>";
			foreach ( $options AS $id => $option_name ) {
				if ( $option_name != "" ) {
					$out .= "<li>";
					
					$checked = false;
					if ( $option_name == $selected && $option_name != "Other" ) $checked = true;
					if ( $option_name == "Other" && $option_name == $selected && $custom_option != "" ) $checked = true;
					
					$out .= "<input type='radio' name=\"".$name."[value]\" value=\"".$option_name."\" ".checked($checked, true, false)." id='".sanitize_title($name)."_".$formfield->id."_".$id."'>";
					
					if ( $option_name == "Other" )
						$out .= "<label for='".$name."_".$formfield->id."_".$id."'> ".__($option_name, 'projectmanager').": </label><input class='radio-input' type='text' name='".$name."[custom-value]' id='".sanitize_title($name)."_".$formfield->id."_".$id."_".$option_name."' value='".$custom_option."' />";
					else
						$out .= "<label for='".sanitize_title($name)."_".$formfield->id."_".$id."'> ".$option_name."</label>";
					
					$out .= "</li>";
				}
			}
			$out .= "</ul>";
		}
		
		if ( $echo )
			echo $out;
		else
			return $out;
	}
	
	
	/**
	 * get orderby options
	 *
	 * @return array
	 */
	public function getOrderbyOptions() {
		$orderby = array( '' => __('Order By', 'projectmanager'), 'id' => __('ID','projectmanager'), 'category' => __( 'Categories', 'projectmanager'), 'order' => __('Custom Order', 'projectmanager') );
		foreach ( $this->getData('formfields') AS $form_field ) {
			if (!in_array($form_field->type, array('paragraph', 'title')))
				$orderby['formfields_'.$form_field->id] = $form_field->label;
		}
		
		return $orderby;
	}
	
	
	/**
	 * get order options
	 *
	 * @return array
	 */
	public function getOrderOptions() {
		$order = array( '' => __('Order','projectmanager'), 'asc' => __('Ascending','projectmanager'), 'desc' => __('Descending','projectmanager') );
		return $order;
	}
	
	
	/**
	 * construct column name for sortable table
	 *
	 * @param string $field_name of orderby field
	 * @param string $label default label
	 * @param array $class an array of CSS classes
	 * @return string
	 */
	public function getSortableTableHeader( $field_name, $label, $class ) {
		if ( is_admin() ) {
			$menu_page_url = ( $this->navi_link == 1 ) ? menu_page_url(sprintf( "project_%d", $this->id ), 0) : menu_page_url('projectmanager', 0)."&amp;subpage=show-project&amp;project_id=".$this->id;
			
			// current field is selected to order by
			if ( isset($_GET['orderby']) && $_GET['orderby'] == $field_name ) {
				$class[] = "sorted";
				if ( isset($_GET['order']) && in_array($_GET['order'], array("ASC", "asc")) ) {
					$class[] = "asc";
					$order_option = "desc";
				} else {
					$class[] = "desc";
					$order_option = "asc";
				}
			} else {
				$class[] = "sortable";
				$class[] = "desc";
				$order_option = "asc";
			}
						
			$colname = "<a href='".$menu_page_url."&amp;orderby=".$field_name."&amp;order=".$order_option."'>".$label."<span class='sorting-indicator'></span></a>";
		} else {
			$colname = $label;
		}
		
		$html = "\n\t<th class='".implode(" ", $class)."' scope='col'>".$colname."</th>";
		
		return $html;
	}
}

/**
 * get Project object
 *
 * @param int|Project|null Project ID or project object. Defaults to global $project
 * @return Project|null
 */
function get_project( $project = null ) {
	if ( empty( $project ) && isset( $GLOBALS['project'] ) )
		$project = $GLOBALS['project'];

	if ( $project instanceof Project ) {
		$_project = $project;
	} elseif ( is_object( $project ) ) {
		$_project = new Project( $project );
	} else {
		$_project = Project::get_instance( $project );
	}

	if ( ! $_project )
		return null;

	return $_project;
}
?>