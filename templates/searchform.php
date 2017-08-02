<div class='projectmanager-search-form alignright'>
<form action='<?php esc_url(the_permalink()) ?>' method='get'>
	<input type='search' class='search-field' name='p_search_<?php the_project_id(); ?>' value='<?php the_project_search_query(); ?>' />
	
	<input type="hidden" name="project_id" value="<?php the_project_id(); ?>" />
	<input type='submit' value='<?php _e('Search', 'projectmanager') ?>' class='button' />
</form>
</div>