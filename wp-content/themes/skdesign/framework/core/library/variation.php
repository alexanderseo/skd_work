<?php
namespace sk\core\variation;

class variation {
    private static $instance;

    public $meta;

    public function __construct() {
        $this->meta = new meta();
    }

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function get_instance_meta() {
        return new meta();
    }
}

class meta {
    protected $fields, $field;

    public function __construct() {
        add_action('woocommerce_product_after_variable_attributes', function ($loop, $variation_data, $variation) {
            $this->show($loop, $variation_data, $variation);
        }, 10, 3);

        add_action('woocommerce_save_product_variation', function ($post_id) {
            foreach ($this->fields as $field) {
                switch ($field['type']) {
                    case 'taxonomy':
                        !empty($_POST[$field['id']][$post_id]) ? update_post_meta($post_id, $field['id'], esc_attr($_POST[$field['id']][$post_id])) : '';
                }
            }
        }, 10, 2);
    }

    public function add($type, $id, $args) {
        if (isset($args['taxonomy']) && $args['taxonomy'] !== '') {
            $args['options'] = get_terms(array(
                'taxonomy' => $args['taxonomy'],
                'hide_empty' => 0
            ));
        }

        $this->fields[] = array_merge(array(
            'type' => $type,
            'id' => 'variable_'. $id,
            'taxonomy' => '',
            'label' => '',
            'description' => '',
            'options' => ''
        ), $args);
    }

    public function show($loop, $variation_data, $variation) {
        foreach ($this->fields as $field) {
            call_user_func(array($this, 'show_meta'), $loop, $variation_data, $variation, $field);
        }
    }

    public function show_meta($loop, $variation_data, $variation, $field) {
        switch ($field['type']) {
            case 'taxonomy':
                $options = array();

                foreach ($field['options'] as $option) {
                    $options[$option->term_id] = $option->name;
                }

                woocommerce_wp_select(array(
                    'id' => $field['id'] . '[' . $variation->ID . ']',
                    'label' => $field['label'],
                    'value' => get_post_meta($variation->ID, $field['id'], true),
                    'options' => $options,
                    'wrapper_class' => 'form-row form-row-full'
                ));

                break;
        }
    }
}