<?php if ( isset($_GET['view']) ) : $dataset = get_dataset(intval($_GET['view'])); ?>
<div class="wrap">
	<h1><?php printf("%s &mdash; %s", $project->title, __( 'Dataset Details', 'projectmanager' )) ?></h1>
	<?php $this->printBreadcrumb( $form_title ) ?>
	<dl class="projectmanager"><?php $dataset->printData( array('output' => 'dl', 'show_all' => true) ); ?></dl>
</div>
<?php else : ?>

<form class="datasetform <?php echo $form_class ?>" name="post" action="<?php echo $menu_page_url ?>" method="post" enctype="multipart/form-data">
<?php wp_nonce_field( 'projectmanager_edit-dataset' ) ?>
	
<div class="wrap">
	<h1><?php printf( "%s &mdash; %s", $project->title, $form_title) ?></h1>
	
	<?php $this->printBreadcrumb( $form_title ) ?>
	
	<?php include( 'dataset-form.php' ) ?>
	
	<input type="hidden" name="project_id" value="<?php echo $project->id ?>" />
	<input type="hidden" name="dataset_id" value="<?php echo $dataset->id ?>" />
	<input type="hidden" name="updateProjectManager" value="dataset" />
			
	<p class="submit"><input type="submit" name="addportrait" value="<?php echo $form_title ?>" class="button-primary" /></p>
</div>
</form>

<?php endif; ?>