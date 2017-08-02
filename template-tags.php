<?php
/**
 * Template tags can be used in template files and are designed like the WordPress template tags
 *
 * @package ProjectManager
 * @category template-tags
 */

/**
 * get project title
 *
 * @param string $start_el
 * @param string $end_el
 * @return string
 * @category template-tags
 */
function get_project_title( $start_el = "<h3>", $end_el = "</h3>" ) {
	global $project;
	 
	if ( $project->title != "" && $project->show_title === true )
		return $start_el . $project->title . $end_el;
	 
	return '';
}
/**
 * print project title
 *
 * @param string $start_el
 * @param string $end_el
 * @see get_project_title()
 * @category template-tags
 */
function the_project_title( $start_el = "<h3>", $end_el = "</h3>" ) {
	echo get_project_title( $start_el, $end_el );
}


/**
 * get project ID
 *
 * @return int
 * @category template-tags
 */
function get_project_id() {
	global $project;
	return $project->id;
}
/**
 * print project ID
 * @see get_project_id()
 * @category template-tags
 */
function the_project_id() {
	echo get_project_id();
}


/**
 * get current number of datasets depending on subselection
 *
 * @return int
 * @category template-tags
 */
function get_num_datasets() {
	global $project;
	return $project->num_datasets;
}
/**
 * get total number of datasets in project
 *
 * @return int
 * @category template-tags
 */
function get_num_total_datasets() {
	global $project;
	return $project->num_datasets_total;
}

/**
 * get number of countries in project
 *
 * @return int
 * @category template-tags
 */
function get_num_countries() {
	global $project;
	return $project->getNumCountries();
}


/**
 * check if at least one dataset-image formfield is present in project
 *
 * @return boolean
 * @category template-tags
 */
function project_has_images() {
	global $project;
	
	if ( $project->hasDatasetImage() )
		return true;
	
	return false;
}


/**
 * check if at least one header-image formfield is present in project
 *
 * @return boolean
 * @category template-tags
 */
function project_has_title_images() {
	global $project;
	
	if ( $project->hasDatasetHeaderImage() )
		return true;
	
	return false;
}


/**
 * check if single dataset has been selected
 *
 * @return boolean
 * @category template-tags
 */
function is_dataset() {
	global $project;
	return $project->is_selected_dataset;
}
  

/**
 * check that dataset variable is set
 *
 * @return boolean
 * @category template-tags
 */
function has_dataset() {
	$dataset = get_dataset();
	
	if ( $dataset )
		return true;
	
	return false;
}


/**
 * test whether project has datasets or we are in the loop
 *
 * @return boolean
 * @category template-tags
 */
function have_datasets() {
	global $project;

	if ( $project->current_dataset + 1 < count($project->datasets) ) {
		return true;
	} elseif ( $project->current_dataset == count($project->datasets)-1 && count($project->datasets) > 0 ) {
		// End of Loop
		$project->current_dataset = -1;	
	}
	
	$project->in_the_loop = false;
	return false;
}


/**
 * start loop through datasets
 *
 * @category template-tags
 */
function the_dataset() {
	global $project, $dataset;
	
	$project->in_the_loop = true;
	
	// Loop start
	if ( $project->current_dataset == -1 ) {
		
	}
	
	// Increment dataset count
	$project->current_dataset++;
	$dataset = $project->datasets[$project->current_dataset];
	
	$project->dataset = $dataset;
}


/**
 * get dataset name in the loop
 *
 * @return string
 * @category template-tags
 */
function get_dataset_name() {
	global $dataset;
	return $dataset->name;
}
/**
 * print dataset name in the loop
 * @see get_dataset_name()
 * @category template-tags
 */
function the_dataset_name() {
	echo get_dataset_name();
}


/**
 * get dataset id in the loop
 *
 * @return  int
 * @category template-tags
 */
function get_dataset_id() {
	global $dataset;
	return $dataset->id;
}
/**
 * print dataset id in the loop
 *
 * @see get_dataset_id()
 * @category template-tags
 */
function the_dataset_id() {
	echo get_dataset_id();
}


/**
 * print url to single dataset formatted with dataset name in the loop
 *
 * @category template-tags
 */
function the_dataset_name_url() {
	global $dataset;
	echo $dataset->nameURL;
}


/**
 * print thickbox popup url
 *
 * @category template-tags
 */
function the_dataset_thickbox_url() {
	global $dataset;
	echo $dataset->ThickboxURL;
}


/**
 * print dataset CSS class
 *
 * @category template-tags
 */
function the_dataset_class() {
	global $dataset;
	echo $dataset->cssClass;
}


/**
 * print dataset width for gallery view
 *
 * @category template-tags
 */
function the_dataset_width() {
	global $project;
	echo $project->dataset_width;
}


/**
 * get dataset url
 *
 * @return string
 * @category template-tags
 */
function get_dataset_url() {
	global $dataset;
	return $dataset->URL;
}
/**
 * print dataset url in the loop
 *
 * @see get_dataset_url()
 * @category template-tags
 */
