<?php
/**
 * ProjectManagerWidget API: ProjectManagerWidget class
 *
 * @author Kolja Schleich
 * @package ProjectManager
 * @subpackage ProjectManagerWidget
 */
 
/**
 * Class to implement the Dataset widget
 *
 * @package ProjectManager
 * @subpackage ProjectManagerWidget
 */
class ProjectManagerWidget extends WP_Widget {
	/**
	 * prefix of widget
	 * 
	 * @var string
	 */
	var $prefix = 'projectmanager-widget';
	
	
	/**
	 * initialize widget
	 *
	 * @param boolean $template
	 */
	public function __construct( $template = false ) {		
		if ( !$template ) {
			$widget_ops = array('classname' => 'widget_projectmanager', 'description' => __('Display datasets from ProjectManager', 'projectmanager') );
			parent::__construct('projectmanager-widget', __( 'Project', 'projectmanager' ), $widget_ops);
		}
	}
	
		
	/**
	 * display widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $wpdb;

		$project = get_project(intval($instance['project']));
		
		$defaults = array(
			'before_widget' => '<li id="projectmanager-'.$this->number.'" class="widget '.get_class($this).'_'.__FUNCTION__.'">',
			'after_widget' => '</li>',
			'before_title' => '<h2 class="widgettitle">',
			'after_title' => '</h2>',
			'number' => $this->number,
			'widget_title' => $project->title,
		);
		$args = array_merge( $defaults, $args );
		extract( $args, EXTR_SKIP );
		
		$limit = ( intval($instance['limit']) != 0 ) ? intval($instance['limit']) : 0;
		$random = ( isset($instance['random']) && $instance['random'] == 1 ) ? true : false;
		$datasets = $project->getDatasets( array( 'limit' => $limit, 'random' => $random ) );
		
		echo $before_widget;
		
		if ( !empty($widget_title) ) echo $before_title . stripslashes($widget_title) . $after_title;

		echo "<ul class='projectmanager_widget'>";
		
		if ( $datasets ) {
			$url = get_permalink($instance['page_id']);
			foreach ( $datasets AS $dataset ) {
				$dataset = get_dataset($dataset);
				
				//$url = add_query_arg('show', $dataset->id, $url);
				$url = add_query_arg("show_".$project->id, $dataset->id, $url);
				$url = add_query_arg('project_id', $project->id, $url);
				
				if ($dataset->image == "") {
					$dataset->image = $project->default_image;
				}
			
				$img_url = $dataset->getFileURL($instance['image_size'].$dataset->image);
				
				if ($project->hasDetails())
					$name = sprintf('<a href="%1$s" title="%3$s"><img src="%2$s" alt="%3$s"  /></a>', esc_url($url), $img_url, stripslashes($dataset->name));
				else
					$name = sprintf('<img src="%1$s" alt="%2$s" title="%2$s" />', $img_url, stripslashes($dataset->name));
				
				echo "<li>".$name."</li>";
			}
		}
		
		echo "</ul>";
		
		echo $after_widget;
	}
	

	/**
	 * save settings
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$new_instance['project'] = intval($new_instance['project']);
		$new_instance['limit'] = intval($new_instance['limit']);
		$new_instance['page_id'] = intval($new_instance['page_id']);
		$new_instance['random'] = intval($new_instance['random']);
		
		return $new_instance;
	}


	/**
	 * widget control panel
	 *
	 * @param array $instance
	 */
	public function form( $instance ) {
		global $wp_registered_widgets;

		if (!isset($instance['project'])) {
			$instance = array('project' => 0, 'limit' => 0, 'page_id' => 0, 'image_size' => 'medium.', 'random' => 0);
		}
		
		echo '<div class="projectmanager_widget_control">';
		echo '<p><label for="'.$this->get_field_id('project').'">'.__('Project', 'projectmanager').'</label>'.$this->getProjectsDropdown($instance['project']).'</p>';
		echo '<p><label for="'.$this->get_field_id('limit').'">'.__('Display', 'projectmanager').'</label><select style="margin-top: 0;" size="1" name="'.$this->get_field_name('limit').'" id="'.$this->get_field_id('limit').'">';
		$selected['show_all'] = ( $instance['limit'] == 0 ) ? " selected='selected'" : '';
		echo '<option value="0"'.$selected['show_all'].'>'.__('All','projectmanager').'</option>';
		for ( $i = 1; $i <= 10; $i++ ) {
		        $selected = ( $instance['limit'] == $i ) ? " selected='selected'" : '';
			echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
		}
		echo '</select></p>';
		$checked = ( isset($instance['random']) && $instance['random'] == 1 ) ? " checked='checked'" : '';
		echo '<p><input type="checkbox" name="'.$this->get_field_name('random').'" id="'.$this->get_field_id('random').'" value="1"'.$checked.' /><label class="checkbox right" for="'.$this->get_field_id('random').'">'.__('Random', 'projectmanager').'</label></p>';
		echo '<p><label for="'.$this->get_field_id('page_id').'">'.__('Page','projectmanager').'</label>'.wp_dropdown_pages(array('name' => $this->get_field_name('page_id'), 'selected' => $instance['page_id'], 'echo' => 0)).'</p>';
		echo '<p><label for="'.$this->get_field_id('image_size').'">'.__('Image Size','projectmanager').'</label>'.$this->getImageSizes($instance['image_size']).'</p>';
		echo '</div>';
	}
	
	
	/**
	 * get dropdown menu of image sizes
	 *
	 * @param string $selected
	 * @return string 
	 */
	public function getImageSizes( $selected ) {
		$sizes = array('tiny.' => __( 'Tiny size', 'projectmanager' ), 'thumb.' => __('Thumbnail size', 'projectmanager'), 'medium.' => __( 'Medium size', 'projectmanager' ), 'large.' => __( 'Large size', 'projectmanager' ), '' => __('Full size', 'projectmanager'), );
		$out = '<select size="1" name="'.$this->get_field_name('image_size').'" id="'.$this->get_field_id('image_size').'">';
		foreach ( $sizes AS $key => $label ) {
			$checked =  ( $selected == $key ) ? " selected='selected'" : '';
			$out .= '<option value="'.$key.'"'.$checked.'>'.$label.'</option>';
		}
		$out .= '</select>';
		return $out;
	}
	
	
	/**
	 * get all projects as dropdown menu
	 *
	 * @param int $current
	 * @return array
	 */
	public function getProjectsDropdown($current) {
		global $projectmanager;
	
		$out = "<select size='1' name='".$this->get_field_name('project')."' id='".$this->get_field_id('project')."'>";
		foreach ( $projectmanager->getProjects() AS $project ) {
			$selected = ( $current == $project->id ) ? " selected='selected'" : '';
			$out .= "<option value='".$project->id."'".$selected.">".$project->title."</option>";
		}
		$out .= "</select>";
		return $out;
	}
}

