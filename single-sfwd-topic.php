<?php

get_header();

?>

<div class="ld-wrapper" id="full-width-page-wrapper">

	<main class="site-main" id="main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
