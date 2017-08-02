<?php if ( $this->getMessage() != "" ) : ?>
	<div class="projectmanager box <?php echo ( $this->isError() ) ? "error" : "success" ?>">
		<p><strong><?php _e( $this->getMessage(), "projectmanager") ?></strong></p>
		<?php if ( $this->isError() && !isset($_GET['activate']) ) : ?>
			<p><a href="<?php the_permalink(); ?>"><?php _e('Back to Formula', 'projectmanager') ?></a></p>
		<?php else : ?>
			<p><a href="<?php echo get_option('home') ?>"><?php _e('Back to Homepage', 'projectmanager') ?></a></p>
		<?php endif; ?>
	</div>
<?php else : ?>

<div class="projectmanager-container projectmanager-form <?php echo sanitize_title($project->title) ?>">
<form name="datasetform" id="datasetform_<?php echo $project->id ?>" class="datasetform <?php echo $form_class ?>" action="<?php esc_url(the_permalink()) ?>" method="post" enctype="multipart/form-data">
	<?php wp_nonce_field('projectmanager_insert_dataset'); ?>
	<?php if ( $form_fields = $project->getData('formfields') ) : $i = -1; ?>
		<?php foreach ( $form_fields AS $form_field ) : $dat = isset($meta_data[$form_field->id]) ? $meta_data[$form_field->id] : ''; $i++; $field_name = "form_field[".$form_field->id."]"; ?>
		
		<div class="input-container input-<?php echo $form_field->type ?> <?php echo implode(" ", $form_field->classes) ?>" style="width: <?php echo $form_field->width ?>%;">
			<div class="input-content">
				<?php include(PROJECTMANAGER_PATH . '/admin/dataset-form-label.php'); ?>		
				<?php include(PROJECTMANAGER_PATH . '/admin/dataset-form-field.php'); ?>			
			</div><!-- input-content -->
		</div><!-- input-container -->
		
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ( $captcha ) : ?>
	<div class="captcha" id="captcha_<?php echo $project->id ?>">
		<label for="captcha" class="captcha"><?php _e('Code', 'projectmanager') ?>*</label>
		<div class="captcha-code">
			<div id="captcha_image" class="captcha-image">
				<img src="<?php echo $this->getCaptchaURL($captcha) ?>" class="captcha" alt="captcha" />
			</div>
			<input type="text" name="projectmanager_captcha" id="captcha" />
		</div>
		<p class="new-code"><a href="#captcha_<?php echo $project->id ?>" onClick="Projectmanager.exchangeCaptcha('<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php', <?php echo $project->id ?>)"><?php _e( 'Try new code', 'projectmanager' ) ?></a></p>
		<input type="hidden" name="projectmanager_captcha_id" id="projectmanager_captcha_id" value="<?php echo $captcha ?>" />
	</div>
	<?php endif; ?>
	
<input type="hidden" name="project_id" value="<?php the_project_id(); ?>" />
<input type="hidden" name="dataset_id" value="<?php echo $dataset->id ?>" />
<input type="hidden" name="user_id" value="<?php echo $dataset->user_id ?>" />
<?php  ?>
<p class="submit"><label for="submit-button-<?php echo $project->id ?>" class="submit"></label><input type="submit" id="submit-button-<?php the_project_id(); ?>" name="insertDataset" value="<?php _e( 'Submit', 'projectmanager' ) ?>" class="button" /></p>
</form>
</div>
<?php endif; ?>