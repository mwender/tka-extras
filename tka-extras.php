<?php
/**
 * Plugin Name:     TKA Extras
 * Plugin URI:      https://github.com/mwender/tka-extras
 * Description:     Various extensions for The King's Academy website
 * Author:          TheWebist
 * Author URI:      https://mwender.com
 * Text Domain:     tka-extras
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Tka_Extras
 */

// Your code starts here.
$css_dir = ( stristr( site_url(), '.local' ) || SCRIPT_DEBUG )? 'css' : 'dist' ;
define( 'TKA_CSS_DIR', $css_dir );
define( 'TKA_DEV_ENV', stristr( site_url(), '.local' ) );
define( 'TKA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'TKA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load Composer dependencies
if( file_exists( TKA_PLUGIN_PATH . 'vendor/autoload.php' ) ){
  require_once TKA_PLUGIN_PATH . 'vendor/autoload.php';
} else {
  add_action( 'admin_notices', function(){
    $class = 'notice notice-error';
    $message = __( 'Missing required Composer libraries. Please run `composer install` from the root directory of this plugin.', 'tka' );
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
  } );
}


// Load required files
require_once( TKA_PLUGIN_PATH . 'lib/fns/acf-json-save-point.php' );
require_once( TKA_PLUGIN_PATH . 'lib/fns/admin-custom-columns.php' );
require_once( TKA_PLUGIN_PATH . 'lib/fns/enqueues.php' );
require_once( TKA_PLUGIN_PATH . 'lib/fns/search.php' );
require_once( TKA_PLUGIN_PATH . 'lib/fns/shortcodes.php' );
require_once( TKA_PLUGIN_PATH . 'lib/fns/templates.php' );
require_once( TKA_PLUGIN_PATH . 'lib/fns/utilities.php' );

/**
 * Enhanced logging.
 *
 * @param      string  $message  The log message
 */
if( ! function_exists( 'uber_log' ) ){
  function uber_log( $message = null ){
    static $counter = 1;

    $bt = debug_backtrace();
    $caller = array_shift( $bt );

    if( 1 == $counter )
      error_log( "\n\n" . str_repeat('-', 25 ) . ' STARTING DEBUG [' . date('h:i:sa', current_time('timestamp') ) . '] ' . str_repeat('-', 25 ) . "\n\n" );
    error_log( "\n" . $counter . '. ' . basename( $caller['file'] ) . '::' . $caller['line'] . "\n" . $message . "\n---\n" );
    $counter++;
  }
}

