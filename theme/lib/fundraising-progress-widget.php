<?php

class JROC_Fundraising_Indicator extends WP_Widget {


  public function __construct() {
    $widget_ops = array(
      'classname' => 'jroc-fundraising-widget',
      'description' => 'A nice visual for our success',
    );
    parent::__construct( 'JROC_Fundraising_Indicator', 'Fundarising Level', $widget_ops );
  }



  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
    $title     = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

    $percent_to_goal = ( $instance[ 'current' ] / $instance[ 'goal' ] ) * 100;
    $has_end         = !empty( $instance[ 'end_date' ] );

    if( $has_end ) {

      $now       = new DateTime;
      $end_date  = DateTime::createFromFormat( 'Y-m-d', $instance[ 'end_date' ] );
      $days_left = $end_date->diff( $now )->format( '%a' );
    }



    $html  = $args['before_widget'];
    $html .= $args['before_title'];
    $html .= $title;

    $html .= sprintf(
      '<div class="goal">$%s</div>',
      number_format( $instance[ 'goal' ] )
    );

    $html .= sprintf(
      '<div class="meter">
        <div style="width:%s;" class="progress"></div>
      </div>',
      $percent_to_goal . '%'
    );

    $html .= '<div class="stats">';

    $html .= sprintf(
      '<dl><dt>%d&#37;</dt><dd>Funded</dd></dl>',
      $percent_to_goal
    );

    $html .= sprintf(
      '<dl><dt>$%s</dt><dd>Raised</dd></dl>',
      number_format( $instance[ 'current' ] )
    );

    if( $has_end ) {

      $html .= sprintf(
        '<dl><dt>%s</dt><dd>Days Left</dd></dl>',
        $days_left
      );

    }

    $html .= '</div>';


    $html .= $args['after_title'];
    $html .= $args['after_widget'];

    echo $html;
  }


  /**
   * Outputs the options form on admin
   *
   * @param array $instance The widget options
   */
  public function form( $instance ) {
    $title         = empty( $instance[ 'title' ] ) ? __( 'New title', 'text_domain' ) : esc_attr( $instance[ 'title' ] );
    $title_id      = esc_attr( $this->get_field_id( 'title'   ) );
    $title_name    = esc_attr( $this->get_field_name( 'title' ) );

    $goal          = empty( $instance[ 'goal' ] ) ?  0 : esc_attr( $instance[ 'goal' ] );
    $goal_id       = esc_attr( $this->get_field_id( 'goal'   ) );
    $goal_name     = esc_attr( $this->get_field_name( 'goal' ) );

    $current       = empty( $instance[ 'current' ] ) ?  0 : esc_attr( $instance[ 'current' ] );
    $current_id    = esc_attr( $this->get_field_id( 'current'   ) );
    $current_name  = esc_attr( $this->get_field_name( 'current' ) );

    $end_date      = empty( $instance[ 'end_date' ] ) ? null : esc_attr( $instance[ 'end_date' ] );
    $end_date_id   = esc_attr( $this->get_field_id( 'end_date'   ) );
    $end_date_name = esc_attr( $this->get_field_name( 'end_date' ) );

    $html  = '<p>';
    $html .= sprintf( '<label for="%s">%s</label>', $title_name, 'Title:' );
    $html .= sprintf(
      '<input class="widefat" id="%s" name="%s" type="text" value="%s">',
      $title_id,
      $title_name,
      $title
    );
    $html .= '</p>';


    $html .= '<p>';
    $html .= sprintf( '<label for="%s">%s</label>', $goal_name, 'Goal:' );
    $html .= sprintf(
      '<input class="widefat" id="%s" name="%s" type="text" value="%s">',
      $goal_id,
      $goal_name,
      $goal
    );
    $html .= '</p>';

    $html .= '<p>';
    $html .= sprintf( '<label for="%s">%s</label>', $current_name, 'Current Level:' );
    $html .= sprintf(
      '<input class="widefat" id="%s" name="%s" type="text" value="%s">',
      $current_id,
      $current_name,
      $current
    );
    $html .= '</p>';

    $html .= '<p>';
    $html .= sprintf( '<label for="%s">%s</label>', $end_date_name, 'End Date:' );
    $html .= sprintf(
      '<input class="widefat" id="%s" name="%s" type="date" value="%s">',
      $end_date_id,
      $end_date_name,
      $end_date
    );
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
    $instance[ 'title'    ] = empty( $new_instance[ 'title'   ]  ) ?  '' : strip_tags( $new_instance[ 'title' ] );
    $instance[ 'goal'     ] = empty( $new_instance[ 'goal'    ]  ) ?  0  : intval( $new_instance[ 'goal' ]      );
    $instance[ 'current'  ] = empty( $new_instance[ 'current' ]  ) ?  0  : intval( $new_instance[ 'current' ]   );

    if( !empty( $new_instance[ 'end_date' ] ) ) {
      $instance[ 'end_date' ] =  $new_instance[ 'end_date' ];
    }

    return $instance;
  }
}

add_action( 'widgets_init', function(){
  register_widget( 'JROC_Fundraising_Indicator' );
});
