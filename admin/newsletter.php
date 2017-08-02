<div class="wrap">

<h1><?php printf( "%s &mdash; %s", $project->title, __("Send Newsletter", 'projectmanager')) ?></h1>

<?php $this->printBreadcrumb( __("Send Newsletter", 'projectmanager') ) ?>

<form class="newsletter" name="newsletter" action="<?php echo $menu_page_url ?>" method="post">
<?php wp_nonce_field( 'projectmanager_newsletter' ) ?>

<table class="form-table newsletter">
	<tr valign="top">
		<th scope="row"><label for="newsletter_from_name"><?php _e( 'From Name', 'projectmanager' ) ?></label></th>
		<td><input type="text" name="newsletter_from_name" id="newsletter_from_name" value="<?php bloginfo('name') ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="newsletter_from_email"><?php _e( 'From E-Mail', 'projectmanager' ) ?></label></th>
		<td><input type="text" name="newsletter_from_email" id="newsletter_from_email" value="<?php echo $project->email_confirmation_sender ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="newsletter_to_field"><?php _e( 'Receiver E-Mail Field', 'projectmanager' ) ?></label></th>
		<td>
			<select size="1" name="newsletter_to_field" id="newsletter_to_field">
				<?php foreach ($project->getData("formfields", "type", "email") AS $formfield) : ?>
				<option value="<?php echo $formfield->id ?>"><?php echo $formfield->label ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="newsletter_subject"><?php _e( 'Subject', 'projectmanager' ) ?></label></th>
		<td><input type="text" name="newsletter_subject" id="newsletter_subject" value="" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="newsletter_message"><?php _e( 'Message', 'projectmanager' ) ?></label></th>
		<td><textarea name="newsletter_message" rows="10" id="newsletter_message" placeholder="<?php _e('Use placeholder [name] to insert the name', 'projectmanager') ?>"></textarea></td>
	</tr>
	<tr valign="top">
		<th scope="row"></th>
		<td><input type="submit" name="sendnewsletter" value="<?php _e("Send Newsletter", 'projectmanager') ?>" class="button-primary" /></td>
	</tr>
</table>

</form>

</div>