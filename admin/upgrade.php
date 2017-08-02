<?php
/**
 * projectmanager_upgrade() - update routine for older version
 * 
 * @return Success Message
 */
function projectmanager_upgrade() {
	global $wpdb, $projectmanager;
	
	$options = get_option( 'projectmanager' );
	$installed = $options['dbversion'];

	echo __('Upgrade database structure...', 'projectmanager');
	$wpdb->show_errors();
	
	if (version_compare($options['version'], '1.2.1', '<')) {
		$charset_collate = '';
		if ( $wpdb->supports_collation() ) {
			if ( ! empty($wpdb->charset) )
				$charset_collate = "CONVERT TO CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
		}
		
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projects} $charset_collate" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} $charset_collate" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} $charset_collate" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_datasetmeta} $charset_collate" );
	}
	
	if (version_compare($options['version'], '1.3', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} CHANGE `grp_id` `cat_ids` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL  ");
	}
	
	if (version_compare($options['version'], '1.5', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} ADD `user_id` int( 11 ) NOT NULL default '1'" );
		$role = get_role('administrator');
		$role->remove_cap('manage_projectmanager');
	}
	
	/*
	 * broken in 3.5.2
	 *
	if (version_compare($options['version'], '1.6.2', '<')) {
		$dir_src = WP_CONTENT_DIR.'/projects';
		if ( file_exists($dir_src) ) {
			$dir_handle = opendir($dir_src);
			if ( wp_mkdir_p( $projectmanager->getFilePath() ) ) {
				while( $file = readdir($dir_handle) ) {
					if( $file!="." && $file!=".." ) {
						if ( copy ($dir_src."/".$file, $this->getFilePath()."/".$file) )
							unlink($dir_src."/".$file);
					}
				}
			}
			closedir($dir_handle);
			@rmdir($dir_src);
		}
		
	}
	*/
	
	if (version_compare($options['version'], '1.7', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `order_by` tinyint( 1 ) NOT NULL default '0' AFTER `order`" );
	}
	
	
	if (version_compare($installed, '1.8', '<')) {
		$role = get_role('administrator');
		$role->add_cap('project_user_profile');
		
		$role = get_role('editor');
		$role->add_cap('project_user_profile');
	}
	
	
	if (version_compare($installed, '1.9', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projects} CHANGE `title` `title` varchar( 255 ) NOT NULL default ''" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} CHANGE `name` `name` varchar( 255 ) NOT NULL default '', CHANGE `image` `image` varchar( 50 ) NOT NULL default ''" );
	}
	
	if (version_compare($installed, '2.0', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `show_in_profile` tinyint( 1 ) NOT NULL default '0' AFTER `show_on_startpage`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} ADD `order` int( 11 ) NOT NULL default '0'" );
	}
	
	if (version_compare($installed, '2.1', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} CHANGE `type` `type` varchar( 50 ) NOT NULL" );

		if ( $formfields = $wpdb->get_results("SELECT `type`, `id` FROM {$wpdb->projectmanager_projectmeta}") ) {
			foreach ( $formfields AS $formfield ) {
				if ( $formfield->type == 1 ) $type = 'text';
				elseif ( $formfield->type == 2 ) $type = 'textfield';
				elseif ( $formfield->type == 3 ) $type = 'email';
				elseif ( $formfield->type == 4 ) $type = 'date';
				elseif ( $formfield->type == 5 ) $type = 'uri';
				elseif ( $formfield->type == 6 ) $type = 'select';
				elseif ( $formfield->type == 7 ) $type = 'checkbox';
				elseif ( $formfield->type == 8 ) $type = 'radio';
		
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projectmeta} SET `type` = '%s' WHERE `id` = '%d'", $type, $formfield->id ) );
			}
		}
	}
	
	if (version_compare($installed, '2.2.1', '<')) {
		// Add default values for each database field	
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} CHANGE `type` `type` varchar( 50 ) NOT NULL default ''" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} CHANGE `label` `label` varchar( 100 ) NOT NULL default ''" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} CHANGE `show_on_startpage` `show_on_startpage` tinyint( 1 ) NOT NULL default '0'" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} CHANGE `show_in_profile` `show_in_profile` tinyint( 1 ) NOT NULL default '0'" );
		
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} CHANGE `name` `name` varchar( 255 ) NOT NULL default ''" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} CHANGE `cat_ids` `cat_ids` longtext NOT NULL default ''" );
	}
	

	if (version_compare($installed, '2.4.4', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projects} ADD `settings` LONGTEXT NOT NULL default ''" );
		foreach ( $projectmanager->getProjects() AS $project ) {
			$settings = $options['project_options'][$project->id];
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projects} SET `settings` = '%s' WHERE `id` = '%d'", maybe_serialize($settings), $project->id ) );
		}
		unset($options['project_options']);
	}

	if (version_compare($installed, '2.5', '<')) {
		$role = get_role('administrator');
		$role->remove_cap('projectmanager_admin');
		$role->remove_cap('manage_projects');
		$role->remove_cap('project_user_profile');
		$role = get_role('editor');
		$role->remove_cap('manage_projects');
		$role->remove_cap('project_user_profile');
	}
	
	if (version_compare($installed, '3.0', '<=')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `options` varchar ( 255 ) NOT NULL default ''" );
		foreach ( $wpdb->get_results( "SELECT `id` FROM {$wpdb->projectmanager_projectmeta}" ) AS $form_field) {
			$formfield_options = $options['form_field_options'][$form_field->id];
			if (is_array($formfield_options)) $formfield_options = implode(";", $formfield_options);
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projectmeta} SET `options` = '%s' WHERE `id` = '%d'", $formfield_options, $form_field->id ) );
		}
		unset($options['form_field_options']);
	}
	
	if (version_compare($installed, '3.1', '<=')) {
		$options['dashboard_widget']['num_items'] = 3;
		$options['dashboard_widget']['show_author'] = 1;
		$options['dashboard_widget']['show_date'] = 1;
		$options['dashboard_widget']['show_summary'] = 1;
	}


	if (version_compare($installed, '3.1.2', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `mandatory` tinyint( 1 ) NOT NULL default '0' AFTER `order_by`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `unique` tinyint( 1 ) NOT NULL default '0' AFTER `mandatory`" );
		
		/*
		* create countries table and dump data
		*/
		include_once( ABSPATH.'/wp-admin/includes/upgrade.php' );
		$charset_collate = '';
		if ( $wpdb->supports_collation() ) {
			if ( ! empty($wpdb->charset) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
		}
		$create_countries_sql = "CREATE TABLE {$wpdb->projectmanager_countries} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT,
						`code` varchar( 3 ) NOT NULL default '',
						`name` varchar( 200 ) NOT NULL default '',
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_countries, $create_countries_sql );
		require_once(PROJECTMANAGER_PATH . "/CountriesSQL.php");
	}
	
	if (version_compare($installed, '3.1.3', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `private` tinyint( 1 ) NOT NULL default '0' AFTER `unique`" );
	}
	
	if (version_compare($installed, '3.1.4', '<')) {
		foreach ($projects = $projectmanager->getProjects() AS $project) {
			$project = get_project($project);
			
			// create new project subdirectory
			wp_mkdir_p( $project->getFilePath() );
			
			// move default image
			if ($project->default_image != "" && file_exists($projectmanager->getFilePath($project->default_image))) {
				rename($projectmanager->getFilePath($project->default_image), $project->getFilePath($project->default_image));
				rename($projectmanager->getFilePath("thumb_".$project->default_image), $project->getFilePath("thumb_".$project->default_image));
				rename($projectmanager->getFilePath("tiny_".$project->default_image), $project->getFilePath("tiny_".$project->default_image));
			}
				
			foreach ($datasets = $project->getDatasets(array('limit' => 0)) AS $dataset) {
				foreach ( $data->getData() AS $m ) {
					// move media files to new directory
					if (in_array($m->type, array('file', 'image', 'video'))) {
						if ($m->value != "" && file_exists($projectmanager->getFilePath($m->value))) {
							rename($projectmanager->getFilePath($m->value), $project->getFilePath($m->value));
							if ('image' == $m->type) {
								rename($projectmanager->getFilePath("thumb_".$m->value), $project->getFilePath("thumb_".$m->value));
								rename($projectmanager->getFilePath("tiny_".$m->value), $project->getFilePath("tiny_".$m->value));
							}
						}			
					}
				}
			}
		}
	}
	
	/* 
	* Fix a bug that would duplicate countries when activating/deactivating the plugin
	* Simply delete table and re-add countries
	*/	
	if (version_compare($installed, '3.1.5', '<')) {
		$wpdb->query( "DROP TABLE {$wpdb->projectmanager_countries}" );
		/*
		* create countries table and dump data
		*/
		include_once( ABSPATH.'/wp-admin/includes/upgrade.php' );
		$charset_collate = '';
		if ( $wpdb->supports_collation() ) {
			if ( ! empty($wpdb->charset) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
		}
		$create_countries_sql = "CREATE TABLE {$wpdb->projectmanager_countries} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT,
						`code` varchar( 3 ) NOT NULL default '',
						`name` varchar( 200 ) NOT NULL default '',
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_countries, $create_countries_sql );
		require_once(PROJECTMANAGER_PATH . "/CountriesSQL.php");
	}
	
	if (version_compare($installed, '3.1.6', '<')) {
		// Add locale name field to countries database
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_countries} ADD `name_locale` varchar( 200 ) NOT NULL default '' AFTER `name`" );
	}
	
	if (version_compare($installed, '3.1.7', '<')) {
		// Add locale name field to countries database
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} ADD `sticky` tinyint( 1 ) NOT NULL default '0' AFTER `image`" );
	}
	
	if (version_compare($installed, '3.1.8', '<')) {
		// Add Palestine territory to country list
		if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'PSE'") == 0) {
			$wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name) VALUES ('PSE', '%s')", "Palestine" ));
		}
	}
	
	if (version_compare($installed, '3.1.9', '<')) {
		// Change "State of Palestine" to "Palestine"
		$wpdb->query( "UPDATE {$wpdb->projectmanager_countries} SET `name` = 'Palestine' WHERE `code` = 'PSE'" );
	}
	
	if (version_compare($installed, '3.2', '<')) {
		// add region code, region name and 2-digits code fields to countries database
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_countries} ADD `region_code` varchar( 3 ) NOT NULL default '' AFTER `name_locale`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_countries} ADD `region_name` varchar( 200 ) NOT NULL default '' AFTER `region_code`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_countries} ADD `code2` varchar( 2 ) NOT NULL default '' AFTER `region_name`" );
		require_once(PROJECTMANAGER_PATH . '/CountriesUpgrade.php'); // update database values
	}
	
	if (version_compare($installed, '3.2.1', '<')) {
		// Add Taiwan territory to country list
		if ($wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->projectmanager_countries} WHERE code = 'TWN'") == 0) {
			$wpdb->query( $wpdb->prepare("INSERT INTO {$wpdb->projectmanager_countries} (code, name, region_code, region_name, code2) VALUES ('TWN', '%s', '%s', '%s', '%s')", "Taiwan", "SS", "South Asia", "TW" ));
		}
	}
	
	if (version_compare($installed, '3.2.2', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `label_type` varchar( 50 ) NOT NULL default '' AFTER `show_in_profile`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `newline` tinyint( 1 ) NOT NULL default '1' AFTER `label_type`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `width` int( 3 ) NOT NULL default '100' AFTER `newline`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} CHANGE `label` `label` longtext NOT NULL default ''" );
				
		/*
		 * broken in 3.5.2
		 *
		 //$admin = $projectmanager_loader->getAdminPanel();
		foreach ( $projectmanager->getProjects() AS $project ) {
			$project = get_project($project);
			
			$add_order = (1 == $project->show_image) ? 2 : 1;
			// First increase order of each formfield
			foreach ( $project->getData("formfields") AS $formfield ) {
				$formfield = (array)$formfield;
				$formfield['order'] = $formfield['order'] + $add_order;
				
				$formfield['name'] = $formfield['label'];
				$projectmanager->editFormField($formfield);
			}
			// Add new name field
			$newfield = array( 'name' => __('Name', 'projectmanager'), 'label_type' => 'label', 'type' => 'name', 'order' => 1, 'width' => 100, 'options' => '', 'newline' => 1, 'show_on_startpage' => 1, 'mandatory' => 1 );
			$name_field_id = $projectmanager->addFormField( $project->id, $newfield );
			
			// Maybe add dataset-image field
			if ( 1 == $project->show_image ) {
				$newfield = array( 'name' => __('Dataset Image', 'projectmanager'), 'label_type' => 'label', 'type' => 'dataset-image', 'order' => 2, 'width' => 100, 'options' => '', 'newline' => 1, 'show_on_startpage' => 1, 'mandatory' => 1 );
				$image_field_id = $projectmanager->addFormField( $project->id, $newfield );
			}
			
			// Add dataset name and maybe image to new formfields
			$datasets = $wpdb->get_results( $wpdb->prepare("SELECT `id`, `name`, `image` FROM {$wpdb->projectmanager_dataset} WHERE `project_id` = '%d'", $project->id) );
			foreach ( $datasets AS $dataset ) {
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_datasetmeta} SET `value` = '%s' WHERE `form_id` = '%d' AND `dataset_id` = '%d' ", $dataset->name, $name_field_id, $dataset->id ) );
				
				if ( 1 == $project->show_image ) {
					$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_datasetmeta} SET `value` = '%s' WHERE `form_id` = '%d' AND `dataset_id` = '%d' ", $dataset->image, $image_field_id, $dataset->id ) );
				}
			}
			
			
			// Add new settings
			$settings = (array)$project->getSettings();
			$settings['captcha']['use'] = 0;
			$settings['captcha']['timeout'] = 15;
			$projectmanager->saveSettings($settings, $project->id);
			
			// Add new color options
			$options['colors']['boxheader'] = array( '#eaeaea', '#bcbcbc' );
		}
		*/
	}
	
	if (version_compare($installed, '3.2.3', '<')) {
		$role = get_role('administrator');
		$role->add_cap('edit_categories');
		
		// Add new categories table
		include_once( ABSPATH.'/wp-admin/includes/upgrade.php' );
		$charset_collate = '';
		if ( $wpdb->has_cap('collation') ) {
			if ( ! empty($wpdb->charset) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
		}
		$create_categories_sql = "CREATE TABLE {$wpdb->projectmanager_categories} (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
						`title` varchar( 255 ) NOT NULL default '',
						`project_id` int( 11 ) NOT NULL,
						PRIMARY KEY ( `id` )) $charset_collate";
		maybe_create_table( $wpdb->projectmanager_categories, $create_categories_sql );
		
		/*
		 * broken in 3.5.2
		 *
		//$admin = $projectmanager_loader->getAdminPanel();
		foreach ( $projectmanager->getProjects() AS $project ) {
			$project = get_project($project);
			
			if ( $project->category > 0 ) {
				$categories = get_categories( "child_of=".$project->category."&hierarchical=0&hide_empty=0" );

				$datasets_cat_ids = array();
				$cat_ids = array();		
				foreach ( $categories AS $category ) {
					if ( !in_array($category->term_id, $cat_ids) )
						$cat_ids[] = $category->term_id;
					
					$projectmanager->setCatID($category->term_id);
					$datasets = $projectmanager->getDatasets( array("limit" => false) );
					foreach ( $datasets AS $dataset ) {
						$datasets_cat_ids[$dataset->id] = $dataset->cat_ids;
					}
				}
				
				// Add new categories and save old-to-new category id
				$new_cat_ids = array();
				foreach ( $cat_ids AS $key => $cat_id ) {
					$cat = get_category($cat_id);
					$new_cat_id = $admin->addCategory(stripslashes($cat->name));
					$new_cat_ids[$cat_id] = $new_cat_id;
				}
				
				foreach ( $datasets_cat_ids AS $dataset_id => $dataset_cat_ids ) {
					$new_datasets_cat_ids = array();
					foreach ( $dataset_cat_ids AS $c_id ) {
						$new_datasets_cat_ids[] = $new_cat_ids[$c_id];
					}
					
					$dataset = $projectmanager->getDataset($dataset_id);
					$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_dataset} SET `cat_ids` = '%s' WHERE `id` = '%d'", maybe_serialize($new_datasets_cat_ids), $dataset->id ) );
				}
			}
		}
		*/
	}
	
	if (version_compare($installed, '3.2.4', '<')) {
		// Add locale name field to countries database
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} ADD `status` varchar( 255 ) NOT NULL default '' AFTER `order`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} ADD `activationkey` varchar( 255 ) NOT NULL default '' AFTER `status`" );
		
		// Set status of all existing datasets to "active"
		$datasets = $wpdb->get_results( "SELECT `id` FROM {$wpdb->projectmanager_dataset}" );
		foreach ( $datasets AS $dataset ) {
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_dataset} SET `status` = 'active' WHERE `id` = '%d'", $dataset->id ) );
		}
	}
	
	if (version_compare($installed, '3.2.5', '<')) {
		/*
		 * fix capital extensions
		 */
		$sizes = array( 'tiny', 'thumb', 'medium', 'large' );
		foreach ( $projectmanager->getProjects() AS $project ) {
			$project = get_project($project);
			
			// move default image
			if ($project->default_image != "") {
				$image = $project->default_image;
				foreach ( $sizes AS $size ) {
					$old_file = $project->getFilePath($size . "." . $image);
					$info = pathinfo( $old_file );
					// make sure that file extension is lowercase
					$new_file = str_replace($info['extension'], strtolower($info['extension']), $project->getImagePath($image, $size));
					// rename image file
					@rename($old_file, $new_file);
				}
				
				// rename full size image separately and save new filename in database
				$old_file = $project->getFilePath($image);
				$info = pathinfo( $old_file );
				// make sure that file extension is lowercase
				$new_file = str_replace($info['extension'], strtolower($info['extension']), $old_file);
				// rename image file
				@rename($old_file, $new_file);
				
				$settings = $project->getSettings();
				$settings['default_image'] = basename($new_file);
				$query = $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projects} SET `settings` = '%s' WHERE `id` = '%d'", maybe_serialize($settings), $project->id );
				$wpdb->query( $query );
			}
				
			foreach ($datasets = $project->getDatasets(array("limit" => false)) AS $dataset) {
				// move main image
				if ($dataset->image != "") {
					$image = $dataset->image;
					foreach ( $sizes AS $size ) {
						$old_file = $project->getFilePath($size . "." . $image);
						$info = pathinfo( $old_file );
						// make sure that file extension is lowercase
						$new_file = str_replace($info['extension'], strtolower($info['extension']), $project->getImagePath($image, $size));
						// rename image file
						@rename($old_file, $new_file);
					}
					
					// rename full size image separately and save new filename in database
					$old_file = $project->getFilePath($image);
					$info = pathinfo( $old_file );
					// make sure that file extension is lowercase
					$new_file = str_replace($info['extension'], strtolower($info['extension']), $old_file);
					// rename image file
					@rename($old_file, $new_file);
					
					$query = $wpdb->prepare( "UPDATE {$wpdb->projectmanager_dataset} SET `image` = '%s' WHERE `id` = '%d'", basename($new_file), $dataset->id );
					$wpdb->query( $query );
				}
				
				$meta = $dataset->getData();
				if ( $meta ) {
					foreach ( $meta AS $m ) {
						if ( in_array($m->type, array('file', 'image', 'dataset-image', 'header-image', 'video')) ) {
							if ($m->value != "") {
								$file = $m->value;
								$old_file = $project->getFilePath($file);
								$info = pathinfo( $old_file );
								// make sure that file extension is lowercase
								$new_file = str_replace($info['extension'], strtolower($info['extension']), $old_file);
								
								// rename file
								@rename($old_file, $new_file);
								$query = $wpdb->prepare( "UPDATE {$wpdb->projectmanager_datasetmeta} SET `value` = '%s' WHERE `id` = '%d'", basename($new_file), $m->id );
								$wpdb->query( $query );
								
								if ( in_array($m->type, array('image', 'dataset-image', 'header-image')) ) {
									foreach ( $sizes AS $size ) {
										$old_file = $project->getFilePath($size . "." . $file);
										$info = pathinfo( $old_file );
										// make sure that file extension is lowercase
										$new_file = str_replace($info['extension'], strtolower($info['extension']), $project->getImagePath($file, $size));
										// rename image file
										@rename($old_file, $new_file);
									}
								}
							}		
						}
					}
				}
			}
		}
	}
	
	if (version_compare($installed, '3.2.6', '<')) {
		/*
		* Add Capabilities
		*/
		$role = get_role('administrator');
		if ( $role !== null ) {
			$role->add_cap('add_multiple_datasets');
		}
	}
	
	// set all datasets with user_id = 0 to -1
	if (version_compare($installed, '3.2.7', '<')) {
		$datasets = $wpdb->get_results( "SELECT `id` FROM {$wpdb->projectmanager_dataset} WHERE `user_id` = '0'" );
		foreach ( $datasets AS $dataset ) {
			$wpdb->query($wpdb->prepare("UPDATE {$wpdb->projectmanager_dataset} SET `user_id` = '-1' WHERE `id` = '%d'", $dataset->id));
		}
	}
	
	if (version_compare($installed, '3.2.8', '<')) {
		/*
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projects} CHANGE `id` `ID` int( 11 ) NOT NULL AUTO_INCREMENT" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_categories} CHANGE `id` `ID` int( 11 ) NOT NULL AUTO_INCREMENT" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} CHANGE `id` `ID` int( 11 ) NOT NULL AUTO_INCREMENT" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} CHANGE `id` `ID` int( 11 ) NOT NULL AUTO_INCREMENT" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_datasetmeta} CHANGE `id` `ID` int( 11 ) NOT NULL AUTO_INCREMENT" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_countries} CHANGE `id` `ID` int( 11 ) NOT NULL AUTO_INCREMENT" );
		*/
		
		//$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} CHANGE `cat_ids` `categories` longtext NOT NULL default ''" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} DROP COLUMN `name`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_dataset} DROP COLUMN `image`" );
	}
	
	if (version_compare($installed, '3.2.9', '<')) {
		wp_clear_scheduled_hook( 'projectmanager_update_map_data' );
	}
	
	if (version_compare($installed, '3.3.0', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projects} ADD `parent` int( 1 ) NOT NULL default '0' AFTER `id`" );
	}
	
	if (version_compare($installed, '3.3.1', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projects} CHANGE `parent` `parent_id` int( 11 ) NOT NULL default '0' AFTER `id`" );
	}
	
	if (version_compare($installed, '3.3.2', '<')) {
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projectmeta} ADD `parent_id` int( 11 ) NOT NULL default '0' AFTER `id`" );
		$wpdb->query( "ALTER TABLE {$wpdb->projectmanager_projects} CHANGE `parent_id` `parent_id` int( 11 ) NOT NULL default '0' AFTER `id`" );
	}
	
	if (version_compare($installed, '3.3.4', '<')) {
		foreach ( $projectmanager->getProjects() AS $project ) {
			$project = get_project($project);
			$settings = $project->getSettings();
			
			if ( isset($settings['slideshow']) ) {
				$settings['page_id'] = $settings['slideshow']['page_id'];
				unset($settings['slideshow']['page_id']);
				
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->projectmanager_projects} SET `settings` = '%s' WHERE `id` = '%d'", maybe_serialize($settings), $project->id ) );
			}
		}
	}
	
	if (version_compare($installed, '3.3.5', '<')) {
		$role = get_role('administrator');
		$role->add_cap('project_send_newsletter');
	}
	
	if (version_compare($installed, '3.3.6', '<')) {
		$role = get_role('administrator');
		$role->add_cap('view_pdf');
		$role->add_cap('projectmanager_send_confirmation');
		$role->add_cap('edit_dataset_order');
	}
	
	// Update dbversion
	$options['dbversion'] = PROJECTMANAGER_DBVERSION;
	$options['version'] = PROJECTMANAGER_VERSION;
	
	update_option('projectmanager', $options);
	_e('finished', 'projectmanager') . "<br />\n";
	$wpdb->hide_errors();
	return;
}


