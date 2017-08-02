<?php if ( $form_field->type != "signature" ) : ?>
	<?php if ( 'paragraph' == $form_field->type ) : ?>
	<p class="label-<?php echo $form_field->label_type ?> input-<?php echo $form_field->type ?>"><?php echo $form_field->label ?></p>
	<?php elseif ( 'title' == $form_field->type ) : ?>
	<h3 class="label-<?php echo $form_field->label_type ?> input-<?php echo $form_field->type ?>"><?php echo $form_field->label ?></h3>
	<?php else : ?>
	<label class="label-<?php echo $form_field->label_type ?> input-<?php echo $form_field->type ?> <?php if ($form_field->mandatory == 1) echo 'mandatory'; ?>" for="<?php echo $field_name ?>_id"><?php echo $form_field->label ?><?php if ($form_field->mandatory == 1) echo '*'; ?></label>
	<?php endif; ?>
<?php endif; ?>