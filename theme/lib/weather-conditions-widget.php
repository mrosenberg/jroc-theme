<?php

class RVA_Weather_Conditions extends WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    $widget_ops = array(
      'classname' => 'rva-weather-conditions',
      'description' => 'Richmond Current Weather',
    );
    parent::__construct( 'RVA_Weather_Consitions', 'Richmond Current Weather', $widget_ops );
  }



  private function jroc_dark_sky_request( $url ) {

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

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
    $title     = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
    $transient = 'darksky-forecast';
    $url       = sprintf( 'https://api.forecast.io/forecast/%s/%s,%s,%s', '0ee3b4a4c6b52530fa0cb0cfa0bee9ea', 37.528452, -77.456574, time() );

    // Check if our data has been cached
    if ( false === ( $forecast = get_transient( $transient ) ) ) {

      // It wasn't there, so regenerate the data and save the transient
      $forecast = $this->jroc_dark_sky_request( $url );

      // Let's now save the new data
      set_transient( $transient, $forecast, 60 * 15 );
    }

    $icon        = $forecast['currently']['icon'];
    $temp        = $forecast['currently']['temperature'];
    $windSpeed   = $forecast['currently']['windSpeed'];
    $windBearing = $forecast['currently']['windBearing'];
    $visibility  = $forecast['currently']['visibility'];
    $pressure    = $forecast['currently']['pressure'];

    $html  = $args['before_widget'];
    $html .= $args['before_title'];
    $html .= $title;
    $html .= $args['after_title'];

    $html .= '<div class="one-half">';
    $html .= "<canvas class='dark-sky-metric dark-sky-icon' data-icon='{$icon}' width='128' height='128'></canvas>";
    $html .= '</div>';
    $html .= '<div class="one-half">';
    $html .= "<p class='dark-sky-metric dark-sky-temp'><i class='wi wi-thermometer-exterior'></i> {$temp}&#176;F</p>";
    $html .= "<p class='dark-sky-metric dark-sky-windspeed'><i class='wi wi-windy'></i> {$windSpeed} <span class='dark-sky-suffix'>mph</span></p>";
    $html .= '</div>';
    $html .= $args['after_widget'];

    echo $html;

  }

  /**
   * Outputs the options form on admin
   *
   * @param array $instance The widget options
   */
  public function form( $instance ) {
    $title      = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
    $title_id   = esc_attr( $this->get_field_id( 'title'   ) );
    $title_name = esc_attr( $this->get_field_name( 'title' ) );

    $html  = '<p>';
    $html .= sprintf( '<label for="%s">%s</label>', $title_name, $title );
    $html .= sprintf( '<input class="widefat" id="%s" name="%s" type="text" value="%s">', $title_id, $title_name, esc_attr( $title ) );
    $html .= '</p>';

    echo $html;
  }

  /**
   * Processing widget options on save
   *
   * @param array $new_instance The new options
   * @param array $old_instance The previous options
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    return $instance;
  }
}

add_action( 'widgets_init', function(){
  register_widget( 'RVA_Weather_Conditions' );
});