function the_dataset_url() {
	echo get_dataset_url();
}


/**
 * check if dataset has valid image
 *
 * @return boolean
 * @category template-tags
 */
function dataset_has_image() {
	global $dataset;
	
	if ( $dataset->image != '' && file_exists($dataset->getFilePath($dataset->image)) )
		return true;
	
	return false;
}


/**
 * check if dataset has valid title image
 *
 * @return boolean
 * @category template-tags
 */
function dataset_has_title_image() {
	global $dataset;
	
	if ( $dataset->headerimage != '' && file_exists($dataset->getFilePath($dataset->headerimage)) )
		return true;
	
	return false;
}


/**
 * check if dataset has been selected from project list
 *
 * @return boolean
 * @category template-tags
 */
function is_selected_dataset() {
	global $dataset;
	if ( $dataset && $dataset->isSelected() )
		return true;
	
	return false;
}


/**
 * determine if dataset is marked sticky
 *
 * @return boolean
 * @category template-tags
 */
function dataset_is_sticky() {
	global $dataset;
	if ( $dataset->sticky == 1 )
		return true;
	
	return false;
}


/**
 * print link back to project overview from single dataset view
 *
 * @category template-tags
 */
function the_dataset_project_url() {
	global $dataset;
	
	echo $dataset->project_url;
}


/**
 * check if dataset navigation is present
 *
 * @return boolean
 * @category template-tags
 */
function dataset_has_navigation() {
	global $dataset;
	
	return $dataset->navigation;
}


/**
 * check if previous dataset is present
 *
 * @return boolean
 * @category template-tags
 */
function has_prev_dataset() {
	global $dataset;
	
	if ( $dataset->prev_url )
		return true;
	
	return false;
}


/**
 * check if next dataset is present
 *
 * @return boolean
 * @category template-tags
 */
function has_next_dataset() {
	global $dataset;
	
	if ( $dataset->next_url )
		return true;
	
	return false;
}


/**
 * print url to next dataset
 *
 * @category template-tags
 */
function the_next_dataset_url() {
	global $dataset;
	
	echo $dataset->next_url;
}


/**
 * print url to previous dataset
 *
 * @category template-tags
 */
function the_prev_dataset_url() {
	global $dataset;
	
	echo $dataset->prev_url;
}


/**
 * get URL to dataset image
 *
 * @param string $size 'full', 'large', 'medium', 'thumb' or 'tiny'
 * @return string
 * @category template-tags
 */
function get_dataset_image_url( $size = 'full' ) {
	global $dataset;
	if (empty($dataset->image)) return '';
	
	return $dataset->getImageURL($dataset->image, $size);
}
/**
 * print URL to dataset image
 *
 * @param string $size 'full', 'large', 'medium', 'thumb' or 'tiny'
 * @see get_dataset_image_url()
 * @category template-tags
 */
function the_dataset_image_url( $size = 'full' ) {
	echo get_dataset_image_url($size);
}

/**
 * get header image URL
 *
 * @param string $size 'full', 'large', 'medium', 'thumb' or 'tiny'
 * @return string
 * @category template-tags
 */
function get_dataset_title_image_url( $size = 'full' ) {
	global $dataset;
	return $dataset->getImageURL( $dataset->headerimage, $size );
}
/**
 * print header image URL
 *
 * @param string $size 'full', 'large', 'medium', 'thumb' or 'tiny'
 * @category template-tags
 */
function the_dataset_title_image_url( $size = 'full' ) {
	echo get_dataset_title_image_url($size);
}


/**
 * display dataset image
 *
 * @param string $size 'full', 'large', 'medium', 'thumb' or 'tiny'
 * @param string $alignment CSS class to align image
 * @category template-tags
 */
function the_dataset_image( $size = 'full', $alignment = "aligncenter" ) {
	global $dataset;
	
	if (!empty($dataset->image))
		printf('<img src="%1$s" alt="%2$s" title="%2$s" class="%3$s" />', get_dataset_image_url($size), $dataset->name, $alignment);
}


/**
 * display dataset header image
 *
 * @param string $size 'full', 'large', 'medium', 'thumb' or 'tiny'
 * @category template-tags
 */
function the_dataset_title_image( $size = 'full' ) {
	global $dataset;
	
	if ( $dataset->headerimage != '' && file_exists($dataset->getFilePath($dataset->headerimage)) )
		printf('<img src="%1$s" alt="%2$s" title="%2$s" class="dataset-header-image" />', get_dataset_title_image_url($size), $dataset->name);
}


/**
 * display dataset meta data
 *
 * @param array $args
 * @category template-tags
 * @see Dataset::printData()
 */
function the_dataset_metadata( $args = array() ) {
	global $dataset;
	
	$defaults = array( "output" => "dl" );
	$args = array_merge( $defaults, $args );
	$dataset->printData( $args );
}


/**
 * display comment in testimonials shortcode templates
 *
 * @category template-tags
 */
function the_dataset_comment() {
	global $dataset;
	echo $dataset->comment;
}


