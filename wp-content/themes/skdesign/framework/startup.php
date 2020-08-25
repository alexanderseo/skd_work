<?php
define('SK_ROOT_DIRECTORY', get_template_directory());
define('SK_FRAMEWORK_ROOT_DIRECTORY', SK_ROOT_DIRECTORY . '/framework/');
define('SK_FRAMEWORK_CORE_ROOT_DIRECTORY', SK_ROOT_DIRECTORY . '/framework/core/');
define('SK_FRAMEWORK_MODULE_ROOT_DIRECTORY', SK_ROOT_DIRECTORY . '/framework/module/');

require_once SK_FRAMEWORK_CORE_ROOT_DIRECTORY . 'load.php';
require_once SK_FRAMEWORK_MODULE_ROOT_DIRECTORY . 'load.php';
require_once SK_FRAMEWORK_ROOT_DIRECTORY . 'helper-functions.php';

require_once SK_FRAMEWORK_ROOT_DIRECTORY . 'Tax-meta-class.php';

do_action('sk_after_loading_framework');