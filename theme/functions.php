<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/user-profile-widget.php' );

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

  // wp_enqueue_script( 'jroc-high-charts', get_bloginfo( 'stylesheet_directory' ) . '/js/high-charts.js', array(  ), '1.0.0', true );

  wp_enqueue_script( 'jroc-darksky', get_bloginfo( 'stylesheet_directory' ) . '/js/darksky.js', array( 'jquery' ), '1.0.0' );

  wp_enqueue_script( 'jroc-modernizr', get_bloginfo( 'stylesheet_directory' ) . '/js/modernizr.js', array(), '3.3.1' );

	wp_enqueue_style( 'dashicons' );
	// wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat:400,700|Neuton:300,700', array(), CHILD_THEME_VERSION );

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


add_action( 'genesis_before', 'jroc_gtm_container' );
function jroc_gtm_container() {

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
	'id'          => 'home-features',
	'name'        => __( 'Home Features', 'jroc' ),
	'description' => __( 'This is the home features section.', 'jroc' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-social',
	'name'        => __( 'Home Social', 'jroc' ),
	'description' => __( 'This is the home social section.', 'jroc' ),
) );
genesis_register_sidebar( array(
  'id'          => 'board-member-profiles',
  'name'        => __( 'Board Members', 'jroc' ),
  'description' => __( 'Member Profiles', 'jroc' ),
  'before_title'  => '<p class="widget-title widgettitle">',
  'after_title'   => "</p>\n",
) );


add_filter( 'genesis_seo_title', 'jroc_site_title_logo' ,10, 3 );
function jroc_site_title_logo( $title, $inside, $wrap ) {

  $link = get_bloginfo( 'url' );
  $logo = file_get_contents( 'images/inline-logo.svg', true );

  return sprintf( '<%s class="site-title"><a href="%s">%s</a></%s>', $wrap, $link, $logo, $wrap );
}


add_action( 'genesis_header', 'jroc_weather_info' );
function jroc_weather_info() {

  if( !is_front_page() ) return;

  $transient = 'darksky-forecast';

  $url = sprintf( 'https://api.forecast.io/forecast/%s/%s,%s,%s', '0ee3b4a4c6b52530fa0cb0cfa0bee9ea', 37.528452, -77.456574, time() );

  // Check if our data has been cached
  if ( false === ( $forecast = get_transient( $transient ) ) ) {

    // It wasn't there, so regenerate the data and save the transient
    $forecast = jroc_dark_sky_request( $url );

    // Let's now save the new data
    set_transient( $transient, $forecast, 60 * 15 );
  }

  $icon        = $forecast['currently']['icon'];
  $temp        = $forecast['currently']['temperature'];
  $windSpeed   = $forecast['currently']['windSpeed'];
  $windBearing = $forecast['currently']['windBearing'];
  $visibility  = $forecast['currently']['visibility'];
  $pressure    = $forecast['currently']['pressure'];

  $html  = '<div class="weather-area">';

  $html .= '<p>Weather Conditions</p>';

  $html .= "<canvas class='dark-sky-metric dark-sky-icon' data-icon='{$icon}' width='128' height='128'></canvas>";

  $html .= "<span class='dark-sky-metric dark-sky-temp'><i class='wi wi-thermometer-exterior
'></i> {$temp}&#176;F</span>";

  $html .= "<span class='dark-sky-metric dark-sky-windspeed'><i class='wi wi-windy'></i> {$windSpeed} <span class='dark-sky-suffix'>mph</span></span>";

  $html .= '</div>';

  echo $html;
}


add_action( 'genesis_header', 'jroc_river_info' );
function jroc_river_info() {

  if( !is_front_page() ) return;


  $transient = 'westham-level';

  $url = 'http://waterservices.usgs.gov/nwis/iv/?format=json&sites=02037500';

  // Check if our data has been cached
  if ( false === ( $level = get_transient( $transient ) ) ) {

    // It wasn't there, so regenerate the data and save the transient
    $level = jroc_usgs_request( $url );

    // Let's now save the new data
    set_transient( $transient, $level, 60 * 15 );
  }

  $feet_second = number_format( $level['value']['timeSeries'][0]['values'][0]['value'][0]['value'] );
  $height      = $level['value']['timeSeries'][1]['values'][0]['value'][0]['value'];

  $html  = '<div class="river-area">';
  $html .= '<p>River Level</p>';
  $html .= "<span class='river-metric ft-per-second'>{$feet_second} ft&#179;/s</span>";
  $html .= "<span class='river-metric height'>{$height} ft</span>";
  $html .= '</div>';

  echo $html;
}


function jroc_usgs_request( $url ) {

  $response = wp_remote_get( $url );

  if ($response === false) {
      throw new \Exception('There was an error contacting the DarkSky API.');
  }

  $json = json_decode($response['body'], true);

  if ($json === null) {
    switch($error_code = json_last_error()) {
      case JSON_ERROR_SYNTAX:
          $reason = 'Bad JSON Syntax';
          break;
      case JSON_ERROR_CTRL_CHAR:
          $reason = 'Unexpected control character found';
          break;
      default:
          $reason = sprintf('Unknown error. Error code %s', $error_code);
          break;
    }

    throw new \Exception(sprintf('Unable to decode JSON response: %s', $reason));
  }

  return $json;
}


function jroc_dark_sky_request( $url ) {

  $response = wp_remote_get( $url );

  if ($response === false) {
      throw new \Exception('There was an error contacting the DarkSky API.');
  }

  $json = json_decode($response['body'], true);

  if ($json === null) {
    switch($error_code = json_last_error()) {
      case JSON_ERROR_SYNTAX:
          $reason = 'Bad JSON Syntax';
          break;
      case JSON_ERROR_CTRL_CHAR:
          $reason = 'Unexpected control character found';
          break;
      default:
          $reason = sprintf('Unknown error. Error code %s', $error_code);
          break;
    }

    throw new \Exception(sprintf('Unable to decode JSON response: %s', $reason));
  }

  return $json;
}


add_filter( 'genesis_footer_creds_text', 'jroc_footer_creds_text' );
function jroc_footer_creds_text( $creds ) {

  $url  = get_bloginfo( 'url' );
  $name = get_bloginfo( 'name' );

  $creds  = '<p>[footer_copyright] &middot ';
  $creds .= sprintf( '<a href="%s">%s</a> &middot 501(c)(3)</p>', $url, $name );
  $creds .= '<p>JROC c/o James River Park P.O. Box 297 Richmond, Va. 23219</p>';
  $creds .= '<a href="contact-us">Contact JROC</a> &middot [footer_loginout]';
  $creds .= '<p>Website hosting sponsored by <a id="footer-sponsor" href="http://www.albtechrva.com/">www.albtechrva.com</a></p>';

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
