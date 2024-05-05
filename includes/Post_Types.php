<?php

namespace Zr\Events;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register custom post types and meta boxes.
 */
class Post_Types {

    /**
     * Initialize the class.
     */
    public function __construct() {
        add_action( 'init', [ $this, 'register_zr_events_post_type' ] );
        add_action( 'save_post', [ $this, 'zr_save_event_date_meta_box' ] );
    }

    /**
     * Register the 'zr-events' custom post type.
     */
    public function register_zr_events_post_type() {
        $labels = array(
            'name'                  => _x( 'ZR Events', 'Post Type General Name', 'zr-events' ),
            'singular_name'         => _x( 'ZR Event', 'Post Type Singular Name', 'zr-events' ),
            'menu_name'             => __( 'ZR Events', 'zr-events' ),
            'name_admin_bar'        => __( 'ZR Event', 'zr-events' ),
            'archives'              => __( 'Event Archives', 'zr-events' ),
            'attributes'            => __( 'Event Attributes', 'zr-events' ),
            'parent_item_colon'     => __( 'Parent Event:', 'zr-events' ),
            'all_items'             => __( 'All Events', 'zr-events' ),
            'add_new_item'          => __( 'Add New Event', 'zr-events' ),
            'add_new'               => __( 'Add New', 'zr-events' ),
            'new_item'              => __( 'New Event', 'zr-events' ),
            'edit_item'             => __( 'Edit Event', 'zr-events' ),
            'update_item'           => __( 'Update Event', 'zr-events' ),
            'view_item'             => __( 'View Event', 'zr-events' ),
            'view_items'            => __( 'View Events', 'zr-events' ),
            'search_items'          => __( 'Search Event', 'zr-events' ),
            'not_found'             => __( 'Not found', 'zr-events' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'zr-events' ),
            'featured_image'        => __( 'Featured Image', 'zr-events' ),
            'set_featured_image'    => __( 'Set featured image', 'zr-events' ),
            'remove_featured_image' => __( 'Remove featured image', 'zr-events' ),
            'use_featured_image'    => __( 'Use as featured image', 'zr-events' ),
            'insert_into_item'      => __( 'Insert into event', 'zr-events' ),
            'uploaded_to_this_item' => __( 'Uploaded to this event', 'zr-events' ),
            'items_list'            => __( 'Events list', 'zr-events' ),
            'items_list_navigation' => __( 'Events list navigation', 'zr-events' ),
            'filter_items_list'     => __( 'Filter events list', 'zr-events' ),
        );

        $args = array(
            'label'                 => __( 'ZR Event', 'zr-events' ),
            'description'           => __( 'Post Type Description', 'zr-events' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'post-formats' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );

        register_post_type( 'zr-events', $args );

        // Add meta box for event date
        add_action( 'add_meta_boxes', array( $this, 'add_event_date_meta_box' ) );
    }

    /**
     * Add meta box for event date.
     */
    public function add_event_date_meta_box() {
        add_meta_box(
            'zr-events-date',
            __( 'Event Date', 'zr-events' ),
            array( $this, 'render_event_date_meta_box' ),
            'zr-events',
            'normal',
            'default'
        );
    }

    /**
     * Render meta box for event date.
     */
    public function render_event_date_meta_box( $post ) {
        $event_date = get_post_meta( $post->ID, 'zr_events_date', true );
        ?>
        <label for="zr-events-date"><?php _e( 'Date:', 'zr-events' ); ?></label>
        <input type="date" id="zr-events-date" name="zr_events_date" value="<?php echo esc_attr( $event_date ); ?>">
        <?php
        wp_nonce_field( 'zr_events_date_nonce', 'zr_events_date_nonce' );
    }

    /**
     * Save event date meta box data.
     */
    public function zr_save_event_date_meta_box( $post_id ) {

        // Check if this is an autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check if nonce is set
        if ( ! isset( $_POST['zr_events_date_nonce'] ) || ! wp_verify_nonce( $_POST['zr_events_date_nonce'], 'zr_events_date_nonce' ) ) {
            return;
        }

        // Check if the current user has permission to edit the post
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Sanitize and save the event date
        if ( isset( $_POST['zr_events_date'] ) ) {
            $event_date = sanitize_text_field( $_POST['zr_events_date'] );
            update_post_meta( $post_id, 'zr_events_date', $event_date );
        }
    }

}
