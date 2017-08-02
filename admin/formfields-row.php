<?php if ( $output == 'table' ) : ?>
	<tr id="form_id_<?php echo $form_field->id ?>" class="<?php echo $class ?>">
		<th scope="row" class="check-column column-cb"><input type="checkbox" class="item_id2" value="<?php echo $form_field->id ?>" name="del_formfield[<?php echo $form_field->id ?>]" /></th>
		<td class="column-primary column-label" data-colname="<?php _e( 'Label', 'projectmanager' ) ?>">
			<?php if ( $form_field->label_type == 'paragraph' ) : ?>
			<textarea style="margin-left: <?php echo $margin ?>%; width: <?php echo 100-$margin; ?>%;" class="label" rows="3" name="formfields[<?php echo $form_field->id ?>][name]"><?php echo htmlspecialchars(stripslashes($form_field->label), ENT_QUOTES) ?></textarea>
			<?php else : ?>
			<input style="margin-left: <?php echo $margin ?>%; width: <?php echo 100-$margin; ?>%;" class="label" type="text" name="formfields[<?php echo $form_field->id ?>][name]" value="<?php echo htmlspecialchars(stripslashes($form_field->label), ENT_QUOTES) ?>" />
			<?php endif; ?>
			<button class="toggle-row" type="button"></button>
		</td>
		<td class="column-label-type" data-colname="<?php _e( 'Label Type', 'projectmanager' ) ?>">
			<select name="formfields[<?php echo $form_field->id ?>][label_type]">
			<?php foreach ( $this->getFormFieldLabelTypes() AS $value => $name ) : ?>
				<option value="<?php echo $value ?>"<?php selected($value, $form_field->label_type) ?>><?php echo $name ?></option>
			<?php endforeach; ?>
			</select>
		</td>
		<td class="column-type" data-colname="<?php _e( 'Type', 'projectmanager' ) ?>" id="form_field_options_box<?php echo $form_field->id ?>">
			<select id="form_type_<?php echo $form_field->id ?>" name="formfields[<?php echo $form_field->id ?>][type]" size="1" onChange="Projectmanager.toggleFormfieldOptions('<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php', <?php echo $form_field->id ?>, this.value, '<?php echo $form_field->options ?>', <?php echo $this->id ?>);">
			<?php foreach( $this->getFormFieldTypes() AS $form_type_id => $form_type ) : $field_name = is_array($form_type) ? $form_type['name'] : $form_type ?>
				<option value="<?php echo $form_type_id ?>"<?php selected($form_type_id, $form_field->type); ?>><?php echo $field_name ?></option>
			<?php endforeach; ?>
			</select>
		</td>
		<td class="column-options" data-colname="<?php _e( 'Options', 'projectmanager' ) ?>">
			<div id="formfield-options-<?php echo $form_field->id ?>">
			<?php if ($form_field->options_type == 'project') : ?>
			<select size="1" name="formfields[<?php echo $form_field->id ?>][options]">
				<option value="0"><?php _e( 'Choose Project', 'projectmanager' ) ?></option>
				<?php $projectmanager->displayProjectIndex( array('child_of' => -1, 'class' => '', 'level' => 0, 'selected' => $form_field->options, 'exclude' => array($this->id)), 'select' ); ?>
			</select>
			<?php else : ?>
			<input type="text" name="formfields[<?php echo $form_field->id ?>][options]" class="tooltip" value="<?php echo $form_field->options ?>" title="<?php _e("For details on formfield options see the Documentation", 'projectmanager') ?>" />
			<?php endif; ?>
			</div>
		</td>
		<td class="column-parent" data-colname="<?php _e( 'Parent', 'projectmanager' ) ?>">
			<select size="1" name="formfields[<?php echo $form_field->id ?>][parent_id]">
				<option value="0"><?php _e( 'None', 'projectmanager' ) ?></option>
				<?php $this->printFormFieldList( array('child_of' => -1, 'class' => '', 'level' => 0, 'selected' => $form_field->parent_id, 'exclude' => array($form_field->id)), 'select' ); ?>
			</select>
		</td>
		<td class="column-mandatory" data-colname="<?php _e( 'Mandatory', 'projectmanager' ) ?>"><input type="checkbox" name="formfields[<?php echo $form_field->id ?>][mandatory]"<?php if (in_array($form_field->type, array('title', 'paragraph'))) echo 'disabled="disabled"'; else checked(1, $form_field->mandatory) ?> value="1" /></td>
		<td class="column-unique" data-colname="<?php _e( 'Unique', 'projectmanager' ) ?>"><input type="checkbox" name="formfields[<?php echo $form_field->id ?>][unique]"<?php if (in_array($form_field->type, array('title', 'paragraph'))) echo 'disabled="disabled"'; else checked(1, $form_field->unique) ?> value="1" /></td>
		<td class="column-private" data-colname="<?php _e( 'Private', 'projectmanager' ) ?>"><input type="checkbox" name="formfields[<?php echo $form_field->id ?>][private]"<?php if (in_array($form_field->type, array('title', 'paragraph'))) echo 'disabled="disabled"'; else checked(1, $form_field->private) ?> value="1" /></td>
		<td class="column-startpage" data-colname="<?php _e( 'Startpage', 'projectmanager' ) ?>"><input type="checkbox" name="formfields[<?php echo $form_field->id ?>][show_on_startpage]"<?php if (in_array($form_field->type, array('title', 'paragraph'))) echo 'disabled="disabled"'; else checked(1, $form_field->show_on_startpage) ?> value="1" /></td>
		<td class="column-profile" data-colname="<?php _e( 'Profile', 'projectmanager' ) ?>"><input type="checkbox" name="formfields[<?php echo $form_field->id ?>][show_in_profile]"<?php checked ( 1, $form_field->show_in_profile) ?> value="1" /></td>
		<td class="column-order" data-colname="<?php _e( 'Order', 'projectmanager' ) ?>"><input type="text" size="1" class="sortable-order" name="formfields[<?php echo $form_field->id ?>][order]" value="<?php echo $form_field->order ?>" /></td>
		<td class="column-orderby" data-colname="<?php _e( 'Order By', 'projectmanager' ) ?>"><input type="checkbox" name="formfields[<?php echo $form_field->id ?>][orderby]" value="1"<?php if (in_array($form_field->type, array('title', 'paragraph'))) echo 'disabled="disabled"'; else checked ( 1, $form_field->order_by ) ?> /></td>
		<td class="column-width" data-colname="<?php _e( 'Width', 'projectmanager' ) ?>"><input type="text" size="1" name="formfields[<?php echo $form_field->id ?>][width]" value="<?php echo $form_field->width ?>" /></td>
		<td class="column-linebreak" data-colname="<?php _e( 'Linebreak', 'projectmanager' ) ?>"><input type="checkbox" name="formfields[<?php echo $form_field->id ?>][newline]"<?php checked(1, $form_field->newline) ?> value="1" /></td>
		<td class="column-ID" data-colname="<?php _e( 'ID', 'projectmanager' ) ?>"><?php echo $form_field->id ?><input type="hidden" name="formfields[<?php echo $form_field->id ?>][id]" value="<?php echo $form_field->id ?>" /></td>
	</tr>
<?php elseif ( $output == 'select' ) : ?>
	<?php if ( ! in_array($form_field->id, $args['exclude']) ) : ?>
		<?php if ( $level > 0 ) $form_field->label = str_repeat( "&mdash; ", $level ) . $form_field->label; ?>
		<option value='<?php echo $form_field->id ?>' <?php selected($form_field->id, $args['selected']) ?>><?php echo $form_field->label ?></option>
	<?php endif; ?>
<?php endif; ?>