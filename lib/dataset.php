<?php
/**
 * Dataset API: Dataset class
 *
 * @author Kolja Schleich
 * @package ProjectManager
 * @subpackage Dataset
 */
 
/**
 * Class to implement the Dataset object
 *
 */
final class Dataset {
	/**
	 * Dataset ID
	 *
	 * @var int
	 */
	public $id = 0;
	
	/**
	 * Dataset Name
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * name URL to single dataset
	 *
	 * @var string
	 */
	public $nameURL = '';
	
	/**
	 * URL to single dataset
	 *
	 * @var string
	 */
	public $URL = '';
	
	/**
	 * Dataset image
	 *
	 * @var string
	 */
	public $image = '';
	
	/**
	 * Dataset header image
	 *
	 * @var string
	 */
	public $headerimage = '';
	
	/**
	 * sticky status
	 *
	 * @var int
	 */
	public $sticky = 0;

	/**
	 * category IDs
	 *
	 * @var array
	 */
	public $cat_ids = array();
	
	/**
	 * categories dataset belongs to
	 *
	 * @var array
	 */
	public $categories = array();
	
	/**
	 * user ID dataset belongs to
	 *
	 * @var int
	 */
	public $user_id = 0;
	
	/**
	 * project ID
	 *
	 * @var int
	 */
	public $project_id = null;
	
	/**
	 * dataset order
	 *
	 * @var int
	 */
	public $order = 0;
	
	/**
	 * activation status
	 *
	 * @var string
	 */
	public $status = '';
	
	/**
	 * CSS classes
	 *
	 * @var array
	 */
	public $cssClass = array();
	
	/**
	 * activation key
	 *
	 * @var string
	 */
	private $activationkey = '';
	
	/**
	 * Thickbox URL
	 *
	 * @var string
	 */
	public $ThickboxURL = '';
	
	/**
	 * dataset data
	 *
	 * @var array
	 */
	public $data = array();
	
	/**
	 * control variable to check if dataset name, image or headerimage are set
	 *
	 * @var array
	 */
	public $has = array('name' => false, 'image' => false, 'header-image' => false);
	
	/**
	 * check if dataset has been selected in project or displayed using dataset shortcode
	 *
	 * @var boolean
	 */
	private $is_selected = false;
	
	/**
	 * dataset offset
	 *
	 * @var int
	 */
	private $offset = -1;
	
	/**
	 * single datasets navigation
	 *
	 * @var boolean
	 */
	public $navigation = false;
	
	/**
	 * url to next dataset
	 *
	 * @var string
	 */
	public $next_url = '';
	
	/**
	 * url to previous dataset
	 *
	 * @var string
	 */
	public $prev_url = '';
	
