<div class="dataset">

<?php if ( is_selected_dataset() ) : ?>
<p class="hide-print"><a href='<?php the_dataset_project_url() ?>'><?php _e('Back to list', 'projectmanager') ?></a></p>
<?php endif; ?>

<?php if ( has_dataset() ) : ?>

<div class='dataset-container'>
	<h3><?php printf(__( '%s', 'projectmanager' ), get_dataset_name()) ?></h3>
	<div class="dataset-content">
		<?php the_dataset_title_image() ?>
		
		<?php if ( dataset_has_image() ) : ?>
		<div class='dataset-main-image'><a class="thickbox" href="<?php the_dataset_image_url( 'full' ); ?>" title="<?php the_dataset_name(); ?>" target="_blank"><?php the_dataset_image( 'medium', 'alignright' ) ?></a></div>
		<?php endif; ?>
		
		<dl><?php the_dataset_metadata( array( 'show_all' => true, 'show_dataset_image' => false, 'show_header_image' => false, 'show_dataset_name' => false ) ); ?></dl>
	</div>
</div>

<?php if ( dataset_has_navigation() ) : ?>
<nav id="dataset-navigation" class="navigation dataset-navigation hide-print">
	<div class="nav">
		<?php if ( has_prev_dataset() ) : ?>
		<p class="prev-dataset"><a href="<?php the_prev_dataset_url(); ?>" title="<?php _e('Previous dataset', 'projectmanager') ?>"><?php _e('Previous dataset', 'projectmanager') ?></a></p>
		<?php endif; ?>
		<?php if ( has_next_dataset() ) : ?>
		<p class="next-dataset"><a href="<?php the_next_dataset_url() ?>" title="<?php _e('Next dataset', 'projectmanager') ?>"><?php _e('Next dataset', 'projectmanager') ?></a></p>
		<?php endif; ?>
	</div>
</nav>
<?php endif; ?>

<?php endif; ?>

</div>