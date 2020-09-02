<?php
namespace sk\core;

use sk\core\post_taxonomy\post_taxonomy as post_taxonomy;
use sk\core\variation\variation as variation;

class core {
    private static $instance;

    public $post_taxonomy, $variation;

    public function __construct() {
        $this->post_taxonomy = post_taxonomy::get_instance();
        $this->variation = variation::get_instance();
    }

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}