<div class="wrap">
	<h1><?php echo $project->title ?></h1>
	
	<?php $this->printBreadcrumb( $project->title ) ?>
	
	<ul class="subsubsub projectmanager-menu clear wp-clearfix">
		<?php foreach ( $this->getMenu() AS $key => $item ) : ?>
		<?php if ( current_user_can($item['cap']) ) : ?>
			<?php if ( (isset($project->navi_link) && $project->navi_link != 1) || isset($_GET['subpage']) ) : ?>
			<li><a class="button-primary" href="admin.php?page=projectmanager&amp;subpage=<?php echo $key ?>&amp;project_id=<?php echo $project->id ?>"><?php echo $item['title'] ?></a></li>
			<?php else : ?>
			<li><a class="button-primary" href="admin.php?page=<?php printf($item['page'], intval($project->id)) ?>"><?php echo $item['title'] ?></a></li>
			<?php endif; ?>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	
	<!--<div class="alignright">-->
	<form class='search-form' action='<?php echo $menu_page_url ?>' method='get'>
		<p class="search-box">
		<input type='text' class='search-input' name='search' value='<?php echo $project->getSearchString() ?>' />
		<input type='hidden' name='page' value='<?php echo htmlspecialchars($_GET['page']) ?>' />
		<input type='hidden' name='project_id' value='<?php echo $project->id ?>' />
		<?php if (isset($_GET['subpage'])) : ?>
		<input type="hidden" name="subpage" value="<?php echo $_GET['subpage'] ?>" />
		<?php endif; ?>
		<input type='submit' value='<?php _e( 'Search' ) ?>' class='button-secondary action' />
		</p>
	</form>
	
	<!--
	<form class="search-form wp-clearfix dup-datasets" action="<?php echo $menu_page_url ?>" method='get'>
		<p class="search-box">
		<input type='hidden' name='page' value='<?php echo htmlspecialchars($_GET['page']) ?>' />
		<input type='hidden' name='project_id' value='<?php echo $project->id ?>' />
		<?php if (isset($_GET['subpage'])) : ?>
		<input type="hidden" name="subpage" value="<?php echo $_GET['subpage'] ?>" />
		<?php endif; ?>
		
		<?php $selected = ""; if (isset($_GET['dup'])) $selected = htmlspecialchars($_GET['dup']); if (isset($_POST['dup'])) $selected = htmlspecialchars($_POST['dup']); ?>
		<select size="1" name="dup" class="">
			<option value=""<?php selected($selected, '') ?>><?php _e('Find duplicated datasets', 'projectmanager') ?></option>
			<?php foreach ( $project->getFormFields() AS $formfield ) :?>
			<?php if (!in_array($formfield->type, array('paragraph', 'title'))) : ?>
			<option value="formfields_<?php echo $formfield->id ?>"<?php selected($selected, sprintf("formfields_%d", $formfield->id)) ?>><?php echo $formfield->label ?></option>
			<?php endif; ?>
			<?php endforeach; ?>
		</select>
			
		<input type='submit' value='<?php _e( 'Search' ) ?>' name='search_up' class='button' />
		</p>
	</form>
	-->
	
	<form id="dataset-filter" method="post" action="<?php echo $menu_page_url ?>" name="form" class="clear">
	<input type="hidden" name="js-active" value="0" class="js-active" />
	<input type="hidden" name="current_page" value="<?php echo $project->current_page ?>" />
	
	<?php wp_nonce_field( 'projectmanager_dataset-bulk' ) ?>
	
	<div class="tablenav top clear">
		<?php if ( $project->no_edit == 0 ) : ?>
		<div class="alignleft actions bulkactions">
			<!-- Bulk Actions -->
			<select name="action" size="1">
				<option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
				<option value="delete"><?php _e('Delete')?></option>
				<option value="duplicate"><?php _e( 'Duplicate', 'projectmanager' ) ?></option>
				<option value="save_order"><?php _e( 'Save Order', 'projectmanager' ) ?></option>
				<option value="sendconfirmation"><?php _e( 'Send E-Mail Confirmation', 'projectmanager' ) ?>
			</select>
			<input type="submit" value="<?php _e('Apply'); ?>" name="doaction" id="doaction" class="button-secondary action" />
		</div>
		<?php endif; ?>
		
		<div class="alignleft actions">
			<?php if ( $project->hasCategories() ) : ?>
			<!-- Category Filter -->
			<select size="1" name="cat_id">
				<option value=""><?php _e( 'View all categories', 'projectmanager') ?></option>
				<?php foreach ( $project->getCategories() AS $category ) : ?>
				<option value="<?php echo $category->id ?>"<?php selected($category->id, $project->getCatID()) ?>><?php echo $category->title ?></option>
				<?php endforeach; ?>
			</select>
			<?php endif; ?>
			<!-- Orderby Options -->
			<select size='1' name='orderby'>
			<?php foreach ( $project->getOrderbyOptions() AS $key => $value ) : ?>
				<option value='<?php echo $key ?>' <?php selected( $project->getDatasetOrderby(), $key ) ?>><?php echo $value ?></option>
			<?php endforeach ?>
			</select>
			<!-- Order Options -->
			<select size='1' name='order'>
			<?php foreach ( $project->getOrderOptions() AS $key => $value ) : ?>
				<option value='<?php echo $key ?>' <?php selected ($project->getDatasetOrder(), $key) ?>><?php echo $value ?></option>
			<?php endforeach; ?>
			</select>
			
			<?php if ($project->hasCountryFormField()) : ?>
			<?php foreach ($project->getCountryFormFields() AS $field) : ?>
			<!-- Country Filter -->
			<select size="1" name="country_<?php echo $field->id ?>">
				<option value=""><?php printf(__('Filter by %s', 'projectmanager'), $field->label) ?></option>
				<?php foreach ($project->getCountries() AS $country) : ?>
				<option value="<?php echo $country->code ?>" <?php selected($country->code, $project->getSelectedCountry($field->id) ); ?>><?php echo $country->name ?></option>
				<?php endforeach; ?>
			</select>
			<?php endforeach; ?>
			<?php endif; ?>
		
			<input type='submit' value='<?php _e( 'Apply' ) ?>' class='button button-secondary action' />
		</div>
		<div class="alignleft actions">
			<?php $selected = ""; if (isset($_GET['dup'])) $selected = htmlspecialchars($_GET['dup']); if (isset($_POST['dup'])) $selected = htmlspecialchars($_POST['dup']); ?>
			<select size="1" name="dup">
				<option value=""<?php selected($selected, '') ?>><?php _e('Find duplicated datasets', 'projectmanager') ?></option>
				<?php foreach ( $project->getFormFields() AS $formfield ) :?>
				<?php if (!in_array($formfield->type, array('paragraph', 'title'))) : ?>
				<option value="formfields_<?php echo $formfield->id ?>"<?php selected($selected, sprintf("formfields_%d", $formfield->id)) ?>><?php echo $formfield->label ?></option>
				<?php endif; ?>
				<?php endforeach; ?>
			</select>
				
			<input type='submit' value='<?php _e( 'Search' ) ?>' name='search_up' class='button button-secondary action' />
		</div>

		<div class="tablenav-pages">
			<?php echo $project->pagination; ?>
		</div>
	</div>

	<?php if ( $datasets ) : ?>
	<table class="widefat wp-list-table sortable-table dataset-list" id="datasets">
	<thead>
		<tr>
			<?php if ( $project->no_edit == 0 ) : ?><th class="manage-column check-column column-cb"><input type="checkbox" /></th><?php endif; ?>
			<?php $datasets[0]->printTableHeader(); ?>
			<?php if ( $project->hasCategories() ) : ?>
			<?php echo $project->getSortableTableHeader('category', __( 'Categories', 'projectmanager' ), array('manage-column', 'column-categories')) ?>
			<?php endif; ?>
			<?php echo $project->getSortableTableHeader('order', '#', array('mange-column', 'column-order')) ?>
			<!--<th class="manage-column column-ID" scope="col"><?php _e( 'ID', 'projectmanager' ) ?></th>-->
			<?php if ( $project->dataset_activation == 1 ) : ?>
			<th class="manage-column column-status" scope="col"><?php _e( 'Status', 'projectmanager' ) ?></th>
			<?php endif; ?>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<?php if ( $project->no_edit == 0 ) : ?><th class="manage-column check-column column-cb"><input type="checkbox" /></th><?php endif; ?>
			<?php $datasets[0]->printTableHeader(); ?>
			<?php if ( $project->hasCategories() ) : ?>
			<?php echo $project->getSortableTableHeader('category', __( 'Categories', 'projectmanager' ), array('manage-column', 'column-categories')) ?>
			<?php endif; ?>
			<?php echo $project->getSortableTableHeader('order', '#', array('mange-column', 'column-order')) ?>
			<!--<th class="manage-column column-ID" scope="col"><?php _e( 'ID', 'projectmanager' ) ?></th>-->
			<?php if ( $project->dataset_activation == 1 ) : ?>
			<th class="manage-column column-status" scope="col"><?php _e( 'Status', 'projectmanager' ) ?></th>
			<?php endif; ?>
		</tr>
	</tfoot>
	<tbody class="the-list">
	<?php foreach ( $datasets AS $dataset ) : ?>
		<tr class="<?php echo $dataset->cssClass ?>" id="dataset_<?php echo $dataset->id ?>">
			<?php if ( $project->no_edit == 0 ) : ?><th scope="row" class="check-column column-cb"><input type="checkbox" value="<?php echo $dataset->id ?>" name="dataset[<?php echo $dataset->id ?>]" /><input type="hidden" name="dataset_id[<?php echo $dataset->id ?>]" value="<?php echo $dataset->id ?>"</th><?php endif; ?>
			<?php $dataset->printData(array('output' => 'td') ) ?>
			<?php if ( $project->hasCategories() ) : ?>
			<td class="column-categories" data-colname="<?php _e( 'Categories', 'projectmanager' ) ?>"><?php echo implode(", ", $dataset->categories) ?></td>
			<?php endif; ?>
			<td class="column-order" data-colname="<?php _e( 'Number', 'projectmanager' ) ?>"><input type="text" class="sortable-order" name="dataset_order[<?php echo $dataset->id ?>]" value="<?php echo $dataset->order ?>" size="1" /><span class="order-value"><?php echo $dataset->order ?></td>
			<!--<td class="column-ID" data-colname="<?php _e( 'ID', 'projectmanager' ) ?>">
				<?php if ( $project->no_edit == 0 && (( current_user_can('edit_datasets') && $current_user->ID == $dataset->user_id ) || ( current_user_can('edit_other_datasets') ) )) : ?>
					<a href="admin.php?page=<?php if($_GET['page'] == 'projectmanager') echo 'projectmanager&subpage=dataset'; else echo 'project-dataset_'.$project->id ?>&amp;edit=<?php echo $dataset->id ?>&amp;project_id=<?php echo $project->id ?>"><?php echo $dataset->id ?></a>
				<?php else : ?>
					<?php echo $dataset->id ?>
				<?php endif; ?>
			</td>-->
			<?php if ( $project->dataset_activation == 1 ) : ?>
			<td class="column-status status-<?php echo $dataset->status ?>" data-colname="<?php _e( 'Status', 'projectmanager' ) ?>"><?php _e($dataset->status, 'projectmanager') ?></td>
			<?php endif; ?>
		</tr>
	<?php endforeach ?>
	</tbody>
	</table>
	<?php else  : ?>
		<div class="error"><p><?php _e( 'Nothing found', 'projectmanager') ?></p></div>
	<?php endif ?>
		
	<div class="tablenav bottom">
		<?php if ( $project->no_edit == 0 ) : ?>
		<div class="alignleft actions bulkactions">
			<!-- Bulk Actions -->
			<select name="action2" size="1">
				<option value="-1" selected="selected"><?php _e('Bulk Actions') ?></option>
				<option value="delete"><?php _e('Delete')?></option>
				<option value="duplicate"><?php _e( 'Duplicate', 'projectmanager' ) ?></option>
				<option value="save_order"><?php _e( 'Save Order', 'projectmanager' ) ?></option>
				<option value="sendconfirmation"><?php _e( 'Send E-Mail Confirmation', 'projectmanager' ) ?></option>
			</select>
			<input type="submit" value="<?php _e('Apply'); ?>" name="doaction2" id="doaction2" class="button-secondary action" />
		</div>
		<?php endif; ?>
		
		<!--
		<div class="alignleft actions">
			<?php if ( $project->hasCategories() ) : ?>
			<select size="1" name="cat_id">
				<option value=""><?php _e( 'View all categories', 'projectmanager') ?></option>
				<?php foreach ( $project->getCategories() AS $category ) : ?>
				<option value="<?php echo $category->id ?>"<?php selected($category->id, $project->getCatID()) ?>><?php echo $category->title ?></option>
				<?php endforeach; ?>
			</select>
			<?php endif; ?>
			<select size='1' name='orderby'>
			<?php foreach ( $project->getOrderbyOptions() AS $key => $value ) : ?>
				<option value='<?php echo $key ?>' <?php selected( $project->getDatasetOrderby(), $key ) ?>><?php echo $value ?></option>
			<?php endforeach ?>
			</select>
			<select size='1' name='order'>
			<?php foreach ( $project->getOrderOptions() AS $key => $value ) : ?>
				<option value='<?php echo $key ?>' <?php selected ($project->getDatasetOrder(), $key) ?>><?php echo $value ?></option>
			<?php endforeach; ?>
			</select>
			
			<?php if ($project->hasCountryFormField()) : ?>
			<?php foreach ($project->getCountryFormFields() AS $field) : ?>
			<select size="1" name="country_<?php echo $field->id ?>">
				<option value=""><?php printf(__('Filter by %s', 'projectmanager'), $field->label) ?></option>
				<?php foreach ($project->getCountries() AS $country) : ?>
				<option value="<?php echo $country->code ?>" <?php selected($country->code, $project->getSelectedCountry($field->id) ); ?>><?php echo $country->name ?></option>
				<?php endforeach; ?>
			</select>
			<?php endforeach; ?>
			<?php endif; ?>
		
			<input type='submit' value='<?php _e( 'Apply' ) ?>' class='button' />
		</div>
		<div class="alignleft actions">
			<?php $selected = ""; if (isset($_GET['dup'])) $selected = htmlspecialchars($_GET['dup']); if (isset($_POST['dup'])) $selected = htmlspecialchars($_POST['dup']); ?>
			<select size="1" name="dup">
				<option value=""<?php selected($selected, '') ?>><?php _e('Find duplicated datasets', 'projectmanager') ?></option>
				<?php foreach ( $project->getFormFields() AS $formfield ) :?>
				<?php if (!in_array($formfield->type, array('paragraph', 'title'))) : ?>
				<option value="formfields_<?php echo $formfield->id ?>"<?php selected($selected, sprintf("formfields_%d", $formfield->id)) ?>><?php echo $formfield->label ?></option>
				<?php endif; ?>
				<?php endforeach; ?>
			</select>
				
			<input type='submit' value='<?php _e( 'Search' ) ?>' name='search_up' class='button' />
		</div>
		-->
		<div class="tablenav-pages">
			<?php echo $project->pagination; ?>
		</div>
	</div>
	
	</form>
</div>