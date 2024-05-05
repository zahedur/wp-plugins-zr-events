<?php


namespace Zr\Events;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Installer
{
    /**
     * Installer constructor.
     */
    public function run() {
        $this->add_version();
    }

    public function add_version() {
        $installed = get_option( 'zr_events_installed' );
        if( ! $installed ) {
            update_option('zr_events_installed', time() );
        }
        update_option('zr_events_version', ZR_EVENTS_VERSION );
    }
}