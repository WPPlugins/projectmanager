=== ProjectManager ===
Contributors: Kolja Schleich
Tags: data manager, CMS, Content Management System
Requires at least: 3.9
Tested up to: 4.7.5
Stable tag: 3.6.2

This plugin can be used to manage any type of collection database, portrait system, FAQs, members database, dvd collection, petition/testimonials

== Description ==

This plugin is a feature-rich datamanager for any recurrent datasets.

**Features**

* Add as many different projects as you want to
* Widget for any project including fancy slideshows (in combination with the [Fancy Slideshow Plugin](https://wordpress.org/plugins/sponsors-slideshow-widget/))
* Adding of form fields (text, textfield, e-mail, date, url, selection, checkbox and radio list, country) for each project independently
* Simple search of any form field and category names
* Global search widget for all projects
* Template system to easily customize frontend display
* Easy adding of shortcodes via TinyMCE Button
* Change colorscheme for output tables via admin panel
* Dataset sorting by any form field
* Import and export of datasets from/to CSV or PDF file including media
* Hook projects into user profile
* Show multiple projects on the same page

**Possible Usages**

* People profiles (e.g. athletes, executive board)
* Collection database
* Members database
* Testimonials
* FAQ

[Randy Hoyt](http://randyhoyt.com/) created a [Screencast](http://randyhoyt.com/wordpress/snippets/) on the usage of ProjectManager. Thanks a lot.


**Translations**

* German
* French 
* Italian ([Adriano Urso](http://heyyoudesign.it/))

== Installation ==

To install the plugin to the following steps

1. Unzip the zip-file and upload the content to your Wordpress Plugin directory.
2. Activiate the plugin via the admin plugin page.


== Screenshots ==
1. Project Overview Page
2. Settings page
3. Add different form fields dynamically
4. Easy adding of new datasets
5. Widget control panel
6. Easy adding of shortcode tags via TinyMCE Button
7. Output of projects with gallery template
8. Individual dataset


== Credits ==
The ProjectManager icons were designed by Yusuke Kamiyamane (http://p.yusukekamiyamane.com/)

The WorldMap is generated using the [Free World Continent Map](http://simplemaps.com/resources/free-continent-map) from simplemaps.com based on the [Interactive-Maps Plugin](https://wordpress.org/plugins/interactive-maps/)

== Changelog ==

= 3.6.2 =
* UPDATED: updated translation database using custom perl script

= 3.6.1 =
* NEW: private option for projects for efficient protection of sensitive data from being displayed in the frontend. This is an additional feature, as the plugin is already designed to prevent unauthorized access to datasets from other projects.
* NEW: mobile responsive admin panel
* NEW: Newsletter function to send a newsletter to all datasets in a project. Requires setting an email field and suggested to combine with "Newsletter Options" field - EXPERIMENTAL
* NEW: new magic formfield "Newsletter Options", which displays a two-field radiolist for users to receive newsletters or not
* NEW: styled dataset formular in admin backend
* NEW: option to set multiple or single category selection for datasets. This is useful if there are many categories and only single category membership is required.
* NEW: add css class "mandatory" to labels of mandatory formfields
* NEW: use Wordpress cache for counting datasets to further reduce SQL queries
* NEW: AJAX enabled formfield options
* NEW: some more fine tuned access control
* NEW: order datasets by first category
* NEW: Option for nested projects and formfields. Currently this only determined hierarchical relationship between projects/formfields, reflected on the index
* BUGFIX: fixed category search
* BUGFIX: fixed an issue with unsubmitted form data when editing datasets
* BUGFIX: fixed some style issues
* CHANGED: format documentation as accordion list
* CHANGED: moved page ID setting to general
* UPDATE: changed visibility of functions
* UPDATE: some more optimization on number of MySQL queries to improve performance
* REMOVED: removed unused jQuery Cycle Plugin
* some code cleaning

= 3.6 =
* CHANGED: removed PHPMailer library from plugin and switched to WordPress bundled library for security reasons
* CHANGED: major restructuring of plugin code to Object-based system. Focussed on optimizing security and speed
* BUGFIX: fixed issue with multiple projects on same page
* BUGFIX: fixed calling uninstallation method
* UPDATE: update FPDF version to 1.81 (2015-12-20)
* tested with PHP7

= 3.5.1 =
* BUGFIX: fixed an error in plugin deletion procedure

= 3.5 =
* NEW: options to sort categories by id or name ascending or descending
* NEW: add grayscale menu icons to fit wordpress design
* BUGFIX: fixed thickbox URL
* BUGFIX: changed deprecated add_object_page to add_menu_page
* BUGFIX: fixed issue with undefined offset in categories
* BUGFIX: fixed issue with registration and profile edit
* CHANGED: make TinyMCE editor 100% width

= 3.4.9 =
* BUGFIX: fixed identical CSS class with wordpress internal category checkbox list

= 3.4.8 =
* BUGFIX: improved loading times of pages by caching MySQL query results

= 3.4.7 =
* BUGFIX: fixed PHPMailer class issue in profile edit page by loading PHPMailer only for frontend formular
* BUGFIX: fixed a style issue with world map
* BUGFIX: fixed some style issues with dataset form
* BUGFIX: fixed cleanup of old media files to also delete thumbnail versions of images

= 3.4.6 =
* BUGFIX: fixed adding datasets for users only with capability 'projectmanager_user'
* BUGFIX: some user capability fixes
* BUGFIX: fixed the unused "profile" option for formfields to control display of formfields in profile page

= 3.4.5 =
* NEW: use wordpress image editor for resizing images
* NEW: optionally crop images to exact dimensions
* NEW: some updates for the Fancy Slideshows Plugin
* NEW: button to regenerate thumbnails in a project
* NEW: button to show and delete possibly orphaned media files in a project
* NEW: new capability 'add_multiple_datasets' to make it easier to control if user is allowed to add more than one dataset
* NEW: new filter 'projectmanager_template_path' to allow other plugins (e.g. LeagueManager) to add additional template directories
* BUGFIX: fixed some issues with dataset user assignments and using it as extended profile
* BUGFIX: fixed image width in gallery view
* BUGFIX: check that dataset belongs to current project to prevent unauthorized access to datasets
* BUGFIX: several small fixes
* UPDATE: updated French translation

= 3.4.4 =
* NEW: optionally enforce activation of datasets added in frontend through confirmation link
* NEW: send emails using SMTP if standard method fails
* BUGFIX: fixed link for reloading captcha in frontend dataset form
* BUGFIX: fixed responsive style of gallery view
* BUGFIX: fixed pagination in testimonials when country is selected
* BUGFIX: fixed country selection with multiple projects on the same page

= 3.4.3 =
* NEW: some new styles
* NEW: own category management for each project
* NEW: special image Title Image ('header-image')
* NEW: improved security for data export
* NEW: add multiple new formfields at once
* NEW: export/import complete projects
* BUGFIX: check for existence of FPDF  and PHPMailer classes before loading to avoid fatal error if loaded elsewhere
* BUGFIX: fixed issue with categories that all datasets are retrieved if category is selected without datasets
* BUGFIX: removed print_r() from table header function
* BUGFIX: fixed some issues using it as team roster in LeagueManager
* BUGFIX: fixed a small issue in plugin activation with notifications giving unexpected output
* BUGFIX: fixed activation error for missing roles
* BUGFIX: fixed uninstallation routine
* BUGFIX: fixed issue with unique formfields when editing datasets

= 3.4.2 =
* NEW: download datasetform as PDF
* NEW: new 'signature' formfield type, which is only shown in PDFs (useful for members applications, which require hand-written signatures)
* NEW: detailed settings for fancy slideshows
* NEW: jQuery UI tabs for settings, import/export and documentation for better structure
* BUGFIX: fixed an issue with exporting media files with images (missing medium and large versions)
* BUGFIX: fixed issues with dataset import due to paragraph, title or signature field types
* BUGFIX: fixed list-accordion-faq.php template

= 3.4.1 =
* BUGFIX: fixed error in upgrade routine

= 3.4 =
* NEW: new formfield types 'name' and 'dataset-image' to add dataset name and primary image
* NEW: multiple new options to control form layout
* NEW: dataset details page in admin area
* NEW: print styles to allow nice printing of dataset details page in admin area
* NEW: export single or all datasets as PDF using FPDF
* NEW: export country fields including full country name and 3-digit code
* NEW: send confirmation/notification emails using PHPMailer including possible PDF attachment
* NEW: new template list-accordion.php and list-expandable.php with jQuery functionality that can be open/closed
* NEW: sortable formfields table using jQuery UI sortable if javascript is active. Order input fields are disabled in that case
* NEW: enable jQuery UI datepicker for date formfields if javascript is active
* NEW: Added some more file and menu icons
* NEW: use iris colorpicker
* NEW: custom dataset order including jQuery UI sortable list (in pagination an offset is added to the order)
* NEW: new fancy dataset template
* NEW: additional color options for box header gradients (dataset and expandable/accordion lists)
* BUGFIX: fixed issue with getting duplicated datasets if value is an array (e.g. checkbox lists)
* BUGFIX: fixed error message output in frontend formular
* BUGFIX: don't delete a file if another dataset uses it as well
* BUGFIX: fixed issue in new captcha generation
* BUGFIX: fixed issues in dataset import
* BUGFIX: fixed issue with ordering settings in shortcode
* BUGFIX: some styling fixes
* BUGFIX: fixed dataset ordering by formfields case-insensitive
* REMOVED: removed default dataset name and image fields (keep database columns at the moment)

= 3.3.2 =
* NEW: use slideshow of fancy slideshows aka sponsors-slideshow-widget >= 2.3-digit
* CHANGE: removed slideshow feature from widget. Use Fancy Slideshows aka Sponsors Slideshow Widget instead
* NEW: get random datasets in widget
* BUGFIX: fixed import issue
* BUGFIX: fixed saving settings if no map is present

= 3.3.1 =
* BUGFIX: included lib/project.php (not used yet)

= 3.3 =
* NEW: template tags provide wordpress template like structure of templates including dataset Loop
* BUGFIX: fixed issues with dataset export
* BUGFIX: fixed issue with scheduling map update
* BUGFIX: fixed issue with empty table cells

= 3.2.9.2 =
* BUGFIX: fixed small notification issue

= 3.2.9.1 =
* BUGIFX: fixed missing ajax.js to exchange captcha

= 3.2.9 = 
* NEW: scheduled update of map data
* NEW: AJAX-responsive link to exchange captcha image
* BUGFIX: improved saving map data
* BUGFIX: delete capabilities upon plugin deletion

= 3.2.8 =
* NEW: settings to customize captcha
* NEW: save map data in settings to avoid long loading times
* BUGFIX: fixed issue with exporting datasets

= 3.2.7 =
* NEW: region information and 2-digits country codes for countries database
* NEW: new shortcode [projectmanager_map] to show a world map with number of datasets by region and list of individual countries (powered by the [Free World Continent Map](http://simplemaps.com/resources/free-continent-map) from www.simplemaps.com)
* NEW: function to retrieve number of datasets by country region
* NEW: Shortcode and TinyMCE Button to show number of countries in datasets
* NEW: added Taiwan to countries database
* CHANGED: reduced complexity of captcha
* BUGFIX: fixed invalid HTML output for empty dataset metadata
* BUGFIX: fixed invalid HTML for more link in comment stripping
* BUGFIX: fixed faulty url issue
* BUGFIX: fixed issue with unsubitted form data (e.g. checkbox, radio list) when new dataset is added
* UPDATE: updated some documentation
* UPDATE: updated german translation for documentation

= 3.2.6 =
* BUGFIX: fixed some poor file location calling

= 3.2.5 =
* BUGFIX: small fix for finding duplicated datasets if nothing is found
* UPDATE: adjusted captcha style for mobile devices

= 3.2.4 =
* NEW: search for duplicated datasets by name or formfield values
* NEW: Included thickbox image popup in single dataset view and for image formfields
* BUGFIX: fixed captcha url

= 3.2.3 =
* NEW: added Palestine to countries database

= 3.2.2 =
* NEW: label datasets as "sticky" to always show them on top. Style them through class "sticky"
* NEW: function to get number of countries in datasets. Included in testimonials-intro.php template
* NEW: testimonials gallery template
* NEW: option to scramble email addresses on website for spam protection

* UPDATE: some styling updates
* REMOVED: disabled dataset editing functions from shortcode dataset form
* BUGFIX: fixed pagination in search
* BUGFIX: fixed dataset ordering issue
* BUGFIX: fixed some access rights issues

= 3.2.1 =
* NEW: new list template
* NEW: disable dataset editing in admin backend. If activated all dataset metadata is always shown in admin panel
* NEW: set email confirmations for frontend dataset form and notification of new datasets
* BUGIFX: don't check for email validity if not mandatory
* BUGFIX: fixed issue with file upload
* BUGFIX: fixed profile hook and update of dataset
* BUGFIX: fixed localized month names
* BUGFIX: fixes some styling issues in testimonials-intro template

= 3.2 =
* NEW: dataset pagination
* NEW: improved search to automatically search in name, formfields and categories
* NEW: new widget with global search form to simultaneously search in all projects
* NEW: shortcode for global search results display [projectmanager_search]
* NEW: pagination in search
* NEW: additional name_locale field for countries to store translated country names of website locale. Search in english and localized country names
* NEW: limit textfield and tinymce content by words
* NEW: slideshow navigation arrows
* NEW: set slideshow speed
* NEW: set image size for slideshow
* NEW: Responsive styles
* NEW: additional large image size
* NEW: User HTML5 input types "number", "email" and "search"
* BUGFIX: don't resize original image
* BUGFIX: add CSS style inline using wp_add_inline_style()
* BUGFIX: Use esc_url() on URLs

= 3.1.8.3 =
* BUGFIX: fixed issue with search not working in testimonials.php template
* BUGFIX: fixed search templates
* BUGFIX: fixed some styling issues
* BUGFIX: fixed undefined index notice in widget control

= 3.1.8.2 =
* CHANGED: moved testimonials styles into style.css
* UPDATED: french translation
* UPDATED: some style changes

= 3.1.8.1 =
* NEW: additional security check if database column exists for dataset orderby to prevent sql injection
* BUGFIX: correctly loading stylesheet and javascript scripts
* BUGFIX: stripslashes on dataset name in widget
* REMOVED: template datasetform-petition.php

= 3.1.8 =
* NEW: Introducing separate media upload directories for each project
* NEW: export/import of media files in zip format (kept on server for 24h)
* NEW: include main image in dataset export
* NEW: add captcha security code to datasetform in frontend including timeout shortcode in minutes. Captchas older than 2h are deleted
* NEW: incorporated tiny image dimensions into project settings
* NEW: define image as mandatory field
* NEW: define return message and form submit button label in datasetform shortcode
* CHANGED: merged dataset-form templates in frontend and backend (keeping the old templates for now)
* UPDATED: updated testimonials templates design and include image display
* UPDATED: updated translation template
* BUGFIX: fixed issues with dataset import
* BUGFIX: fixed image upload in frontend dataset
* BUGFIX: fixed intinite loop for getting random datasets if there are not more datasets in the database than the number to obtain
* BUGFIX: fixed directory creation issue
* BUGFIX: fixed several stripslashes issues in project title, dataset names and metadata and formfield labels
* BUGFIX: fixed issue with duplicated countries in database upon multiple deactivation/activation of plugin

= 3.1.7.9 =
* NEW: updated TinyMCE button to allow formfield IDs and page IDs selection from dropdown menus

= 3.1.7.8 =
* BUGFIX: fixed infinite loop when getting random datasets without any datasets in database

= 3.1.7.7 =
* NEW: selection menu to filter for countries
* NEW: new list view template for testimonials
* UPDATED: updated TinyMCE button
* UPDATED: documentation update
* CHANGED: testimonials/petitions shortcode tag and templates
* BUGFIX: some small fixes regarding testimonials/petitions templates and shortcode

= 3.1.7.6 =
* BUGFIX: fixed error with dataset ordering by formfield and no limit to number of datasets per_page = "NaN"

= 3.1.7.5 =
* NEW: set limit for string length cut-off of textarea and TinyMCE Editor using the options field in the formfields in the format `limit:XX`
* BUGFIX: fixed index issue with multiple formfield options
* BUGFIX: fixed wrong page in backlink of single dataset if datasets are ordered by a formfield

= 3.1.7.4 =
* NEW: limit dataset name to 30 characters in frontend forms
* NEW: mark formfields as `private` to prevent display in frontend
* NEW: set maximum number of characters for formfields in the formfield options field in the format `max:XX`
* NEW: TinyMCE Button for petitions landingpage
* BUGFIX: fixed some styling issues with respect to formfield input width
* BUGFIX: ordering of datasets by formfields with pagination in frontend and admin panel
* BUGFIX: fixed search for country-type formfield (This only works searching for english country names!)
* REMOVED: option to set columns and rows for textarea

= 3.1.7.3 =
* NEW: new shortcode to display number of datasets of certain project in frontend
* NEW: updated TinyMCE button to include new shortcode and static function
* UPDATE: updated pot translation template
* UPDATE: updated german translation including countries names from MySQL database
* BUGFIX: filter country name through translation system and re-sort after translation

= 3.1.7.2 =
* NEW: mark formfields as mandatory to force data input
* NEW: mark formfields as unique to avoid double database
* NEW: new formfield type 'country' with selection dropdown retrieved from new MySQL database table consisting of 3-digit code and country name
* NEW: new template for simplified dataset form for petitions
* BUGFIX: fixed frontend dataset form

= 3.1.7.1 =
* UPDATE: German translation

= 3.1.7 =
* NEW: add default image for project, which is used for datasets without image
* NEW: only show images in frontend if setting is activated
* NEW: more options in TinyMCE Button
* UPDATE: code cleaning
* UPDATE: converted menu icons to grayscale to fit wordpress design
* BUGFIX: fixed some small bugs
* BUGFIX: fixed frontend templates to display multiple projects on the same page

= 3.1.6 =
* NEW: more functionalities with multiple projects on the same page including parallel pagination, search, category selection and dataset ordering

= 3.1.5 =
* NEW: multiple projects can be displayed on the same page with some limitations
* NEW: admin dashboard widget showing latest posts from wordpress support forum with editable options
* BUGFIX: fixed several small bugs

= 3.1.4 =
* BUGFIX: small fixes for better coding
* BUGFIX: fix htmlspecialchars problem with TinyMCE editor data

= 3.1.3 =
* NEW: function to easily display dropdown selection for all datasets of a project, see an example in templates/dataset.php for usage
* UPDATE: update main submit button classes to "button-primary"
* BUGFIX: fixed conflict with image edit function
* BUGFIX: several small bugfixes

= 3.1.2 =
* BUGFIX: fixed TinyMCE in frontent template

= 3.1.1 = 
* UPDATE: re-added TinyMCE editor as formfield type, which was broken

= 3.1 =
* UPDATE: compatible with Wordpress 4
* BUGFIX: administration works without Javascript
* BUGFIX: tinymce button
* SECURITY: fixed possible security issues
* REMOVED: AJAX editing was broken	

= 3.0.4 =
* UPDATE: French Translation

= 3.0.3 =
* NEW: Italian translation
* BUGFIX: formfields

= 3.0.2 =
* BUGFIX: only load javascript files on projectmanager pages to avoid malfunction of WP image editor

= 3.0.1 =
* BUGFIX: fixed css to avoid linebreak in gallery display

= 3.0 =
* NEW: documentation included with plugin
* UPDATED: Screenshots
* BUGFIX: empty property when form field label is empty
* BUGFIX: external fields, such as statistics from LeagueManager

= 2.9.8 =
* BUGFIX: dataset image got lost in search
* BUGFIX: date lost upon editing dataset
* BUGFIX: dataset meta data not available in single view
* BUGFIX: check if dataset and meta objects have values to avoid fatal error with empty property

= 2.9.7 =
* NEW: include dataset meta data in dataset object accesible through $dataset->LABEL. LABEL is the label of the formfield cleaned with the function sanitize_title. Use var_dump($dataset) to display object contents.

= 2.9.6 =
* BUGFIX: slideshow conflict with NextGen Gallery

= 2.9.5 =
* NEW: french translation

= 2.9.4 =
* BUGFIX: User registration when project is hooked into profile

= 2.9.3 =
* NEW: method to duplicate dataset
* NEW: sort formfield options alphabetically
* BUGFIX: import of datasets

= 2.9.2 =
* NEW: WP User field type
* NEW: custom fields with input callback functions
* BUGFIX: missed argument 'order' in project() function
* BUGFIX: division by zero bug in dataset.php with "NaN" datasets per page

= 2.9.1 =
* BUGFIX: TinyMCE Editor content displayed HTML tags

= 2.9 =
* NEW: time formfield
* NEW: filter for each formfield type *projectmanager_$type* (select, radio, checkbox, project all text)
* BUGFIX: strange PHP 4 bug

= 2.8.2 =
* BUGFIX: removed NumberFormatter from lib/ajax.php

= 2.8.1 =
* NEW: template tag for widget
* REMOVED: NumberFormatter caused syntax error for some webhosts

= 2.8 =
* NEW: widget with 2.8 API
* NEW: template tags

= 2.7.3 =
* BUGFIX: unable to delete all formfields

= 2.7.2 =
* BUGFIX: table template

= 2.7.1 =
* BUGFIX: parse error in lib/core.php line 713

= 2.7 =
* NEW: image upload formfield type
* NEW: video field with upload
* NEW: internal link to other project
* BUGFIX: dataset ordering

= 2.6 =
* NEW: shortcode attribute to limit number of results
* NEW: shortcode attribute to get datasets with specific meta key and meta value
* NEW: shortcode attribute to get random datasets with limit of results

= 2.5.8 =
* BUGIFX: call-time pass-by-reference deprecated

= 2.5.7 =
* BUGFIX: parse error

= 2.5.6 =
* CHANGED: moved AJAX functions to separate class in lib/ajax.php
* BUGFIX: chmod of image uploads
* BUGFIX: access control for editing datasets

= 2.5.5 =
* BUGFIX: access to dataset editing page with only cap 'projectmanager_user'
* BUGFIX: profile update

= 2.5.4 =
* BUGFIX: access control for adding/editing of datasets

= 2.5.3 =
* BUGFIX: access control for adding/editing of datasets
* code cleaning

= 2.5.2 =
* BUGFIX: profile hook

= 2.5.1 =
* BUGFIX: check for double datasets

= 2.5 =
* NEW: fine grained access control
* NEW: thickbox box for adding WP Users
* NEW: add dataset upon user registration if user has capablity
* NEW: profile Hook for any number of projects
* CHANGED: only users with matching datasets are shown form in profile

= 2.4.7 =
* NEW: display ID of dataset in admin overview

= 2.4.6 =
* BUGFIX: MySQL string to get datasets of certain category

= 2.4.5 =
* BUGFIX: options

= 2.4.4 =
* CHANGED: moved project settings into project table

= 2.4.3 =
* BUGFIX: display of admin menu icons
* CHANGED: moved main ProjectManager menu back down

= 2.4.2 =
* NEW: table template with tiny image
* BUGFIX: unsetting of widget option if deleted
* UPDATED: german translation with slideshow effects

= 2.4.1 =
* NEW: numeric and currency formfield types (require NumberFormatter or WP filter)
* NEW: filters projectmanager_numeric and projectmanager_currency for display
* BUGFIX: popup window size for newly added formfield options
* BUGFIX: image upload in user profile
* BUGFIX: single view in gallery template
* CHANGED: took out separate option for displaying image form in profile
* CHANGED: default limit on datasets of 15, use "NaN" for no limit

= 2.4 =
* NEW: custom icon directory in THEMEDIR/projectmanager/icons
* BUGFIX: dataset ordering is overriden by dropdown selection
* BUGFIX: IE Slideshow Bug fixed with new jQuery Cycle Plugin
* BUGFIX: Popup Window for Formfield Options
* BUGFIX: TinyMCE Button for searchform
* BUGFIX: total number of datasets in search
* CHANGED: use function add_object_page for menu if present
* CHANGED: use of jQuery Cycle Plugin for Slideshow

= 2.3 =
* NEW: URL and E-Mail with alternative text in format "www.example.com|Example Website"
* NEW: multiple widget support
* NEW: file-upload form field without AJAX uploading
* BUGFIX: AJAX editing if datafield value is empty
* BUGFIX: manual ordering of datasets
* BUGFIX: options link for select, checkbox and radio form types
* BUGFIX: save options for formfields
* CHANGED: apply stripslashes in function getDatasetMeta instead of getDatasetMetaData

= 2.2 =
* NEW: set file permission for image uploads
* NEW: image as new formfield type. Image needds to be uploaded already
* BUGFIX: AJAX editing of datasets
* BUGFIX: single and double quotes in names, formfields and formfield labels

= 2.1 =
* NEW: filter for formfields to enable bridging

= 2.0 =
* NEW: manual drag & drop sorting of datasets (ajax saving, but not updating tr class)
* NEW: set order of datasets in option
* NEW: more shortcode atts for project display
* NEW: delete image folder upon plugin uninstallation
* BUGFIX: dataset division by zero
* CHANGED: save image name in database also if file already exists

= 1.9 =
* NEW: show formfield ID on admin page
* NEW: shortcode supports ordering of datasets including TinyMCE Button
* BUGFIX: project deletion
* CHANGED: varchar lengths for project title, dataset name and image

= 1.8.2 =
* NEW: remove line breaks from form field values upon export
* BUGFIX: image upload and thumbnail creation

= 1.8.1 =
* BUGFIX: shortcode display of single dataset

= 1.8 =
* NEW: dataset ordering selection in frontend
* NEW: hook one project into profile
* NEW: set custom menu icon for each project
* NEW: shortcode to display single dataset
* NEW: template engine for frontend display
* CHANGED: new menu icons
* CHANGED: major restructuring of plugin
* CHANGED: shortcodes
* DELETED: Ajax adding of category dropdown in TinyMCE Button. Using text field for direct input of Category ID.

= 1.7 =
* NEW: sorting of datasets by form fields
* NEW: import/export of datasets from/to CSV file
* BUGFIX: form field saving

= 1.6.2 =
* CHANGED: moved image directory to wp-content/uploads

= 1.6.1 =
* BUGFIX: pretty permalinks

= 1.6 =
* NEW: Slideshow Widget
* CHANGED: usability enhancements

= 1.5 =
* NEW: coupled datasets to user id who entered them.

= 1.4 =
* NEW: selection, checkbox list, radio list form field types

= 1.3 =
* NEW: support for multiple categorization
* NEW: customization of dataset output via wordpress hooks
* NEW: search for category names (comma separated list of cat names)
* NEW: set colorschemes of tables

= 1.2.3 =
* NEW: option to add direct link to project in navigation panel
* BUGFIX: adding of new project failed

= 1.2.2 =
* BUGFIX: upgrade bug

= 1.2.1 =
* BUGFIX: database collation

= 1.2 =
* NEW: Ajax editing of datasets
* NEW: display of specific group only

= 1.1 =
* NEW: full control of display via shortcodes
* NEW: TinyMCE Button for better usability
* CHANGED: major restructuring of plugin

= 1.0 =
* initial release
