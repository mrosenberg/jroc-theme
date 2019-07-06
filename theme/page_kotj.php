<?php

/*
Template Name: KOTJ Landing
*/


//* Add landing body class to the head
add_filter( 'body_class', 'jroc_add_body_class' );
function jroc_add_body_class( $classes ) {

	$classes[] = 'kotj-landing';
	return $classes;

}

add_action( 'genesis_before_entry', 'jroc_kotj_top_sidebar' );
function jroc_kotj_top_sidebar() {
    genesis_widget_area( 'kotj-landing-top' );
}

add_action( 'genesis_after_entry', 'jroc_kotj_bottom_sidebar' );
function jroc_kotj_bottom_sidebar() {
    genesis_widget_area( 'kotj-landing-bottom' );
}

//* Run the Genesis loop
genesis();