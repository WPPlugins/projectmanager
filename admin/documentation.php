<?php
if ( !current_user_can( 'view_projects' ) ) : 
     echo '<div class="error"><p style="text-align: center;">'.__("You do not have sufficient permissions to access this page.").'</p></div>';
else :
?>
<div class="wrap projectmanager-doc" id="projectmanager-documentation">
	<h1 id="top"><?php _e( 'ProjectManager Documentation', 'projectmanager' ) ?></h1>
	
	<div class="jquery-ui-accordion">
		<!--
		<ul>
		 <li><a href="#formfield-options"><?php _e( 'Formfield Options', 'projectmanager' ) ?></a></li>
		 <li><a href="#slideshows"><?php _e( 'Slideshows', 'projectmanager' ) ?></a></li>
		 <li><a href="#shortcodes"><?php _e( 'Shortcodes', 'projectmanager' ) ?></a></li>
		 <li><a href="#templates"><?php _e( 'Templates', 'projectmanager' ) ?></a></li>
		 <li><a href="#global_search"><?php _e( 'Global Search', 'projectmanager' ) ?></a></li>
		 <li><a href="#template_tags"><?php _e( 'Template Tags', 'projectmanager' ) ?></a></li>
		 <li><a href="#access"><?php _e( 'Access Control', 'projectmanager' ) ?></a></li>
		 <li><a href="#extended_profile"><?php _e( 'Extended Profile', 'projectmanager' ) ?></a></li>
		 <li><a href="#customization"><?php _e( 'Customization', 'projectmanager' ) ?></a></li>
		 <li><a href="#import"><?php _e( 'Export/Import', 'projectmanager' ) ?></a></li>
		 <li><a href="#howto_intro"><?php _e( 'Howto', 'projectmanager' ) ?></a></li>
		</ul>
		-->
		
		<div id='formfield-options'>
			<h2><?php _e( 'Formfield Options', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				
				<p><?php _e( 'Each formfield has an options field, which can be used to extend its functionality.', 'projectmanager') ?></p>
				<p><?php _e( 'Formfields of types checkbox, radio or dropdown menu, the options field is used to specify the different options. Each option is separated by ;. For checkbox and radio lists you can also use a special option <em>Other</em>, which will trigger addition of a textfield so that users can input custom values', 'projectmanager' ) ?></p>
				<p><?php _e( 'Other formfield types have special options to extend their functionality as listed below', 'projectmanager' ) ?></p>
				<ul style="list-style: disc; margin-left: 1em;">
					<li><?php _e( 'max:XX allows limiting the number of allowed characters of the field', 'projectmanager' ) ?></li>
					<li><?php _e( 'limit:XX allows generating text excerpts. This is especially useful for textfields or TinyMCE editor fields', 'projectmanager' ) ?></li>
					<li><?php printf(__("slideshow:description is a special option for the <a href='%s' target='_blank'>Fancy Slideshows Plugin</a> to specify slideshow description fields.", 'projectmanager'), 'https://wordpress.org/plugins/sponsors-slideshow-widget/') ?></li>
				</ul>
			</div>
		</div>
		
		<div id='slideshows'>
			<h2><?php _e( 'Slideshows', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<p><?php printf(__( "Fancy slideshows of individual projects data can be easily created in combination with the <a href='%s' target='_blank'>Fancy Slideshows Plugin</a>.", 'projectmanager' ), 'https://wordpress.org/plugins/sponsors-slideshow-widget/') ?></p>
			</div>
		</div>
		
		<div id='shortcodes'>
			<h2><?php _e( 'Shortcodes', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<!-- Shortcode to display all datasets from one project -->
				<p><?php _e( 'The main shortcode is to display datasets of a project. The following shows a minimal example. A complete list of arguments is described in the table below.', 'projectmanager' ) ?></p>
				<blockquote><p class="shortcode">[project id=ID template=X]</p></blockquote>

				<table class="widefat wp-list-table projectmanager">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-parameter column-primary"><?php _e( 'Parameter', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column column-description"><?php _e( 'Description', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Possible Values', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Default', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Optional', 'projectmanager' ) ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $shortcode = array(
						array( 'parameter' => 'id', 'desc' => 'ID of Project', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'template', 'desc' => 'Template file used to display', 'values' => '<em>table</em>, <em>table-image</em>, <em>gallery</em>, <em>list</em> or template file without extension', 'default' => 'table', 'optional' => 'Yes' ),
						array( 'parameter' => 'cat_id', 'desc' => 'Set this attribute to only display datasets of given category ID', 'values' => 'em>integer</em>', 'default' => '', 'optional' => 'Yes' ),
						array( 'parameter' => 'orderby', 'desc' => 'order datasets by given field', 'values' => '<em>order</em>, <em>id</em>, <em>formfields_ID</em> (replace ID with respective ID or <em>rand</em>. <em>rand</em> must be used together with the results attribute to limit the number of datastes.', 'default' => '', 'optional' => 'Yes' ),
						array( 'parameter' => 'order', 'desc' => 'Ordering of datasets', 'values' => '<em>asc</em>, <em>desc</em>', 'default' => 'asc', 'optional' => 'Yes' ),
						array( 'parameter' => 'single', 'desc' => 'Toggle link to single dataset', 'values' => '<em>true</em>, <em>false</em>', 'default' => 'true', 'optional' => 'Yes' ),
						array( 'parameter' => 'selections', 'desc' => 'Toggle display of selection forms for categories and dataset ordering', 'values' => '<em>true</em>, <em>false</em>', 'default' => 'true', 'optional' => 'Yes' ),
						array( 'parameter' => 'results', 'desc' => 'Limit number of datasets', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'Yes' ),
						array( 'parameter' => 'field_id', 'desc' => 'Filter datasets for formfield ID. Must be used together with <em>field_value</em>.', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'Yes' ),
						array( 'parameter' => 'field_value', 'desc' => 'Filter datasets for formfield value. Must be used together with <em>field_id</em>.', 'values' => '<em>string</em>', 'default' => '', 'optional' => 'Yes' )
					); $class = ''; ?>
					<?php foreach ( $shortcode AS $key => $value ) : $class = ( 'alternate' == $class ) ? '' : 'alternate'; ?>
					<tr class="<?php echo $class ?>" valign="top">
						<td class="column-primary column-parameter" data-colname="<?php _e( 'Parameter', 'projectmanager' ) ?>"><?php echo $value['parameter'] ?><button class="toggle-row" type="button"></button></td>
						<td class="column-description" data-colname="<?php _e( 'Description', 'projectmanager' ) ?>"><?php _e( $value['desc'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Possible Values', 'projectmanager' ) ?>"><?php _e( $value['values'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Default', 'projectmanager' ) ?>"><?php echo $value['default'] ?></td>
						<td data-colname="<?php _e( 'Optional', 'projectmanager' ) ?>"><?php _e( $value['optional'], 'projectmanager' ) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
				
				<!-- Shortcode to display individual dataset -->
				<p><?php _e( 'A single dataset can be displayed with the following code', 'projectmanager' ) ?></p>
				<blockquote><p class="shortcode">[dataset id=X]</p></blockquote>
				<table class="widefat wp-list-table projectmanager">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-parameter column-primary"><?php _e( 'Parameter', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column column-description"><?php _e( 'Description', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Possible Values', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Default', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Optional', 'projectmanager' ) ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $shortcode = array(
						array( 'parameter' => 'id', 'desc' => 'ID of Project', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'template', 'desc' => 'Template to use', 'values' => 'file name without extension', 'default' => '', 'optional' => 'Yes' )
					); $class = ''; ?>
					<?php foreach ( $shortcode AS $key => $value ) : $class = ( 'alternate' == $class ) ? '' : 'alternate'; ?>
					<tr class="<?php echo $class ?>" valign="top">
						<td class="column-primary column-parameter" data-colname="<?php _e( 'Parameter', 'projectmanager' ) ?>"><?php echo $value['parameter'] ?><button class="toggle-row" type="button"></button></td>
						<td class="column-description" data-colname="<?php _e( 'Description', 'projectmanager' ) ?>"><?php _e( $value['desc'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Possible Values', 'projectmanager' ) ?>"><?php _e( $value['values'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Default', 'projectmanager' ) ?>"><?php echo $value['default'] ?></td>
						<td data-colname="<?php _e( 'Optional', 'projectmanager' ) ?>"><?php _e( $value['optional'], 'projectmanager' ) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>

				<!-- Shortcode to include dataset input form -->
				<p><?php _e( 'It is possible to include the dataset input form with the following code', 'projectmanager' ) ?></p>
				<blockquote><p class="shortcode">[dataset_form project_id=ID]</p></blockquote>
				<table class="widefat wp-list-table projectmanager">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-parameter column-primary"><?php _e( 'Parameter', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column column-description"><?php _e( 'Description', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Possible Values', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Default', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Optional', 'projectmanager' ) ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $shortcode = array(
						array( 'parameter' => 'project_id', 'desc' => 'ID of Project', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' )
					); $class = ''; ?>
					<?php foreach ( $shortcode AS $key => $value ) : $class = ( 'alternate' == $class ) ? '' : 'alternate'; ?>
					<tr class="<?php echo $class ?>" valign="top">
						<td class="column-primary column-parameter" data-colname="<?php _e( 'Parameter', 'projectmanager' ) ?>"><?php echo $value['parameter'] ?><button class="toggle-row" type="button"></button></td>
						<td class="column-description" data-colname="<?php _e( 'Description', 'projectmanager' ) ?>"><?php _e( $value['desc'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Possible Values', 'projectmanager' ) ?>"><?php _e( $value['values'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Default', 'projectmanager' ) ?>"><?php echo $value['default'] ?></td>
						<td data-colname="<?php _e( 'Optional', 'projectmanager' ) ?>"><?php _e( $value['optional'], 'projectmanager' ) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>

				<!-- Shortcode to include number of dataset -->
				<p><?php _e( 'It is possible to include the number datasets or countries', 'projectmanager' ) ?></p>
				<blockquote><p class="shortcode">[projectmanager_counter project_id=ID field=datasets|countries]</p></blockquote>
				<table class="widefat wp-list-table projectmanager">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-parameter column-primary"><?php _e( 'Parameter', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column column-description"><?php _e( 'Description', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Possible Values', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Default', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Optional', 'projectmanager' ) ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $shortcode = array(
						array( 'parameter' => 'project_id', 'desc' => 'ID of Project', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'field', 'desc' => 'Database Field to retrieve counts for', 'values' => '<em>string</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'text', 'desc' => 'additional text', 'values' => '', 'default' => '', 'optional' => 'Yes' )
					); $class = ''; ?>
					<?php foreach ( $shortcode AS $key => $value ) : $class = ( 'alternate' == $class ) ? '' : 'alternate'; ?>
					<tr class="<?php echo $class ?>" valign="top">
						<td class="column-primary column-parameter" data-colname="<?php _e( 'Parameter', 'projectmanager' ) ?>"><?php echo $value['parameter'] ?><button class="toggle-row" type="button"></button></td>
						<td class="column-description" data-colname="<?php _e( 'Description', 'projectmanager' ) ?>"><?php _e( $value['desc'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Possible Values', 'projectmanager' ) ?>"><?php _e( $value['values'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Default', 'projectmanager' ) ?>"><?php echo $value['default'] ?></td>
						<td data-colname="<?php _e( 'Optional', 'projectmanager' ) ?>"><?php _e( $value['optional'], 'projectmanager' ) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			
				<!-- Shortcode to include global search results -->
				<p><?php _e( 'It is possible to include global search results page by simply putting the following shortcode into a page or post', 'projectmanager' ) ?></p>
				<blockquote><p class="shortcode">[projectmanager_search]</p></blockquote>
				
				<!-- Shortcode to include world map -->
				<p><?php printf(__( "If you have at least one country formfield you can display a worldmap denoting the number of datasets by continents powered by the <a href='%s' target='%s' title=Simplemaps'>Free World Continent Map</a> from <a href='%s' target='%s' title='Simplemaps'>simplemaps</a>, based on the <a href='%s' target='%s' title='Interactive-Maps Plugin'>Interactive-Maps Plugin</a>.", 'projectmanager'), 'http://simplemaps.com/resources/free-continent-map', '_blank', 'http://simplemaps.com', '_blank', 'https://wordpress.org/plugins/interactive-maps/', '_blank'); ?></p>
				<blockquote><p class="shortcode">[projectmanager_map project_id=ID formfield_id=X]</p></blockquote>
				<table class="widefat wp-list-table projectmanager">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-parameter column-primary"><?php _e( 'Parameter', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column column-description"><?php _e( 'Description', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Possible Values', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Default', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Optional', 'projectmanager' ) ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $shortcode = array(
						array( 'parameter' => 'project_id', 'desc' => 'ID of Project', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'formfield_id', 'desc' => 'ID of country formfield', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'label', 'desc' => 'Dataset label text', 'values' => '<em>string</em>', 'default' => 'Supporter', 'optional' => 'Yes' )
					); $class = ''; ?>
					<?php foreach ( $shortcode AS $key => $value ) : $class = ( 'alternate' == $class ) ? '' : 'alternate'; ?>
					<tr class="<?php echo $class ?>" valign="top">
						<td class="column-primary column-parameter" data-colname="<?php _e( 'Parameter', 'projectmanager' ) ?>"><?php echo $value['parameter'] ?><button class="toggle-row" type="button"></button></td>
						<td class="column-description" data-colname="<?php _e( 'Description', 'projectmanager' ) ?>"><?php _e( $value['desc'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Possible Values', 'projectmanager' ) ?>"><?php _e( $value['values'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Default', 'projectmanager' ) ?>"><?php echo $value['default'] ?></td>
						<td data-colname="<?php _e( 'Optional', 'projectmanager' ) ?>"><?php _e( $value['optional'], 'projectmanager' ) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>

				<!-- Shortcode to include testimonials -->
				<p><?php _e( 'It is possible to include testimonials', 'projectmanager' ) ?></p>
				<blockquote><p class="shortcode">[testimonials project_id=ID comment=X country=X city=X]</p></blockquote>
				<table class="widefat wp-list-table projectmanager">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-parameter column-primary"><?php _e( 'Parameter', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column column-description"><?php _e( 'Description', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Possible Values', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Default', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column"><?php _e( 'Optional', 'projectmanager' ) ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $shortcode = array(
						array( 'parameter' => 'project_id', 'desc' => 'ID of Project', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'comment', 'desc' => 'Formfield ID containing comment', 'values' => '', 'default' => '', 'optional' => '' ),
						array( 'parameter' => 'country', 'desc' => 'Formfield ID containing country', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'city', 'desc' => 'Formfield ID containing city', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'No' ),
						array( 'parameter' => 'number', 'desc' => 'Number of datasets to display in intro template', 'values' => '<em>integer</em>', 'default' => '6', 'optional' => 'Yes' ),
						array( 'parameter' => 'template', 'desc' => 'Template to use', 'values' => '<em>empty, intro or X with a template named testimonials-X.php</em>', 'default' => '', 'optional' => 'Yes' ),
						array( 'parameter' => 'ncol', 'desc' => 'Number of columns in intro template', 'values' => '<em>integer</em>', 'default' => '3', 'optional' => 'Yes' ),
						array( 'parameter' => 'sign_page_id', 'desc' => 'Page ID containing datasetform', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'Yes' ),
						array( 'parameter' => 'list_page_id', 'desc' => 'Page ID containing list of testimonials', 'values' => '<em>integer</em>', 'default' => '', 'optional' => 'Yes' ),
					); $class = ''; ?>
					<?php foreach ( $shortcode AS $key => $value ) : $class = ( 'alternate' == $class ) ? '' : 'alternate'; ?>
					<tr class="<?php echo $class ?>" valign="top">
						<td class="column-primary column-parameter" data-colname="<?php _e( 'Parameter', 'projectmanager' ) ?>"><?php echo $value['parameter'] ?><button class="toggle-row" type="button"></button></td>
						<td class="column-description" data-colname="<?php _e( 'Description', 'projectmanager' ) ?>"><?php _e( $value['desc'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Possible Values', 'projectmanager' ) ?>"><?php _e( $value['values'], 'projectmanager' ) ?></td>
						<td data-colname="<?php _e( 'Default', 'projectmanager' ) ?>"><?php echo $value['default'] ?></td>
						<td data-colname="<?php _e( 'Optional', 'projectmanager' ) ?>"><?php _e( $value['optional'], 'projectmanager' ) ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			</div>
		</div>
		
		<div id='templates'>
			<h2><?php _e( 'Templates', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<p><?php _e( 'Templates are special files that are used to display plugin data in the website frontend. They reside in the following directory', 'projectmanager' ) ?></p>
				<blockquote><p>WP_PLUGIN_DIR/projectmanager/templates/</p></blockquote>
				<p><?php _e( 'The following table lists all available default templates', 'projectmanager' ) ?></p>
				<table class="widefat wp-list-table projectmanager">
				<thead>
					<tr>
						<th scope="col" class="manage-column column-template column-primary"><?php _e( 'Template', 'projectmanager' ) ?></th>
						<th scope="col" class="manage-column column-description"><?php _e( 'Description', 'projectmanager' ) ?></th>
					</tr>
				</thead>
					<tbody>
					<?php $templates = array(
						array('template' => 'table.php', 'desc' => 'Tabular display of datasets'),
						array('template' => 'gallery.php', 'desc' => 'Show datasets as photo gallery'),
						array('template' => 'list.php', 'desc' => 'List display of datasets'),
						array('template' => 'list-accordion.php', 'desc' => 'List display of datasets with jQuery UI accordion funcionality'),
						array('template' => 'list-expandable.php', 'desc' => 'List display of datasets with jQuery expandable funcionality'),
						array('template' => 'list-accordion-faq/list-expandable-faq.php', 'desc' => 'As above, but specially for FAQ lists with only one descriptive field'),
						array('template' => 'table-image.php', 'desc' => 'Tabular display of datasets with small image'),
						array('template' => 'selections.php', 'desc' => 'Display dropdown selections for categories and dataset sorting'),
						array('template' => 'dataset-form.php', 'desc' => 'Dataset input formular'),
						array('template' => 'searchform.php', 'desc' => 'Search formular'),
						array('template' => 'testimonials.php', 'desc' => 'gallery view of datasets specifically for testimonials or petitions'),
						array('template' => 'testimonials-list.php', 'desc' => 'list view of datasets specifically for testimonials or petitions'),
						array('template' => 'testimonials-intro.php', 'desc' => 'landing page specifically for testimonials or petitions displaying random datasets')
					); $class = ''; ?>
					<?php foreach ( $templates AS $key => $template ) : $class = ( $class == 'alternate' ) ? '' : 'alternate'; ?>
					<tr class="<?php echo $class ?>" valign="top">
						<td class="column-primary column-template" data-colname="<?php _e( 'Template', 'projectmanager' ) ?>"><?php echo $template['template'] ?><button class="toggle-row" type="button"></button></td>
						<td data-colname="<?php _e( 'Description', 'projectmanager' ) ?>"><?php _e( $template['desc'], 'projectmanager' ) ?></td>

					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
				<p><?php _e( 'If you want to modify existing templates copy it to', 'projectmanager' ) ?></p>
				<blockquote><p>your_theme_dir/projectmanager/</p></blockquote>
				<p><?php _e( 'The plugin will then first look in your theme directory. Further it is possible to design own templates. Assume you created a file <strong>sample1.php</strong>, to display datasets of a project. To use the template use the following tag.', 'projectmanager' ) ?></p>
				<blockquote><p>[project id=ID template=<strong>sample1</strong>]</p></blockquote>
				<p><?php _e( 'For single datasets templates must be named <strong>dataset-X.php</strong>, dataset form <strong>dataset-form-X.php</strong> and testimonials <strong>testimonials-X</strong>. The files are then loaded with the following tags.', 'projectmanager' ) ?></p>
				<blockquote>
					<p>[dataset id=ID template=<strong>X</strong>]</p>
					<p>[datasetform project_id=ID template=<strong>X</strong>]</p>
					<p>[testimonials project_id=ID template=<strong>X</strong>]</p>
				</blockquote>
				<p><?php _e( 'You can add additional search paths for templates by using the filter <em>projectmanager_template_paths</em>', 'projectmanger' ) ?></p>
				<pre>
		&lt;?php
		add_filter( 'projectmanager_template_paths', 'add_template_path');

		function add_template_path( $paths ) {
			$paths[] = PATH_TO_YOUR_DIRECTORY_WITHOUT_TRAILINGSLASH;
			return $paths;
		}
		?&gt;
				</pre>
			</div>
		</div>
		
		<div id='global_search'>
			<h2><?php _e( 'Global Search', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e('Top', 'projectmanager') ?></a>
				<p><?php _e('The search widget allows searching simultaneously in all projects. In the widget settings a results page has to be defined. This can be either any page containing a project with shortcodes <strong>[project]</strong> or <strong>[testimonials]</strong>, which will automatically show global search results. Alternatively, a page can be created containing the shortcode <strong>[projectmanager_search]</strong>, which will not display anything, unless a global search has been queried.', 'projectmanager') ?></p>
			</div>
		</div>
		
		<div id='template_tags'>
			<h2 id="template_tags"><?php _e( 'Template Tags', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<p><?php _e( 'Template Tags are functions that can be used in your Wordpress Theme to display the plugin data. Here is a brief listing of available tags. For details see file functions.php', 'projectmanager' ) ?><p>
				<dl class="projectmanager">
					<dt><pre>&lt;?php project( $id, $args ) ?&gt;</pre></dt><dd><?php _e( 'display all datasets from a single project', 'projectmanager' ) ?></dd>
					<dt><pre>&lt;?php dataset( $id, $args ) ?&gt;</pre></dt><dd><?php _e( 'display a single dataset', 'projectmanager' ) ?></dd>
					<dt><pre>&lt;?php projectmanager_display_widget( $number, $instance ) ?&gt;</pre></dt><dd><?php _e( 'Display widget. <em>$number</em> is the widget number and <em>$instance</em> is an assoziative array of widget settings. See lib/widget.php function widget for details.', 'projectmanager' ) ?></dd>
					<!--<dt><pre>&lt;?php projectmanager_searchform( $project_id, $args ) ?&gt;</pre></dt><dd><?php _e( 'display the searchform. <em>$project_id</em> is the ID of the project.', 'projectmanager' ) ?></dd>
					<dt><pre>&lt;?php projectmanager_selections( $project_id ) ?&gt;</pre></dt><dd><?php _e( 'display the selection bar. <em>$project_id</em> is the ID of the project.', 'projectmanager' ) ?></dd>-->
					<dt><pre>&lt;?php project_datasetform( $project_id ) ?&gt;</pre></dt><dd><?php _e( 'display the dataset form. <em>$project_id</em> is the ID of the project.', 'projectmanager' ) ?></dd>
				</dl>
				<p><?php _e( 'The variable <em>$args</em> is always an assoziative array of additional arguments with keys being the same as the shortcode attributes.', 'projectmanager' ) ?></p>
			</div>
		</div>
		
		<div id='access'>
			<h2><?php _e( 'Access Control', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<p><?php printf( __( 'ProjectManager has fine grained capabilities to control access to different areas of the administration panel. You could use <a href="%s" target="_blank">Capability Manager</a> to manage roles and capabilities. <em>Note</em>: Capabilities are not inherent.', 'projectmanager' ), 'http://wordpress.org/extend/plugins/capsman/'); ?></p>
				<dl class="projectmanager">
					<dt>edit_projects</dt><dd><?php _e( 'add and edit projects', 'projectmanager' ) ?></dd>
					<dt>delete_projects</dt><dd><?php _e( 'delete existing projects', 'projectmanager' ) ?></dd>
					<dt>projectmanager_settings</dt><dd><?php _e( 'allow access to global settings of ProjectManager', 'projectmanager' ) ?></dd>
					<dt>edit_formfields</dt><dd><?php _e( 'allow access to FormField Panel', 'projectmanager' ) ?></dd>
					<dt>edit_projects_settings</dt><dd><?php _e( 'allow access to individual projects settinigs', 'projectmanager' ) ?></dd>
					<dt>edit_categories</dt><dd><?php _e( 'add and edit categories', 'projectmanager' ) ?></dd>
					<dt>import_datasets</dt><dd><?php _e( 'export and import data', 'projectmanager' ) ?></dd>
					<dt>edit_datasets</dt><dd><?php _e( 'add datasets and edit own datasets', 'projectmanager' ) ?></dd>
					<dt>edit_other_datasets</dt><dd><?php _e( 'add datasets and edit all datasets and add WP User as dataset', 'projectmanager' ) ?></dd>
					<dt>add_multiple_datasets</dt><dd><?php _e( 'add more than one dataset', 'projectmanager' ) ?></dd>
					<dt>delete_datasets</dt><dd><?php _e( 'delete own datasets', 'projectmanager' ) ?></dd>
					<dt>delete_other_datasets</dt><dd><?php _e( 'delete any dataset', 'projectmanager' ) ?></dd>
					<dt>view_projects</dt><dd><?php _e( 'browse projects in administration panel', 'projectmanager' ) ?></dd>
					<dt>projectmanager_user</dt><dd><?php _e( 'allow usage of profile hook', 'projectmanager' ) ?></dd>
					<dt>view_pdf</dt><dd><?php _e( 'Download datasets as PDF', 'projectmanager' ) ?></dd>
					<dt>projectmanager_send_confirmation</dt><dd><?php _e( 'Send Confirmation E-Mails from admin panel', 'projectmanager' ) ?></dd>
					<dt>edit_dataset_order</dt><dd><?php _e( 'Save custom dataset order', 'projectmanager' ) ?></dd>
				</dl>
			</div>
		</div>
		
		<div id='extended_profile'>
			<h2><?php _e( 'Extended Profile', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<p><?php _e( 'Each dataset is assigned an owner who added it. This owner can be also changed by anybody with the capability <em>edit_other_datasets</em>. This makes it possible to use ProjectManager as extended WP User Profile by activating the profile hook option in the projects settings. When this option is activated the first dataset of the current user is loaded into the profile page and can be edited through their profile. For new users, a dataset is automatically generated upon registration if the default user group has the capability <em>projectmanager_user</em>.', 'projectmanager' ) ?></p>
			</div>
		</div>
		
		<div id='customization'>
			<h2><?php _e( 'Customization', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<h3>Icons in admin menu</h3>
				<p><?php _e( 'If you want to use custom icons for the admin menu put them into the following folder in your theme directory', 'projectmanager' ) ?></p>
				<blockquote><p>projectmanager/icons</p></blockquote>
				
				<h3>Add Formfield types</h3>
				<p><?php _e( 'You can also add custom Formfields via the filter projectmanager_formfields. First let us add the field.', 'projectmanager' ) ?></p>
				<pre>
		&lt;?php
		add_filter( 'projectmanager_formfields', 'my_formfields');

		function my_formfields( $formfields ) {
			$formfields['myfield'] = array( 'name' => 'My Field', 'callback' => 'get_myfield_data', 'args' => array());
			return $formfields;
		}
		?&gt;
				</pre>
				<p><?php _e( 'The <em>callback</em> option is a function which gets the data for this field as it is not stored in the ProjectManager Database. <em>args</em> can be an optional assoziative array of arguments that are passed to the callback function. Finally we just need to get the data from somewhere.', 'projectmanager' ) ?></p>
				<pre>
		&lt;?php
		function get_myfield_data( $dataset, $args ) {
			// $dataset is an assoziative array with keys 'id' and 'name' that hold the dataset ID and name respectively
			// do some stuff
		}
		?&gt;
				</pre>
			</div>
		</div>
		
		<div id='import'>
			<h2><?php _e( 'Export/Import', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<p><?php _e( 'There are multiple possibilities for data export and import as listed below', 'projectmanager' ) ?></p>
				<ol>
					<li><?php _e( 'You can export datasets as tab-separated (CSV) or PDF files. Datasets in tab-separated format can be opened in Excel and also imported into another project.', 'projectmanager' ) ?></li>
					<li><?php _e( 'Media files of a project can be exported as zip file and also imported into another project', 'projectmanager' ) ?></li>
					<li><?php _e( 'Complete projects can be also exported. This will generate a PHP file with MySQL queries to import the whole project including all settings and formfields. Simply create a new project and directly continue to project import.', 'projectmanager' ) ?></li>
				</ol>
			</div>
		</div>

		<div id='howto_intro'>
			<h2><?php _e( 'HowTo', 'projectmanager' ) ?></h2>
			<div class="content">
				<a href="#top" class="alignright top-link"><?php _e( 'Top', 'projectmanager' ) ?></a>
				<p><?php _e( 'This section should give a short introduction to setting up and using ProjectManager. In addition <a href="http://randyhoyt.com/" target="_blank">Randy Hoyt</a> created a <a href="http://randyhoyt.com/wordpress/snippets/" target="_blank">Screencast</a> on the usage of ProjectManager. Thanks a lot.', 'projectmanager' ) ?></p>
				<p><?php printf( __( 'After activation, there will be a new item in the admin menu. The first step is to <a href="%s" class="thickbox" rel="howto">add a new project</a>. When you click on a specific project you will get to an <a href="%s" class="thickbox" rel="howto">overview page displaying all datasets</a>. The screenshot already shows some example datasets. At first you should go to the <a href="%s" class="thickbox" rel="howto">settings page</a>. The option <em>Top-level menu</em> will create an individual object in the admin menu. Activate the <em>Hook into profile option</em> to use ProjectManager as extended WP User Profile. Before adding datasets you need to setup the <a href="%s" class="thickbox" rel="howto">formfields</a>. This is a very powerful feature of ProjectManager as it allows the design of custom input formular to have datasets with a variety of data. You can choose to display the field value on the startpage and also control display in the user profile. Further it is possible to order datasets by certain formfield values. After that you are set to <a href="%s" class="thickbox" rel="howto">insert datasets</a>. It is possible to group datasets into different <a href="%s" class="thickbox" rel="howto">categories</a> using the WP category system.', 'projectmanager'), PROJECTMANAGER_URL .'/admin/doc/index.png', PROJECTMANAGER_URL .'/admin/doc/overview.png', PROJECTMANAGER_URL .'/admin/doc/settings.png', PROJECTMANAGER_URL .'/admin/doc/formfields.png', PROJECTMANAGER_URL .'/admin/doc/dataset-form.png', PROJECTMANAGER_URL .'/admin/doc/category.png') ?></p>
				<p><?php printf( __( 'The datasets of a project can be inserted into a page or post either by directly using the shortcodes which are described above or by using the <a href="%s" class="thickbox" rel="howto">TinyMCE Button</a>. The button, however, only covers a few default parameter. One default template is <a href="%s" class="thickbox" rel="howto">gallery</a> which displays the datasets in a multicolumn photogallery with a link to <a href="%s" class="thickbox" rel="howto">individual datasets</a>. This template is especially useful for athlete profiles.', 'projectmanager' ), PROJECTMANAGER_URL .'/admin/doc/page.png', PROJECTMANAGER_URL .'/admin/doc/gallery.png', PROJECTMANAGER_URL .'/admin/doc/dataset.png') ?></p>
				<!--<p><?php printf( __( 'ProjectManager also supplies a <a href="%s" class="thickbox" rel="howto">widget</a> and supports any number of widgets. It can be used to display a list of datasets in the sidebar, but also show a slideshow of datasets, e.g. athlete portraits.', 'projectmanager' ), PROJECTMANAGER_URL .'/admin/doc/widget.png') ?></p>-->
				<!--<p><?php printf( __( 'ProjectManager also supports <a href="%s" class="thickbox" rel="howto">AJAX editing</a> of dataset values by clicking on the pencil symbol next to the field value on the overview page. <a href="%s" class="thickbox" rel="howto">E-Mail and URL</a> fields have a special syntax to add the values with a certain text.', 'projectmanager' ), PROJECTMANAGER_URL .'/admin/doc/ajax_group.png', PROJECTMANAGER_URL .'/admin/doc/ajax_email.png') ?></p>-->
			</div>
		</div>
	</div>
</div>
<?php endif; ?>