<?php the_project_title( "<h3>", "</h3>" ); ?>

<?php if ( is_dataset()) : ?>
	<?php the_single_dataset(); ?>
<?php else: ?>

<?php the_project_selections(); ?>
<?php the_project_searchform(); ?>

<?php if ( have_datasets() ) : ?>

<table class='projectmanager'>
<tr>
	<?php the_project_table_header( array('show_dataset_image' => false) ); ?>
</tr>

<?php while ( have_datasets() ) : the_dataset(); ?>
	<tr class="<?php the_dataset_class(); ?>">
		<?php the_dataset_metadata( array("output" => "td", 'show_dataset_image' => false) ); ?>
	</tr>
<?php endwhile; ?>

</table>

<?php the_project_pagination(); ?>

<?php else : ?>
<p class='error'><?php _e( 'Nothing found', 'projectmanager') ?></p>
<?php endif; ?>

<?php endif; ?>