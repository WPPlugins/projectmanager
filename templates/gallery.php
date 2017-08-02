<?php the_project_title( "<h3>", "</h3>" ); ?>

<?php if ( is_dataset() ) : ?>
 	<?php the_single_dataset(); ?>
<?php else: ?>

<?php the_project_selections(); ?>
<?php the_project_searchform(); ?>

<?php if ( have_datasets() ) : ?>
<div class='dataset-gallery'><div class="cols">
	<?php while ( have_datasets() ) : the_dataset(); ?>
	
	<div class='pm-gallery-item <?php the_dataset_class(); ?>' style='width: <?php the_dataset_width(); ?>%;'>
		<div id="TB_dataset_<?php the_dataset_id() ?>" style="display: none">
		<?php include("dataset.php"); ?>
		</div>
		
		<div class="gallery-image">
			<a href="<?php the_dataset_url() ?>"><?php the_dataset_image( 'thumb' ) ?></a>
			<!--<p class='caption'><?php the_dataset_name_url() ?></p>-->
			<p class='caption'><a href="<?php the_dataset_thickbox_url() ?>" class="thickbox"><?php the_dataset_name() ?></a></p>
		</div>
	</div>
	
	<?php project_close_cols() ?>

	<?php endwhile; ?>

<?php the_project_pagination(); ?>
</div>

<?php else : ?>
<p class='error'><?php _e( 'Nothing found', 'projectmanager') ?></p>
<?php endif; ?>

<?php endif; ?>