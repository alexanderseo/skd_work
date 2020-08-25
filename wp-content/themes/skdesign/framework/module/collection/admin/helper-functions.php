<?php
add_action('sk_after_loading_framework', function () {
    global $core;

    $meta = $core->post_taxonomy::get_instance_meta(array(
        'id' => 'collection',
        'taxonomies' => array('collection'),
        'fields' => array()
    ));

    $meta->add('radio', 'collection', 'category', array(
        'label' => 'Категория ткани',
        'options' => array(
            '1' => 'Первая категория',
            '2' => 'Вторая категория',
            '3' => 'Третья категория',
            '4' => 'Четвертая категория'
        )
    ));

    $meta->add('select', 'collection', 'material', array(
        'label' => 'Материал ткани',
        'options' => array(
            'velveteen' => 'Вельвет',
            'velours' => 'Велюр',
            'jacquard' => 'Жаккард',
            'lanital' => 'Искусственная шерсть',
            'gunny' => 'Рогожка',
            'chenille' => 'Шенилл'
        )
    ));
}, 20);