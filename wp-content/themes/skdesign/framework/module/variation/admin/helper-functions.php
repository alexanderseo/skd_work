<?php
add_action('sk_after_loading_framework', function () {
    global $core;

    $meta = $core->variation::get_instance_meta();

    $meta->add('taxonomy', 'fabric', array(
        'taxonomy' => 'fabric',
        'label' => 'Ткань на образце'
    ));
}, 20);