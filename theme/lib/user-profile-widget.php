<?php


class User_Profile extends WP_Widget {


  public $current_user;



  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    $widget_ops = array(
      'classname'   => 'user-profile',
      'description' => 'User Profile',
    );
    parent::__construct( 'User_Profile', 'User Profile', $widget_ops );
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {

    $user  = get_userdata( $instance['user_id'] );
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

    if( function_exists( 'get_fields' ) ) :
      $field_id  = "user_{$instance['user_id']}";
      $user_meta = get_fields( $field_id );
    endif;

    $src    = wp_get_attachment_image_url(    $user_meta['profile_photo'], 'medium' );
    $srcset = wp_get_attachment_image_srcset( $user_meta['profile_photo'], 'medium' );
    $sizes  = wp_get_attachment_image_sizes(  $user_meta['profile_photo'], 'medium' );

    $html  = $args['before_widget'];
    $html .= sprintf( '<img src="%s" srcset="%s" sizes="%s"/>', $src, $srcset, $sizes );
    $html .= $args['before_title'];
    $html .= $user->data->display_name;
    $html .= $args['after_title'];
    $html .= sprintf( '<p><small>%s</small></p>', $user_meta['position'] );
    $html .= $args['after_widget'];

    echo $html;
  }


  /**
   * Outputs the content of the widget
   *
   * @param object $user
   * @private
   */
  private function format_option( $user ) {
    return sprintf(
      '<option value="%d" %s>%s</option>',
      $user->ID,
      selected( $user->ID, $this->current_user->ID, false ),
      $user->data->display_name
    );
  }


  /**
   * Outputs the options form on admin
   *
   * @param array $instance The widget options
   */
  public function form( $instance ) {

    $this->current_user = $user = $instance['user_id'] ? get_userdata( $instance['user_id'] ) : FALSE;

    $title_id   = esc_attr( $this->get_field_id( 'title'           ) );
    $title_name = esc_attr( $this->get_field_name( 'title'         ) );
    $user_id    = esc_attr( $this->get_field_id( 'user'            ) );
    $user_name  = esc_attr( $this->get_field_name( 'user'          ) );
    $users      = get_users( array( 'role' => 'board_member'       ) );
    $options    = array_map( array( $this, 'format_option' ), $users );

    $html  = '<p>';
    $html .= sprintf(
      '<label for="%s">%s</label>: ',
      $user_id,
      'Board Member'
    );
    $html .= sprintf(
      '<select id="%s" name="%s">%s</select>',
      $user_id,
      $user_name,
      implode( '', $options )
    );
    $html .= '</p>';

    $html .= sprintf(
      '<input type="hidden" id="%s" name="%s" value="%s"/>',
      $title_id,
      $title_name,
      $user->data->display_name
    );

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

    $instance['user_id'] = ( ! empty( $new_instance['user'] ) ) ? strip_tags( $new_instance['user'] ) : NULL;

    if( $instance['user_id'] ) {
      $user = get_userdata( $instance['user_id'] );
      $instance['title'] = $user->data->display_name;
    }

    return $instance;
  }
}


add_action( 'widgets_init', function(){
  register_widget( 'User_Profile' );
});
