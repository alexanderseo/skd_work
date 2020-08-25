<?php
if (!function_exists('sk_load_modules')) {
    function sk_load_modules() {
        foreach (glob(SK_FRAMEWORK_MODULE_ROOT_DIRECTORY . '*/load.php') as $file) {
            include_once $file;
        }
    }

    add_action('sk_after_loading_framework', 'sk_load_modules', 10);
}