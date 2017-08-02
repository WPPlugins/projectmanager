<?php
// check for rights
if(!current_user_can('edit_posts')) die;

global $wpdb, $projectmanager;

$projects = $projectmanager->getProjects();
foreach ($projects AS $i => $project) {
	$projects[$i] = get_project($project);
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php _e('Projectmanager', 'projectmanager') ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<?php wp_register_script( 'projectmanager', PROJECTMANAGER_URL.'/admin/js/functions.js', array( 'colorpicker', 'sack' ), PROJECTMANAGER_VERSION ); ?>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo includes_url(); ?>js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo PROJECTMANAGER_URL ?>/admin/tinymce/tinymce.js"></script>
	<script type="text/javascript">
	//<![CDATA[
	ProjectManagerAjaxL10n = {
		blogUrl: "<?php bloginfo( 'wpurl' ); ?>",
		//pluginPath: "<?php echo PROJECTMANAGER_PATH; ?>",
		pluginUrl: "<?php echo PROJECTMANAGER_URL; ?>",
		requestUrl: "<?php  bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php",
		imgUrl: "<?php echo PROJECTMANAGER_URL; ?>/images",
		Edit: "<?php _e("Edit"); ?>",
		Post: "<?php _e("Post"); ?>",
		Save: "<?php _e("Save"); ?>",
		Cancel: "<?php _e("Cancel"); ?>",
		pleaseWait: "<?php _e("Please wait..."); ?>",
		Revisions: "<?php _e("Page Revisions"); ?>",
		Time: "<?php _e("Insert time"); ?>",
		Options: "<?php _e("Options", "projectmanager") ?>",
		Delete: "<?php _e('Delete', 'projectmanager') ?>"
	}
	//]]>
	</script>
	<base target="_self" />
	
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="ProjectManagerTinyMCE" action="#">
	<div class="tabs">
		<ul>
			<li id="project_tab" class="current"><span><a href="javascript:mcTabs.displayTab('project_tab', 'project_panel');" onmouseover="return false;"><?php _e( 'Project', 'projectmanager' ); ?></a></span></li>
			<!--<li id="dataset_tab"><span><a href="javascript:mcTabs.displayTab('dataset_tab', 'dataset_panel');" onmouseover="return false;"><?php _e( 'Dataset', 'projectmanager' ); ?></a></span></li>-->
			<!--<li id="search_tab"><span><a href="javascript:mcTabs.displayTab('search_tab', 'search_panel');" onmouseover="return false;"><?php _e('Search Form','projectmanager') ?></a></span></li>-->
			<li id="datasetform_tab"><span><a href="javascript:mcTabs.displayTab('datasetform_tab', 'datasetform_panel');" onmouseover="return false;"><?php _e('Dataset Form','projectmanager') ?></a></span></li>
			<li id="counter_tab"><span><a href="javascript:mcTabs.displayTab('counter_tab', 'counter_panel');" onmouseover="return false;"><?php _e('Counter','projectmanager') ?></a></span></li>
			<li id="testimonials_tab"><span><a href="javascript:mcTabs.displayTab('testimonials_tab', 'testimonials_panel');" onmouseover="return false;"><?php _e('Testimonials','projectmanager') ?></a></span></li>
			<li id="map_tab"><span><a href="javascript:mcTabs.displayTab('map_tab', 'map_panel');" onmouseover="return false;"><?php _e('Map','projectmanager') ?></a></span></li>
		</ul>
	</div>
	<div class="panel_wrapper" style="height: 190px;">
		
	<!-- project panel -->
	<div id="project_panel" class="panel current">
	<table style="border: 0;">
	<tr>
		<td><label for="projects"><?php _e("Project", 'projectmanager'); ?></label></td>
		<td>
		<select id="projects" name="projects" style="width: 200px">
        	<option value="0"><?php _e("No Project", 'projectmanager'); ?></option>
			<?php foreach ( $projects AS $project ) : ?>
				<option value="<?php echo $project->id ?>"><?php echo $project->title ?></option>
			<?php endforeach; ?>
        </select>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap" valign="top"><label for="template"><?php _e( 'Template', 'projectmanager' ) ?></label></td>
		<td>
		<?php $templates = array('gallery' => __('Gallery', 'projectmanager'), 'table' => __('Table', 'projectmanager'), 'table-image' => __('Table with Image', 'projectmanager'), 'list' => __('List', 'projectmanager'), 'list-accordion' => __('jQuery UI Accordion', 'projectmanager'), 'list-expandable' => __('Expandable List', 'projectmanager'), 'list-accordion-faq' => __('jQuery UI Accordion FAQ', 'projectmanager'), 'list-expandable-faq' => __('Expandable FAQ', 'projectmanager')) ?>
		<select size="1" name="project_template" id="project_template">
			<?php foreach ($templates AS $value => $template_name) : ?>
			<option value="<?php echo $value ?>"><?php echo $template_name ?></option>
			<?php endforeach; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap" valign="top"><label for="cat_id"><?php _e( 'Category', 'projectmanager' ) ?></label></td>
		<td>
			<select size="1" name="cat_id" id="cat_id">
				<option value=""><?php _e( 'None', 'projectmanager' ) ?></option>
				<?php foreach ( $projects AS $project ) : ?>
					<optgroup label="<?php echo $project->title ?>">
					<?php foreach ( $project->getData("categories") AS $category ) : ?>
						<option value="<?php echo $category->id ?>"><?php echo $category->title ?></option>
					<?php endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap" valign="top"><label for="orderby"><?php _e( 'Order By', 'projectmanager' ) ?></label></td>
		<td>
			<select size="1" name="orderby" id="orderby">
				<option value=""><?php _e( 'Default', 'projectmanager') ?></option>
				<option value="id"><?php _e('ID', 'projectmanager') ?></option>
				<option value="order"><?php _e('Custom Order', 'projectmanager') ?></option>
				<option value="formfields"><?php _e( 'Formfields', 'projectmanager') ?></option>
			</select>
			<input type="text" size="3" name="formfield_id" id="formfield_id" />
			<select size="1" name="order" id="order">
				<option value=""><?php _e( 'Default', 'projectmanager') ?></option>
				<option value="asc"><?php _e('Ascending', 'projectmanager') ?></option>
				<option value="desc"><?php _e('Descending', 'projectmanager') ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap" valign="top"><label for="selections"><?php _e('Show Selections', 'projectmanager') ?></label></td>
		<td><input type="checkbox" name="selections" value="true" id="selections" checked="checked" /></td>
	</tr>
	<tr>
		<td nowrap="nowrap" valign="top"><label for="searchform"><?php _e('Show Searchform', 'projectmanager') ?></label></td>
		<td><input type="checkbox" name="searchform" value="true" id="searchform" checked="checked" /></td>
	</tr>
	<tr>
		<td nowrap="nowrap" valign="top"><label for="limit"><?php _e('Limit', 'projectmanager') ?></label></td>
		<td>
			<select size="1" name="limit" id="limit">
				<option value=""><?php _e('Show all datasets', 'projectmanager') ?></option>
				<?php for($i = 1; $i <= 20; $i++) : ?>
				<option value="<?php echo $i ?>"><?php echo $i ?></option>
				<?php endfor; ?>
			</select>
		</td>
	</tr>
	</table>
	</div>
	
	<!-- dataset panel -->
	<!--<div id="dataset_panel" class="panel">
	<table style="border: 0;" cellpadding="5">
	<tr>
		<td><label for="datasets"><?php _e("Dataset", 'projectmanager'); ?></label></td>
		<td>
			<select id="datasets" name="datasets" style="width: 200px">
				<option value="0"><?php _e("", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
					<optgroup label="<?php echo $project->title ?>">
					<?php //foreach ( $project->getDatasets(array('limit' => 0, 'orderby' => 'id', 'order' => 'ASC')) AS $dataset ) : $dataset = get_dataset($dataset); ?>
						<option value="<?php echo $dataset->id ?>"><?php echo $dataset->name ?></option>
					<?php //endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	</table>
	</div>-->
	
	<!-- search panel -->
	<!--<div id="search_panel" class="panel">
	<table style="border: 0;">
	<tr>
		<td><label for="search_projects"><?php _e("Project", 'projectmanager'); ?></label></td>
		<td>
			<select id="search_projects" name="search_projects" style="width: 200px">
				<option value="0"><?php _e("No Project", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
					<option value="<?php echo $project->id ?>"><?php echo $project->title ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap" valign="top"><label><?php _e( 'Display', 'projectmanager' ) ?></label></td>
		<td>
			<input type="radio" name="search_display" id="search_display_extend" value="extend" checked="ckecked" /><label for="search_display_extended"><?php _e( 'Extended Version', 'projectmanager' ) ?></label><br />
			<input type="radio" name="search_display" id="search_display_compact" value="compact" /><label for="search-display_compact"><?php _e( 'Compact Version', 'projectmanager' ) ?></label><br />
		</td>
	</tr>
	</table>
	</div>-->
	
	<!-- dataset form panel -->
	<div id="datasetform_panel" class="panel">
	<table style="border: 0;">
	<tr>
		<td><label for="datasetform_projects"><?php _e("Project", 'projectmanager'); ?></label></td>
		<td>
			<select id="datasetform_projects" name="datasetform_projects" style="width: 200px">
				<option value="0"><?php _e("No Project", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
					<option value="<?php echo $project->id ?>"><?php echo $project->title ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="datasetform_templates"><?php _e("Template", 'projectmanager'); ?></label></td>
		<td><input type="text" name="datasetform_template" id="datasetform_template" style="width: 200px" /></td>
	</tr>
	</table>
	</div>
	
	<!-- counter panel -->
	<div id="counter_panel" class="panel">
	<table style="border: 0;">
	<tr>
		<td><label for="counter_project"><?php _e("Project", 'projectmanager'); ?></label></td>
		<td>
			<select id="counter_project" name="counter_project" style="width: 200px">
				<option value="0"><?php _e("No Project", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
					<option value="<?php echo $project->id ?>"><?php echo $project->title ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="counter_field"><?php _e( 'Count Field', 'projectmanager' ) ?></label></td>
		<td>
			<select size="1" id="counter_field" name="counter_field" style="width: 100px">
				<option value="datasets"><?php _e("Datasets", 'projectmanager'); ?></option>
				<optgroup label="<?php _e('Countries', 'projectmanager') ?>">
				<?php foreach( $projects as $project ) : ?>
					<?php foreach ($project->getData("formfields", "type", "country") AS $formfield) : ?>
					<option value="countries_<?php echo $formfield->id ?>" ><?php echo $project->title." - ".$formfield->label ?></option>
					<?php endforeach; ?>
				<?php endforeach; ?>
				</optgroup>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="counter_text"><?php _e("Optional Text", 'projectmanager'); ?></label></td>
		<td><input type="text" size="40" name="counter_text" id="counter_text" /></td>
	</tr>
	</table>
	</div>
	
	<!-- testimonials panel -->
	<div id="testimonials_panel" class="panel">
	<table style="border: 0;">
	<tr>
		<td><label for="testimonials_projects"><?php _e("Project", 'projectmanager'); ?></label></td>
		<td>
			<select size="1" id="testimonials_projects" name="testimonials_projects" style="width: 200px">
				<option value="0"><?php _e("No Project", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
					<option value="<?php echo $project->id ?>"><?php echo $project->title ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="testimonials_template"><?php _e('Template', 'projectmanager'); ?></label></td>
		<td>
		<?php $templates = array('intro' => __('Intro', 'projectmanager'), 'list' => __('List', 'projectmanager'), '' => __('Gallery', 'projectmanager')) ?>
		<select size="1" name="testimonials_template" id="testimonials_template">
			<?php foreach ($templates AS $value => $template_name) : ?>
			<option value="<?php echo $value ?>"><?php echo $template_name ?></option>
			<?php endforeach; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td><label for="testimonials_number"><?php _e("Number of datasets", 'projectmanager'); ?></label></td>
		<td>
			<input type="text" size="5" name="testimonials_number" id="testimonials_number" />
			<label for="testimonials_ncol"><?php _e("Number of Columns", 'projectmanager'); ?></label>
			<input type="text" size="5" name="testimonials_ncol" id="testimonials_ncol" />
		</td>
	</tr>
	<tr>
		<td><label for="testimonials_comment_id"><?php _e("Formfields", 'projectmanager'); ?></label></td>
		<td>
			<select size="1" id="testimonials_comment_id" name="testimonials_comment_id" style="width: 100px">
				<option value=""><?php _e("Comment", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
				<optgroup label="<?php echo $project->title ?>">
					<?php foreach ($project->getData("formfields") AS $formfield) : ?>
					<option value="<?php echo $formfield->id ?>" ><?php echo $formfield->label ?></option>
					<?php endforeach; ?>
				</optgroup>
				<?php endforeach; ?>
			</select>
			<select size="1" id="testimonials_country_id" name="testimonials_country_id" style="width: 100px">
				<option value=""><?php _e("Country", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
				<optgroup label="<?php echo $project->title ?>">
					<?php foreach ($project->getData("formfields") AS $formfield) : ?>
					<option value="<?php echo $formfield->id ?>" ><?php echo $formfield->label ?></option>
					<?php endforeach; ?>
				</optgroup>
				<?php endforeach; ?>
			</select>
			<select size="1" id="testimonials_city_id" name="testimonials_city_id" style="width: 100px">
				<option value=""><?php _e("City", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
				<optgroup label="<?php echo $project->title ?>">
					<?php foreach ($project->getData("formfields") AS $formfield) : ?>
					<option value="<?php echo $formfield->id ?>" ><?php echo $formfield->label ?></option>
					<?php endforeach; ?>
				</optgroup>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="testimonials_sign_page_id"><?php _e("Signing Page ID", 'projectmanager'); ?></label></td>
		<td>
			<select size="1" id="testimonials_sign_page_id" name="testimonials_sign_page_id" style="width: 100px;">
				<option value=""></option>
				<?php if ($pages = get_pages()) : ?>
				<?php foreach ($pages AS $page) : ?>
					<option value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<span><?php _e('or', 'projectmanager') ?></span>
			<span><input type="text" size="20" name="testimonials_sign_page_id_text" id="testimonials_sign_page_id_text" placeholder="<?php _e('Anker on same page', 'projectmanager') ?>" /></span>
			<span>(<?php _e('Optional', 'projectmanager') ?>)</span>
		</td>
	</tr>
	<tr>
		<td><label for="testimonials_list_page_id"><?php _e("Supporter Page ID", 'projectmanager'); ?></label></td>
		<td>
			<select size="1" id="testimonials_list_page_id" name="testimonials_list_page_id" style="width: 100px;">
				<option value=""></option>
				<?php if ($pages = get_pages()) : ?>
				<?php foreach ($pages AS $page) : ?>
					<option value="<?php echo $page->ID ?>"><?php echo $page->post_title ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<span>(<?php _e('Optional', 'projectmanager') ?>)</span>
		</td>
	</tr>
	<tr>
		<td><label for="testimonials_selections"><?php _e('Show Selections', 'projectmanager') ?></label></td>
		<td><input type="checkbox" name="testimonials_selections" value="true" id="testimonials_selections" checked="checked" /></td>
	</tr>
	</table>
	</div>
	
	<!-- map panel -->
	<div id="map_panel" class="panel">
	<table style="border: 0;">
	<tr>
		<td><label for="map_project"><?php _e("Project", 'projectmanager'); ?></label></td>
		<td>
			<select size="1" id="map_project" name="map_project" style="width: 200px">
				<option value="0"><?php _e("No Project", 'projectmanager'); ?></option>
				<?php foreach ( $projects AS $project ) : ?>
					<option value="<?php echo $project->id ?>"><?php echo $project->title ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	</table>
	
	<p class="maps-info"><?php printf(__( "Powered by the <a href='%s' target='%s' title=Simplemaps'>Free World Continent Map</a> from <a href='%s' target='%s' title='Simplemaps'>simplemaps</a>, based on the <a href='%s' target='%s' title='Interactive-Maps Plugin'>Interactive-Maps Plugin</a>.", 'projectmanager'), 'http://simplemaps.com/resources/free-continent-map', '_blank', 'http://simplemaps.com', '_blank', 'https://wordpress.org/plugins/interactive-maps/', '_blank'); ?></p>
	</div>
	
	</div>
	
	<br style="clear: both;" />
	<div class="mceActionPanel" style="margin-top: 0.5em;">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'projectmanager'); ?>" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'projectmanager'); ?>" onclick="ProjectManagerInsertLink();" />
		</div>
	</div>
</form>
</body>
</html>
