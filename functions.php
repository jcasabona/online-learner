<?php
function online_learner_init() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action('init', 'online_learner_init' );

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );
    
    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_register_style( 'online-learner-fonts', '//fonts.googleapis.com/css?family=Merriweather:400,400i,700|Playfair+Display:700', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'online-learner-fonts' );
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array( 'online-learner-fonts' ), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'popper-scripts', get_template_directory_uri() . '/js/popper.min.js', array(), false);
    wp_enqueue_script( 'fitvids', get_stylesheet_directory_uri() . '/js/fitvids.js', array( 'jquery' ), true);
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array( 'fitvids' ), $the_theme->get( 'Version' ), true );
}


function online_learner_setup() {
    register_nav_menus( array(
        'top-bar' => __( 'Top Bar', 'online-learner' ),
    ) );

    register_sidebar( array(
        'name'          => __( 'LearnDash Widgets', 'online-learner' ),
        'id'            => 'learndash-widgets',
        'description'   => 'Learndash widget area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( '404', 'online-learner' ),
        'id'            => '404',
        'description'   => '404 Page widget area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'after_setup_theme', 'online_learner_setup' );

function custom_excerpt_more( $more ) {
	return '...';
}

function all_excerpts_get_more_link( $post_excerpt ) {
    return $post_excerpt . '<p><a class="online-learner-read-more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read More...',
    'understrap' ) . '</a></p>';
}


function online_learner_fitvids() {
?>
   <script>
        jQuery(document).ready(function($){
            $("body").fitVids();
        }); 
    </script>
<?php
}

add_action( 'wp_footer', 'online_learner_fitvids' );

function understrap_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="updated" datetime="%1$s">%2$s</time>';
        $time_string = sprintf( $time_string,
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );
	} else {
        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() )
        );
    }

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'understrap' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'understrap' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}

require get_stylesheet_directory() . '/inc/editor.php';