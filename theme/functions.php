<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'jroc', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'jroc' ) );

//* Add Image upload to WordPress Theme Customizer
add_action( 'customize_register', 'jroc_customizer' );
function jroc_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );

}

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Remobile Pro Theme', 'jroc' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/jroc/' );
define( 'CHILD_THEME_VERSION', '1.0.2' );

//* Enqueue scripts and style
add_action( 'wp_enqueue_scripts', 'jroc_enqueue_styles' );
function jroc_enqueue_styles() {

	wp_enqueue_script( 'jroc-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat:400,700|Neuton:300,700', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 320,
	'height'          => 80,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Remove layout section from Theme Customizer
add_action( 'customize_register', 'jroc_customize_register', 16 );
function jroc_customize_register( $wp_customize ) {

	$wp_customize->remove_section( 'genesis_layout' );

}

//* Unregister sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Force full-width-content layout setting
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'footer-widgets',
) );

//* Rename primary and secondary navigation menus
add_theme_support( 'genesis-menus' , array( 'primary' => __( 'Before Header Menu', 'jroc' ), 'secondary' => __( 'Footer Menu', 'jroc' ) ) );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 5 );

//* Reduce the primary navigation menu to one level depth
add_filter( 'jroc_primary_menu_args', 'jroc_primary_menu_args' );
function jroc_primary_menu_args( $args ){

	if( 'primary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'jroc_secondary_menu_args' );
function jroc_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'jroc_author_box_gravatar' );
function jroc_author_box_gravatar( $size ) {

	return 170;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'jroc_comments_gravatar' );
function jroc_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;

	return $args;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-intro',
	'name'        => __( 'Home Intro', 'jroc' ),
	'description' => __( 'This is the home intro section.', 'jroc' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-pricing',
	'name'        => __( 'Home Pricing', 'jroc' ),
	'description' => __( 'This is the home pricing section.', 'jroc' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-features',
	'name'        => __( 'Home Features', 'jroc' ),
	'description' => __( 'This is the home features section.', 'jroc' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-social',
	'name'        => __( 'Home Social', 'jroc' ),
	'description' => __( 'This is the home social section.', 'jroc' ),
) );
