<div class="wrap">
	<h1><?php printf("%s &mdash; %s", $project->title, __( 'Form Fields', 'projectmanager' )) ?></h1>

	<?php $this->printBreadcrumb( __('Form Fields','projectmanager') ) ?>
		
	<form id="formfield-filter" method="post" action="<?php echo $menu_page_url ?>">
	<input type="hidden" name="project_id" value="<?php echo $project->id ?>" />
	<input type="hidden" name="exportkey" value="<?php echo $options['exportkey'] ?>" />
	
	<?php wp_nonce_field( 'projectmanager_manager-formfields' ) ?>
	
	<div class="tablenav top">
		<div class="alignleft actions bulkactions">
			<!-- Bulk Actions -->
			<select name="action" size="1">
				<option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
				<option value="delete"><?php _e('Delete')?></option>
			</select>
			<input type="submit" value="<?php _e('Apply'); ?>" name="doaction" id="doaction" class="button-secondary action" />
			<!--<input type="number" class="small-text" min=1 step=1 name="add_formfields_number" value="1" /><input type="submit" name="addFormField" value="<?php _e( 'Add Form Field', 'projectmanager' ) ?>" class="button-secondary action" />
			<input type="submit" name="downloadFormPDF" value="<?php _e( 'Download Formular as PDF', 'projectmanager') ?>" class="button-secondary action" />-->
		</div>
	</div>
	
	<table class="wp-list-table widefat sortable-table projectmanager formfields-list" id="formfields_table">
	<thead>
	<tr>
		<th scope="col" class="manage-column check-column column-cb"><input type="checkbox" /></th>
		<th scope="col" class="manage-column column-label column-primary"><?php _e( 'Label', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-label-type"><?php _e( 'Label Type', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-type"><?php _e( 'Type', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-options"><?php _e( 'Options', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-parent"><?php _e( 'Parent', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-mandatory"><?php _e( 'Mandatory', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-unique"><?php _e( 'Unique', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-private"><?php _e( 'Private', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-startpage"><?php _e( 'Startpage', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-profile"><?php _e( 'Profile', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-order"><?php _e( 'Order', 'projectmanager' ) ?></th>
		<th scope="sol" class="manage-column column-orderby"><?php _e( 'Order By', 'projectmanager' ) ?></th>
		<th scope="sol" class="manage-column column-width"><?php _e( 'Width', 'projectmanager' ) ?>&nbsp;[%]</th>
		<th scope="sol" class="manage-column column-linebreak"><?php _e( 'Linebreak', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-ID"><?php _e( 'ID', 'projectmanager' ) ?></th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th scope="col" class="manage-column check-column column-cb"><input type="checkbox" /></th>
		<th scope="col" class="manage-column column-label column-primary"><?php _e( 'Label', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-label-type"><?php _e( 'Label Type', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-type"><?php _e( 'Type', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-options"><?php _e( 'Options', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-parent"><?php _e( 'Parent', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-mandatory"><?php _e( 'Mandatory', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-unique"><?php _e( 'Unique', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-private"><?php _e( 'Private', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-startpage"><?php _e( 'Startpage', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-profile"><?php _e( 'Profile', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-order"><?php _e( 'Order', 'projectmanager' ) ?></th>
		<th scope="sol" class="manage-column column-orderby"><?php _e( 'Order By', 'projectmanager' ) ?></th>
		<th scope="sol" class="manage-column column-width"><?php _e( 'Width', 'projectmanager' ) ?>&nbsp;[%]</th>
		<th scope="sol" class="manage-column column-linebreak"><?php _e( 'Linebreak', 'projectmanager' ) ?></th>
		<th scope="col" class="manage-column column-ID"><?php _e( 'ID', 'projectmanager' ) ?></th>
	</tr>
	</tfoot>
	
	<tbody class="the-list form-table">
		<?php $project->printFormFieldList() ?>
	</tbody>
	</table>
	
	<div class="tablenav bottom">
		<div class="alignleft actions bulkactions">
			<!-- Bulk Actions -->
			<select name="action2" size="1">
				<option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
				<option value="delete"><?php _e('Delete')?></option>
			</select>
			<input type="submit" value="<?php _e('Apply'); ?>" name="doaction2" id="doaction2" class="button-secondary action" />
		</div>
		<div class="alignleft actions">
			<input type="number" class="small-text" min=1 step=1 name="add_formfields_number" value="1" /><input type="submit" name="addFormField" value="<?php _e( 'Add Form Field', 'projectmanager' ) ?>" class="button-secondary action" />
			<input type="submit" name="downloadFormPDF" value="<?php _e( 'Download Formular as PDF', 'projectmanager') ?>" class="button-secondary action" />
		</div>
	</div>
	
	<p class="submit"><input type="submit" name="saveFormFields" value="<?php _e( 'Save Form Fields', 'projectmanager' ) ?>" class="button-primary" /></p>
	<input type="hidden" name="js-active" value="0" class="js-active" />
	<!--<p class="submit"><input type="submit" name="saveFormFields" value="<?php _e( 'Save Form Fields', 'projectmanager' ) ?>" class="button-primary" /></p>-->
	</form>
</div> 