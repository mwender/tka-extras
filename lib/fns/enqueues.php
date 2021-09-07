<?php

namespace tka\enqueues;

function enqueue_scripts(){
  // Our custom styles
  $css_filename = TKA_PLUGIN_PATH . 'lib/' . TKA_CSS_DIR . '/main.css';
  if( file_exists( $css_filename ) )
    wp_enqueue_style( 'tka', TKA_PLUGIN_URL . 'lib/' . TKA_CSS_DIR . '/main.css', ['hello-elementor','elementor-frontend'], filemtime( $css_filename ) );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );

/**
 * Custom styles for the WP Admin
 */
function custom_admin_styles(){
  wp_enqueue_style( 'tka-admin-styles', TKA_PLUGIN_URL . 'lib/dist/admin.css', null, filemtime( TKA_PLUGIN_PATH . 'lib/dist/admin.css' ) );
}
add_action( 'admin_head', __NAMESPACE__ . '\\custom_admin_styles' );