/**
 * display city in testimonials shortcode templates
 *
 * @category template-tags
 */
function the_dataset_city() {
	global $dataset;
	echo $dataset->city;
}


/**
 * display country in testimonials shortcode templates
 *
 * @category template-tags
 */
function the_dataset_country() {
	global $dataset;
	echo $dataset->country;
}


/**
 * check if searchform should be shown
 *
 * @return boolean
 * @category template-tags
 */
function project_has_searchform() {
	global $project;
	return $project->searchform;
}


/**
 * check if selections menu should be shown
 *
 * @return boolean
 * @category template-tags
 */
function project_has_selections() {
	global $project;
	return $project->selections;
}


/**
 * display projects pagination
 *
 * @param string $start_el
 * @param string $end_el
 * @category template-tags
 */
function the_project_pagination( $start_el = "<p class='projectmanager-pagination page-numbers'>", $end_el = "</p>" ) {
	global $project;
	
	if ( $project->pagination )
		echo $start_el . $project->pagination . $end_el;
}


/**
 * display selected single dataset in a project
 *
 * @param string $template
 * @category template-tags
 */
function the_single_dataset( $template = "" ) {
	global $project;
	echo do_shortcode("[dataset id='".$project->current_dataset."' template='".$template."']");
}

/**
 * get search query
 *
 * @return string
 * @category template-tags
 */
function get_project_search_query() {
	global $project;
	return $project->getSearchString();
}
/**
 * print search query
 *
 * @see get_project_search_query()
 * @category template-tags
 */
function the_project_search_query() {
	echo get_project_search_query();
}


/**
 * display projects searchform
 *
 * @category template-tags
 */
function the_project_searchform() {
	global $project;
	if ( project_has_searchform() ) {
		do_action('projectmanager_searchform', array('project_id' => $project->id));
	}
}


/**
 * display projects searchform
 *
 * @category template-tags
 */
function the_project_selections() {
	global $project;
	if ( project_has_selections() ) {
		do_action('projectmanager_selections');
	}
}


/**
 * properly close cols row and maybe open next row for multi-grid view
 *
 * @category template-tags
 */
function project_close_cols() {
	global $project; 
	
	$counter = $project->current_dataset + 1;
	// Cols row has to be closed if the dataset is at the end of the row or we've reached the last dataset
	if ( 0 == $counter % $project->gallery_num_cols || $counter == count($project->datasets) ) {
		echo "</div>";
		
		// Open new row if we haven't reached the last dataset yet
		if ( $counter < count($project->datasets) )
			echo '<div class="cols">';
	}
}


/**
 * print table header for table output
 *
 * @param array $args
 * @category template-tags
 * @see Dataset::printTableHeader()
 */
function the_project_table_header( $args = array() ) {
	global $project;
	$project->datasets[0]->printTableHeader( $args );
}


/**
 * display full project
 *
 * @param integer $id Project ID
 * @param array $args assoziative array of parameters
 * @see ProjectManagerShortcodes::displayProject()
 * @category template-tags
 */
function project( $id, $args = array() ) {
	$defaults = array( 'template' => 'table', 'cat_id' => 0, 'orderby' => false, 'order' => false, 'single' => true, 'selections' => 'true', 'searchform' => 'true', 'results' => "true", 'field_id' => 0, 'field_value' => '', 'show_title' => true );
	$args = array_merge($defaults, $args);
	extract($args, EXTR_SKIP);
	
	echo do_shortcode("[project id=".intval($id)." template='".$template."' cat_id='".intval($cat_id)."' orderby='".$orderby."' order='".$order."' single='".$single."' selections='".$selections."' searchform='".$searchform."' results='".$results."' field_id='".intval($field_id)."', field_value='".$field_value."' show_title='".$show_title."']");
}


/**
 * display independent dataset
 *
 * @param integer $id Dataset ID
 * @param array $args assoziative array of parameters
 * @see ProjectManagerShortcodes::displayDataset()
 * @category template-tags
 */
function dataset( $id, $args = array() ) {
	$args = array_merge(array( 'template' => '' ), $args);
	extract($args, EXTR_SKIP);
	echo do_shortcode("[dataset id=".intval($id)." template='".$template."']");
}


/**
 * display dataset form
 *
 * @param integer $project_id Project ID
 * @see ProjectManagerShortcodes::displayDatasetForm()
 * @category template-tags
 */
function the_datasetform( $project_id ) {
	echo do_shortcode('[dataset_form project_id='.intval($project_id).']');
}


/**
 * display widget
 *
 * @param integer $number
 * @param array $instance widget parameters
 * @see ProjectManagerWidget::widget()
 * @category template-tags
 */
function projectmanager_widget( $number, $instance ) {
	$number = intval($number);
	echo "<ul id='projectmanager-widget-".$instance['project']."' class='projectmanager_widget'>";
	$widget = new ProjectManagerWidget(true);
	$widget->widget( array('number' => $number), $intance );
	echo "</ul>";
}
?>