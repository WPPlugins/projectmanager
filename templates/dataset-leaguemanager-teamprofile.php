<?php if ( has_dataset() ) : ?>
<div class="dataset">
	<div class='leaguemanager-teamprofile'>
		<div class="dataset-content">
			<?php the_dataset_title_image() ?>
			
			<?php if ( dataset_has_image() ) : ?>
			<div class='dataset-main-image'><a class="thickbox" href="<?php the_dataset_image_url( 'full' ); ?>" title="<?php the_dataset_name(); ?>" target="_blank"><?php the_dataset_image( 'medium', 'alignright' ) ?></a></div>
			<?php endif; ?>
			
			<dl><?php the_dataset_metadata( array( 'show_all' => true, 'show_dataset_image' => false, 'show_header_image' => false, 'show_dataset_name' => false ) ); ?></dl>
		</div>
	</div>
</div>
<?php endif; ?>