<?php
/**
 * Plugin Name:     SFG Medicare Extras
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Various extensions for the SFG Medicare website
 * Author:          TheWebist
 * Author URI:      https://mwender.com
 * Text Domain:     sfgmedicare-extras
 * Domain Path:     /languages
 * Version:         0.2.0
 *
 * @package         Sfgmedicare_Extras
 */

// Your code starts here.
define( 'SFG_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'SFG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once( SFG_PLUGIN_PATH . 'lib/fns/acf-json-save-point.php' );
require_once( SFG_PLUGIN_PATH . 'lib/fns/shortcodes.php' );
require_once( SFG_PLUGIN_PATH . 'lib/fns/utilities.php' );

/**
 * Enhanced logging.
 *
 * @param      string  $message  The log message
 */
function uber_log( $message = null ){
  static $counter = 1;

  $bt = debug_backtrace();
  $caller = array_shift( $bt );

  if( 1 == $counter )
    error_log( "\n\n" . str_repeat('-', 25 ) . ' STARTING DEBUG [' . date('h:i:sa', current_time('timestamp') ) . '] ' . str_repeat('-', 25 ) . "\n\n" );
  error_log( "\n" . $counter . '. ' . basename( $caller['file'] ) . '::' . $caller['line'] . "\n" . $message . "\n---\n" );
  $counter++;
}