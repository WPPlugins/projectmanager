<script type='text/javascript'>
	jQuery(function() {
		jQuery("#tabs").tabs({
			active: <?php echo $tab ?>
		});
		
		jQuery(".jquery-ui-accordion").accordion({
			active: <?php echo $tab ?>
		});
	});
</script>
<div class="wrap">
	<h1><?php printf("%s &mdash; %s", $project->title, __( 'Import & Export Data', 'projectmanager' )) ?></h1>

	<?php $this->printBreadcrumb( __('Import/Export', 'projectmanager') ) ?>
	
	<div class="import-container jquery-ui-accordion clear" id="">
		<input type="hidden" class="active-tab" name="active-tab" value="<?php echo $tab ?>" ?>
		
		<!--<ul class="tablist">
			<li><a href='#export'><?php _e( 'Export Data', 'projectmanager' ) ?></a></li>
			<li><a href='#import-media'><?php _e( 'Import Media', 'projectmanager' ) ?></a></li>
			<li><a href='#import-datasets'><?php _e( 'Import Datasets', 'projectmanager' ) ?></a></li>
			<li><a href='#import-project'><?php _e( 'Import Project', 'projectmanager' ) ?></a></li>
		</ul>-->
		
		<div id='export' class='import-block-container'>
			<h2><?php _e( 'Export Data', 'projectmanager' ) ?></h2>
			<div class="import-block">
				<?php if (file_exists($media_filename)) : ?>
				<!--<p><?php printf(__('Your media files are ready to <a href="%s">download</a>. (Last modified: %s)','projectmanager'), $project->getFileURL(basename($media_filename)), date ("F d Y H:i:s.", filemtime($media_filename))); ?></p>-->
				<?php endif; ?>
				
				<form action="" method="post">
					<input type="hidden" name="project_id" value="<?php echo $project->id ?>" />
					<input type="hidden" name="exportkey" value="<?php echo $options['exportkey'] ?>" />
					<?php wp_nonce_field( 'projectmanager_export' ) ?>
					
					<select size="1" name="export_type" id="export_type">
						<option value="data-csv"><?php _e('Datasets (CSV)', 'projectmanager') ?></option>
						<option value="data-pdf"><?php _e('Datasets (PDF)', 'projectmanager') ?></option>
						<option value="project"><?php _e('Project', 'projectmanager') ?></option>
						<option value="media"><?php _e('Media Files', 'projectmanager') ?></option>
					</select>
					<p class="tagline-description description"><?php _e('You can export datasets in tab-delimited format or media files as zip archive', 'projectmanager') ?></p>
					
					<p class="submit"><input type="submit" name="projectmanager_export" value="<?php _e('Export Data', 'projectmanager') ?>" class="button-primary" /></p>
				</form>
			</div>
		</div>

		<div id='import-media' class='import-block-container'>
			<h2><?php _e( 'Import Media', 'projectmanager' ) ?></h2>
			<div class="import-block">
				<form action="" method="post" enctype="multipart/form-data">
					<input type="hidden" class="active-tab" name="active-tab" value="<?php echo $tab ?>" ?>
					<?php wp_nonce_field( 'projectmanager_import-media' ) ?>
					<input type="hidden" name="project_id" value="<?php echo $project->id ?>" />
					<input type="file" name="projectmanager_media_zip" id="projectmanager_media_zip" size="40"/>
					<p class="tagline-description description"><?php _e( 'You can upload media files in zip format to the webserver', 'projectmanager' ) ?></p>
					
					<p class="submit"><input type="submit" name="import_media" value="<?php _e('Upload Media', 'projectmanager') ?>" class="button-primary" /></p>
				</form>
			</div>
		</div>
		
		<div id='import-datasets' class='import-block-container'>
			<h2><?php _e( 'Import Datasets', 'projectmanager' ) ?></h2>
			<div class="import-block">
				<form action="" method="post" enctype="multipart/form-data">
				<?php wp_nonce_field( 'projectmanager_import-datasets' ) ?>
				<input type="hidden" class="active-tab" name="active-tab" value="<?php echo $tab ?>" ?>
				<input type="hidden" name="project_id" value="<?php echo $project->id ?>" />
				
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="projectmanager_import"><?php _e('File','projectmanager') ?></label></th><td><input type="file" name="projectmanager_import" id="projectmanager_import" size="40"/></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="delimiter"><?php _e('Delimiter','projectmanager') ?></label></th><td><input type="text" class="form-input" name="delimiter" id="delimiter" value="TAB" size="3" /><p class="tagline-description description"><?php _e('For tab delimited files use TAB as delimiter', 'projectmanager') ?></p></td>
				</tr>
				</table>
				<h3><?php _e( 'Column Assignment', 'projectmanager' ) ?></h3>
				<p><?php _e('All FormFields need to be assigned, also if some contain no data.', 'projectmanager') ?></p>
				<p><?php _e('Dates must have the format <strong>YYYY-MM-DD</strong>.', 'projectmanager') ?></p>
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php printf(__( 'Column %d', 'projectmanager'), 1 ) ?></th><td><?php _e( 'Categories', 'projectmanager' ) ?> - <?php _e('multiple categories separated by comma', 'projectmanager') ?></td>
				</tr>
				<?php for ( $i = 1; $i <= count($formfields); $i++ ) : ?>
				<tr valign="top">
					<th scope="row"><label for="col_<?php echo $i ?>"><?php printf(__( 'Column %d', 'projectmanager'), ($i+1)) ?></label></th>
					<td>
						<select size="1" name="cols[<?php echo $i ?>]" id="col_<?php echo $i ?>" class="form-input">
							<?php foreach ( $formfields AS $key => $form_field ) : ?>
							<?php if ( !in_array($form_field->type, array('paragraph', 'title', 'signature')) ) : ?>
							<option value="<?php echo $form_field->id ?>"<?php selected($key+1, $i) ?>><?php echo $form_field->label ?></option>
							<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<?php endfor; ?>
				</table>
				
				<p class="submit"><input type="submit" name="import_datasets" value="<?php _e('Import Datasets', 'projectmanager') ?>" class="button-primary" /></p>
				</form>
			</div>
		</div>
		
		<div id='import-project' class='import-block-container'>
			<h2><?php _e( 'Import Database', 'projectmanager' ) ?></h2>
			<div class="import-block">
				<form action="" method="post" enctype="multipart/form-data">
					<input type="hidden" class="active-tab" name="active-tab" value="<?php echo $tab ?>" ?>
					<?php wp_nonce_field( 'projectmanager_import-project' ) ?>
					<input type="hidden" name="project_id" value="<?php echo $project->id ?>" />
					<input type="file" name="projectmanager_project_database" id="projectmanager_project_database" size="40"/>
					<p class="submit"><input type="submit" name="import_project" value="<?php _e('Import Project', 'projectmanager') ?>" class="button-primary" /></p>
				</form>
			</div>
		</div>
	</div>
</div>