<?php


add_action( 'login_enqueue_scripts', 'jroc_login_styles' );
function jroc_login_styles() {
    wp_enqueue_style( 'jroc-login-styles', get_stylesheet_directory_uri() . '/login.css' );
}
