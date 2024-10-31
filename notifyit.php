<?php
/**
 * Plugin Name:       Notifyit
 * Plugin URI:        https://wordpress.org/plugins/notifyit/
 * Description:       Add stylish notification on your website.
 * Version:           1.0.1
 * Requires at least: 4.7
 * Requires PHP:      5.2.4
 * Author:            Jahidur Nadim
 * Author URI:        https://github.com/nadim1992/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://wordpress.org/plugins/notifyit/
 * Text Domain:       notifyit
 * Domain Path:       /languages
 */

// Make sure we don't expose any info if called directly.
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'NOTIFYIT_VERSION', '1.0.1' );
define( 'NOTIFYIT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'NOTIFYIT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if ( is_admin() ) {
    require_once( NOTIFYIT_PLUGIN_DIR . 'admin/notifyit-admin.php' );
    add_action( 'init', array( 'NotifyItAdmin', 'init' ) );
}

require_once( NOTIFYIT_PLUGIN_DIR . 'class.frontend.php' );
add_action( 'init', array( 'NotifyFront', 'init' ) );
