<?php
/**
 * Plugin Name: ZR Events
 * Description: ZR Events is a WordPress plugin for managing events. It allows users to add, edit, and delete events with event dates, and provides a calendar view for easy event visualization.
 * Plugin URI: https://zahedur.com/zr-events
 * Author: Zahedur Rahman
 * Author URI: https://zahedur.com
 * Version: 1.0
 * License: GPL2
 * Text Domain: zr-events
 * License URI: https://www.gnu.org/license/gpl-2.0.html
 */

use Zr\Events\Installer;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */

final class ZR_Events {

    /**
     * Plugin version
     *
     * @return string
     */
    const version = '1.0';

    /**
     * ZR_EVENTS constructor.
     */
    function __construct() {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate'] );

        add_action( 'plugins_loaded', [$this, 'init_plugin' ] );


    }

    /**
     * Initialize a singleton instance
     *
     * @return bool|ZR_Events
     */
    public static function init() {
         static $instance = false;

         if ( ! $instance ) {
             $instance = new self();
         }

         return $instance;
    }

    public function define_constants() {
        define('ZR_EVENTS_VERSION', self::version);
        define('ZR_EVENTS_FILE', __FILE__ );
        define('ZR_EVENTS_PATH', __DIR__);
        define('ZR_EVENTS_URL', plugins_url( '', ZR_EVENTS_FILE ) );
        define('ZR_EVENTS_ASSETS', ZR_EVENTS_URL . '/assets');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new Zr\Events\Assets();

        new Zr\Events\Post_Types();

//        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

//        }

        if( is_admin() ){
            new Zr\Events\Admin();
        } else {
            new Zr\Events\Frontend();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {

        $installer = new Installer();
        $installer->run();
    }
}


/**
 * Initialize the main plugin
 *
 * @return bool|ZR_Events
 */
function zr_events() {
    return ZR_Events::init();
}

/**
 * lick of the plugin
 */
zr_events();