/**
* projectmanager_upgrade_page() - This page showsup , when the database version doesn't fit to the script PROJECTMANAGER_DBVERSION constant.
* 
* @return Upgrade Message
*/
function projectmanager_upgrade_page() {
	global $projectmanager;
	$filepath = admin_url() . 'admin.php?page=' . htmlspecialchars($_GET['page']);

	if (isset($_GET['upgrade']) && $_GET['upgrade'] == 'now') {
		projectmanager_do_upgrade($filepath);
		return;
	}
?>
	<div class="wrap">
		<h2><?php _e('Upgrade ProjectManager', 'projectmanager') ;?></h2>
		<p><?php _e('Your database for ProjectManager is out-of-date, and must be upgraded before you can continue.', 'projectmanager'); ?>
		<p><?php _e('The upgrade process may take a while, so please be patient.', 'projectmanager'); ?></p>
		<h3><a class="button" href="<?php echo $filepath;?>&amp;upgrade=now"><?php _e('Start upgrade now', 'projectmanager'); ?>...</a></h3>
	</div>
	<?php
}


/**
 * projectmanager_do_upgrade() - Proceed the upgrade routine
 * 
 * @param mixed $filepath
 * @return void
 */
function projectmanager_do_upgrade($filepath) {
	global $wpdb;
?>
<div class="wrap">
	<h2><?php _e('Upgrade ProjectManager', 'projectmanager') ;?></h2>
	<p><?php projectmanager_upgrade();?></p>
	<p><?php _e('Upgrade successful', 'projectmanager') ;?></p>
	<h3><a class="button" href="<?php echo $filepath;?>"><?php _e('Continue', 'projectmanager'); ?>...</a></h3>
</div>
<?php
}
?>