<?php 
/*
  Plugin Name: sSky Newsletter Form Integrating to Emarsys
  Plugin URI:  https://github.com/saskysamonte/ssky-wp-emarsys
  Description: WordPress Custom Form integrated to Emarsys marketing software
  Version:     1.0.0
  Author:      Sasky Samonte
  Author URI:  https://github.com/saskysamonte/
  License:     GPL2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.txt
  Domain Path: /languages/
  Text Domain: ssky-wp-emarsys
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
  
if ( ! defined( 'SSKY_WP_EMARSYS_VERSION' ) ) {
    define( 'SSKY_WP_EMARSYS_VERSION', '1.0.0' ); //DEFINED PLUGIN VERSION.
    define( 'SSKY_PHP_VERSION', phpversion() ); //DEFINED PHP VERSION.
    defined('SSKY_WP_EMARSYS_FILE') or define('SSKY_WP_EMARSYS_FILE', plugin_dir_url(__FILE__) );
}


/**
 * Plugin init hook.
 * @since 1.0.0
 */
add_action( 'plugins_loaded', 'ssky_wp_emarsys_plugin_init', 1 );

/**
 * Initialize plugin.
 * @since 1.0.0
 */
function ssky_wp_emarsys_plugin_init() {
    //require_once __DIR__ . '/ssky-wp-emarsys-api-class.php';
    require_once __DIR__ . '/ssky-wp-emarsys-form.php';
    require_once __DIR__ . '/ssky-wp-emarsys-class.php';
    new sSKY_WP_Emarsys();
}
