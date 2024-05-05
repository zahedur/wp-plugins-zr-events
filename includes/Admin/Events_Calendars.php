<?php


namespace Zr\Events\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Class Events_Calendars
 * @package Zr\Events\Admin;
 */
class Events_Calendars  {

    public function __construct() {

    }

    public function plugin_page() {

        $zr_events = zr_events_get_all_events();
        // Prepare event data for JavaScript
        $event_data = array_map(function($event) {

            $event_date = get_post_meta($event->ID, 'zr_events_date', true);
            return [
                'date' => $event_date,
                'event_url' => get_the_permalink($event->ID),
                'event_title' => $event->post_title,
            ];
        }, $zr_events);
        // Pass event data to JavaScript
        wp_localize_script('zr-events-admin-script', 'zrEventData', $event_data);

        $template = __DIR__ . '/views/events-calendars.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

}