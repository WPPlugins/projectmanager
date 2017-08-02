	<?php if ( in_array($form_field->type, array('paragraph', 'title')) ) : ?>
			
	<?php elseif ( in_array($form_field->type, array('text', 'email', 'uri', 'numeric', 'currency', 'name')) ) : ?>
		<input type="text" placeholder="<?php echo $form_field->placeholder ?>" class="form-input input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>" id="<?php echo sanitize_title($field_name) ?>_id" value="<?php echo $dat ?>" />
	<?php elseif ( 'wp_media' == $form_field->type ) : ?>
		<input type="text" placeholder="<?php echo $form_field->placeholder ?>" class="form-input input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>" id="<?php echo sanitize_title($field_name) ?>_id" value="<?php echo $dat ?>" />

		<div class="wp-media-buttons"><button id="<?php echo sanitize_title($field_name) ?>_button" class="button wp-media-button" name="<?php echo sanitize_title($field_name) ?>_button" type="button" data-editor="<?php echo sanitize_title($field_name) ?>_id"><span class="wp-media-buttons-icon"></span><?php _e( 'Browse Media', 'projectmanager' ) ?></button></div>
	<?php elseif ( 'textfield' == $form_field->type ) : ?>
		<div>
			<textarea placeholder="<?php echo $form_field->placeholder ?>" class="form-input input-<?php echo $form_field->type ?>" <?php if ( 'tinymce' == $form_field->type ) echo 'class="theEditor"' ?> name="<?php echo $field_name ?>" id="<?php echo sanitize_title($field_name) ?>_id" rows="4"><?php echo $dat ?></textarea>
		</div>
	<?php elseif ( 'tinymce' == $form_field->type ) : ?>
		<div class="form-input input-<?php echo $form_field->type ?>">
			<?php wp_editor($dat, "form_field_".$form_field->id."_id", $settings = array("textarea_name" => $field_name)); ?>
		</div>
	<?php elseif ( 'date' == $form_field->type ) : ?>
		<select size="1" class="form-input-date input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>[day]" id="<?php echo sanitize_title($field_name) ?>_id">
			<option value="00"><?php _e( 'Day', 'projectmanager' ) ?></option>
			<option value="00">&#160;</option>
			<?php for ( $day = 1; $day <= 31; $day++ ) : ?>
				<option value="<?php echo str_pad($day, 2, 0, STR_PAD_LEFT) ?>"<?php selected ( $day, intval(substr($dat, 8, 2)) ); ?>><?php echo $day ?></option>
			<?php endfor; ?>
		</select>
		<select size="1" class="form-input-date input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>[month]">
			<option value="00"><?php _e( 'Month', 'projectmanager' ) ?></option>
			<option value="00">&#160;</option>
			<?php foreach ( $this->getMonths() AS $key => $month ) : ?>
				<option value="<?php echo str_pad($key, 2, 0, STR_PAD_LEFT) ?>"<?php selected ( $key, intval(substr($dat, 5, 2)) ); ?>><?php echo $month ?></option>
			<?php endforeach; ?>
		</select>
		<select size="1" class="form-input-date input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>][year]">
			<option value="0000"><?php _e('Year', 'projectmanager') ?></option>
			<option value="0000">&#160;</option>
			<?php for ( $year = 1970; $year <= date('Y')+10; $year++ ) : ?>
				<option value="<?php echo $year ?>"<?php selected ( $year, intval(substr($dat, 0, 4)) ); ?>><?php echo $year ?></option>
			<?php endfor; ?>
		</select>
		<input type="text" name="<?php echo $field_name ?>[date]" id="<?php echo sanitize_title($field_name) ?>_id" value="<?php echo $dat ?>" class="form-input datepicker" />
	<?php elseif ( 'time' == $form_field->type ) : ?>
		<select size="1" class="form-input-time input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>[hour]" id="<?php echo sanitize_title($field_name) ?>_id">
			<?php for ( $hour = 0; $hour <= 23; $hour++ ) : ?>
			<option value="<?php echo str_pad($hour, 2, 0, STR_PAD_LEFT) ?>"<?php selected( $hour, intval(substr($dat, 0, 2)) ) ?>><?php echo str_pad($hour, 2, 0, STR_PAD_LEFT) ?></option>
			<?php endfor; ?>
		</select>
		<select size="1" class="form-input-time input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>[minute]">
			<?php for ( $minute = 0; $minute <= 59; $minute++ ) : ?>
			<option value="<?php  echo str_pad($minute, 2, 0, STR_PAD_LEFT) ?>"<?php selected( $minute, intval(substr($dat, 3, 2)) ) ?>><?php echo str_pad($minute, 2, 0, STR_PAD_LEFT) ?></option>
			<?php endfor; ?>
		</select>
	<?php elseif ( 'country' == $form_field->type ) : ?>
		<select size="1" class="form-input input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>" id="<?php echo sanitize_title($field_name) ?>_id">
			<option value="">&#160;</option>
			<?php foreach ( $project->getCountries() AS $country ) : ?>
			<option value="<?php echo $country->code ?>"<?php selected( $country->code, $dat ) ?>><?php echo $country->name ?></option>
			<?php endforeach; ?>
		</select>
	<?php elseif ( $form_field->type == 'newsletter' ) : ?>
		<ul class="form-input label-<?php echo $form_field->label_type ?> input-radio input-newsletter">
			<?php foreach ( array('yes' => 'Yes', 'no' => 'No') AS $key => $label ) : ?>
			<li>
				<input type="radio" name="<?php echo $field_name ?>[value]" value="<?php echo $key ?>" <?php checked($dat, $key) ?> id="<?php echo sanitize_title($field_name) ?>_id_<?php echo $key ?>">
				<label for="<?php echo $field_name ?>_id_<?php echo $key ?>"><?php _e( $label, 'projectmanager' ) ?></label>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php elseif ( in_array($form_field->type, array('file', 'image', 'video', 'dataset-image', 'header-image')) ) : ?>
		<?php if ( !empty($dat) && in_array($form_field->type, array('image', 'dataset-image', 'header-image', 'video')) ) : ?>
			<?php if( in_array($form_field->type, array('image', 'dataset-image', 'header-image')) ) : ?>
				<img src="<?php echo $project->getImageURL($dat, 'tiny')?>" class="alignright" />
			<?php elseif ( 'video' == $form_field->type ) : ?>
				<embed src="<?php $project->getFileURL($dat) ?>" width="150" class="alignright" />
			<?php endif; ?>
		<?php endif; ?>
		
		<div class="alignleft">
			<input type="file" class="form-input input-<?php echo $form_field->type ?>" name="<?php echo $field_name ?>" id="<?php echo sanitize_title($field_name) ?>_id" size="40" />
			<input type="hidden" name="<?php echo $field_name ?>[current]" value="<?php echo $dat ?>" />
			
			<?php if ( in_array($form_field->type, array('image', 'dataset-image', 'header-image')) ) : ?>
				<p><?php _e( 'Supported file types', 'projectmanager' ) ?>: <?php echo implode( ',',$this->getSupportedImageTypes() ); ?></p>
			<?php endif; ?>
			
			<?php if (!empty($dat)) : ?>
				<p class="file-options">
					<input type="checkbox" name="<?php echo $field_name ?>[del]" value="1" id="delete_file_<?php echo $form_field->id ?>">&#160;<label for="delete_file_<?php echo $form_field->id ?>"><strong><?php _e( 'Delete File', 'projectmanager' ) ?></strong></label>&#160;
					<input type="checkbox" name="<?php echo $field_name ?>[overwrite]" value="1" id="overwrite_file_<?php echo $form_field->id ?>">&#160;<label for="overwrite_file_<?php echo $form_field->id ?>"><strong><?php _e( 'Overwrite File', 'projectmanager' ) ?></strong></label>
				</p>
			<?php endif; ?>
		</div>
	<?php elseif ( 'wp_user' == $form_field->type ) : wp_dropdown_users( array('name' => $field_name, 'selected' => $dat) ); ?>	
	<?php elseif ( 'project' == $form_field->type ) : $this->printDatasetCheckboxList($form_field->options, $field_name, $dat, $form_field->label_type); ?>
	<?php elseif ( 'select' == $form_field->type ) : $project->printFormFieldDropDown($form_field->id, $dat, $dataset->id, $field_name, $form_field->label_type); ?>
	<?php elseif ( 'checkbox' == $form_field->type ) : $project->printFormFieldCheckboxList($form_field->id, $dat, $dataset->id, $field_name, $form_field->label_type); ?>
	<?php elseif ( 'radio' == $form_field->type ) : $project->printFormFieldRadioList($form_field->id, $dat, $dataset->id, $field_name, $form_field->label_type); ?>
	<?php elseif ( !empty($form_field->type) && is_array($project->getFormFieldTypes($form_field->type)) ) : ?>
		<?php $field = $project->getFormFieldTypes($form_field->type); ?>
		<?php if ( isset($field['input_callback']) ) : 
			$args = array ( 'dataset_id' => $dataset->id, 'form_field' => $form_field, 'data' => $dat, 'name' => $field_name, 'field_options' => $form_field->options );
			$field['input_args'] = array_merge( $args, (array)$field['input_args'] );
			call_user_func_array($field['input_callback'], $field['input_args']);
		else : ?>
		<p>
			<input type="hidden" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>_id" value="" />
			<?php echo $field['msg'] ?>
		</p>
		<?php endif; ?>
	<?php endif; ?>