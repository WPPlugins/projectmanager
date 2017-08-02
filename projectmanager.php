<?php
/*
Plugin Name: ProjectManager
Description: This Plugin can be used to manage several different types of collection database. This could be athlet portraits, DVD database, FAQs, testimonials, members database or architect projects. You can define different form field types and groups to sort your project entries.
Plugin URI: http://wordpress.org/extend/plugins/projectmanager/
Version: 3.6.2
Author: Kolja Schleich

Copyright 2008-2017

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * ProjectManager is a feature-rich data management plugin.
 *
 * This plugin has been originally designed to manage athlete portraits for gymnastics. Since then it has grown to an extremely flexible data management tool.
 * Formfields to store datasets can be dynamically generated with common input types and various magic fields.
 * The plugin can be used for a multitude of purposes including the following
 * - athlete, team portraits
 * - FAQ lists
 * - testimonial systems
 * - members database
 * - anything else you can think of
 *
 * @author Kolja Schleich
 * @package ProjectManager
 * @version 3.6.2
 * @copyright 2008-2017
 * @license GPL-3
 */

 /**
  * Main class to implement ProjectManager
  *
  */
class ProjectManager {
	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $version = '3.6.2';
	 
	/**
	 * Plugin database version
	 *
	 * @var string
	 */
	private $dbversion = '3.3.6';
	 
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
	 * constructor
	 *
	 * @param boolean $init
	 */
	public function __construct($init=true) {
		if (!$init) return;
		
		// set locale
		setlocale( LC_ALL, get_locale() );

		// Load language file
		$this->loadTextdomain();

		$this->defineConstants();
		$this->defineTables();
		$this->loadOptions();
		$this->loadLibraries();

		// register installation/deinstallation functions
		register_activation_hook(__FILE__, array(&$this, 'activate') );
		register_deactivation_hook(__FILE__, array(&$this, 'deactivate') );
		register_uninstall_hook(__FILE__, array('ProjectManager', 'uninstall'));

		// add widgets
		add_action( 'widgets_init', array(&$this, 'registerWidgets') );
		
		// load styles and scripts
		add_action('wp_enqueue_scripts', array(&$this, 'loadStyles'), 5 );
		add_action('wp_enqueue_scripts', array(&$this, 'loadScripts') );
		
		// add TinyMCE Button
		add_action( 'init', array(&$this, 'addTinyMCEButton') );
		// register AJAX action to show TinyMCE Window
		add_action( 'wp_ajax_projectmanager_tinymce_window', array(&$this, 'showTinyMCEWindow') );
		
		// add dataset for newly registered users
		add_action( 'user_register', array(&$this, 'registerUser') );
		
		// add action to update map data using cron schedule
		add_action('projectmanager_update_map_data', array(&$this, 'updateMapData'));
		
		// Enable projects in Fancy slideshows
		add_filter( 'fancy_slideshow_sources', array( &$this, 'addSlideshowSources' ) );
		add_filter( 'fancy_slideshow_get_slides_projects', array(&$this, 'getSlideshowSlides') );
		
		
		// cleanup captchas, which are older than 2 hours
		wp_mkdir_p( $this->getCaptchaPath() );
		$this->cleanupOldFiles($this->getCaptchaPath(), 2);
		
		// cleanup old captcha options
		$options = get_option('projectmanager');
		if (isset($options['captcha']) && count($options['captcha']) > 0) {
			$now = time();
			foreach ($options['captcha'] AS $key => $dat) {
				if (!file_exists($this->getCaptchaPath($key))) {
					unset($options['captcha'][$key]);
				}
			}
		}
		if (isset($options['captcha']) && count($options['captcha']) == 0)
			unset($options['captcha']);

		update_option('projectmanager', $options);
	}

	
	/**
	 * get all projects from database
	 *
	 * @param integer $child_of If empty, all projects are retrieved, -1 gets all parent projects, otherwise child projects are retrieved
	 * @return array
	 */
	public function getProjects( $child_of = false ) {
		global $wpdb;
	
		$sql = "SELECT `id`, `parent_id`, `title`, `settings` FROM {$wpdb->projectmanager_projects}";	
		if ( !empty($child_of) ) {
			if ( $child_of == -1 ) {
				$sql .= " WHERE `parent_id` = 0";
			} else {
				$sql .= $wpdb->prepare(" WHERE `parent_id` = '%d'", intval($child_of));
			}
		}
		$sql .= " ORDER BY `id` ASC";
		
		$projects = $wpdb->get_results($sql);

		$class = '';
		foreach ( $projects AS $i => $project ) {
			$project = get_project($project);
			
			$class = ( 'alternate' == $class ) ? '' : 'alternate';
			$project->cssClass = $class;
			
			$projects[$i] = $project;
		}
		return $projects;
	}
	
	
	/**
	 * print project index with nested project hierarchy
	 *
	 * @param array $args An associative array
	 * @param string $output
	 * @return string the current CSS class of the table row
	 */
	public function displayProjectIndex($args = array('child_of' => -1, 'class' => '', 'level' => 0), $output = 'table') {
		$class = $args['class'];
		$level = $args['level'];
		
		foreach ( $this->getProjects(intval($args['child_of'])) AS $project ) {
			$class = ( 'alternate' == $class ) ? '' : 'alternate';
			
			if ( $level > 0 && in_array($output, array('table', 'select')) ) $project->title = str_repeat( "&mdash; ", $level ) . $project->title;
			
			if ( $output == 'table' ) {
				$out = '<tr class="'.$class.' iedit hentry">';
				
				if ( is_admin() )
					$out .= '<th scope="row" class="check-column column-cb"><input type="checkbox" value="'.$project->id.'" name="project['.$project->id.']" /></th>';
				//$out .= '<td class="column-ID" data-colname="'.__( 'ID', 'projectmanager' ).'">'.$project->id.'</td>';
				
				if ( is_admin() ) {
					$out .= '<td class="column-title column-primary" data-colname="'.__( 'Title', 'projectmanager' ).'"><a href="admin.php?page=projectmanager&amp;subpage=show-project&amp;project_id='.$project->id.'">'.$project->title.'</a><button class="toggle-row" type="button"></button>';
					$out .= '<div class="row-actions"><span class="project-settings"><a href="admin.php?page=projectmanager&amp;subpage=settings&amp;project_id='.$project->id.'">'. __( 'Settings', 'projectmanager' ).'</a> | </span><span class="project-formfields"><a href="admin.php?page=projectmanager&amp;subpage=formfields&amp;project_id='.$project->id.'">'.__( 'Formfields', 'projectmanager' ).'</a> | </span><span class="project-categories"><a href="admin.php?page=projectmanager&amp;subpage=categories&amp;project_id='.$project->id.'>">'.__( 'Categories', 'projectmanager' ).'</a> | </span><span class="project-dataset"><a href="admin.php?page=projectmanager&amp;subpage=dataset&amp;project_id='.$project->id.'">'.__( 'Add Dataset', 'projectmanager' ).'</a></span></div>';
					$out .= '</td>';
				} else {
					$out .= '<td class="column-title column-primary" data-colname="'.__( 'Title', 'projectmanager' ).'">'.$project->title.'</td>';
				}
				
				$out .= '<td class="column-num-datasets column-num" data-colname="'.__( 'Datasets', 'projectmanager' ).'">'.$project->num_datasets_total.'</td>';
				/*if ( is_admin() ) {
					$out .= '<td class="column-actions" data-colname="'.__( 'Actions', 'projectmanager' ).'"><a href="admin.php?page=projectmanager&amp;subpage=settings&amp;project_id='.$project->id.'">'. __( 'Settings', 'projectmanager' ).'</a> - <a href="admin.php?page=projectmanager&amp;subpage=formfields&amp;project_id='.$project->id.'">'.__( 'Formfields', 'projectmanager' ).'</a> - <a href="admin.php?page=projectmanager&amp;subpage=categories&amp;project_id='.$project->id.'>">'.__( 'Categories', 'projectmanager' ).'</a> - <a href="admin.php?page=projectmanager&amp;subpage=dataset&amp;project_id='.$project->id.'">'.__( 'Add Dataset', 'projectmanager' ).'</a></td>';
				}*/
				$out .= '</tr>';
			} elseif ( in_array($output, array('ul', 'ol')) ) {
				$out = "<li class='".$class." projects-list-item level-".$level."'>".$project->title."</li>";
			} elseif ( $output == 'select' ) {
				if ( ! in_array($project->id, $args['exclude']) ) {
					$out = "<option value='".$project->id."' ".selected($project->id, $args['selected'], false).">".$project->title."</option>";
				} else {
					$out = "";
				}
			}
			
			echo $out;
			
			if ( $project->hasChildren() ) {
				if ( in_array($output, array('ul', 'ol')) ) echo "<".$output." class='projects-list level-".$level."'>";
				$args = array_merge($args, array('child_of' => $project->id, 'class' => $class, 'level' => $level+1));
				$class = $this->displayProjectIndex($args, $output );
				if ( in_array($output, array('ul', 'ol')) ) echo "</".$output.">";
			}
		}
		
		return $class;
	}
	
	
	/**
	 * get number of projects
	 *
	 * @return int
	 */
	public function getNumProjects() {
		global $wpdb;
		return $wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_projects}");
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
	 * get message
	 *
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}
	
	
	/**
	 * print formatted success or error message
	 *
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
	 * check if there was an error
	 *
	 * @return boolean
	 */
	public function isError() {
		return $this->error;
	}
	
	
	/**
	 * Add individual projects to FancySlideshows slideshows categories
	 *
	 * @param array $categories
	 * @return array
	 * @see FancySlideshows::sources()
	 */
	public function addSlideshowSources( $categories ) {	
		$categories['projects'] = array( "title" => __( 'Projects', 'projectmanager'), "options" => array() );
		foreach ( $this->getProjects() AS $project ) {
			$categories["projects"]["options"][] = array( "value" => "projects_".$project->id, "label" => $project->title );
			// Include Options for project categories
			/*foreach ( $project->getData("categories") AS $cat ) {
				$categories["projects"]["options"][] = array( "value" => sprintf("projects_%d_%d", $project->id, $cat->id), "label" => sprintf("%s - %s", $project->title, $cat->title) );
			}*/
		}
		
		return $categories;
	}
	
	
	/**
	 * retrieve FancySlideshows slides
	 *
	 * @param array $category
	 * @return array
	 * @see FancySlideshows::getSlides()
	 */
	public function getSlideshowSlides( $category ) {
		$project_id = intval($category[1]);
		$cat_id = ( isset($category[2]) && intval($category[2]) > 0 ) ? intval($category[2]) : 0;
		
		$project = get_project($project_id);
		
		$ids = ( $project->slideshow['dataset_ids'] != "" ) ? explode(",", $project->slideshow['dataset_ids']) : array();
		$datasets = $project->getDatasets( array( 'ids' => $ids, 'limit' => intval($project->slideshow['num_datasets']), 'random' => $project->slideshow['dataset_orderby'] == 'random', 'orderby' => $project->slideshow['dataset_orderby'], 'order' => $project->slideshow['dataset_order'], 'sticky' => false, 'cat_id' => $cat_id ) );
		
		$formfield_description_id = $project->getSlideshowDescriptionFormFieldID();
		
		$slides = array();
		foreach ( $datasets AS $dataset ) {
			if ( $project->page_id == 0 ) {
				$url = $dataset->getImageURL($dataset->image);
				$link_class = "thickbox";
			} else {
				$url = get_permalink($project->page_id);
				$url = add_query_arg("show_".$project->id, $dataset->id, $url);
				$url = add_query_arg('project_id', $project->id, $url);
				$link_class = "";
			}
			
			// get optional slide description
			$slide_desc = ( $formfield_description_id ) ? $dataset->getData('form_field_id', $formfield_description_id, 1) : '';
			
			$slide = array(
				"name" => $dataset->name,
				"imageurl" => $dataset->getImageURL($dataset->image),
				"imagepath" => $dataset->getFilePath(basename($dataset->image)),
				"url" => $url,
				"url_target" => '',
				"link_class" => $link_class,
				"link_rel" => '',
				"title" => $dataset->name,
				"slide_title" => $dataset->name,
				"slide_desc" => $slide_desc
			);
			
			$slides[] = (object)$slide;
		}
		
		return $slides;
	}

	
	/**
	 * register Widgets
	 */
	public function registerWidgets() {
		register_widget('ProjectManagerWidget');
		register_widget('ProjectManagerSearchWidget');
	}


	/**
	 * define constants
	 *
	 */
	private function defineConstants() {
		if (!defined('EURO')) {
			/**
			 * € Symbol
			 *
			 * @var string
			 */
			define('EURO', chr(128));
		}
		
		if (!defined('PROJECTMANAGER_VERSION')) {
			/**
			 * Plugin version
			 * @var string
			 */
			define( 'PROJECTMANAGER_VERSION', $this->version );
		}
		if (!defined('PROJECTMANAGER_DBVERSION')) {
			/** 
			 * Plugin database version
			 * @var string
			 */
			define( 'PROJECTMANAGER_DBVERSION', $this->dbversion );
		}
		if (!defined('PROJECTMANAGER_URL')) {
			/**
			 * Plugin URL
			 *
			 * @var string
			 */
			define( 'PROJECTMANAGER_URL', rtrim(esc_url(plugin_dir_url(__FILE__)), "/") ); // remove trailing slash as the plugin has been coded without it
		}
		if (!defined('PROJECTMANAGER_PATH')) {
			/**
			 * Plugin path
			 * @var string
			 */
			define( 'PROJECTMANAGER_PATH', dirname(__FILE__) );
		}
	}
	
	
	/**
	 * define database tables
	 */
	private function defineTables() {
		global $wpdb;
		
		$wpdb->projectmanager_projects = $wpdb->prefix . 'projectmanager_projects';
		$wpdb->projectmanager_projectmeta = $wpdb->prefix . 'projectmanager_projectmeta';
		$wpdb->projectmanager_categories = $wpdb->prefix . 'projectmanager_categories';
		$wpdb->projectmanager_dataset = $wpdb->prefix . 'projectmanager_dataset';
		$wpdb->projectmanager_datasetmeta = $wpdb->prefix . 'projectmanager_datasetmeta';
		$wpdb->projectmanager_countries = $wpdb->prefix . 'projectmanager_countries';
	}
	
	
	/**
	 * load libraries
	 *
	 */
	private function loadLibraries() {
		// Objects
		require_once (dirname (__FILE__) . '/lib/project.php');
		require_once (dirname (__FILE__) . '/lib/dataset.php');
		require_once (dirname (__FILE__) . '/lib/map.php');
		
		require_once (dirname (__FILE__) . '/lib/widget.php');
		require_once (dirname (__FILE__) . '/lib/shortcodes.php');
		require_once (dirname (__FILE__) . '/lib/ajax.php');
		
		// template tags
		require_once (dirname (__FILE__) . '/template-tags.php');
		
		// Register AJAX Functions
		$projectmanager_ajax = new ProjectManagerAJAX();
		// Register shortcodes
		$projectmanager_shortcodes = new ProjectManagerShortcodes();
		
		// load pdf libraries
		if ( !class_exists("FPDF") )
			require_once( PROJECTMANAGER_PATH . '/lib/fpdf/fpdf.php' );
		require_once( PROJECTMANAGER_PATH . '/lib/pdf.php' );
	}
	
	
	/**
	 * load options
	 *
	 */
	private function loadOptions() {
		$this->options = get_option('projectmanager');
	}
	
	
	/**
	 * get options
	 *
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}
	
	
	/**
	 * load textdomain
	 *
	 */
	public function loadTextdomain() {
		load_plugin_textdomain( 'projectmanager', false, 'projectmanager/languages' );
	}
	
	
	/**
	 * load Javascript
	 *
	 */
	public function loadScripts() {
		wp_enqueue_script( 'projectmanager', PROJECTMANAGER_URL.'/js/projectmanager.js', array('jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-datepicker', 'jquery-effects-core', 'jquery-effects-slide', 'thickbox') );
		wp_enqueue_script( 'projectmanager_ajax', PROJECTMANAGER_URL.'/js/ajax.js', array('sack') );
	}
	
	/**
	 * load CSS Styles
	 *
	 */
	public function loadStyles() {
		$options = get_option('projectmanager');
		
		wp_enqueue_style('projectmanager', PROJECTMANAGER_URL . "/style.css", false, '1.0', 'all');
		
		wp_register_style('jquery-ui', PROJECTMANAGER_URL . "/css/jquery/jquery-ui.min.css", false, '1.11.4', 'all');
		wp_register_style('jquery-ui-structure', PROJECTMANAGER_URL . "/css/jquery/jquery-ui.structure.min.css", array('jquery-ui'), '1.11.4', 'all');
		wp_register_style('jquery-ui-theme', PROJECTMANAGER_URL . "/css/jquery/jquery-ui.theme.min.css", array('jquery-ui', 'jquery-ui-structure'), '1.11.4', 'all');
		
		wp_register_style('jquery_ui_css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css', false, '1.0', 'screen');
		//wp_enqueue_style('jquery_ui_css');
		wp_enqueue_style('jquery-ui-structure');
		wp_enqueue_style('jquery-ui-theme');
		
		wp_enqueue_style('thickbox');
		
		ob_start();
		require_once(PROJECTMANAGER_PATH.'/css/colors.css.php');
		$css = ob_get_contents();
		ob_end_clean();
		
		wp_add_inline_style( 'projectmanager', $css );
	}
	
	
	/**
	 * add TinyMCE Button
	 *
	 */
	public function addTinyMCEButton() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
		
		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", array(&$this, 'addTinyMCEPlugin'));
			add_filter('mce_buttons', array(&$this, 'registerTinyMCEButton'));
		}
	}
	/**
	 * add TinyMCE Plugin
	 *
	 * @param array $plugin_array An array of TinyMCE plugins
	 * @param array
	 */
	public function addTinyMCEPlugin( $plugin_array ) {
		$plugin_array['ProjectManager'] = PROJECTMANAGER_URL.'/admin/tinymce/editor_plugin.js';
		return $plugin_array;
	}
	/**
	 * register TinyMCE Button
	 *
	 * @param array $buttons An array of TinyMCE Buttons
	 * @return array
	 */
	public function registerTinyMCEButton( $buttons ) {
		array_push($buttons, "separator", "ProjectManager");
		return $buttons;
	}

	
	/**
	 * Display the TinyMCE Window.
	 *
	 */
	public function showTinyMCEWindow() {
		require_once( PROJECTMANAGER_PATH . '/admin/tinymce/window.php' );
		exit;
	}
	
	
	/**
	 * Activate Plugin
	 *
	 */
	public function activate() {
		global $wpdb, $projectmanager;
		include_once( ABSPATH.'/wp-admin/includes/upgrade.php' );
		$options = $this->getOptions();
		
		if (!$options) {
			$installed = false;
			
			$options = array();
			$options['version'] = $this->version;
			$options['dbversion'] = $this->dbversion;
			$options['colors'] = array( 'headers' => '#ddd', 'rows' => array( '#efefef', '#ffffff' ), 'boxheader' => array( "#eaeaea", "#bcbcbc" ) );
			$options['dashboard_widget']['num_items'] = 4;
			$options['dashboard_widget']['show_author'] = 1;
			$options['dashboard_widget']['show_date'] = 1;
			$options['dashboard_widget']['show_summary'] = 1;
		} else {
			$installed = true;
		}
			
		// Set default options
		add_option( 'projectmanager', $options, '', 'yes' );
		// Add widget options
		add_option( 'projectmanager_widget', array(), '', 'yes' );
		
		$charset_collate = '';
		if ( $wpdb->has_cap('collation') ) {
			if ( ! empty($wpdb->charset) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
		}
		
		$create_projects_sql = "CREATE TABLE {$wpdb->projectmanager_projects} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
						`parent_id` int( 11 ) NOT NULL default '0',
						`title` varchar( 255 ) NOT NULL default '',
						`settings` longtext NOT NULL default '',
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_projects, $create_projects_sql );
		
		$create_categories_sql = "CREATE TABLE {$wpdb->projectmanager_categories} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
						`title` varchar( 255 ) NOT NULL default '',
						`project_id` int( 11 ) NOT NULL,
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_categories, $create_categories_sql );
		
		$create_projectmeta_sql = "CREATE TABLE {$wpdb->projectmanager_projectmeta} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT,
						`parent_id int( 11 ) NOT NULL default '0',
						`type` varchar( 50 ) NOT NULL default '',
						`label` longtext NOT NULL default '',
						`order` int( 10 ) NOT NULL default '0',
						`order_by` tinyint( 1 ) NOT NULL default '0',
						`mandatory` tinyint( 1 ) NOT NULL default '0',
						`unique` tinyint( 1 ) NOT NULL default '0',
						`private` tinyint( 1 ) NOT NULL default '0',
						`show_on_startpage` tinyint( 1 ) NOT NULL default '0',
						`show_in_profile` tinyint( 1 ) NOT NULL default '0',
						`label_type` varchar( 50 ) NOT NULL default '',
						`options` longtext NOT NULL default '',
						`width` int( 3 ) NOT NULL default '100',
						`newline` tinyint( 1 ) NOT NULL default '1',
						`project_id` int( 11 ) NOT NULL,
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_projectmeta, $create_projectmeta_sql );
				
		$create_dataset_sql = "CREATE TABLE {$wpdb->projectmanager_dataset} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT,
						`sticky` tinyint( 1 ) NOT NULL default '0',
						`cat_ids` longtext NOT NULL default '',
						`project_id` int( 11 ) NOT NULL,
						`user_id` int( 11 ) NOT NULL default '1',
						`order` int( 11 ) NOT NULL default '0',
						`status` varchar( 255 ) NOT NULL default '',
						`activationkey` varchar( 255 ) NOT NULL default '',
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_dataset, $create_dataset_sql );
			
		$create_datasetmeta_sql = "CREATE TABLE {$wpdb->projectmanager_datasetmeta} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT,
						`form_id` int( 11 ) NOT NULL,
						`dataset_id` int( 11 ) NOT NULL,
						`value` longtext NOT NULL default '',
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_datasetmeta, $create_datasetmeta_sql );
		
		$create_countries_sql = "CREATE TABLE {$wpdb->projectmanager_countries} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT,
						`code` varchar( 3 ) NOT NULL default '',
						`name` varchar( 200 ) NOT NULL default '',
						`name_locale` varchar( 200 ) NOT NULL default '',
						`region_code` varchar( 2 ) NOT NULL default '',
						`region_name` varchar( 200 ) NOT NULL default '',
						`code2` varchar( 2 ) NOT NULL default'',
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_countries, $create_countries_sql );
		
		if (!$installed) require_once("CountriesSQL.php");

		// Save translated country names in database
		$countries = $wpdb->get_results( "SELECT `name`, `id` FROM {$wpdb->projectmanager_countries} ORDER BY `id` ASC" );
		foreach ( $countries AS $country ) {
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_countries} SET `name_locale` = '%s' WHERE `id` = '%d'", __($country->name, 'projectmanager'), $country->id ) );
		}
		
		// create directories
		wp_mkdir_p($this->getFilePath());
		wp_mkdir_p($this->getCaptchaPath());
		wp_mkdir_p($this->getFilePath("backups"));

		/*
		* Add Capabilities
		*/
		$role = get_role('administrator');
		if ( $role !== null ) {
			$role->add_cap('edit_projects');
			$role->add_cap('project_send_newsletter');
			$role->add_cap('delete_projects');
			$role->add_cap('projectmanager_settings');
			$role->add_cap('edit_formfields');
			$role->add_cap('edit_categories');
			$role->add_cap('edit_projects_settings');
			$role->add_cap('import_datasets');
			$role->add_cap('edit_datasets');
			$role->add_cap('edit_other_datasets');
			$role->add_cap('add_multiple_datasets');
			$role->add_cap('delete_datasets');
			$role->add_cap('delete_other_datasets');
			$role->add_cap('view_projects');
			$role->add_cap('projectmanager_user');
			$role->add_cap('view_pdf');
			$role->add_cap('projectmanager_send_confirmation');
			$role->add_cap('edit_dataset_order');
		}
		
		
		$role = get_role('editor');
		if ( $role !== null ) {
			$role->add_cap('import_datasets');
			$role->add_cap('edit_datasets');
			$role->add_cap('edit_other_datasets');
			$role->add_cap('add_multiple_datasets');
			$role->add_cap('delete_datasets');
			$role->add_cap('delete_other_datasets');
			$role->add_cap('view_projects');
			$role->add_cap('projectmanager_user');
		}
		
		$role = get_role('subscriber');
		if ( $role !== null ) {
			$role->add_cap('projectmanager_user');
		}
	}
	
	
	/**
	 * deactivate Plugin
	 *
	 */
	public function deactivate() {
		// remove any cron schedules
		foreach ( $this->getProjects() AS $project ) {
			$args = array('project_id' => $project->id);
			wp_clear_scheduled_hook( 'projectmanager_update_map_data', $args );
		}
	}
	

	/**
	 * uninstall Plugin
	 *
	 */
	public static function uninstall() {
		global $wpdb;

		// remove any cron schedules
		foreach ( self::getProjects() AS $project ) {
			$args = array('project_id' => $project->id);
			wp_clear_scheduled_hook( 'projectmanager_update_map_data', $args );
		}
		
		$wpdb->query( "DROP TABLE {$wpdb->projectmanager_projects}" );
		$wpdb->query( "DROP TABLE {$wpdb->projectmanager_projectmeta}" );
		$wpdb->query( "DROP TABLE {$wpdb->projectmanager_categories}" );
		$wpdb->query( "DROP TABLE {$wpdb->projectmanager_dataset}" );
		$wpdb->query( "DROP TABLE {$wpdb->projectmanager_datasetmeta}" );
		$wpdb->query( "DROP TABLE {$wpdb->projectmanager_countries}" );

		delete_option( 'projectmanager' );
		delete_option( 'projectmanager_widget' );
		
		/*
		* Remove Capabilities
		*/
		$role = get_role('administrator');
		if ( $role !== null ) {
			$role->remove_cap('edit_projects');
			$role->remove_cap('project_send_newsletter');
			$role->remove_cap('delete_projects');
			$role->remove_cap('projectmanager_settings');
			$role->remove_cap('edit_formfields');
			$role->remove_cap('edit_categories');
			$role->remove_cap('edit_projects_settings');
			$role->remove_cap('import_datasets');
			$role->remove_cap('edit_datasets');
			$role->remove_cap('edit_other_datasets');
			$role->remove_cap('add_multiple_datasets');
			$role->remove_cap('delete_datasets');
			$role->remove_cap('delete_other_datasets');
			$role->remove_cap('view_projects');
			$role->remove_cap('projectmanager_user');
		}
		
		$role = get_role('editor');
		if ( $role !== null ) {
			$role->remove_cap('import_datasets');
			$role->remove_cap('edit_datasets');
			$role->remove_cap('edit_other_datasets');
			$role->remove_cap('delete_datasets');
			$role->remove_cap('delete_other_datasets');
			$role->remove_cap('view_projects');
			$role->remove_cap('projectmanager_user');
		}
		
		$role = get_role('subscriber');
		if ( $role !== null ) {
			$role->remove_cap('projectmanager_user');
		}
		
		// Delete media files
		self::removeDir(self::getFilePath());
	}
	
	
	/**
	 * recursively remove directory
	 *
	 * @param string $dir
	 */
	public function removeDir($dir) {
		if ( file_exists($dir) && is_dir($dir) ) {
			$files = array_diff(scandir($dir), array('.','..'));
			foreach ($files AS $file) {
				if (is_dir("$dir/$file"))
					$this->removeDir("$dir/$file");
				else
					@unlink("$dir/$file");
			}
			@rmdir($dir);
		}
	}
	
	
	/**
	 * get months in appropriate language depending on Wordpress locale
	 *
	 * @return array
	 */
	public function getMonths() {
		$locale = explode("_", get_locale());
		setlocale( LC_ALL, $locale[0] );
		$months = array();
		for ( $month = 1; $month <= 12; $month++ )
			$months[$month] = utf8_encode(strftime( "%B", mktime( 0,0,0, $month, date("j"), date("Y") ) ));
		
		return $months;
	}
	
	
	/**
	 * clean up old files
	 *
	 * @param string $dir
	 * @param int $time time in h after which files are removed
	 */
	public function cleanupOldFiles($dir, $time = 24) {
		$files = array_diff(scandir($dir), array('.','..'));
		
		// get current time in seconds
		$now = time();
		foreach ($files AS $file) {
			$file = $dir."/".basename($file);
			// get file modification time as unix timestamp in seconds
			$filetime = filemtime($file);
			// get difference between current time and file modification time in hours
			$diff = ($now-$filetime)/(60*60);

			// remove file if it is older than $time
			if ($diff > $time)
				@unlink($file);
		}
	}
	
	
	/**
	 * read in contents from directory, optionally recursively
	 *
	 * @param string/array $dir
	 * @param boolean $recursive
	 * @param array $files
	 * @return array A list of files
	 */
	public function readFolder( $dir, $recursive = false, $files = array() ) {
		if (!is_array($dir)) $dir = array($dir);

		foreach ( $dir AS $d ) {
			if ($handle = opendir($d)) {
				while (false !== ($file = readdir($handle))) {
					if ( $file != '.' && $file != '..' ) {
						if ($recursive) $file = $d."/".$file;
						
						if (is_dir($file) && $recursive) {
							$files = $this->readFolder($file, true, $files);
						} else {
							$files[] = $file;
						}
					}
				}
				closedir($handle);
			}
		}
		
		return $files;
	}
	
	
	/**
	 * get upload directory
	 *
	 * @param string|false $file
	 * @return string the upload path
	 */
	public function getFilePath( $file = false ) {
		$base = WP_CONTENT_DIR.'/uploads/projects';
			
		if ( $file ) {
			return $base .'/'. basename($file);
		} else {
			return $base;
		}
	}
	
	
	/**
	 * get path to captcha directory
	 *
	 * @param string|false $file
	 * @return string the captcha path
	 */
	public function getCaptchaPath( $file = false ) {
		$base = WP_CONTENT_DIR.'/uploads/projects/captchas';
		if ( $file )
			return $base .'/'. basename($file);
		else
			return $base;
	}
	
	
	/**
	 * get url to captcha directory
	 *
	 * @param string|false $file
	 * @return string the upload path
	 */
	public function getCaptchaURL( $file = false ) {
		$base = WP_CONTENT_URL.'/uploads/projects/captchas';
		
		if ( $file )
			return esc_url($base)."/".basename($file);
		else
			return esc_url($base);
	}
	
	
	/**
	 * Generate Captcha
	 *
	 * @param int $strlen number of characters of captcha code
	 * @param int $nlines number of lines in captcha image
	 * @param int $ndots number of dots in captcha image
	 * @param string $letters letters to use for captcha code
	 * @param int $font_size font size of code
	 * @param int $width image width
	 * @param int $height image height
	 * @return string the captcha image filename
	 */
	public function generateCaptcha($strlen = 6, $nlines = 0, $ndots = 300, $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890', $font_size = 5, $width = 200, $height = 50) {
		wp_mkdir_p( $this->getCaptchaPath() );
		
		// initalize black image
		$image = imagecreatetruecolor($width, $height);
		// make white background color
		$background_color = imagecolorallocate($image, 255, 255, 255);
		imagefilledrectangle($image,0,0,$width,$height,$background_color);
		
		// generate some random lines
		$line_color = imagecolorallocate($image, 64,64,64); 
		for($i = 0; $i < $nlines; $i++) {
			imageline($image,0,rand()%$height,$width,rand()%$height,$line_color);
		}
		
		// generate some random dots
		$pixel_color = imagecolorallocate($image, 0,0,255);
		for($i = 0; $i < $ndots; $i++) {
			imagesetpixel($image,rand()%$width,rand()%$height,$pixel_color);
		} 

		// Letters and text color for captcha string
		//$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
		$len = strlen($letters);
		$text_color = imagecolorallocate($image, 0,0,0);
		
		// Generate random captcha string
		$code = "";
		for ($i = 0; $i < $strlen; $i++) {
			$letter = $letters[rand(0, $len-1)];
			//imagestring($image, 5,  5+($i*30), rand()%($height/2), $letter, $text_color);
			imagechar($image, $font_size,  5+($i*30), rand()%($height/2), $letter, $text_color);
			$code .= $letter;
		}
		
		// generate unique captcha name
		$filename = uniqid(rand(), true) . ".png";
		
		// save captcha data in options with unique filename as key
		$options = get_option('projectmanager');
		$options['captcha'][$filename] = array('code' => $code, 'time' => time());
		update_option('projectmanager', $options);
		
		// generate png and save it
		imagepng($image, $this->getCaptchaPath($filename));
		
		return $filename;
	}
	
	
	/**
	 * archive files in zip format
	 *
	 * @param array $files
	 * @param string $destination
	 * @param boolean $overwrite
	 * @return boolean
	 */
	public function createZip($files, $destination, $overwrite = true) {
		//if the zip file already exists and overwrite is false, return false
		if(file_exists($destination) && !$overwrite)
			return false;
	
		if (!file_exists($destination))
			$overwrite = false;
		
		$valid_files = array();
		
		// make sure that files are an array
		if (!is_array($files)) $files = array($files);
		
		foreach ($files AS $file) {
			if (file_exists($file))
				$valid_files[] = $file;
		}
		
		// Only proceed if we have valid files
		if (count($valid_files)) {
			// create zip Archive
			$zip = new ZipArchive();
			$res = $zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZipArchive::CREATE);

			if ($res == TRUE) {
				foreach ($valid_files AS $file) {
					$zip->addFile($file, basename($file));
				}

				$zip->close();
			} else {
				return false;
			}
			
			return file_exists($destination);
		} else {
			return false;
		}
	}

	
	/**
	 * unzip media files to upload folder
	 *
	 * @param string $zip_file
	 * @param string|null $destination destination directory. Default: global projectmanager upload path
	 * @return boolean
	 */
	public function unzipFiles($zip_file, $destination = NULL) {
		$zip = new ZipArchive();
		$res = $zip->open($zip_file);
		
		if (is_null($destination)) $destination = $this->getFilePath();
		
		if ($res == TRUE) {
			$zip->extractTo($destination);
			$zip->close();
			
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * load TinyMCE Editor Javascript
	 *
	 */
	public function loadTinyMCE() {
		global $tinymce_version;
		
		$baseurl = includes_url('js/tinymce');

		$mce_locale = ( '' == get_locale() ) ? 'en' : strtolower( substr(get_locale(), 0, 2) ); // only ISO 639-1
		$language = $mce_locale;

		//$version = apply_filters('tiny_mce_version', '');
		$version = 'ver=' . $tinymce_version;

		$mce_buttons = array('bold', 'italic', 'strikethrough', '|', 'bullist', 'numlist', 'blockquote', '|', 'justifyleft', 'justifycenter', 'justifyright', '|', 'link', 'unlink',  '|', 'spellchecker', 'fullscreen', 'wp_adv' );
		$mce_buttons = implode($mce_buttons, ',');

		$mce_buttons_2 = array('formatselect', 'underline', 'justifyfull', 'forecolor', '|', 'pastetext', 'pasteword', 'removeformat', '|', 'media', 'image', 'charmap', '|', 'outdent', 'indent', '|', 'undo', 'redo', 'wp_help' );
		$mce_buttons_2 = implode($mce_buttons_2, ',');

		$plugins = array( 'safari', 'inlinepopups', 'spellchecker', 'paste', 'wordpress', 'media', 'fullscreen', 'wpeditimage', 'tabfocus' );
		$plugins = implode(",", $plugins);

		//if ( 'en' != $language )
		//include_once(ABSPATH . WPINC . '/js/tinymce/langs/wp-langs.php');
?>
		<script type="text/javascript" src="<?php bloginfo('url') ?>/wp-includes/js/tinymce/tiny_mce.js"></script>
		<script type="text/javascript">
			tinyMCE.init({
			mode: "specific_textareas",
			editor_selector: "theEditor",
			theme: "advanced",
			theme_advanced_buttons1: "<?php echo $mce_buttons ?>",
			theme_advanced_buttons2: "<?php echo $mce_buttons_2 ?>",
			theme_advanced_buttons3: "",
			theme_advanced_buttons4: "",
			plugins: "<?php echo $plugins ?>",
			language: "<?php echo $mce_locale ?>",
	
			// Theme Options
			theme_advanced_buttons3: "",
			theme_advanced_buttons4: "",
			theme_advanced_toolbar_location: "top",
			theme_advanced_toolbar_align: "left",
			theme_advanced_statusbar_location: "bottom",
			theme_advanced_resizing: true,
			theme_advanced_resize_horizontal: "",

			relative_urls: false,
			convert_urls: false,
		});
		</script>
	<?php
		if ( 'en' != $language && isset($lang) )
			echo "<script type='text/javascript'>\n$lang\n</script>";
		else
			echo "<script type='text/javascript' src='$baseurl/langs/wp-langs-en.js?$version'></script>\n";
	
	}
	
	
	/**
	 * Add a dataset for newly registrered user
	 *
	 * @param int $user_id
	 */
	public function registerUser( $user_id ) {
		require_once( PROJECTMANAGER_PATH.'/admin/admin.php' );
		$admin = new ProjectManagerAdmin(false);

		$user = new WP_User($user_id);
		if ( $user->has_cap('projectmanager_user') ) {
			foreach ( $this->getProjects() AS $project ) {
				if ( 1 == $project->profile_hook && !$admin->datasetExists($project->id, $user_id) )
					$admin->addDataset( $project->id, array(), false, $user_id );
			}
		}
	}
	
	
	/**
	 * set dataset status to 'active'
	 *
	 * @param int $dataset_id
	 * @param string $key
	 * @return boolean
	 */
	public function activateDataset( $dataset_id, $key ) {
		global $wpdb;
		
		$dataset = $wpdb->get_row( $wpdb->prepare("SELECT `id` FROM {$wpdb->projectmanager_dataset} WHERE `id` = '%d' AND `activationkey` = '%s'", intval($dataset_id), $key) );
		
		if ( $dataset ) {
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_dataset} SET `status` = 'active', `activationkey` = '' WHERE `id` = '%d'", $dataset->id ) );
			return true;
		}
		
		return false;
	}
	
	
	/**
	 * check if global search has been performed
	 *
	 * @return boolean
	 */
	public function isGlobalSearch() {
		if (isset($_GET['projectmanager_search_global']))
			return true;
		
		return false;
	}
	
	
	/**
	 * get search string
	 *
	 * @return string
	 */
	public function getSearchString() {
		if ( $this->isGlobalSearch())
			return $_GET['projectmanager_search_global'];
		
		return '';
	}
	
	
	/**
	 * get supported image types
	 *
	 * @return array
	 */
	public function getSupportedImageTypes() {
		return array( "jpg", "jpeg", "png", "gif" );
	}
	
	
	/**
	 * update map data using cron job
	 *
	 * @param int $project_id
	 */
	public function updateMapData( $project_id ) {
		$map = new PM_Map($project_id);
		$map->updateData();
	}
	
	
	/**
	 * print dataset checkbox list of specific project
	 *
	 * @param int $project_id
	 * @param string $name
	 * @param array $selected
	 * @param string $label_type
	 * @param boolean $echo default true
	 */
	public function printDatasetCheckboxList($project_id, $name, $selected, $label_type = "label", $echo = true) {
		$project = get_project($project_id);
		$project->printDatasetCheckboxList($name, $selected, $label_type, $echo);
	}
	
	
	/**
	 * print dataset dropdown menu of specific project
	 *
	 * @param int $project_id
	 * @param string $name
	 * @param array $selected
	 * @param string $label_type
	 * @param boolean $echo default true
	 */
	public function printDatasetDropdown($project_id, $name, $selected, $label_type = "label", $echo = true) {
		$project = get_project($project_id);
		$project->printDatasetDropdown($name, $selected, $label_type, $echo);
	}
}

global $projectmanager;
if ( is_admin() ) {
	require_once (dirname (__FILE__) . '/admin/admin.php');
	$projectmanager = new ProjectManagerAdmin();
} else {
	$projectmanager = new ProjectManager();
}

// Suppress output for export
if ( isset($_POST['projectmanager_export']) || isset($_GET['projectmanager_pdf']) || (isset($_POST['downloadFormPDF']) && isset($_POST['project_id'])) ) {
	ob_start();
}
?>