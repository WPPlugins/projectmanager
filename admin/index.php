<div class="wrap">
	<h1><?php _e( 'Projectmanager', 'projectmanager' ) ?></h1>
	
	<div id="col-container" class="clear wp-clearfix">
		<div id="col-left">
		<div class="col-wrap">
			<!-- Add New Project -->
			<div class="form-wrap">
			<form action="" method="post">
				<input type="hidden" name="updateProjectManager" value="project" />
				<?php wp_nonce_field( 'projectmanager_manage-projects' ) ?>
				
				<h2><?php _e( 'Add Project', 'projectmanager' ) ?></h2>
				<div class="form-field form-required">
					<label for="project_title"><?php _e( 'Title', 'projectmanager' ) ?></label>
					<input type="text" name="project_title" id="project_title" value="" />
				</div>
				
				<p class="submit"><input type="submit" value="<?php _e( 'Add Project', 'projectmanager' ) ?>" class="button button-primary" /></p>
			</form>
			</div>
		</div>
		</div><!-- / col-left -->
		
		<div id="col-right">
		<div class="col-wrap">
			<form id="projects-filter" method="post" action="">
			<?php wp_nonce_field( 'projectmanager_projects-bulk' ) ?>
			
			<div class="tablenav top">
				<div class="alignleft actions bulkactions">
					<!-- Bulk Actions -->
					<select name="action" size="1">
						<option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
						<option value="delete"><?php _e('Delete')?></option>
					</select>
					<input type="submit" value="<?php _e('Apply'); ?>" name="doaction" id="doaction" class="button-secondary action" />
				</div>
			</div>
			
			<table class="wp-list-table widefat projectmanager" summary="<?php _e( 'List of Projects', 'projectmanager' ) ?>" title="<?php _e( 'Projectmanager', 'projectmanager' ) ?>">
			<thead>
				<tr>
					<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
					<!--<th scope="col" class="manage-column"><?php _e('ID', 'projectmanager') ?></th>-->
					<th scope="col" class="manage-column column-title column-primary"><?php _e( 'Project', 'projectmanager' ) ?></th>
					<th scope="col" class="manage-column column-num-datasets column-num"><?php _e( 'Datasets', 'projectmanager' ) ?></th>
					<!--<th scope="col" class="manage-column column-actions"><?php _e( 'Action', 'projectmanager' ) ?></th>-->
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
					<!--<th scope="col" class="manage-column"><?php _e('ID', 'projectmanager') ?></th>-->
					<th scope="col" class="manage-column column-title column-primary"><?php _e( 'Project', 'projectmanager' ) ?></th>
					<th scope="col" class="manage-column column-num-datasets column-num"><?php _e( 'Datasets', 'projectmanager' ) ?></th>
					<!--<th scope="col" class="manage-column column-actions"><?php _e( 'Action', 'projectmanager' ) ?></th>-->
				</tr>
			</tfoot>
			<tbody id="the-list">
				<?php $this->displayProjectIndex(); ?>
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
			</div>
			
			</form>
		</div>
		</div><!-- /col-right -->
	</div>
</div>