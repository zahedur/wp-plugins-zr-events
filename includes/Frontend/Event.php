<?php

namespace Zr\Events\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Shortcode handler class
 */
class Event {
     
    /**
     * Initialize the class
     */
    function __construct()
    {
        add_filter('the_content', [$this, 'show_event_date']);
    }


    public function show_event_date($content) {
        // Check if this is a single event post
        if (is_singular('zr-events')) { // Replace 'zr-events' with your actual event post type slug

            wp_enqueue_style('zr-events-style');
            wp_enqueue_script('zr-events-script');

            // Retrieve event date from post meta
            $event_date = get_post_meta(get_the_ID(), 'zr_events_date', true);

            // If event date exists, append it to the content
            if ($event_date) {
                $event_date_html = '<div class="zr-event-date-show">Event Date: ' . date('F j, Y', strtotime($event_date)) . '</div>';
                $content .= $event_date_html;
            }
        }

        return $content;
    }

}