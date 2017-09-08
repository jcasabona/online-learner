<?php
/**
 * The template for displaying a 404 Error.
 *
 * @package understrap
 */

get_header();
$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>

<div class="blog-wrapper" id="single-wrapper">

<div class="center bg-image">
<header class="entry-header">

		<h1>Oh no! It's a 404!</h1>

		<div class="entry-meta">

			<p>So it looks like whatever page you're looking for is lost in the ether. But hey...here's some other stuff for you instead!</p>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->
</div>

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>

			<main class="site-main not-found-widgets" id="main">
				<?php dynamic_sidebar( '404' ); ?>
			</main><!-- #main -->

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>

			<?php get_sidebar( 'right' ); ?>

		<?php endif; ?>

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
