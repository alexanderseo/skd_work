<?php
namespace sk\core\post_taxonomy;

use \sk\core\i;

// Общий класс пользовательской таксономии
class post_taxonomy {
    private static $instance;

    public $register, $fields;

    public function __construct() {
        $this->register = new register();
    }

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function get_instance_meta($_) {
        return new meta($_);
    }
}

// Регистрация пользовательской таксономии
class register {
    private static $instance;

    private $taxonomies = array();

    public function __construct() {
        $this->register();
    }

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function add_post_taxonomy(i\post_taxonomy $taxonomy) {
        if (!array_key_exists($taxonomy->get_base(), $this->taxonomies)) {
            $this->taxonomies[$taxonomy->get_base()] = $taxonomy;
        }
    }

    private function add_post_taxonomies() {
        $array = array(
            'sk\core\post_taxonomy\fabric\register',
            'sk\core\post_taxonomy\collection\register',
            'sk\core\post_taxonomy\material\register'
        );

        foreach ($array as $key => $value) {
            $this->add_post_taxonomy(new $value);
        }
    }

    public function register() {
        $this->add_post_taxonomies();

        foreach ($this->taxonomies as $taxonomy) {
            $taxonomy->register();
        }
    }
}

// Регистрация пользовательских мета-полей
class meta {
    protected $meta_box, $prefix, $fields, $form_type;

    public function __construct($_) {
        $this->meta_box = $_;

        add_action('admin_init', function () {
            foreach ($this->meta_box['taxonomies'] as $taxonomy) {
                add_action($taxonomy . '_add_form_fields', function ($term_id) {
                    $this->form_type = 'new';

                    $this->show($term_id);
                });

                add_action($taxonomy . '_edit_form_fields', function ($term_id) {
                    $this->form_type = 'edit';

                    $this->show($term_id);
                });

                add_action('edited_' . $taxonomy, array($this, 'save'), 10, 2);

                add_action('created_' . $taxonomy, array($this, 'save'), 10, 2);
            }
        });
    }

    //Добавление мета-поля
    public function add($type, $term_id, $id, $args) {
        if (isset($args['taxonomy']) && $args['taxonomy'] !== '') {
            $args['options'] = get_terms(array(
                'taxonomy' => $args['taxonomy'],
                'hide_empty' => 0
            ));
        }

        $this->fields[] = array_merge(array(
            'type' => $type,
            'id' => 'sk_' . $term_id . '_' . $id,
            'taxonomy' => '',
            'label' => '',
            'description' => '',
            'options' => '',
            'style' => ''
        ), $args);
    }

    // Отображение мета-полей
    public function show($term_id) {
        $term_id = is_object($term_id) ? $term_id->term_id : $term_id;

        wp_nonce_field(basename(__FILE__), 'tax_meta_class_nonce');

        foreach ($this->fields as $field) {
            if (function_exists('get_term_meta')) {
                $meta = get_term_meta($term_id, $field['id'], true);
            } else {
                $meta = $this->get_tax_meta($term_id, $field['id']);
            }

            $meta = is_array($meta) ? array_map('esc_attr', $meta) : esc_attr($meta);

            if ($field['type'] == 'radio' || $field['type'] == 'select' || $field['type'] == 'taxonomy') {
                $meta = !is_array($meta) ? (array)$meta : $meta;
            }

            echo '<tr class="form-field">';

            call_user_func(array($this, 'show_meta'), $field, is_array($meta) ? $meta : stripslashes($meta), $term_id);

            echo '</tr>';
        }

        echo '</table>';
    }

    public function show_before($field) {
        if ($this->form_type == 'edit') {
            echo '<th valign="top" scope="row">';
        } else {
            echo '<td>';
            echo '<div class="form-field">';
        }

        if (isset($field['label'])) {
            echo '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
        }

        if ($this->form_type == 'edit') {
            echo '</th>';
            echo '<td>';
        }
    }

    public function show_after($field) {
        if (isset($field['description'])) {
            echo '<p class="description">' . $field['description'] . '</p>';
        }

        if ($this->form_type == 'edit') {
            echo '</td>';
        } else {
            echo '</td>';
            echo '</div>';
        }
    }

    public function show_meta($field, $meta) {
        $this->show_before($field);

        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30"/>';

                break;
            case 'select':
                echo '<select name="' . $field['id'] . '" id="' . $field['id'] . '">';

                foreach ($field['options'] as $key => $value) {
                    echo '<option value="' . $key . '"' . selected(in_array($key, $meta), true, false) . '>' . $value . '</option>';
                }

                echo '</select>';

                break;
            case 'radio':
                foreach ($field['options'] as $key => $value) {
                    echo '<label class="radio-group radio-clearfix"><input type="radio" name="' . $field['id'] . '" value="' . $key . '"' . checked(in_array($key, $meta), true, false) . ' /> ' . $value . '</label>';
                }

                break;
            case 'taxonomy':
                echo '<select name="' . $field['id'] . '">';

                foreach ($field['options'] as $term) {
                    echo '<option value="' . $term->id . '"' . selected(in_array($term->slug, $meta), true, false) . '>' . $term->name . '</option>';
                }

                echo '</select>';

                break;
        }

        $this->show_after($field);
    }

    // Сохрание мета-полей
    public function save($term_id) {
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'inline-save-tax') {
            return $term_id;
        }

        if (!isset($term_id) || (!isset($_POST['taxonomy'])) || (!in_array($_POST['taxonomy'], $this->meta_box['taxonomies'])) || (!check_admin_referer(basename(__FILE__), 'tax_meta_class_nonce')) || (!current_user_can('manage_categories'))) {
            return $term_id;
        }

        foreach ($this->fields as $field) {
            if (function_exists('get_term_meta')) {
                $term_meta = get_term_meta($term_id, $field['id'], true);
            } else {
                $term_meta = $this->get_tax_meta($term_id, $field['id']);
            }

            $this->save_field($term_id, $field, $term_meta, (isset($_POST[$field['id']])) ? $_POST[$field['id']] : '');
        }
    }

    public function save_field($term_id, $field, $term_meta, $value) {
        if (function_exists('get_term_meta')) {
            delete_term_meta($term_id, $field['id']);
        } else {
            $this->delete_tax_meta($term_id, $field['id']);
        }

        if ($value == '' || $value == array()) {
            return;
        }

        if (function_exists('update_term_meta')) {
            update_term_meta($term_id, $field['id'], $value);
        } else {
            $this->update_tax_meta($term_id, $field['id'], $value);
        }
    }

    // Работа со значениям мета-полей
    public function get_tax_meta($term_id, $key) {
        $term_id = (is_object($term_id)) ? $term_id->term_id : $term_id;

        $tax_meta = get_option('tax_meta_' . $term_id);

        if (isset($tax_meta[$key])) {
            return $tax_meta[$key];
        } else {
            return '';
        }
    }

    public function delete_tax_meta($term_id, $key) {
        $tax_meta = get_option('tax_meta_' . $term_id);

        if (isset($tax_meta[$key])) {
            unset($tax_meta[$key]);
        }

        update_option('tax_meta_' . $term_id, $tax_meta);
    }

    public function update_tax_meta($term_id, $key, $value) {
        $tax_meta = get_option('tax_meta_' . $term_id);

        $tax_meta[$key] = $value;

        update_option('tax_meta_' . $term_id, $tax_meta);
    }
}