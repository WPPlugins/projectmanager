<script type='text/javascript'>
	jQuery(function() {
		jQuery("#tabs.settings-blocks").tabs({
			active: <?php echo $tab ?>
		});
	});
</script>
<div class='wrap'>
	<h1><?php _e( 'Global Settings', 'projectmanager' ) ?></h1>

	<form action='' method='post' name='colors'>
	<?php wp_nonce_field( 'projetmanager_manage-global-league-options' ); ?>	
	
	<div class="settings-blocks jquery-ui-accordion" id="">
		<input type="hidden" class="active-tab" name="active-tab" value="<?php echo $tab ?>" ?>
		
		<!--<ul class="tablist">
			<li><a href="#colors"><?php _e( 'Color Scheme', 'projectmanager' ) ?></a></li>
			<li><a href="#dashboard-widget"><?php _e( 'Dashboard Widget Support News', 'projectmanager' ) ?></a></li>
		</ul>-->
		
		<div id="colors" class="settings-block-container">
			<h2><?php _e( 'Color Scheme', 'projectmanager' ) ?></h2>
			<div class="settings-block content">
				<table class='form-table'>
				<tr valign='top'>
					<th scope='row'><label for='color_headers'><?php _e( 'Table Headers', 'projectmanager' ) ?></label></th><td><input type='text' name='color_headers' id='color_headers' value='<?php echo $options['colors']['headers'] ?>' size='7' class="projectmanager-colorpicker color" /><span class="colorbox" style="background-color: <?php echo $options['colors']['headers'] ?>"></span></td>
				</tr>
				<tr valign='top'>
					<th scope='row'><label for='color_rows'><?php _e( 'Table Rows', 'projectmanager' ) ?></label></th>
					<td>
						<p class='table_rows'><input type='text' name='color_rows_alt' id='color_rows_alt' value='<?php echo $options['colors']['rows'][0] ?>' size='7' class="projectmanager-colorpicker color" /><span class="colorbox" style="background-color: <?php echo $options['colors']['rows'][0] ?>"></span></p>
						<p class='table_rows'><input type='text' name='color_rows' id='color_rows' value='<?php echo $options['colors']['rows'][1] ?>' size='7' class="projectmanager-colorpicker color" /><span class="colorbox" style="background-color: <?php echo $options['colors']['rows'][1] ?>"></span></p>
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'><label for='color_rows'><?php _e( 'Box Header', 'projectmanager' ) ?></label></th>
					<td>
						<p class='table_rows'><input type='text' name='color_boxheader1' id='color_boxheader1' value='<?php echo $options['colors']['boxheader'][0] ?>' size='7' class="projectmanager-colorpicker color" /><span class="colorbox" style="background-color: <?php echo $options['colors']['boxheader'][0] ?>"></span></p>
						<p class='table_rows'><input type='text' name='color_boxheader2' id='color_boxheader2' value='<?php echo $options['colors']['boxheader'][1] ?>' size='7' class="projectmanager-colorpicker color" /><span class="colorbox" style="background-color: <?php echo $options['colors']['boxheader'][1] ?>"></span></p>
					</td>
				</tr>
				</table>
			</div>
		</div>
		
		<div id="dashboard-widget" class="settings-block-container">
			<h2><?php _e('Dashboard Widget Support News', 'projectmanager') ?></h2>
			<div class="settings-block content">
				<table class='form-table'>
				<tr valign='top'>
					<th scope='row'><label for='dashboard_num_items'><?php _e( 'Number of Support Threads', 'projectmanager' ) ?></label></th><td><input type="number" step="1" min="0" class="small-text" name='dashboard[num_items]' id='dashboard_num_items' value='<?php echo $options['dashboard_widget']['num_items'] ?>' size='2' /></td>
				</tr>
				<tr valign='top'>
					<th scope='row'><label for='dashboard_show_author'><?php _e( 'Show Author', 'projectmanager' ) ?></label></th><td><input type='checkbox' name='dashboard[show_author]' id='dashboard_show_author'<?php checked($options['dashboard_widget']['show_author'], 1) ?> /></td>
				</tr>
				<tr valign='top'>
					<th scope='row'><label for='dashboard_show_date'><?php _e( 'Show Date', 'projectmanager' ) ?></label></th><td><input type='checkbox' name='dashboard[show_date]' id='dashboard_show_date'<?php checked($options['dashboard_widget']['show_date'], 1) ?> /></td>
				</tr>
					<tr valign='top'>
					<th scope='row'><label for='dashboard_show_summary'><?php _e( 'Show Summary', 'projectmanager' ) ?></label></th><td><input type='checkbox' name='dashboard[show_summary]' id='dashboard_show_summary'<?php checked($options['dashboard_widget']['show_summary'], 1) ?> /></td>
				</tr>
				</table>
			</div>
		</div>
	</div>
	
	<input type='hidden' name='page_options' value='color_headers,color_rows,color_rows_alt' />
	<p class='submit'><input type='submit' name='updateProjectManager' value='<?php _e( 'Save Preferences', 'projectmanager' ) ?>' class='button-primary' /></p>
	
	</form>

</div>