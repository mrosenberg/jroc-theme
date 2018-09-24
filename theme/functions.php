<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Profile Widget
include_once( get_stylesheet_directory() . '/lib/user-profile-widget.php' );

//* River Level Widget
include_once( get_stylesheet_directory() . '/lib/river-level-widget.php' );

//* RVA Weather Widget
include_once( get_stylesheet_directory() . '/lib/weather-conditions-widget.php' );

//* Fundarising Widget
include_once( get_stylesheet_directory() . '/lib/fundraising-progress-widget.php' );


//* Login Form
include_once( get_stylesheet_directory() . '/lib/login-form.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'jroc', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'jroc' ) );

//* Add Image upload to WordPress Theme Customizer
add_action( 'customize_register', 'jroc_customizer' );
function jroc_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );

}

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'James River Outdoor Coalition', 'jroc' ) );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue scripts and style
add_action( 'wp_enqueue_scripts', 'jroc_enqueue_styles' );
function jroc_enqueue_styles() {

	wp_enqueue_script( 'jroc-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

  wp_enqueue_script( 'jroc-darksky', get_bloginfo( 'stylesheet_directory' ) . '/js/darksky.js', array( 'jquery' ), '1.0.0' );

  wp_enqueue_script( 'jroc-header-scroll', get_bloginfo( 'stylesheet_directory' ) . '/js/header-scroll.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );


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


//* Rename from email
add_filter( 'wp_mail_from', 'jroc_wp_mail_from' );
function jroc_wp_mail_from( $original_email_address ) {
  return 'hello@jroc.net';
}


//* Rename email from name
add_filter( 'wp_mail_from_name', 'jroc_wp_mail_from_name' );
function jroc_wp_mail_from_name( $original_email_from ) {
  return 'JROC';
}


add_action( 'genesis_before', 'jroc_gtm_container' );
function jroc_gtm_container() {

  if( WP_DEBUG ) return;

  echo "\r\n";
?>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P8SL33"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P8SL33');</script>
<!-- End Google Tag Manager -->

<?php
  echo "\r\n";

}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

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
  'id'          => 'home-social',
  'name'        => __( 'Home Social', 'jroc' ),
  'description' => __( 'This is the home social section.', 'jroc' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-features',
	'name'        => __( 'Home Features', 'jroc' ),
	'description' => __( 'This is the home features section.', 'jroc' ),
) );
genesis_register_sidebar( array(
  'id'          => 'board-member-profiles',
  'name'        => __( 'Board Members', 'jroc' ),
  'description' => __( 'Member Profiles', 'jroc' ),
  'before_title'  => '<p class="widget-title widgettitle">',
  'after_title'   => "</p>\n",
) );


add_filter( 'genesis_seo_title', 'jroc_site_title_logo', 10, 3 );
function jroc_site_title_logo( $title, $inside, $wrap ) {

  $link = get_bloginfo( 'url' );
  $logo = file_get_contents( 'images/inline-logo.svg', true );

  return sprintf( '<%s class="site-title"><a href="%s">%s</a></%s>', $wrap, $link, $logo, $wrap );
}




add_filter( 'genesis_footer_creds_text', 'jroc_footer_creds_text' );
function jroc_footer_creds_text( $creds ) {

  $url  = get_bloginfo( 'url' );
  $name = get_bloginfo( 'name' );

  if ( ! is_user_logged_in() )
    $link = '<a class="button" href="' . esc_url( wp_login_url() ) . '">' . __( 'Member log in' ) . '</a>';
  else
    $link = '<a class="button" href="' . esc_url( wp_logout_url() ) . '">' . __( 'Log out', 'genesis' ) . '</a>';


  $creds  = '<a class="button" href="contact-us">Contact JROC</a>';
  $creds .= $link;
  $creds .= sprintf(
    '<div><small>[footer_copyright] &middot <a href="%s">%s</a> &middot 501(c)(3) JROC c/o James River Park P.O. Box 297 Richmond, Va. 23219</small></div>',
    $url,
    $name
  );

  return $creds;
}



add_action( 'after_switch_theme', 'jroc_theme_setup' );
function jroc_theme_setup() {

  $capabilities = array(
    'switch_themes' => false,
    'activate_plugins' => false,
    'edit_plugins' => false,
    'install_plugins' => false,
    'edit_users' => false,
    'edit_files' => false,
    'manage_options' => false,
    'moderate_comments' => true,
    'manage_categories' => true,
    'upload_files' => true,
    'unfiltered_html' => false,
    'edit_posts' => true,
    'edit_others_posts' => true,
    'edit_published_posts' => true,
    'publish_posts' => true,
    'edit_posts' => true,
    'edit_pages' => true,
    'read' => true
  );

  add_role( 'board_member', __( 'Board Member' ), $capabilities );
}


add_action( 'admin_menu', 'jroc_cfs_disable_admin' );
function jroc_cfs_disable_admin() {

  if( !current_user_can( 'manage_options' ) ) {
    remove_menu_page( 'edit.php?post_type=cfs' );
    remove_menu_page( 'tools.php' );
  }
}
