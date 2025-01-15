<?php
/**
 * Plugin Name:       weDevs
 * Plugin URI:        https://github.com/developerbayazid/
 * Description:       This is a short description of what plugin does.
 * Version:           1.0.0
 * Author:            Bayazid Hasan
 * Author URI:        https://github.com/developerbayazid/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       weDevs
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';

final class weDevs {

    private static $instance;

    private function __construct() {
        $this->define_constants();
        $this->load_classes();
    }

    public static function init() {
        if ( self::$instance ) {
            return self::$instance;
        }
        self::$instance = new self();
        return self::$instance;
    }

    private function define_constants() {
        define( 'WD_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
        define( 'WD_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
    }

    private function load_classes() {
        new WeDevs\Enqueue();
        new WeDevs\Admin_Menu();
        new WeDevs\Custom_Column();
        new WeDevs\Custom_Post();
        new WeDevs\Courses();
        new WeDevs\Shortcode();
        new WeDevs\Admin_Settings();
    }

}

weDevs::init();