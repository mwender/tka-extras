<?php

namespace sfgmedicare\enqueues;

/**
 * Custom styles for the WP Admin
 */
function custom_admin_styles(){
  wp_enqueue_style( 'myndyou-admin-styles', plugin_dir_url( __FILE__ ) . '../css/admin.css', null, filemtime( plugin_dir_path( __FILE__ ) . '../css/admin.css' ) );
}
add_action( 'admin_head', __NAMESPACE__ . '\\custom_admin_styles' );