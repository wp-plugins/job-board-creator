<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

// http://brassblogs.com/code-snippets/get-page-by-slug
function get_ID_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

add_filter( 'optionsframework_menu', function( $menu ) {
 	$menu['page_title'] = 'JBC';
	$menu['menu_title'] = 'JBC';
	$menu['capability'] = 'edit_theme_options';
	$menu['menu_slug'] = 'options-job';
	$menu['parent_slug'] = 'options-general.php';
	return $menu;
});

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */
add_filter( 'of_options', function($options) {


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}



	$options = array();

	$options[] = array(
		'name' => __( 'Basic Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( 'Listings Page', 'theme-textdomain' ),
		'desc' => __( 'This is used to determine where your listings will be shown.', 'theme-textdomain' ),
		'id' => 'job_listings_page',
		'type' => 'select',
		'std' => get_ID_by_slug('listings'),
		'options' => $options_pages
	);

	$options[] = array(
		'name' => __( 'Job Post/Edit Page', 'theme-textdomain' ),
		'desc' => __( 'This is used to determine which page your job post/edit form will appear.', 'theme-textdomain' ),
		'id' => 'job_form_page',
		'type' => 'select',
		'std' => get_ID_by_slug('post'),	
		'options' => $options_pages
		
	);
	

	$options[] = array(
		'name' => __( 'Profile Edit Page', 'theme-textdomain' ),
		'desc' => __( 'This allow users to edit their profile.', 'theme-textdomain' ),
		'id' => 'profile_edit_page',
		'type' => 'select',
		'std' => get_ID_by_slug('profile'),	
		'options' => $options_pages
		
	);
	
	
	$options[] = array(
		'name' => __( 'Default Post Status', 'theme-textdomain' ),
		'desc' => __( 'This is used to determine which status of a job post once it has been submitted (e.g. "publish", "pending review", etc.).', 'theme-textdomain' ),
		'id' => 'job_post_status',
		'std' => 'pending',	
		'type' => 'select',
		'options' => get_post_statuses()
	);	
	return $options;
});