	/**
	 * url to project overiew
	 *
	 * @var string
	 */
	public $project_url = '';
	
	
	/**
	 * retrieve dataset instance
	 *
	 * @param int $dataset_id
	 * @return Dataset|false
	 */
	public static function get_instance($dataset_id) {
		global $wpdb;

		$dataset_id = (int) $dataset_id;
		if ( ! $dataset_id )
			return false;

		$dataset = wp_cache_get( $dataset_id, 'datasets' );
		
		if ( ! $dataset ) {
			$dataset = $wpdb->get_row( $wpdb->prepare( "SELECT `id`, `sticky`, `cat_ids`, `project_id`, `user_id`, `order`, `status`, `activationkey` FROM $wpdb->projectmanager_dataset WHERE id = %d LIMIT 1", $dataset_id ) );
			
			if ( !$dataset ) return false;

			$dataset = new Dataset( $dataset );
			
			wp_cache_add( $dataset->id, $dataset, 'datasets' );
		}
		
		return $dataset;
	}
	
	
	/**
	 * Constructor
	 *
	 * @param object $dataset Dataset object.
	 */
	public function __construct( $dataset = null ) {
		if ( !is_null($dataset) ) {
			foreach ( get_object_vars( $dataset ) as $key => $value )
				$this->$key = $value;
			
			// make sure that categories are array
			$this->categories = (array) maybe_unserialize($this->cat_ids);
			
			$this->is_selected = isset($_GET["show_".$this->project_id]) ? true : false;
				
			$this->loadData();
		}
	}
	
	
	/**
	 * load dataset metadata
	 *
	 * This function loads all metadata associated with the dataset from database. Run upon object creation.
	 *
	 * @return boolean returns success on finish
	 */
	 private function loadData() {
		global $wpdb;
		
		// First try to get global project
		$project = get_project();
		if ( is_null($project) || (!is_null($project) && $project->id != $this->project_id) ) $project = get_project($this->project_id);
		
		$sql = "SELECT data.id AS id, form.id AS form_field_id, form.label AS label, form.parent_id AS formfield_parent, form.options AS formfield_options, form.private AS is_private, form.unique AS is_unique, form.mandatory AS is_mandatory, data.value AS value, form.type AS type, form.show_on_startpage AS show_on_startpage FROM {$wpdb->projectmanager_datasetmeta} AS data LEFT JOIN {$wpdb->projectmanager_projectmeta} AS form ON form.id = data.form_id WHERE data.dataset_id = '%d' ORDER BY form.order ASC";
			
		$data = wp_cache_get( $this->id, 'dataset_meta' );

		if (!$data) {
			$data = $wpdb->get_results( $wpdb->prepare($sql, $this->id) );
			wp_cache_add( $this->id, $data, 'dataset_meta' );
		}
		
		if ( !$data ) return false;
		
		foreach ( $data AS $m ) {
			$m->form_field_id = intval($m->form_field_id);
			$m->id = intval($m->id);
			$m->is_private = intval($m->is_private);
			$m->is_unique = intval($m->is_unique);
			$m->is_mandatory = intval($m->is_mandatory);
			$m->show_on_startpage = intval($m->show_on_startpage);
			$m->formfield_parent = intval($m->formfield_parent);
			
			if (!is_numeric($m->value))
				$m->value = stripslashes_deep(maybe_unserialize($m->value));
			
			/**
			 * Fired when dataset metadata is loaded
			 *
			 * @param mixed $value the value
			 * @return mixed
			 * @category wp-filter
			 */
			$m->value = apply_filters('dataset_meta_'.$m->type, $m->value);
			
			// save data by keys for easy direct access
			$key = sanitize_title($m->label);
			if ($key != "") $this->$key = $m->value;
				
			// save data as two-dimensional array
			$this->data[] = get_object_vars($m);
				
			if (intval($this->has['name']) == 0 && $m->type == 'name') {
				$this->name = stripslashes(htmlspecialchars($m->value));
				$this->has['name'] = $m->form_field_id;
			}
				
			if (intval($this->has['image']) == 0 && $m->type == 'dataset-image') {
				$this->image = $m->value;
				$this->has['image'] = $m->form_field_id;
			}
				
			if (intval($this->has['header-image']) == 0 && $m->type == 'header-image') {
				$this->headerimage = $m->value;
				$this->has['header-image'] = $m->form_field_id;
			}
		}
		
		if ($this->sticky == 1) $this->cssClass[] = "sticky";
		
		// set thickbox url
		$this->ThickboxURL = "#TB_inline?height=700&width=700&inlineId=TB_dataset_".$this->id;
		
		$this->nameURL = $this->name;
		
		/*
		 * set dataset images
		 */
		if ($this->image == "") {
			$this->image = $project->default_image;
		}
		
		// set categories indexed by category IDs
		$categories = array();
		if (is_array($this->categories) && count($this->categories) > 0) {
			foreach ($this->categories AS $cat_id) {
				if (!empty($cat_id)) {
					$category = $project->getData("categories", "id", $cat_id, 1);
					$categories[$cat_id] = $category->title;
				}
			}
			
			asort($categories);
		}
		$this->categories = $categories;
		$this->cat_ids = array_keys($this->categories);
		
		// prepare single dataset navigation and link back to project overview
		if ( $this->is_selected === true && !is_admin() ) {
			// get global project
			$project = get_project();
			
			$this->offset = $project->getDatasetOffset($this->id);
			
			$url = get_permalink();
			//$url = add_query_arg('project_id', $this->project_id, $url);
			$url = ($project->isCategory()) ? add_query_arg('cat_id', $project->getCatID(), $url) : $url;

			foreach ( $_GET AS $key => $value ) {
				$url = add_query_arg( $key, $value, $url );
			}
			
			$url = remove_query_arg('show_'.$this->project_id, $url);
			$url = remove_query_arg('paged_'.$this->project_id, $url);
			
			// now specify URLs
			$project_url = add_query_arg('paged_'.$this->project_id, $project->getDatasetPage($this->id), $url);
			
			if ( $project->hasNextDataset($this->offset)) {
				$next_url = add_query_arg('show_'.$this->project_id, $project->getDatasetID($this->offset + 1), $url);
				$next_url = add_query_arg('paged_'.$this->project_id, $project->getDatasetPage($project->getDatasetID($this->offset + 1)), $next_url);
				$next_url = esc_url($next_url);
			} else {
				$next_url = '';
			}
				
			if ( $project->hasPreviousDataset($this->offset)) {
				$prev_url = add_query_arg('show_'.$this->project_id, $project->getDatasetID($this->offset - 1), $url);
				$prev_url = add_query_arg('paged_'.$this->project_id, $project->getDatasetPage($project->getDatasetID($this->offset - 1)), $prev_url);
				$prev_url = esc_url($prev_url);
			} else {
				$prev_url = '';
			}
			
			$this->navigation = true;
			$this->project_url = esc_url($project_url);
			$this->prev_url = $prev_url;
			$this->next_url = $next_url;
		} else {
			$this->project_url = $this->prev_url = $this->next_url = '';
			$this->navigation = false;
		}
			
		return true;
	}
	
	
	/**
	 * check if dataset is selected in project
	 *
	 * @return boolean
	 */
	public function isSelected() {
		return $this->is_selected;
	}
	
	
	/**
	 * check if dataset is in specific category-
	 *
	 * @param int $cat_id
	 * @return boolean
	 */
	public function hasCategory( $cat_id ) {
		if ( in_array($cat_id, $this->cat_ids) )
			return true;
		
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
	 * @param string $file
	 * @return string
	 */
	public function getFilePath( $file = false ) {
		$base = WP_CONTENT_DIR.'/uploads/projects/Project-'.$this->project_id;
			
		if ( $file ) {
			return $base .'/'. basename($file);
		} else {
			return $base;
		}
	}
	
	
	/**
	 * get url of upload directory
	 *
	 * @param string $file
	 * @return string
	 */
	public function getFileURL( $file = false ) {
		$base = WP_CONTENT_URL.'/uploads/projects/Project-'.$this->project_id;
			
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
	 * get file extension
	 * 
	 * @param string $filename
	 * @return string
	 */
	public function getFileExtension( $filename ) {
		$file = $this->getFilePath($filename);
		if (file_exists($file)) {
			$file_info = pathinfo($file);
			return strtolower($file_info['extension']);
		}
		return false;
	}
	
	
	/**
	 * get file type depending on file extension
	 *
	 * @param string $filename
	 * @return string
	 */
	public function getFileType( $filename ) {
		$extension = $this->getFileExtension($filename);
		
		switch ( $extension ) {
			case 'ods':
			case 'doc':
			case 'docx':
				$type = "word";
				break;
			case 'xlsx':
			case 'xls':
			case 'ods':
				$type = "excel";
				break;
			case 'csv':
			case 'tsv':
				$type = "excel_csv";
				break;
			case 'ppt':
			case 'odp':
			case 'pptx':
				$type = "presentation";
				break;
			case 'zip':
			case 'rar':
			case 'tar':
			case 'gzip':
			case 'gz':
			case 'tar.gz':
			case 'bzip2':
			case 'tar.bz2':
				$type = "compressed";
				break;
			case 'divx':
			case 'mpg':
			case 'mp4':
			case 'wmv':
			case 'avi':
			case 'mp4':
			case 'mpg':
			case 'mpeg':
			case 'm4v':
			case '3gp':
			case 'mov':
			case 'qt':
			case 'mkv':
			case 'vob':
				$type = "video";
				break;
			case 'flv':
			case 'f4v':
			case 'f4p':
			case 'f4a':
			case 'f4b':
				$type = "video-flash";
				break;
			case 'mp3':
			case 'ogg':
			case 'wma':
			case 'aac':
			case 'm4a':
			case 'm4p':
			case 'wav':
				$type = "audio";
				break;
			case 'gif':
			case 'png':
			case 'jpg':
			case 'jpeg':
			case 'raw':
			case 'tiff':
			case 'tif':
			case 'bmp':
			case 'ico':
				$type = "image";
				break;
			case 'svg':
			case 'ai':
				$type = "image-vector";
				break;
			case 'psd':
			case 'eps':
			case 'ps':
			case 'xcf':
				$type = "image-photoshop";
				break;
			case 'html':
			case 'htm':
				$type = "www";
				break;
			case 'php':
				$type = "www-php";
				break;
			case 'txt':
				$type = "text";
				break;
			case 'pdf':
				$type = "pdf";
				break;
			default:
				$type = "generic";
				break;
		}
		
		return $type;
	}
	
	
	/**
	 * get file icon depending on file extension
	 * 
	 * @param string $filename
	 * @return string URL to file icon
	 */
	public function getFileImage( $filename ) {
		$extension = $this->getFileExtension($filename);
		$type = $this->getFileType($filename);
		$out = PROJECTMANAGER_URL . "/admin/icons/files/";
		
		switch ( $type ) {
			case 'word':
				$out .= "document_word.png";
				break;
			case 'excel':
				$out .= "document_excel.png";
				break;
			case 'excel_csv':
				$out .= "document_excel_csv.png";
				break;
			case 'presentation':
				$out .= "document_powerpoint.png";
				break;
			case 'compressed':
				$out .= "document_zipper.png";
				break;
			case 'video':
				$out .= "film.png";
				break;
			case 'video-flash':
				$out .= "document-flash-movie.png";
				break;
			case 'audio':
				$out .= "document_music.png";
				break;
			case 'image':
				$out .= "image.png";
				break;
			case 'image-vector':
				$out .= "document-illustrator.png";
				break;
			case 'image-photoshop':
				$out .= "document-photoshop.png";
				break;
			case 'www':
				$out .= "globe.png";
				break;
			case 'www-php':
				$out .= "document-php.png";
				break;
			case 'text':
				$out .= "document_text.png";
				break;
			case 'pdf':
				$out .= "pdf.png";
				break;
			default:
				$out .= "document.png";
				break;
		}
		
		/*
		switch ( $extension ) {
			case 'ods':
			case 'doc':
			case 'docx':
				$out .= "document_word.png";
				break;
			case 'xls':
			case 'ods':
				$out .= "document_excel.png";
				break;
			case 'csv':
				$out .= "document_excel_csv.png";
				break;
			case 'ppt':
			case 'odp':
			case 'pptx':
				$out .= "document_powerpoint.png";
				break;
			case 'zip':
			case 'rar':
			case 'tar':
			case 'gzip':
			case 'tar.gz':
			case 'bzip2':
			case 'tar.bz2':
				$out .= "document_zipper.png";
				break;
			case 'divx':
			case 'mpg':
			case 'mp4':
			case 'wmv':
			case 'avi':
			case 'mp4':
			case 'mpg':
			case 'mpeg':
			case 'm4v':
			case '3gp':
			case 'mov':
			case 'qt':
			case 'mkv':
			case 'vob':
				$out .= "film.png";
				break;
			case 'mp3':
			case 'ogg':
			case 'wma':
			case 'aac':
			case 'm4a':
			case 'm4p':
			case 'wav':
				$out .= "document_music.png";
				break;
			case 'flv':
			case 'f4v':
			case 'f4p':
			case 'f4a':
			case 'f4b':
				$out .= "document-flash-movie.png";
				break;
			case 'gif':
			case 'png':
			case 'jpg':
			case 'jpeg':
			case 'raw':
			case 'tiff':
			case 'tif':
			case 'bmp':
				$out .= "image.png";
				break;
			case 'svg':
			case 'ai':
				$out .= "document-illustrator.png";
				break;
			case 'psd':
			case 'eps':
			case 'ps':
				$out .= "document-photoshop.png";
				break;
			case 'html':
			case 'htm':
				$out .= "globe.png";
				break;
			case 'php':
				$out .= "document-php.png";
				break;
			case 'txt':
				$out .= "document_text.png";
				break;
			case 'pdf':
				$out .= "pdf.png";
				break;
			default:
				$out .= "document.png";
				break;
		}
		*/
		return esc_url($out);
	}
	
	
	/**	
	 * get dataset metadata
	 *
	 * @param string $column the column key
	 * @param string $search 
	 * @param int $limit
	 * @see Dataset::loadData()
	 */
	public function getData($column='', $search='', $limit=0) {
		if (!empty($column)) {
			$data = array_column($this->data, $column);
		} else {
			$data = $this->data;
		}
	
		if ($search === 0 || !empty($search)) {
			$keys = array_keys($data, $search);
			$data = array();
			foreach ($keys AS $key) {
				$data[] = $this->data[$key]["value"];
			}
		}
		
		foreach ($data AS $i => $d) {
			$data[$i] = (object)$d;
		}
		
		if (intval($limit) > 0) $data = array_slice($data, 0, $limit);
		if (intval($limit) == 1) {
			$data = $data[0];
			
			if (!empty($column) && !empty($search)) $data = $data->scalar;
		} elseif (count($data) == 1) {
			$data[0]->value = $data[0]->scalar;
			unset($data[0]->scalar);
		}
		
		return $data;
	}
	
	
	/**
	 * determine whether to show data field
	 *
	 * @param object $meta
	 * @param boolean $show_all
	 * @param array $exclude
	 * @param array $include
	 * @return boolean
	 */
	private function showField($meta, $show_all=false, $exclude = array(), $include = array()) {
		$show = true;
	
		// exclude by type or formfield  ID
		if ( !empty($exclude) && (in_array($meta->type, $exclude, true) || in_array($meta->form_field_id, $exclude, true)) ) $show = false;
		// include by type or formfield ID
		if ( !empty($include) && (!in_array($meta->type, $include, true) && !in_array($meta->form_field_id, $include, true)) ) $show = false;
		// exclude by formfield option
		if ( $meta->show_on_startpage == 0 && !$show_all ) $show = false;
		// only show private formfields in admin panel
		if ( $meta->is_private == 1 && !is_admin() ) $show = false;
		// exclude certain formfields
		if ( in_array($meta->type, array('paragraph', 'title')) ) $show = false;
		
		return $show;
	}
	
	
	/**
	 * gets form field labels as table header
	 *
	 * @param array $args
	 * @return string
	 */
	public function printTableHeader( $args = array() ) {
		$project = get_project($this->project_id);
		
		$defaults = array(
			"exclude" => '',
			"include" => '',
			"show_all" => false,
			"show_dataset_name" => true,
			"show_dataset_image" => true,
		);
			
		$args = array_merge( $defaults, $args );
		extract( $args, EXTR_SKIP );
		
		$exclude = !empty($exclude) ? (array) explode(',', $exclude) : array();
		$include = !empty($include) ? (array) explode(',', $include) : array();

		if ( !$show_dataset_name ) $exclude[] = intval($this->has['name']);
		if ( !$show_dataset_image ) $exclude[] = intval($this->has['image']);
		
		$out = ''; $hasPrimary = false;
		foreach ( $this->getData() AS $i => $meta ) {
			if ( $this->showField($meta, $show_all, $exclude, $include) ) {
				$class = array( 'manage-column', "column-".$meta->type );
				
				// set first column as primary
				if ( !$hasPrimary ) {
					$class[] = "column-primary";
					$hasPrimary = true;
				}
				
				if ( $meta->type == "numeric" )
					$class[] = "num";
				
				$out .= $project->getSortableTableHeader("formfields_".$meta->form_field_id, stripslashes($meta->label), $class);
			}
		}
		echo $out;
	}
	
	
	/**
	 * print data
	 *
	 * @param array $args additional arguments
	 */
	public function printData( $args = array() ) {
		global $current_user;
		
		$defaults = array(
			"exclude" => '',
			"include" => '',
			"output" => "td",
			"show_all" => false,
			"show_dataset_image" => true,
			"show_header_image" => true,
			"show_dataset_name" => true,
			"show_labels" => true,
			"class" => "",
			"imagesize" => "thumb",
		);
		$args = array_merge( $defaults, $args );
		extract( $args, EXTR_SKIP );

		$exclude = !empty($exclude) ? (array) explode(',', $exclude) : array();
		$include = !empty($include) ? (array) explode(',', $include) : array();

		if ( !$show_dataset_name ) $exclude[] = intval($this->has['name']);
		if ( !$show_dataset_image ) $exclude[] = intval($this->has['image']);
		if ( !$show_header_image ) $exclude[] = intval($this->has['header-image']);
		
		//$locale = get_locale();
		$project = get_project($this->project_id);

		$out = ''; $hasPrimary = false;
		foreach ( $this->getData() AS $i => $meta ) {
			$meta = (object)$meta;
			
			// setup dataset class
			$classes = ( $class == "" ) ? array() : array( $class );

			if ( $this->showField($meta, $show_all, $exclude, $include) ) {
				$meta->label = stripslashes($meta->label);
				$meta_value = ( is_string($meta->value) && 'tinymce' != $meta->type ) ? stripslashes(htmlspecialchars( $meta->value, ENT_QUOTES )) : $meta->value;
				
				$custom = false;
				// Custom Formfield without callback function
				if ( is_array($project->getFormFieldTypes($meta->type)) ) {
					$field = $project->getFormFieldTypes($meta->type);
					if ( !isset($field['callback']) ) {
						$custom = $meta->type;
						$meta->type = isset($field['html_type']) ? $field['html_type'] : 'text';
					}
				}

				// Do some parsing on array datasets
				if ( in_array($meta->type, array('checkbox', 'project')) ) {
					$list = "<ul class='".$meta->type." dataset-meta' id='form_field_".$meta->form_field_id."'>";
					foreach ( (array)$meta_value AS $item ) {
						if ( 'project' == $meta->type && is_numeric($item) ) {
							$item = get_dataset($item);
							if ( is_admin() ) {
								if ( $_GET['page'] == 'projectmanager' )
									$url_pattern = "<a href='admin.php?page=projectmanager&subpage=dataset&edit=".$item->id."&project_id=".$item->project_id."'>%s</a>";
								else
									$url_pattern = "<a href='admin.php?page=project-dataset_".$item->project_id."&edit=".$item->id."&project_id=".$item->project_id."'>%s</a>";
							} else {
								$url = get_permalink();
								$url = add_query_arg('show_'.$this->project_id, $item->id, $url);
								$url = $project->isCategory() ? add_query_arg('cat_id_'.$this->project_id, $project->getCatID(), $url) : $url;
								$url_pattern = "<a href='".$url."'>%s</a>";
							}
							$item = sprintf($url_pattern, $item->name);
						}
						if ( $item != "" )
							$list .= "<li>".$item."</li>";
					}
					$list .= "</ul>";
					$meta_value = $list;
				}
			
				// get formfield options
				$formfield_options = explode(";", $meta->formfield_options);
			
				$pattern = is_admin() ? "<span id='datafield".$meta->form_field_id."_".$this->id."'>%s</span>" : "%s";
				if ( in_array($meta->type, array('text', 'select', 'checkbox', 'radio', 'project')) ) {
					if (is_array($meta_value)) $meta_value = '';
					$meta_value = sprintf($pattern, $meta_value);
				} elseif ( in_array($meta->type, array('textfield', 'tinymce')) ) {
					if (!$show_all) {
						$meta_value = $this->textExcerpt($meta_value, $formfield_options, "");
						if (!is_admin()) {
							$meta_value = nl2br($meta_value . " <a href='".esc_url(get_permalink())."?show_".$this->project_id."=".$this->id."&amp;order_".$this->project_id."=".$project->getDatasetOrder()."&amp;orderby_".$this->project_id."=".$project->getDatasetOrderBy()."'>[".__('More...', 'projectmanager')."]</a>");
						}
					}
					
					$meta_value = sprintf($pattern, $meta_value);
				} elseif ( 'email' == $meta->type && !empty($meta_value) && !is_array($meta_value) ) {
					if ( is_admin() || $project->scramble_email == 0 ) {
						$meta_value = "<a href='mailto:".$this->extractURL($meta_value, 'url')."' class='projectmanager_email'>".$this->extractURL($meta_value, 'title')."</a>";
					} else {
						$meta_value = preg_replace("/^(.+)@(.+)\\.(.+)$/", "$1 [at] $2 [dot] $3", $meta_value);
					}
					
					$meta_value = sprintf($pattern, $meta_value);
				} elseif ( 'date' == $meta->type && !is_array($meta_value) ) {
					$meta_value = ( $meta_value == '0000-00-00' ) ? '' : $meta_value;
					$meta_value = ( $meta_value != '') ? mysql2date(get_option('date_format'), $meta_value, true ) : $meta_value;
					$meta_value = sprintf($pattern, $meta_value);
				} elseif ( 'time' == $meta->type && !is_array($meta_value) ) {
					$meta_value = mysql2date(get_option('time_format'), $meta_value);
					$meta_value = sprintf($pattern, $meta_value);
				} elseif ( 'country' == $meta->type && !is_array($meta_value) ) {
					$map = new PM_Map($this->project_id);
					$meta_value = $map->getCountryName($meta_value);
				} elseif ( 'uri' == $meta->type && !empty($meta_value) && !is_array($meta_value) ) {
					$meta_value = "<a class='projectmanager_url' href='".esc_url($this->extractURL($meta_value, 'url'))."' target='_blank' title='".$this->extractURL($meta_value, 'title')."'>".$this->extractURL($meta_value, 'title')."</a>";
					$meta_value = sprintf($pattern, $meta_value);
				} elseif( in_array($meta->type, array('image', 'dataset-image', 'header-image')) ) {
					// Current Image is dataset Image - Exchange with default image if empty
					if ( $this->has['image'] == $meta->form_field_id ) {
						if ( $meta_value == '' )
							$meta_value = $project->default_image;
						
						// Simply hide dataset image by making its value empty
						if ( !$show_dataset_image )
							$meta_value = "";
					}
					
					// revert to full size image if desired size is not found
					if ( !empty($meta_value) && !file_exists($this->getImagePath($meta_value, $imagesize)) ) {
						$imagesize = 'full';
					}
					if ( !empty($meta_value) && file_exists($this->getImagePath($meta_value, $imagesize)) ) {
						$img_dims = getimagesize($this->getImagePath($meta_value, $imagesize));
						$meta_value = "<a class='thickbox' href='".$this->getImageURL($meta_value)."' target='_blank'><img class='projectmanager_image' src='".$this->getImageURL($meta_value, $imagesize)."' style='max-width: ".$img_dims[0]."px;' alt='".$meta_value."' title='".$meta_value."' /></a>";
						$meta_value = sprintf($pattern, $meta_value);
					}
				} elseif ( in_array($meta->type, array('file', 'video')) && !empty($meta_value) && !is_array($meta_value) ) {
					$meta_value = "<img id='fileimage".$meta->form_field_id."_".$this->id."' src='".$this->getFileImage($meta_value)."' alt='' class='file-icon' />&#160;" . sprintf($pattern, "<a class='projectmanager_file ".$this->getFileExtension($meta_value)."' href='".$this->getFileURL($meta_value)."' target='_blank'>".$meta_value."</a>");
				} elseif ( 'numeric' == $meta->type && !empty($meta_value) && !is_array($meta_value) ) {
					$meta_value = sprintf($pattern, $meta_value);
				} elseif ( 'currency' == $meta->type && !empty($meta_value) && !is_array($meta_value) ) {
					if (function_exists("money_format"))
						$meta_value = money_format('%i', $meta_value);
					
					$meta_value = sprintf($pattern, $meta_value);
				} elseif ( 'wp_user' == $meta->type && !empty($meta_value) && !is_array($meta_value) ) {
					$userdata = get_userdata($meta_value);
					$meta_value = $userdata->display_name;
					$meta_value = sprintf($pattern, $meta_value);
				}
				
				if ( $meta->form_field_id == $this->has['name'] )
					$meta_value = $this->nameURL;
				
				$classes[] = $meta->type;
				$classes[] = "column-".$meta->type;
				$classes[] = sanitize_title($meta->label);
				
				// use first column as primary
				if ( !$hasPrimary ) {
					$classes[] = "column-primary";
					$hasPrimary = true;
				}
				
				// Generate the output - Exclude paragraph and title field types
				if ( $custom ) $meta->type = $custom; // restore original meta data for Thickbox
				if ( is_admin() && $output == "td" ) {
					if (empty($meta_value))
						$meta_value = sprintf($pattern, '');

					$out .= "\n\t<td class='".implode(" ", $classes)."' data-colname='".$meta->label."'>";
					$out .= "\n\t\t".$meta_value;
					
					// mobile actions
					if ( in_array('column-primary', $classes) ) {
						$out .= "<div class='row-actions'>";
						$page_url = ($_GET['page'] == 'projectmanager') ? 'projectmanager&subpage=dataset' : 'project-dataset_'.$project->id;
						if ( $project->no_edit == 0 && (( current_user_can('edit_datasets') && $current_user->ID == $this->user_id ) || ( current_user_can('edit_other_datasets') ) )) {
							$out .= '<span class="edit edit-dataset"><a href="admin.php?page='.$page_url.'&amp;edit='.$this->id.'&amp;project_id='.$project->id.'">'.__('Edit', 'projectmanager').'</a> | </span>';
						}
						$out .= '<span class="view-dataset"><a href="admin.php?page='.$page_url.'&amp;view='.$this->id.'&amp;project_id='.$project->id.'">'.__('View', 'projectmanager').'</a></span>';
						
						if ( current_user_can('view_pdf') ) {
							$page_url = ($_GET['page'] == 'projectmanager') ? 'projectmanager&subpage=show-project' : 'project_'.$project->id;
							$out .= ' | <span class="dataset-pdf"><a href="admin.php?page='.$page_url.'&amp;projectmanager_pdf='.$this->id.'&amp;project_id='.$project->id.'">'.__('PDF', 'projectmanager').'</a></span>';
						}
						
						if ( current_user_can( 'edit_projects_settings' ) && $project->email_confirmation != 0 && $project->email_confirmation_sender != "" && $project->email_confirmation_text != "" ) {
							$page_url = ($_GET['page'] == 'projectmanager') ? 'projectmanager' : 'project_'.$project->id;
							$out .= '<span> | <a href="admin.php?page='.$page_url.'&amp;sendconfirmation='.$this->id.'&amp;project_id='.$project->id.'">'.__('Send E-Mail Confirmation', 'projectmanager').'</a></span>';
						}
						$out .= "</div>";
						$out .= "<button class='toggle-row' type='button'></button>";
					}
					$out .= "\n\t</td>";
				} else {
					// Don't show 'private' formfields in frontend
					if ( 'dl' == $output && !empty($meta_value) ) {
						$out .= "\n\t<dt class='".implode(" ", $classes)."'>".$meta->label."</dt><dd class='".implode(" ", $classes)."'>".$meta_value."</dd>";
					} elseif ( 'li' == $output && !empty($meta_value) ) {
						$out .= "\n\t<li class='".implode(" ", $classes)."'><span class='dataset_label'>".$meta->label."</span>:&#160;".$meta_value."</li>";
					} elseif ( 'td' == $output ) {
						$out .= "\n\t<td class='".implode(" ", $classes)."'>".$meta_value."</td>";
					} elseif ( !empty($meta_value) ) {
						if ( !empty($output) ) $out .= "<$output class='".implode(" ", $classes)."'>";
						$out .= $meta_value;
							
						if ( !empty($output) ) $out .= "</$output>";
					}
				}
			}
		}
		echo $out;
	}
	
	
	/**
	 * trim text to specific number of words
	 *
	 * @param string $text
	 * @param string $formfield_options
	 * @param string $more
	 * @param int $default_length
	 * @return string
	 */
	public function textExcerpt($text, $formfield_options, $more = "[...]", $default_length = 50) {
		$text = stripslashes(strip_tags(strip_shortcodes($text)));
		
		$match = array_values(preg_grep("/limit:/", $formfield_options));
		if (count($match) == 1) {
			$length = explode(":", $match[0]);
			$length = $length[1];
		} else {
			$length = $default_length;
		}
			
		$words = explode(' ', $text, $length + 1);

		if(count($words) > $length) {
			array_pop($words);
			if (!empty($more)) array_push($words, $more);
			$text = implode(' ', $words);
		}
		
		
		return $text;
	}
	
	
	/**
	 * Extract url or title from website field
	 * 
	 * @param string $url
	 * @param string $index
	 * @return string
	 */
	private function extractURL($url, $index) {
		if ( strstr($url,'|') ) {
			$pos = strpos($url,'|');
			$uri = substr($url,0,$pos);
			$title = substr($url, $pos+1, strlen($url)-$pos);
		} else {
			$uri = $title = $url;
		}
		$data = array( 'url' => $uri, 'title' => $title );
		return $data[$index];
	}
	
	
	/**
	 * get dataset activation key
	 *
	 * @return string
	 */
	public function getActivationKey() {
		return $this->activationkey;
	}
}

/**
 * get Dataset object
 *
 * @param int|Dataset|null Dataset ID or dataset object. Defaults to global $dataset
 * @return Dataset|null
 */
function get_dataset( $dataset = null ) {
	if ( empty( $dataset ) && isset( $GLOBALS['dataset'] ) )
		$dataset = $GLOBALS['dataset'];

	if ( $dataset instanceof Dataset ) {
		$_dataset = $dataset;
	} elseif ( is_object( $dataset ) ) {
		$_dataset = new Dataset( $dataset );
	} else {
		$_dataset = Dataset::get_instance( $dataset );
	}

	if ( ! $_dataset )
		return null;

	return $_dataset;
}
?>