<?php

function tka_acf_json_save_point( $path ) {
  // update path
  $path = plugin_dir_path( __FILE__ ) . '../acf-json';

  // return
  return $path;
}
add_filter('acf/settings/save_json', 'tka_acf_json_save_point');

function tka_acf_json_load_point( $paths ) {
    // remove original path
    unset($paths[0]);

    // append path
    $paths[] = plugin_dir_path( __FILE__ ) . '../acf-json';

    // return
    return $paths;
}
add_filter('acf/settings/load_json', 'tka_acf_json_load_point');