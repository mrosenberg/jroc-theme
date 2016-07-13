<?php
/**
 * Template Name: Calendar
 *
 * @package JROC
 */



add_action( 'genesis_after_entry', 'jrp_calendar_widget');
function jrp_calendar_widget() {
  if( function_exists( 'CFS' ) ) echo CFS()->get( 'calendar_widget' );
}

genesis();


