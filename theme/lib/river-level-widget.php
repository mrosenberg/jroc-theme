<?php

class JROC_River_Level extends WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    $widget_ops = array(
      'classname' => 'jroc-river-level',
      'description' => 'Westham Gauge',
    );
    parent::__construct( 'JROC_River_Level', 'JROC River Level', $widget_ops );
  }


  private function jroc_usgs_request( $url ) {

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
    $transient = 'westham-level';
    $url       = 'http://waterservices.usgs.gov/nwis/iv/?format=json&sites=02037500';

    // Check if our data has been cached
    if ( false === ( $level = get_transient( $transient ) ) ) {

      // It wasn't there, so regenerate the data and save the transient
      $level = $this->jroc_usgs_request( $url );

      // Let's now save the new data
      set_transient( $transient, $level, 60 * 15 );
    }

    $feet_second = number_format( $level['value']['timeSeries'][0]['values'][0]['value'][0]['value'] );
    $height      = $level['value']['timeSeries'][1]['values'][0]['value'][0]['value'];

    $html  = $args['before_widget'];
    $html .= $args['before_title'];
    $html .= $title;
    $html .= $args['after_title'];
    $html .= "<p class='river-metric ft-per-second'>{$feet_second} ft&#179;/s</p>";
    $html .= "<p class='river-metric height'>{$height} ft</p>";
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
  register_widget( 'JROC_River_Level' );
});
