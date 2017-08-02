<?php if ($is_profile_page) : ?>
<script type="text/javascript">
document.forms[0].encoding = "multipart/form-data";
</script>
<?php endif; ?>

<table class="form-table">

<?php if ( $form_fields = $project->getFormFields() ) : ?>
	<?php foreach ( $form_fields AS $form_field ) : $dat = isset($meta_data[$form_field->id]) ? $meta_data[$form_field->id] : ''; ?>
	<?php $field_name = ( $is_profile_page ) ? "form_field[".$dataset->id."][".$form_field->id."]" : "form_field[".$form_field->id."]";

		$colspan = ( $form_field->type == 'paragraph' || $form_field->label_type == 'paragraph' ) ? 2 : 1;
		
		$show_field = true;
		// Don't show signature formfield
		if ( $form_field->type == "signature" ) $show_field = false;
		// Don't show formfields in profile if profile option is deactivated
		if ( $is_profile_page && $form_field->show_in_profile == 0 ) $show_field = false; ?>

	<?php if ( $show_field ) : ?>
		<tr valign="top">
			<th scope="row" colspan="<?php echo $colspan ?>" class="input-<?php echo $form_field->type ?> label-<?php echo $form_field->label_type ?>"><?php include('dataset-form-label.php'); ?></th>
			<?php if ( $form_field->type != 'paragraph' ) : ?>
			<?php if ( $colspan == 2 ) : ?></tr><tr valign="top"><?php endif; ?>
			<td colspan="<?php echo $colspan ?>" class="input-<?php echo $form_field->type ?> label-<?php echo $form_field->label_type ?>"><?php include('dataset-form-field.php'); ?></td>
			<?php endif; ?>
		</tr>
	<?php else : ?>
		<input type="hidden" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>_id" value="<?php echo $dat ?>"  />
	<?php endif; ?>
		
	<?php endforeach; ?>
<?php endif; ?>

	<tr valign="top">
		<th scope="row" class="input-sticky"><label for="sticky"><?php _e( 'Sticky', 'projectmanager' ) ?></label></th>
		<td class="input-sticky"><input type="checkbox" value="1" name="sticky" id="sticky"<?php checked($dataset->sticky, 1) ?> /><p class="tagline-description description"><?php _e('Set this option to show dataset on top of list', 'projectmanager') ?></p></td>
	</tr>

<?php if (!$is_profile_page) : ?>
	<?php if ( $project->hasCategories() && current_user_can('edit_other_datasets') ) : ?>
	<!-- category selection form -->
	<tr valign="top">
		<th scope="row" class="input-catgories"><label for="category"><?php _e( 'Categories', 'projectmanager' ) ?></label></th>
		<td class="input-catgories">
			<?php if ( $project->category_selections == 'multiple' ) : ?>
			<?php $this->categoryChecklist( $dataset->cat_ids ); ?>
			<?php elseif ( $project->category_selections == 'single' ) : ?>
			<?php $this->categoryDropdown( $dataset->cat_ids ); ?>
			<?php endif; ?>
		</td>
	</tr>
	<?php else : ?>
		<?php if (count($dataset->cat_ids) > 0) : ?>
			<?php foreach ($dataset->cat_ids AS $cat_id) : ?>
			<input type="hidden" name="category[]" id="category_<?php echo $dataset->id ?>" value="<?php echo $cat_id ?>" />
			<?php endforeach; ?>
		<?php else :?>
			<input type="hidden" name="category[]" id="category_<?php echo $dataset->id ?>" value="" />
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( $project->profile_hook == 1 && current_user_can('edit_other_datasets') ) : ?>
	<tr valign="top">
		<th scope="row" class="input-user"><label for="user_id"><?php _e( 'Owner', 'projectmanager' ) ?></label></th>
		<td class="input-user"><?php wp_dropdown_users( array('selected' => isset($dataset->user_id) ? $dataset->user_id : 0, 'name' => 'user_id', 'show_option_none' => __('Nobody', 'projectmanager')) ) ?></td>
	</tr>
	<?php else : ?>
	<input type="hidden" name="user_id" id="user_id"  value="<?php if (isset($dataset->user_id)) echo $dataset->user_id ?>" />
	<?php endif; ?>
<?php else : ?>
	<?php if (count($dataset->cat_ids) > 0) : ?>
		<?php foreach ($dataset->cat_ids AS $cat_id) : ?>
		<input type="hidden" name="category[<?php echo $dataset->id ?>][]" id="category_<?php echo $dataset->id ?>" value="<?php echo $cat_id ?>" />
		<?php endforeach; ?>
	<?php else :?>
		<input type="hidden" name="category[<?php echo $dataset->id ?>][]" id="category_<?php echo $dataset->id ?>" value="" />
	<?php endif; ?>
		
	<input type="hidden" name="user_id" id="user_id"  value="<?php echo $dataset->user_id ?>" />
<?php endif; ?>

</table>