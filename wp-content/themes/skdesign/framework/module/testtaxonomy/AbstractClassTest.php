<?php
namespace sk\module\testtaxonomy;


//use sk\core\post_taxonomy\post_taxonomy;
use sk\core\i\post_taxonomy;

abstract class AbstractClassTest implements post_taxonomy
{
    public $base, $post_type;

    public function __construct($base, $post_type) {
        $this->base = $base; # передаем названии нашей записи
        $this->post_type = $post_type; # передаем post_type, например продукт
    }

    public function get_base() {
        return $this->base;
    }

    public function register() {
        register_taxonomy($this->base, array($this->post_type), array(
            'hierarchical' => false,
            'labels' => array(
                'name' => _x($this->base, 'taxonomy general name'),
                'singular_name' => _x($this->base, 'taxonomy singular name'),
                'search_items' => __('Найти ' . $this->base),
                'all_items' => __('Все ' . $this->base),
                'parent_item' => __('Родитель'),
                'parent_item_colon' => __('Родитель:'),
                'edit_item' => __('Редактировать'),
                'update_item' => __('Обновить'),
                'add_new_item' => __('Добавить ' . $this->base),
                'new_item_name' => __('Новая ' . $this->base),
                'menu_name' => __($this->base),
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'type'),
        ));
    }
}