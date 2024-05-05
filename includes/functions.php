<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Fetch Addresses
 *
 * @param  array  $args
 *
 * @return array
 */
function zr_events_get_all_events( $args = [] ) {
    global $wpdb;

    $sql = $wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE post_type = %s AND post_status = %s", 'zr-events', 'publish');

    $items = $wpdb->get_results( $sql );

    return $items;
}
