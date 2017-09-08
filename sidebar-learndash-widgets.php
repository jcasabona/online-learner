<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package understrap
 */

if ( ! is_active_sidebar( 'learndash-widgets' ) ) {
	return;
}

?>

<div class="col-md-4 widget-area learndash-widgets" id="right-sidebar" role="complementary">

<?php dynamic_sidebar( 'learndash-widgets' ); ?>

</div><!-- #secondary -->
