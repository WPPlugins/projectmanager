<?php the_project_title( "<h3>", "</h3>" ); ?>

<?php if ( is_dataset()) : ?>
	<?php the_single_dataset(); ?>
<?php else: ?>

<?php the_project_selections(); ?>
<?php the_project_searchform(); ?>

<?php if ( have_datasets() ) : ?>

<div class='projectmanager-list'>
<?php while ( have_datasets() ) : the_dataset(); ?>
	<?php if ( dataset_has_image() ) : ?><a class="thickbox" href="<?php the_dataset_image_url( 'full' ); ?>" title="<?php the_dataset_name(); ?>"><img src="<?php the_dataset_image_url( 'thumb' ); ?>" class="alignright" title="<?php the_dataset_name() ?>" alt="<?php the_dataset_name(); ?>" /></a><?php endif; ?>
	<dl class="projectmanager <?php the_dataset_class(); ?>">
		<?php the_dataset_metadata( array('show_dataset_image' => false) ); ?>
	</dl>
<?php endwhile; ?>
</div>

<?php the_project_pagination(); ?>

<?php else : ?>
<p class='error'><?php _e( 'Nothing found', 'projectmanager') ?></p>
<?php endif; ?>

<?php endif; ?>