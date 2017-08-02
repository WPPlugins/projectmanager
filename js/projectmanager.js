jQuery(document).ready(function() {
	/*
	 * Own Expandable list
	 */
	// close list items
	jQuery(".projectmanager-list.expandable>.list-header").addClass("closed");
	jQuery(".projectmanager-list.expandable>.list-content").addClass("closed");
	
	// maybe open first item
	if ( jQuery(".projectmanager-list.expandable").hasClass("first-open") ) {
		jQuery(".projectmanager-list.expandable>.list-header:first").toggleClass("closed open");
		jQuery(".projectmanager-list.expandable>.list-content:first").toggleClass("closed open");
	}
	
	jQuery(".projectmanager-list.expandable>.list-header").click(function(){
		jQuery(this).next(".list-content").slideToggle("fast");
		jQuery(this).next(".list-content").toggleClass("closed open");
		jQuery(this).toggleClass("closed open");
	});

	/* jQuery UI accordion list */	
	jQuery( ".projectmanager-list.accordion" ).accordion({
		header: ".list-header",
		heightStyle: "content"
	});
	
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
});