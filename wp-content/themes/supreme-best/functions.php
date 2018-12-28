<?php

// register menus
register_nav_menus( array(
    'primary' => 'Primary Navigation',
));

// post thumbnails
add_theme_support( 'post-thumbnails' );

// ACF Options Page
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Website Settings',
        'menu_title'	=> 'Website Settings'
    ));
    acf_add_options_page(array(
		'page_title' 	=> 'Section Settings',
		'menu_title'	=> 'Section Settings'
	));
}

//add SVG to allowed file uploads
function add_file_types_to_uploads($file_types){

    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );

    return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');


// enqueue styles
function theme_enqueue_styles() {
    wp_enqueue_style( 'main', get_stylesheet_directory_uri().'/css/style.css', '' ); // main stylesheet
    wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,500,700,900', '' ); // google fonts

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// enqueue scripts
function theme_enqueue_scripts() {
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', '', '', ''); 
    wp_enqueue_script('jquery'); //jQuery
    wp_register_script('main', get_stylesheet_directory_uri().'/js/main.js', '', '', ''); 
    wp_enqueue_script('main'); //Main Scripts
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

/* EXCERPTS */
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt).'...';
  } else {
	$excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

//ADD EXCERPT SUPPORT
add_post_type_support( 'page', 'excerpt' );

//========================================================================================//
//==================================[DO NOT EDIT BELOW]==================================//
//=======================================================================================//

//=====================================[ADMIN BACKEND]=====================================//
// Remove homepage modules from the dashboard
add_action('admin_menu', function() {
    remove_meta_box('dashboard_right_now', 'dashboard', 'core');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
    remove_meta_box('dashboard_primary', 'dashboard', 'core');
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');
    remove_meta_box('dashboard_activity', 'dashboard', 'core');
});

// Remove the welcome panel and help tab
remove_action('welcome_panel', 'wp_welcome_panel');
add_action('admin_head', function() { get_current_screen()->remove_help_tabs(); });

// Remove pages fropm the admin menu
add_action('admin_init', function() {
    @remove_menu_page('link-manager.php');
    @remove_submenu_page('tools.php', 'ms-delete-site.php');
    @remove_submenu_page('themes.php', 'customize.php?return='.urlencode('/wp-admin/'));
});

// Remove nodes from the admin bar
add_action('admin_bar_menu', function($wp_admin_bar) {
    $wp_admin_bar->remove_node('wp-logo');
    $wp_admin_bar->remove_node('customize');
    $wp_admin_bar->remove_node('comments');
    $wp_admin_bar->remove_node('updates');
    $wp_admin_bar->remove_node('new-media');
    $wp_admin_bar->remove_node('new-user');
    $wp_admin_bar->remove_node('my-sites-list');
}, 999);
//======================================================================================================//
