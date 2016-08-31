<?php
/*
 Template Name: Board Members
 */



add_action( 'genesis_after_entry', 'jrp_board_member_sidebar');
function jrp_board_member_sidebar() {

  genesis_widget_area( 'board-member-profiles', array(
    'before'       => '<div class="board-member-profiles widget-area">',
    'after'        => '</div>'
  ) );

}

genesis();
