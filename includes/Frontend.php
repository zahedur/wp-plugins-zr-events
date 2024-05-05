<?php

namespace Zr\Events;

use Zr\Events\Frontend\Event;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Frontend handler class
 */

 class Frontend {

    function __construct()
    {
        new Event();
    }
 }