<script type='text/javascript'>
	jQuery(function() {
		jQuery("#tabs.settings-blocks").tabs({
			active: <?php echo $tab ?>
		});
		
		jQuery(".jquery-ui-accordion").accordion({
			active: <?php echo $tab ?>
		});
	});
</script>

<div class="wrap">
	<h1><?php printf("%s &mdash; %s", $project->title, __( 'Settings', 'projectmanager' )) ?></h1>
	
	<?php $this->printBreadcrumb( __( 'Settings', 'projectmanager' ) ) ?>
	
	<?php if ( isset($_GET['cleanUnusedFiles']) ) : ?>
	<?php $this->cleanUnusedMediaFiles(); ?>
	<?php else : ?>
	
	<form action="<?php echo $menu_page_url ?>" method="post" enctype="multipart/form-data" id="projectmanager-settings">
		<?php wp_nonce_field( 'projectmanager_manage-settings' ) ?>		
		<div class="settings-blocks jquery-ui-accordion clear" id="">	
			<input type="hidden" class="active-tab" name="active-tab" value="<?php echo $tab ?>" ?>
			
			<!--
			<ul class='tablist'>
				<li><a href='#general'><?php _e( 'General', 'projectmanager' ) ?></a></li>
				<li><a href='#images'><?php _e( 'Images', 'projectmanager' ) ?></a></li>
				<li><a href='#datasetform-frontend'><?php _e( 'Frontend Datasetform', 'projectmanager' ) ?></a></li>
				<li><a href='#captcha'><?php _e( 'Captcha Settings', 'projectmanager' ) ?></a></li>
				<li><a href='#slideshow'><?php _e( 'Slideshows', 'projectmanager' ) ?></a></li>
				<li><a href='#map'><?php _e( 'World Map', 'projectmanager' ) ?></a></li>
				<li><a href='#advanced'><?php _e( 'Advanced Settings', 'projectmanager' ) ?></a></li>
			</ul>
			-->
			
			<div id='general' class='tab settings-block-container'>
				<h2><?php _e( 'General', 'projectmanager' ) ?></h2>
				<div class="settings-block content">
					<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="project_title"><?php _e( 'Title', 'projectmanager' ) ?></label></th><td><input type="text" name="project_title" id="project_title" value="<?php echo $project->title ?>" size="30" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="is_private"><?php _e( 'Private', 'projectmanager' ) ?></th><td><input type="checkbox" name="settings[is_private]" id="is_private" value="1" <?php checked( 1, $project->is_private ) ?> />&#160;<p class="tagline-description description"><?php _e( 'Set this option to prevent display of any project data in the frontend', 'projectmanager' ) ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="per_page"><?php _e( 'Datasets per page', 'projectmanager' ) ?></label></th><td><input type="number" step="1" min="0" class="small-text" name="settings[per_page]" id="per_page" size="2" value="<?php echo $project->per_page ?>" /><p class="tagline-description description"><?php _e( 'Set to 0 for no limit', 'projectmanager' ) ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="dataset_orderby"><?php _e( 'Sort Datasets', 'projectmanager' ) ?></label></th>
						<td>
							<select size="1" name="settings[dataset_orderby]" id="dataset_orderby"><?php $this->datasetOrderbyOptions($project->dataset_orderby) ?></select>
							<select size="1" name="settings[dataset_order]" id="dataset_order"><?php $this->datasetOrderOptions($project->dataset_order) ?></select>
						</td>
						
					</tr>
					<tr valign="top">
						<th scope="row"><label for="category_orderby"><?php _e( 'Sort Categories', 'projectmanager' ) ?></label></th>
						<td>
							<select size="1" name="settings[category_orderby]" id="category_orderby"><?php $this->categoryOrderbyOptions($project->category_orderby) ?></select>
							<select size="1" name="settings[category_order]" id="category_order"><?php $this->datasetOrderOptions($project->category_order) ?></select>
						</td>
						
					</tr>
					<tr valign="top">
						<th scope="row"><label for="category_selections"><?php _e( 'Category Selections', 'projectmanager' ) ?></label></th>
						<td>
							<select size="1" name="settings[category_selections]" id="category_selections">
								<option value="multiple" <?php selected($project->category_selections, 'multiple') ?>><?php _e( 'Multiple Selections', 'projectmanager' ) ?></option>
								<option value="single" <?php selected($project->category_selections, 'single') ?>><?php _e( 'Only Single Category', 'projectmanager' ) ?></option>
							</select>
						</td>
						
					</tr>
					<tr valign="top">
						<th scope="row"><label for="navi_link"><?php _e( 'Top-level Menu', 'projectmanager' ) ?></th><td><input type="checkbox" name="settings[navi_link]" id="navi_link" value="1" <?php checked( 1, $project->navi_link ) ?> />&#160;<p class="tagline-description description"><?php _e( 'Set this option to add a direct link in the navigation panel.', 'projectmanager' ) ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="profile_hook"><?php _e( 'Hook into Profile', 'projectmanager' ) ?></th><td><input type="checkbox" name="settings[profile_hook]" id="profile_hook" value="1" <?php checked( 1, $project->profile_hook ) ?> /><p class="tagline-description description"><?php _e( 'Set this option to add first user-owned dataset to profile edit page', 'projectmanager' ) ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="menu_icon"><?php _e( 'Menu Icon', 'projectmanager' ) ?></label></th>
						<td>
							<select size="1" name="settings[menu_icon]" id="menu_icon">
								<?php foreach ( $menu_icons = $this->readFolder( array( PROJECTMANAGER_PATH.'/admin/icons/menu', TEMPLATEPATH . "/projectmanager/icons")) AS $icon ) : ?>
								<option value="<?php echo $icon ?>" <?php if ( $icon == $project->menu_icon ) echo ' selected="selected"' ?>><?php echo $icon ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="gallery_num_cols"><?php _e( 'Number of Columns', 'projectmanager' ) ?></label></th><td><input type="number" step="1" min="0" class="small-text" name="settings[gallery_num_cols]" id="gallery_num_cols" value="<?php echo $project->gallery_num_cols ?>" size="2" /><p class="tagline-description description"><?php _e( 'Needed for multicolumn output, e.g. gallery', 'projectmanager') ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="scramble_email"><?php _e( 'Scramble E-Mail Addresses on Website', 'projectmanager' ) ?></label></th><td><input type="checkbox" name="settings[scramble_email]" id="scramble_email" value="1" <?php checked( 1, $project->scramble_email ) ?> /><p class="tagline-description description"><?php _e( 'Activate this to replace @ and . with [at] and [dot] to secure e-mail addresses on website', 'projectmanager') ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="project_page_id"><?php _e( 'Page', 'projectmanager' ) ?></label></th><td><?php wp_dropdown_pages(array('name' => 'settings[page_id]', 'id' => 'project_page_id', 'selected' => $project->page_id, 'show_option_none' => __('None', 'projectmanager'))); ?><p class="tagline-description description"><?php _e( 'The Project page is used by the slideshow and maybe other plugins to set links', 'projectmanager' ) ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="parent_id"><?php _e( 'Parent Project', 'projectmanager' ) ?></label></th>
						<td>
							<select size="1" name="settings[parent_id]" id="parent_id">
								<option value="0"><?php _e( 'None', 'projectmanager' ) ?></option>
								<?php $this->displayProjectIndex( array('child_of' => -1, 'class' => '', 'level' => 0, 'selected' => $project->parent_id, 'exclude' => array($project->id)), 'select') ; ?>
							</select>
						</td>
					</tr>
					<?php
						/**
						 * Fired in the general settings block
						 *
						 * @category wp-action
						 */
						do_action('projectmanager_settings');
					?>
					<?php
						/**
						 * Fired in the general settings block to add project-specific settings
						 *
						 * @category wp-action
						 */
						do_action('projectmanager_settings_'.$project->id);
					?>
					</table>
				</div>
			</div>
			
			<div id='images' class='settings-block-container'>
				<h2><?php _e( 'Images', 'projectmanager' ) ?></h2>
				<div class="settings-block content">
					<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="default_image"><?php _e( 'Default Image', 'projectmanager' ) ?></label></th>
						<td>
							<input type="file" name="project_default_image" id="default_image" size="45"/>
							<p><?php _e( 'Supported file types', 'projectmanager' ) ?>: <?php echo implode( ',',$this->getSupportedImageTypes() ); ?></p>
							<p><?php _e('Current Image:', 'projectmanager') ?><?php if ($project->default_image != "") : ?> <a href="<?php echo $project->getFileURL($project->default_image) ?>" target="_blank"><?php echo $project->default_image ?></a><span class="del_image"><input type="checkbox" id="del_default_image" name="settings[del_default_image]" value="1" />&#160;<label for="del_default_image"><?php _e( 'Delete', 'projectmanager' ) ?></label></span><?php endif; ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="tiny_size"><?php _e( 'Tiny size', 'projectmanager' ) ?></label></th><td><span class="image-sizes"><label for="tiny_width"><?php _e( 'Max Width' ) ?>&#160;</label><input type="number" step="1" min="0" class="small-text" name="settings[tiny_size][width]" id="tiny_width" value="<?php echo $project->tiny_size['width'] ?>" /></span> <span class="image-sizes"><label for="tiny_height"><?php _e( 'Max Height' ) ?>&#160;</label><input type="number" step="1" min="0" class="small-text" name="settings[tiny_size][height]" id="tiny_height" value="<?php echo $project->tiny_size['height'] ?>" /></span><p><input type="checkbox" value="1" name="settings[crop_image][tiny]" <?php checked( 1, $project->crop_image['tiny'] ) ?> id="crop_image_tiny" /><label for="crop_image_tiny"><?php _e( 'Crop image to exact dimensions', 'projectmanager') ?></label></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="thumb_size"><?php _e( 'Thumbnail size', 'projectmanager' ) ?></label></th><td><span class="image-sizes"><label for="thumb_width"><?php _e( 'Max Width' ) ?>&#160;</label><input type="number" step="1" min="0" class="small-text" name="settings[thumb_size][width]" id="thumb_width" value="<?php echo $project->thumb_size['width'] ?>" /></span> <span class="image-sizes"><label for="thumb_height"><?php _e( 'Max Height' ) ?>&#160;</label><input type="number" step="1" min="0" class="small-text" name="settings[thumb_size][height]" id="thumb_height" value="<?php echo $project->thumb_size['height'] ?>" /></span><p><input type="checkbox" value="1" name="settings[crop_image][thumb]" <?php checked( 1, $project->crop_image['thumb'] ) ?> id="crop_image_thumb" /><label for="crop_image_thumb"><?php _e( 'Crop image to exact dimensions', 'projectmanager') ?></label></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="medium_size"><?php _e( 'Medium size', 'projectmanager' ) ?></label></th><td><span class="image-sizes"><label for="medium_width"><?php _e( 'Max Width' ) ?>&#160;</label><input type="number" step="1" min="0" class="small-text" id="medium_width" name="settings[medium_size][width]" value="<?php echo $project->medium_size['width'] ?>" /></span> <span class="image-sizes"><label for="medium_height"><?php _e( 'Max Height' ) ?>&#160;</label> <input type="number" step="1" min="0" class="small-text" id="medium_height" name="settings[medium_size][height]" value="<?php echo $project->medium_size['height'] ?>" /></span><p><input type="checkbox" value="1" name="settings[crop_image][medium]" <?php checked( 1, $project->crop_image['medium'] ) ?> id="crop_image_medium" /><label for="crop_image_medium"><?php _e( 'Crop image to exact dimensions', 'projectmanager') ?></label></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="large_size"><?php _e( 'Large size', 'projectmanager' ) ?></label></th><td><span class="image-sizes"><label for="large_width"><?php _e( 'Max Width' ) ?>&#160;</label><input type="number" step="1" min="0" class="small-text" id="large_width" name="settings[large_size][width]" value="<?php echo $project->large_size['width'] ?>" /></span> <span class="image-sizes"><label for="large_height"><?php _e( 'Max Height' ) ?>&#160;</label> <input type="number" step="1" min="0" class="small-text" id="large_height" name="settings[large_size][height]" value="<?php echo $project->large_size['height'] ?>" /></span><p><input type="checkbox" value="1" name="settings[crop_image][large]" <?php checked( 1, $project->crop_image['large'] ) ?> id="crop_image_large" /><label for="crop_image_large"><?php _e( 'Crop image to exact dimensions', 'projectmanager') ?></label></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="regenerate_thumbnails"><?php _e( 'Regenerate Thumbnails', 'projectmanager' ) ?></th><td><a href="<?php echo $menu_page_url ?>&amp;regenerate_thumbnails" class="button button-secondary"><?php _e( 'Regenerate Thumbnails Now', 'projectmanager' ) ?></a><p class="tagline-description description"><?php _e( 'This will re-create all thumbnail images of this project. Depending on the number of images it could take some time.', 'projectmanager' ) ?></p></td>
					</tr>
					</table>
				</div>
			</div>
			
			<div id='datasetform-frontend' class='settings-block-container'>
				<h2><?php _e( 'Frontend Datasetform', 'projectmanager' ) ?></h2>
				<div class="settings-block content">
					<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="form_submit_message"><?php _e( 'Submit Message', 'projectmanager' ) ?></label></th>
						<td><input type="text" class="form-input" name="settings[form_submit_message]" id="form_submit_message" value="<?php echo $project->form_submit_message ?>"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="dataset_activation"><?php _e( 'Require dataset activation', 'projectmanager' ) ?></label></th>
						<td>
							<input type="checkbox" id="dataset_activation" name="settings[dataset_activation]" value="1"<?php checked(intval($project->dataset_activation), 1) ?> />
							<p class="tagline-description description"><?php _e( 'Requires sending an email confirmation', 'projectmanager' ) ?></p>
							<p class="tagline-description description"><?php _e( 'Use the tag [CONFIRMATION_LINK] in your confirmation text to insert the confirmation link.', 'projectmanager' ) ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="datasetform_page_id"><?php _e( 'Page', 'projectmanager' ) ?></label></th><td><?php wp_dropdown_pages(array('name' => 'settings[datasetform_page_id]', 'id' => 'datasetform_page_id', 'selected' => $project->datasetform_page_id, 'show_option_none' => __('None', 'projectmanager'))); ?><p class="tagline-description description"><?php _e( 'The page is required for re-sending a onfirmation email from the admin panel', 'projectmanager' ) ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_confirmation"><?php _e( 'Send E-Mail Confirmation', 'projectmanager' ) ?></label></th>
						<td>
							<select size="1" name="settings[email_confirmation]" id="email_confirmation" class="form-input">
								<option value="0"<?php selected($project->email_confirmation, 0) ?>><?php _e( 'Don&rsquo;t send email confirmation', 'projectmanager' ) ?></option>
								<?php foreach ($project->getData("formfields", "type", "email") AS $formfield) : ?>
								<option value="<?php echo $formfield->id ?>"<?php selected($project->email_confirmation, $formfield->id) ?>><?php echo $formfield->label ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_confirmation_sender"><?php _e( 'Sender E-Mail', 'projectmanager' ) ?></label></th>
						<td><input type="text" class="form-input" name="settings[email_confirmation_sender]" id="email_confirmation_sender" value="<?php echo $project->email_confirmation_sender ?>" placeholder="<?php _e( 'This E-Mail will be also used to notify of new datasets', 'projectmanager' ) ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_confirmation_subject"><?php _e( 'E-Mail Confirmation Subject', 'projectmanager' ) ?></label></th>
						<td><input type="text" class="form-input" name="settings[email_confirmation_subject]" id="email_confirmation_subject" value="<?php echo $project->email_confirmation_subject ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_confirmation_text"><?php _e( 'E-Mail Confirmation Text', 'projectmanager' ) ?></label></th>
						<td><textarea name="settings[email_confirmation_text]" class="form-input" rows="10" id="email_confirmation_text" placeholder="<?php _e('Use placeholder [name] to insert the name', 'projectmanager') ?>"><?php echo $project->email_confirmation_text ?></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_confirmation_pdf"><?php _e( 'Attach PDF to Confirmation', 'projectmanager' ) ?></label></th><td><input type="checkbox" id="email_confirmation_pdf" name="settings[email_confirmation_pdf]" value="1"<?php checked(intval($project->email_confirmation_pdf), 1) ?> /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="notify_new_datasets"><?php _e( 'Notify me of new datasets', 'projectmanager' ) ?></label></th><td><input type="checkbox" id="notify_new_datasets" name="settings[notify_new_datasets]" value="1"<?php checked(intval($project->notify_new_datasets), 1) ?> /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_notification_subject"><?php _e( 'E-Mail Notification Subject', 'projectmanager' ) ?></label></th>
						<td><input type="text" class="form-input" name="settings[email_notification_subject]" id="email_notification_subject" value="<?php echo $project->email_notification_subject ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_notification_text"><?php _e( 'E-Mail Notification Text', 'projectmanager' ) ?></label></th>
						<td><textarea name="settings[email_notification_text]" class="form-input" rows="8" id="email_notification_text"><?php echo $project->email_notification_text ?></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_notification_pdf"><?php _e( 'Attach PDF to Notification', 'projectmanager' ) ?></label></th><td><input type="checkbox" id="email_notification_pdf" name="settings[email_notification_pdf]" value="1"<?php checked(intval($project->email_notification_pdf), 1) ?> /></td>
					</tr>
					</table>
				</div>
			</div>
			
			<div id='captcha' class='settings-block-container'>
				<h2><?php _e( 'Captcha Settings', 'projectmanager' ) ?></h2>
				<div class="settings-block content">
					<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="use_captcha"><?php _e( 'Use Captcha', 'projectmanager' ) ?></label></th><td><input type="checkbox" name="settings[captcha][use]" id="use_captcha"<?php if ( isset($project->captcha['use']) && 1 == $project->captcha['use'] ) echo ' checked="checked"' ?> value="1"></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="captcha_timeout"><?php _e( 'Timeout', 'projectmanager' ) ?></label></th>
						<td><input type="number" step="1" min="0" class="small-text" name="settings[captcha][timeout]" id="captcha_timeout" value="<?php echo $project->captcha['timeout'] ?>" />&#160;<?php _e( 'minutes', 'projectmanager') ?></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="captcha_code_length"><?php _e( 'Code Length', 'projectmanager' ) ?></label></th>
						<td><input type="number" step="1" min="0" class="small-text" name="settings[captcha][length]" id="captcha_code_length" value="<?php echo $project->captcha['length'] ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="captcha_letters"><?php _e( 'Code Letters', 'projectmanager' ) ?></label></th>
						<td><textarea class="form-input" rows="2" name="settings[captcha][letters]" id="captcha_letters"><?php echo $project->captcha['letters'] ?></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="captcha_ndots"><?php _e( 'Number of Dots', 'projectmanager' ) ?></label></th>
						<td><input type="number" step="1" min="0" class="small-text"  name="settings[captcha][ndots]" id="captcha_ndots" value="<?php echo $project->captcha['ndots'] ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="captcha_nlines"><?php _e( 'Number of Lines', 'projectmanager' ) ?></label></th>
						<td><input type="number" step="1" min="0" class="small-text" name="settings[captcha][nlines]" id="captcha_nlines" value="<?php echo $project->captcha['nlines'] ?>" /></td>
					</tr>
					</table>
				</div>
			</div>
			
			<div id='slideshow' class='settings-block-container'>
				<h2><?php _e( 'Slideshows', 'projectmanager' ) ?></h2>
				<div class="settings-block content">
					<?php if ( is_plugin_active("sponsors-slideshow-widget/sponsors-slideshow-widget.php") ) : ?>
					<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="slideshow_dataset_orderby"><?php _e( 'Sort Datasets', 'projectmanager' ) ?></label></th>
						<td>
							<select size="1" name="settings[slideshow][dataset_orderby]" id="slideshow_dataset_orderby">
								<?php $this->datasetOrderbyOptions($project->slideshow["dataset_orderby"]) ?>
								<option value="random" <?php selected($project->slideshow['dataset_orderby'], 'random') ?>><?php _e( 'Random', 'projectmanager' ) ?></option>
							</select>
							<select size="1" name="settings[slideshow][dataset_order]" id="slideshow_dataset_order">
								<?php $this->datasetOrderOptions($project->slideshow["dataset_order"]) ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="slideshow_num_datasets"><?php _e( 'Number of datasets', 'projectmanager' ) ?></label></th><td><input type="number" step="1" min="0" class="small-text" name="settings[slideshow][num_datasets]" id="slideshow_num_datasets" size="2" value="<?php echo intval($project->slideshow["num_datasets"]) ?>" /><p class="tagline-description description"><?php _e( 'Set to 0 for no limit', 'projectmanager' ) ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="slideshow_dataset_ids"><?php _e( 'Specific Dataset IDs', 'projectmanager' ) ?></label></th><td><input type="text" name="settings[slideshow][dataset_ids]" size="30" placeholder="<?php _e( 'Separate IDs by comma', 'projectmanager' ) ?>" id="slideshow_dataset_ids" size="2" value="<?php echo $project->slideshow["dataset_ids"] ?>" /></td>
					</tr>
					</table>
					<?php else : ?>
					<p><?php printf(__("You can easily create fancy slideshows of datasets using the <a href='%s' target='_blank'>Fancy Slideshows Plugin</a>. After installing and activating the plugin, come back here for slideshow configuration.", 'projectmanager'), "https://wordpress.org/plugins/sponsors-slideshow-widget/") ?></p>
					<?php endif; ?>
				</div>
			</div>
				
			<div id='map' class='settings-block-container'>
				<h2><?php _e( 'World Map', 'projectmanager' ) ?></h2>
				<div class="settings-block content">
					<?php if ( count($project->getData("formfields", "type", "country")) > 0 ) : ?>
					<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="map_field"><?php _e( 'Formfield', 'projectmanager' ) ?></label></th>
						<td>
						<?php foreach ($project->getData("formfields", "type", "country") AS $field) : ?>
						<select size="1" name="settings[map][field]" id="map_field">
							<option value=""></option>
							<option value="<?php echo $field->id ?>" <?php selected($field->id, $project->map['field'] ); ?>><?php echo $field->label ?></option>
						</select>
						<?php endforeach; ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="map_label"><?php _e( 'Dataset Label', 'projectmanager' ) ?></label></th>
						<td><input type="text" class="form-input" name="settings[map][dataset_label]" id="map_label" value="<?php echo $project->map['dataset_label'] ?>" /></td>
					</tr>
					<?php if ( $project->map['field'] != 0 ) : ?>
					<tr valign="top">
						<th scope="row"><label for="map_update"><?php _e( 'Update Map Data', 'projectmanager' ) ?></label></th>
						<td>
							<!--<input type="checkbox" name="settings[map][update]" id="map_update" value="1" />-->
							<select size="1" name="settings[map][update_schedule]" id="map_update">
								<?php foreach ( $this->getMapUpdateSchedules() AS $key => $schedule ) : ?>
								<option value="<?php echo $key ?>"<?php selected($key, $project->map['update_schedule']) ?>><?php echo $schedule ?></option>
								<?php endforeach; ?>
							</select>
							<p class="map-last-updated"><?php _e( 'Last Updated:', 'projectmanager' ) ?> <?php if ($project->map['data']['last_updated'] != 0) echo date_i18n("j. F Y H:i:s eP", $project->map['data']['last_updated']) ?></p>
							<p class="map-next-update"><?php _e( 'Next scheduled update:', 'projectmanager' ) ?> <?php if ($this->getNextScheduledMapUpdate() != 0) echo date_i18n("j. F Y H:i:s eP", $this->getNextScheduledMapUpdate()); ?></p>
						</td>
					</tr>
					<?php endif; ?>
					</table>
					<p class="maps-info"><?php printf(__( "Powered by the <a href='%s' target='%s' title=Simplemaps'>Free World Continent Map</a> from <a href='%s' target='%s' title='Simplemaps'>simplemaps</a>, based on the <a href='%s' target='%s' title='Interactive-Maps Plugin'>Interactive-Maps Plugin</a>.", 'projectmanager'), 'http://simplemaps.com/resources/free-continent-map', '_blank', 'http://simplemaps.com', '_blank', 'https://wordpress.org/plugins/interactive-maps/', '_blank'); ?></p>
					<?php else : ?>
					<p class="maps-info"><?php printf(__( "If you have at least one country formfield you can display a worldmap denoting the number of datasets by continents powered by the <a href='%s' target='%s' title=Simplemaps'>Free World Continent Map</a> from <a href='%s' target='%s' title='Simplemaps'>simplemaps</a>, based on the <a href='%s' target='%s' title='Interactive-Maps Plugin'>Interactive-Maps Plugin</a>.", 'projectmanager'), 'http://simplemaps.com/resources/free-continent-map', '_blank', 'http://simplemaps.com', '_blank', 'https://wordpress.org/plugins/interactive-maps/', '_blank'); ?></p>
					<?php endif; ?>
				</div>
			</div>
			
			<div id='advanced' class='settings-block-container'>
				<h2><?php _e( 'Advanced Settings', 'projectmanager' ) ?></h2>
				<div class="settings-block content">
					<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="no_edit"><?php _e( 'Disable dataset editing', 'projectmanager' ) ?></label></th><td><input type="checkbox" id="no_edit" name="settings[no_edit]" value="1"<?php checked(intval($project->no_edit), 1) ?> /></td>
					</tr>
					</table>
					
					<p><a href="<?php echo $menu_page_url ?>&amp;cleanUnusedFiles" class="button-secondary"><?php _e( 'List unused media files', 'projectmanager' ) ?></a></p>
				</div>
			</div>
		</div>
		
		<input type="hidden" name="project_id" value="<?php echo $project->id ?>" />
		<p class="submit"><input type="submit" name="saveSettings" value="<?php _e( 'Save Settings', 'projectmanager' ) ?>" class="button-primary" /></p>
	</form>
	
	<?php endif; ?>
</div>