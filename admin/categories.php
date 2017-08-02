<div class="wrap">
	<h1><?php printf("%s &mdash; %s", $project->title, __( 'Categories', 'projectmanager' )) ?></h1>
	
	<?php $this->printBreadcrumb( __('Categories','projectmanager') ) ?>
	
	<div id="col-container" class="wp-clearfix clear">
	<div id="col-left">
	<div class="col-wrap">
		<!-- add new category or edit category -->
		<div class="form-wrap">
		<form action="<?php echo $menu_page_url ?>" method="post">
			<input type="hidden" name="updateProjectManager" value="category" />
			<input type="hidden" name="cat_id" value="<?php echo intval($cat->id) ?>" />
			<?php wp_nonce_field( 'projectmanager_manage-categories' ) ?>
			
			<h2><?php echo $form_title ?></h2>
			<div class="form-field form-required">
				<label for="title"><?php _e( 'Title', 'projectmanager' ) ?></label>
				<input type="text" name="title" id="title" value="<?php echo $cat->title ?>" />
			</div>
			
			<p class="submit"><input type="submit" value="<?php echo $form_title ?>" class="button button-primary" /></p>
		</form>
		</div>
	</div>
	</div><!-- / col-left -->
	
	<div id="col-right">
	<div class="col-wrap">
		<form id="categories-filter" method="post" action="">
		<?php wp_nonce_field( 'projectmanager_categories-bulk' ) ?>
		
		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<!-- Bulk Actions -->
				<select name="action" size="1">
					<option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
					<option value="delete"><?php _e('Delete')?></option>
				</select>
				<input type="submit" value="<?php _e('Apply'); ?>" name="doaction" id="doaction" class="button-secondary action" />
			</div>
		</div>
		
		<table class="wp-list-table widefat projectmanager" summary="<?php _e( 'List of categories', 'projectmanager' ) ?>" title="<?php _e( 'Categories', 'projectmanager' ) ?>">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column-master check-column column-cb"><input type="checkbox" /></th>
				<th scope="col" class="manage-column column-primary column-title"><?php _e( 'Category', 'projectmanager' ) ?></th>
				<!--<th scope="col" class="manage-column column-actions"><?php _e( 'Actions', 'projectmanager' ) ?></th>-->
				<th scope="col" class="manage-column column-ID"><?php _e('ID', 'projectmanager') ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column-master check-column column-cb"><input type="checkbox" /></th>
				<th scope="col" class="manage-column column-primary column-title"><?php _e( 'Category', 'projectmanager' ) ?></th>
				<!--<th scope="col" class="manage-column column-actions"><?php _e( 'Actions', 'projectmanager' ) ?></th>-->
				<th scope="col" class="manage-column column-ID"><?php _e('ID', 'projectmanager') ?></th>
			</tr>
		</tfoot>
		<tbody id="the-list">
		<?php if ( $project->hasCategories() ) : ?>
	
		<?php foreach ( $project->getCategories() AS $category ) : ?>
			<tr class="<?php echo $category->class ?>">
				<th scope="row" class="check-column check-column-child column-cb"><input type="checkbox" value="<?php echo $category->id ?>" name="category[<?php echo $category->id ?>]" /></th>
				<td class="column-title column-primary" data-colname="<?php _e( 'Category', 'projectmanager' ) ?>"><?php echo $category->title ?><div class='row-actions'><span class="edit edit-category"><a href="<?php echo $menu_page_url; ?>&amp;edit=<?php echo $category->id ?>"><?php _e( 'Edit', 'projectmanager' ) ?></a></span></div><button class='toggle-row' type='button'></button></td>
				<!--<td class="column-actions" data-colname="<?php _e( 'Actions', 'projectmanager' ) ?>"><a href="<?php echo $menu_page_url; ?>&amp;edit=<?php echo $category->id ?>"><?php _e( 'Edit', 'projectmanager' ) ?></a></td>-->
				<td class="column-ID" data-colname="<?php _e('ID', 'projectmanager') ?>"><?php echo $category->id ?></td>
			</tr>
		<?php endforeach; ?>
	
		<?php endif; ?>
		</tbody>
		</table>

		<div class="tablenav bottom">
			<div class="alignleft actions bulkactions">
				<!-- Bulk Actions -->
				<select name="action2" size="1">
					<option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
					<option value="delete"><?php _e('Delete')?></option>
				</select>
				<input type="submit" value="<?php _e('Apply'); ?>" name="doaction2" id="doaction2" class="button-secondary action" />
			</div>
		</div>
		
		</form>
	</div>
	</div><!-- /col-right -->
</div>
</div>