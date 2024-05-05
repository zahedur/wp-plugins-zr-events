<?php

namespace Zr\Events\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * The menu handler class
 */
class Menu 
{
    function __construct()
    {
        add_action('admin_menu', [ $this, 'admin_menu' ] );
    }

    public function admin_menu() {
        add_submenu_page(
            'edit.php?post_type=zr-events',
            esc_html__('Events calendar', 'zr-events'),
            esc_html__('Events calendar', 'zr-events'),
            'manage_options',
            'zr-events-calendar',
            [$this, 'zr_events_calenders']
        );
    }

    public function zr_events_calenders(){

        $this->enqueue_assets();
        $events = new Events_Calendars();
        $events->plugin_page();
    }

    public function enqueue_assets() {
        wp_enqueue_style('zr-events-admin-style');
        wp_enqueue_script('zr-events-admin-script');
    }
}
