var Projectmanager = new Object();

/**
 * AJAX response to exchange capcha in frontend formular
 *
 * @param string requestURL
 * @param int project_id
 * @see templates/dataset-form.php
 */
Projectmanager.exchangeCaptcha = function( requestURL, project_id ) {
	var ajax = new sack(requestURL);
	ajax.execute = 1;
	ajax.method = 'POST';
	ajax.setVar( "action", "projectmanager_new_captcha" );
	ajax.setVar( "project_id", project_id );
	ajax.onError = function() { alert('Ajax error'); };
	ajax.onCompletion = function() { return true; };
	ajax.runAJAX();
}

/**
 * AJAX response to toggle formfield options input
 *
 * @param string requestURL
 * @param int formfield_id
 * @param string new_formfield_type
 * @param int project_id
 * @see admin/formfields-row.php
 */
Projectmanager.toggleFormfieldOptions = function( requestURL, formfield_id, new_formfield_type, formfield_options, project_id ) {
	var ajax = new sack(requestURL);
	ajax.execute = 1;
	ajax.method = 'POST';
	ajax.setVar( "action", "projectmanager_toggle_formfield_options" );
	ajax.setVar( "formfield_id", formfield_id );
	ajax.setVar( "formfield_options", formfield_options );
	ajax.setVar( "new_formfield_type", new_formfield_type );
	ajax.setVar( "project_id", project_id );
	ajax.onError = function() { alert('Ajax error'); };
	ajax.onCompletion = function() { return true; };
	ajax.runAJAX();
}