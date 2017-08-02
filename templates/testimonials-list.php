<?php the_project_title( "<h3>", "</h3>" ); ?>

<?php if ( is_dataset() ) : ?>
 	<?php the_single_dataset(); ?>
<?php else: ?>

<?php the_project_selections(); ?>
<?php the_project_searchform(); ?>

<div class="testimonials">

<?php if ( have_datasets() ) : ?>
	<ol class="testimonials-list">
	<?php while ( have_datasets() ) : the_dataset(); ?>
		<li class="<?php the_dataset_class(); ?>">
			<div class="testimonial">
				<?php the_dataset_image('tiny', 'left'); ?>
				
				<p class='comment'>&ldquo;<?php the_dataset_comment(); ?>&rdquo;</p>
				<p class='cite'><?php the_dataset_name(); ?> - <?php the_dataset_city(); ?>, <?php the_dataset_country(); ?></p>
			</div>
		</li>
	<?php endwhile; ?>
	</ol>
	
	<?php the_project_pagination(); ?>
<?php else : ?>
<p class='error'><?php _e( 'Nothing found', 'projectmanager') ?></p>
<?php endif; ?>

</div>
<?php endif; ?>