/**
 * Class to implement the global search widget
 *
 * @package ProjectManager
 * @subpackage ProjectManagerSearchWidget
 */
class ProjectManagerSearchWidget extends WP_Widget {
	/**
	 * initialize
	 *
	 */
	public function __construct( ) {
		$widget_ops = array('classname' => 'widget_projectmanager_search', 'description' => __('Global Search for ProjectManager', 'projectmanager') );
		parent::__construct('projectmanager-search-widget', __( 'ProjectManager Search', 'projectmanager' ), $widget_ops);
	}

	
	/**
	 * display widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $wpdb, $projectmanager;
		
		$defaults = array(
			'before_widget' => '<li id="projectmanager-'.$this->number.'" class="widget projectmanager_widget_search">',
			'after_widget' => '</li>',
			'before_title' => '<h2 class="widgettitle">',
			'after_title' => '</h2>',
			'number' => $this->number,
		);
		$args = array_merge( $defaults, $args );
		extract( $args, EXTR_SKIP );
		
		echo $before_widget;
		if ( !empty($instance['widget_title']) ) echo $before_title . stripslashes($instance['widget_title']) . $after_title;
		?>
		<form action='<?php echo esc_url(get_permalink(intval($instance['results_page']))) ?>' class="projectmanager-search" method='get'>
			<input type='search' class='search-field' name='projectmanager_search_global' value='<?php echo $projectmanager->getSearchString() ?>' placeholder="<?php _e('Search', 'projectmanager') ?>" />
			<input type="hidden" name="template" id="template" value="<?php echo $instance['template'] ?>" />
			<input type='submit' value='<?php _e('Search', 'projectmanager') ?>' class='button' />
		</form>
		<?php
		echo $after_widget;
	}
	
	
	/**
	 * save settings
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$new_instance['widget_title'] = htmlspecialchars($new_instance['widget_title']);
		$new_instance['results_page'] = intval($new_instance['results_page']);
		
		return $new_instance;
	}


	/**
	 * widget control panel
	 *
	 * @param array $instance
	 */
	public function form( $instance ) {
		global $wp_registered_widgets;

		if (!isset($instance['widget_title'])) {
			$instance = array('widget_title' => __('ProjectManager Search', 'projectmanager'), 'results_page' => '', 'template' => 'table');
		}
		
		echo '<div class="projectmanager_widget_control">';
		echo '<p><label for="'.$this->get_field_id('widget_title').'">'.__( 'Title', 'projectmanager' ).'</label><input type="text" name="'.$this->get_field_name('widget_title').'" id="'.$this->get_field_id('widget_title').'" value="'.htmlspecialchars($instance['widget_title']).'" /></p>';
		echo '<p><label for="'.$this->get_field_id('results_page').'">'.__('Results Page','projectmanager').'</label>'.wp_dropdown_pages(array('name' => $this->get_field_name('results_page'), 'selected' => $instance['results_page'], 'echo' => 0)).'</p>';
		echo '<p><label for="'.$this->get_field_id('template').'">'.__( 'Format', 'projectmanager' ).'</label>'.$this->getTemplates($instance['template']).'</p>';
		echo '</div>';
	}
	
	
	/**
	 * dropdown list of templates
	 *
	 * @param string $selected
	 * @return string
	 */
	public function getTemplates( $selected ) {
		$templates = array( 'gallery' => __('Gallery', 'projectmanager'), 'table' => __('Table', 'projectmanager'), 'table-image' => __('Table with Image', 'projectmanager') );
		$out = '<select size="1" name="'.$this->get_field_name('template').'" id="'.$this->get_field_id('template').'">';
		foreach ( $templates AS $key => $name ) {
			$selected =  ( $selected == $key ) ? " selected='selected'" : '';
			$out .= '<option value="'.$key.'"'.$selected.'>'.$name.'</option>';
		}
		$out .= '</select>';
		return $out;
	}
}
?>