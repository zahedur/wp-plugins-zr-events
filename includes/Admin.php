<?php

namespace Zr\Events;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The admin class
 */
class Admin {

    function __construct()
    {
        new Admin\Menu();
    }
}