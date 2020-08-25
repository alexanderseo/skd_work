<?php
//if (!function_exists('sk_add_taxonomy_field')) {
//    function sk_add_taxonomy_field($array) {
//        global $core;
//
//        $core->post_taxonomy->fields->add_field($array);
//    }
//}
//
//if (!function_exists('sk_add_taxonomy_fields')) {
//    function sk_add_taxonomy_fields() {
//        global $core;
//
//        $core->post_taxonomy->fields->add_fields();
//    }
//
//    add_action('after_setup_theme', 'sk_add_taxonomy_fields', 10);
//}
//
//if (!function_exists('sk_edit_taxonomy_fields')) {
//    function sk_edit_taxonomy_fields() {
//        global $core;
//
//        $core->post_taxonomy->fields->edit_fields();
//    }
//
//    add_action('after_setup_theme', 'sk_edit_taxonomy_fields', 10);
//}
//
//if (!function_exists('sk_save_taxonomy_fields')) {
//    function sk_save_taxonomy_fields() {
//        global $core;
//
//        $_ = array();
//
//        foreach ($core->post_taxonomy->fields->get_fields() as $field) {
//            $_[] = $field['taxonomy'];
//        }
//
//        $taxonomies = array_unique($_);
//
//        foreach ($taxonomies as $taxonomy) {
//            add_action('edited_' . $taxonomy, function ($term_id) {
//                global $core;
//
//                $core->post_taxonomy->fields->save_fields($term_id);
//            }, 10, 2);
//
//            add_action('create_' . $taxonomy, function ($term_id) {
//                global $core;
//
//                $core->post_taxonomy->fields->save_fields($term_id);
//            }, 10, 2);
//        }
//    }
//
//    add_action('after_setup_theme', 'sk_save_taxonomy_fields', 10);
//}
//
//if (!function_exists('sk_delete_taxonomy_fields')) {
//    function sk_delete_taxonomy_fields() {
//        global $core;
//
//        $_ = array();
//
//        foreach ($core->post_taxonomy->fields->get_fields() as $field) {
//            $_[] = $field['taxonomy'];
//        }
//
//        $taxonomies = array_unique($_);
//
//        foreach ($taxonomies as $taxonomy) {
//            add_action('delete_' . $taxonomy, function ($term, $tt_id, $deleted_term, $object_ids) {
//                delete_option($deleted_term->taxonomy . '_' . $deleted_term->term_id);
//            }, 10, 4);
//        }
//    }
//
//    add_action('after_setup_theme', 'sk_delete_taxonomy_fields', 10);
//}