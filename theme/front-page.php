<?php
/**
 * This file adds the Home Page to the Remobile Pro Theme.
 *
 * @author StudioPress
 * @package Remobile
 * @subpackage Customizations
 */

//* Enqueue scripts for backstretch
add_action( 'wp_enqueue_scripts', 'jroc_front_page_enqueue_scripts' );
function jroc_front_page_enqueue_scripts() {

	$image = get_option( 'jroc-backstretch-image', sprintf( '%s/images/home-intro.jpg', get_stylesheet_directory_uri() ) );

	//* Load scripts only if custom backstretch image is being used
	if ( ! empty( $image ) ) {

		//* Enqueue Backstretch scripts
		wp_enqueue_script( 'jroc-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );
		wp_enqueue_script( 'jroc-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'jroc-backstretch' ), '1.0.0' );

		wp_localize_script( 'jroc-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', $image ) ) );

	}

}

//* Add widget support for homepage. If no widgets active, display the default loop.
add_action( 'genesis_meta', 'jroc_home_genesis_meta' );
function jroc_home_genesis_meta() {

	if ( is_active_sidebar( 'home-intro' ) || is_active_sidebar( 'home-pricing' ) || is_active_sidebar( 'home-features' ) || is_active_sidebar( 'home-twitter' ) ) {

		//* Add jroc-home body class
		add_filter( 'body_class', 'jroc_body_class' );
		function jroc_body_class( $classes ) {

   			$classes[] = 'jroc-home';
  			return $classes;

		}

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

		//* Add homepage widgets
		add_action( 'genesis_before_loop', 'jroc_homepage_widgets' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Remove elements of the entry
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
		remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	}
}

//* Add markup for homepage widgets
function jroc_homepage_widgets() {

	genesis_widget_area( 'home-intro', array(
		'before' => '<div class="home-section home-intro widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

  genesis_widget_area( 'home-social', array(
    'before' => '<div class="home-section home-social widget-area"><div class="wrap">',
    'after'  => '</div></div>',
  ) );

	genesis_widget_area( 'home-features', array(
		'before' => '<div class="home-section home-features widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );



}

genesis();
