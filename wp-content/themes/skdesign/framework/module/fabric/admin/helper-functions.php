<?php
add_action('sk_after_loading_framework', function () {
    global $core;

    $meta = $core->post_taxonomy::get_instance_meta(array(
        'id' => 'fabric',
        'taxonomies' => array('fabric'),
        'fields' => array()
    ));

    $meta->add('taxonomy', 'fabric', 'collection', array(
        'taxonomy' => 'collection',
        'label' => 'Коллекция'
    ));
}, 20);