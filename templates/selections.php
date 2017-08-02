<div class='projectmanager-selections'>
<form action='<?php esc_url(the_permalink()) ?>' method='get'>
	<input type='hidden' name='page_id' value='<?php the_ID() ?>' />
	<?php foreach (array("/cat_id_\d+/", "/paged_\d+/", "/orderby_\d+/", "/order_\d+/") AS $pattern) : ?>
	<?php foreach ( preg_grep($pattern, array_keys($_GET)) AS $key ) : ?>
		<input type="hidden" name="<?php echo $key ?>" value="<?php echo htmlspecialchars($_GET[$key]) ?>" />
	<?php endforeach; ?>
	<?php endforeach; ?>

	<?php if ( $project->hasCategories() ) : ?>
	<select size="1" name="cat_id_<?php echo $project->id ?>">
		<option value=""><?php _e( 'View all categories', 'projectmanager') ?></option>
		<?php foreach ( $project->getData("categories") AS $category ) : ?>
		<option value="<?php echo $category->id ?>"<?php selected($category->id, $project->getCatID()) ?>><?php echo $category->title ?></option>
		<?php endforeach; ?>
	</select>
	<?php endif; ?>
	
	<select size='1' name='orderby_<?php echo $project->id ?>'>
		<?php foreach ( $project->getOrderbyOptions() AS $key => $value ) : ?>
		<option value='<?php echo $key ?>' <?php selected($key, $project->getDatasetOrderby()) ?>><?php echo $value ?></option>
		<?php endforeach; ?>
	</select>
	
	<select size='1' name='order_<?php echo $project->id ?>'>
		<?php foreach ( $project->getOrderOptions() AS $key => $value ) : ?>
		<option value='<?php echo $key ?>' <?php selected($key, $project->getDatasetOrder()) ?>><?php echo $value ?></option>
		<?php endforeach; ?>
	</select>
	
	<?php if ($project->hasCountryFormField()) : ?>
	<?php foreach ($project->getCountryFormFields() AS $field) : ?>
	<select size="1" style="width: 200px;" name="country_<?php echo $project->id ?>_<?php echo $field->id ?>">
		<option value=""><?php printf(__('Filter by %s', 'projectmanager'), $field->label) ?></option>
		<?php foreach ($project->getCountries() AS $country) : ?>
		<option value="<?php echo $country->code ?>" <?php selected($country->code, $project->getSelectedCountry() ); ?>><?php echo $country->name ?></option>
		<?php endforeach; ?>
	</select>
	<?php endforeach; ?>
	<?php endif; ?>
	
	<input type='submit' value='<?php _e( 'Apply' ) ?>' class='button' />
</form>
</div>