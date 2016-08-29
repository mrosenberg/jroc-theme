<?php
/**
 * Template Name: Calendar
 *
 * @package JROC
 */



add_action( 'genesis_after_entry', 'jrp_calendar_widget');
function jrp_calendar_widget() {
?>

  <iframe class="full-calendar" name="cw_frame" width="100%" height="1000" src="//www.calendarwiz.com/calendars/calendar.php?crd=jrpcalendar&cid[]=159455&cid[]=164417&cid[]=161764&cid[]=159456&cid[]=160845&cid[]=161752&cid[]=162126">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
<?php
}

genesis();


