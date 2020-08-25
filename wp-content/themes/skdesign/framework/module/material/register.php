<?php
namespace sk\core\post_taxonomy\material;

use sk\core\i\post_taxonomy;

class register implements post_taxonomy {
    private $base, $post_type;

    public function __construct() {
        $this->base = 'material';
        $this->post_type = 'product';
    }

    public function get_base() {
        return $this->base;
    }

    public function register() {
        register_taxonomy($this->base, array($this->post_type), array(
            'hierarchical' => false,
            'labels' => array(
                'name' => _x('Ткани', 'taxonomy general name'),
                'singular_name' => _x('Материал', 'taxonomy singular name'),
                'search_items' => __('Найти материал'),
                'all_items' => __('Все материалы'),
                'parent_item' => __('Родитель'),
                'parent_item_colon' => __('Родитель:'),
                'edit_item' => __('Редактировать'),
                'update_item' => __('Обновить'),
                'add_new_item' => __('Добавить материал'),
                'new_item_name' => __('Новая материал'),
                'menu_name' => __('Материалы'),
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'type'),
        ));
    }
}