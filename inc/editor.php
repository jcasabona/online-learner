<?php
/**
 * Understrap modify editor
 *
 * @package understrap
 */

/**
 * Registers an editor stylesheet for the theme.
 */
function online_learner_google_fonts() {
    wp_enqueue_style( 'online-learner-fonts' );
}

add_action( 'admin_enqueue_scripts', 'online_learner_google_fonts' );

function online_learner_add_editor_styles() {
  add_editor_style( 'css/custom-editor-style.css?20170929' );
}

remove_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );
add_action( 'admin_init', 'online_learner_add_editor_styles' );