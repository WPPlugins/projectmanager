<div id="testimonials-intro">

	<?php if ( have_datasets() ) : ?>
		<div class='testimonials-intro dataset-gallery'><div class="cols">
			<?php while ( have_datasets() ) : the_dataset(); ?>
			<div class='pm-gallery-item <?php the_dataset_class(); ?>' style='width: <?php the_dataset_width(); ?>%;'>
				<div class="testimonial">
					<blockquote class='comment'>&ldquo;<?php the_dataset_comment(); ?>&rdquo;</blockquote>
					<div class='supporter'>					
						<?php if ( dataset_has_image() ) : ?>
						<a href="<?php the_dataset_url(); ?>"><img src="<?php the_dataset_image_url( 'tiny' ); ?>" alt="<?php the_dataset_name(); ?>" title="<?php the_dataset_name(); ?>" /></a>
						<?php endif; ?>
								
						<p class="cite <?php if ( project_has_images() ) echo "image"; ?>"><span class="name"><?php the_dataset_name(); ?></span><span class="location"><?php the_dataset_city(); ?>, <?php the_dataset_country(); ?></span></p>
					</div>
				</div>
			</div>
			
			<?php project_close_cols() ?>
		
			<?php endwhile; ?>

			<p class="num-supporters">
				<?php printf(__("<span class='num'>%d</span> Supporters from <span class='num'>%d</span> Countries Already.", 'projectmanager'), get_num_total_datasets(), get_num_countries() ); ?>
				<?php if ($project->sign_petition_href != "") : ?>
				<span class="testimonials-join"><a href="<?php echo $project->sign_petition_href ?>"> <?php _e('Become part of our cause.', 'projectmanager') ?></a></span>
				<?php endif; ?>
				<?php if ($project->list_page_href != "") : ?>
				<span class="testimonials-list"><a href="<?php echo $project->list_page_href ?>"> <?php _e('List of supporters.', 'projectmanager') ?></a></span>
				<?php endif; ?>
			</p>
		
		</div>
	<?php endif; ?>

</div>