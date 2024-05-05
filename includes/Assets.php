<?php


namespace Zr\Events;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Assets handlers class
 */
class Assets
{
    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'zr-events-script' => [
                'src'     => ZR_EVENTS_ASSETS . '/js/frontend.js',
                'version' => filemtime( ZR_EVENTS_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'zr-events-admin-script' => [
                'src'     => ZR_EVENTS_ASSETS . '/js/admin.js',
                'version' => filemtime( ZR_EVENTS_PATH . '/assets/js/admin.js' ),
                'deps'    => [ 'jquery', 'wp-util' ]
            ],
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'zr-events-style' => [
                'src'     => ZR_EVENTS_ASSETS . '/css/frontend.css',
                'version' => filemtime( ZR_EVENTS_PATH . '/assets/css/frontend.css' )
            ],
            'zr-events-admin-style' => [
                'src'     => ZR_EVENTS_ASSETS . '/css/admin.css',
                'version' => filemtime( ZR_EVENTS_PATH . '/assets/css/admin.css' )
            ]

        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

    }
}