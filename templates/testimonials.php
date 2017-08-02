<?php the_project_title( "<h3>", "</h3>" ); ?>

<?php if ( is_dataset() ) : ?>
 	<?php the_single_dataset(); ?>
<?php else: ?>

<?php the_project_selections(); ?>
<?php the_project_searchform(); ?>

<div class="testimonials">

<?php if ( have_datasets() ) : ?>
	<div class='dataset-gallery'><div class="cols">
	<?php while ( have_datasets() ) : the_dataset(); ?>
		<div class='pm-gallery-item <?php the_dataset_class(); ?>' style='width: <?php the_dataset_width(); ?>%;'>
			<div class="testimonial">
				<blockquote class='comment'>&ldquo;<?php the_dataset_comment(); ?>&rdquo;</blockquote>
				<div class='supporter'>					
					<?php the_dataset_image('tiny', 'left'); ?>
							
					<p class="cite <?php if ( project_has_images() ) echo "image"; ?>"><span class="name"><?php the_dataset_name_url() ?></span><span class="location"><?php the_dataset_city(); ?>, <?php the_dataset_country(); ?></span></p>
				</div>
			</div>
		</div>
		
		<?php project_close_cols() ?>
	
	<?php endwhile; ?>
	
	<?php the_project_pagination(); ?>
<?php else : ?>
<p class='error'><?php _e( 'Nothing found', 'projectmanager') ?></p>
<?php endif; ?>

</div>
<?php endif; ?>