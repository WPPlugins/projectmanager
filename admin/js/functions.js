jQuery(function() {
	// select all checkboxes in a form, when clicking checkbox with class 'select_all'
/*	jQuery('.select_all').change(function() {
		var checkboxes = jQuery(this).closest('form').find(':checkbox');
		if(jQuery(this).is(':checked')) {
			checkboxes.prop('checked', true);
		} else {
			checkboxes.prop('checked', false);
		}
	});
	
	// select all checkboxes in form of specific class
	jQuery('.check-column-master input:checkbox').change(function() {
		var checkboxes = jQuery('.check-column-child input:checkbox');
		if(jQuery(this).is(':checked')) {
			checkboxes.prop('checked', true);
		} else {
			checkboxes.prop('checked', false);
		}
	});
	*/
	
	/*
	 * Enable sortable tables
	 */
	jQuery(".sortable-table .the-list").sortable({
		axis: "y"
	});
	jQuery(".sortable-table .the-list").css("cursor", "move");
	
	// Set js-active value to 1
	jQuery("#dataset-filter>input.js-active").val(1);
	// Set js-active value to 1
	jQuery("#formfield-filter>input.js-active").val(1);
	
	// disable order input fields
	jQuery(".sortable-table input.sortable-order").prop('disabled', 'true');
	
	/*
	 * enable datepicker for date formfields
	 */
	jQuery(".datepicker").datepicker({
		showAnim: "slideDown",
		showOtherMonths: true,
		showButtonPanel: true,
		numberOfMonths: 3,
		showWeek: true,
		dateFormat: "yy-mm-dd",
		changeYear: true,
		yearRange: "c-100:c+100",
		changeMonth: true
	});
	jQuery(".datepicker").css("display", "inline");
	jQuery(".form-input-date").remove();
	
	// Enable iris colorpicker
	jQuery(document).ready(function() {
		jQuery('.projectmanager-colorpicker').iris();
	});
	
	/* jQuery UI tooltips */
	jQuery( ".tooltip").tooltip({
		track: true,
		show: {
			effect: "slideDown",
			delay: 250
		},
		hide: {
			effect: "slideUp",
			delay: 250
		}
	});
	
	/* jQuery UI tabs */	
	jQuery( "#tabs" ).tabs({
		collapsible: true,
	});
	
	/* Add event listener to get active tab */
	jQuery( "#tabs").on('tabsactivate', function(event, ui) {
		var index = ui.newTab.index();
		jQuery("#tabs>.active-tab").val(index);
	});
	
	/* jQuery UI accordion */	
	jQuery( ".jquery-ui-accordion" ).accordion({
		header: "h2",
		collapsible: true,
		heightStyle: "content",
		
		// add event listener to set active tab
		activate: function (event, ui) {
			var index = jQuery(".jquery-ui-accordion").accordion( "option", "active" );
			jQuery(".jquery-ui-accordion>.active-tab").val(index);
		}
	});
	
	/* jQuery Tabs for settings and import/export */
	jQuery("#tabs>.tablist").css("display", "block");
	jQuery("#tabs>.tab>h2").css("display", "none");
	//jQuery("#tabs>.import-block-container>h2").css("display", "none");
	
	/* hide top-links in documentation */
	jQuery(".top-link").css("display", "none");
	
	
	/* hide order columns in formfields table*/
	jQuery(".formfields-list .column-order").css("display", "none");
	
	/* show only order count in dataset table */
	jQuery(".dataset-list .column-order input.sortable-order").css("display", "none");
	jQuery(".dataset-list .column-order span.order-value").css("display", "block");
});