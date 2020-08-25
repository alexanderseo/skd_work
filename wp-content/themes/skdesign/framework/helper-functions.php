<?php
$core = '';

if (!function_exists('sk_core_init')) {
    function sk_core_init() {
        global $core;

        $core = \sk\core\core::get_instance();
    }

    add_action('sk_after_loading_framework', 'sk_core_init', 10);
}

function debug($_) {
    echo '<pre>';
    var_dump($_);
    echo '</pre>';
}