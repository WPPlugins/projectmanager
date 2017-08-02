<?php
/**
 * Implement AJAX responses
 *
 * @author Kolja Schleich
 * @package	ProjectManager
 * @subpackage ProjectManagerAJAX
*/
class ProjectManagerAJAX extends ProjectManager {
	/**
	 * register ajax actions
	 */
	public function __construct() {
		// templates/dataset-form.php
		add_action( 'wp_ajax_nopriv_projectmanager_new_captcha', array(&$this, 'getNewCaptcha') );
		add_action( 'wp_ajax_projectmanager_new_captcha', array(&$this, 'getNewCaptcha') );
		
		// admin/formfields-row.php
		add_action( 'wp_ajax_projectmanager_toggle_formfield_options', array(&$this, 'toggleFormFieldOptions') );
	}
	
	
	/**
	 * exchange captcha code in dataset form
	 *
	 * @see templates/dataset-form.php
	 */
	public function getNewCaptcha() {
		$project = get_project(intval($_POST['project_id']));
		
		$captcha = $this->generateCaptcha( $project->captcha['length'], $project->captcha['nlines'], $project->captcha['ndots'], $project->captcha['letters'] );
		$captcha_image = '<img src="'.$this->getCaptchaURL($captcha).'" class="captcha" alt="captcha" />';
		
		die(
			"jQuery('div#captcha_image').fadeOut('fast', function() {
				jQuery('div#captcha_image').html('".addslashes_gpc($captcha_image)."').fadeIn('fast');
			});
			document.getElementById('projectmanager_captcha_id').value = '".$captcha."';
		");
	}
	
	
	/**
	 * exchange formfield options field
	 *
	 * @see admin/formfields-row.php
	 */
	public function toggleFormFieldOptions() {
		$project = get_project(intval($_POST['project_id']));
		
		$formfield_id = intval($_POST['formfield_id']);
		$options_value = htmlspecialchars($_POST['formfield_options']);
		$new_formfield_type = htmlspecialchars($_POST['new_formfield_type']);

		$new_type = $project->getFormFieldTypes($new_formfield_type);
		if ( $new_formfield_type == 'project' )
			$options_type = 'project';
		elseif ( is_array($new_type) && isset($new_type['options_type']) )
			$options_type = $new_type['options_type'];
		else
			$options_type = 'text';
		
		if ( $options_type == "project" ) {
			$html = '<select size="1" name="formfields['.$formfield_id.'][options]">';
			$html .= '<option value="0">'.__( 'Choose Project', 'projectmanager' ).'</option>';
			foreach ( $this->getProjects() AS $p ) {
				if ( $p->id != $project->id ) {
					$html .= '<option value="'.$p->id.'" '.selected($p->id, $options_value, false).'>'.$p->title.'</option>';
				}
			}
			$html .= '</select>';
		} else {
			$html = '<input type="text" name="formfields['.$formfield_id.'][options]" class="tooltip" value="'.$options_value.'" title="'.__("For details on formfield options see the Documentation", 'projectmanager').'" />';
		}
		
		die(
			"jQuery('div#formfield-options-".$formfield_id."').fadeOut('fast', function() {
				jQuery('div#formfield-options-".$formfield_id."').html('".addslashes_gpc($html)."').fadeIn('fast');
			});
		");
	}
}
?>