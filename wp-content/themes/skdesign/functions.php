<?php
require_once get_template_directory() . '/framework/startup.php';

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
function crb_attach_theme_options()
{
    Container::make('theme_options', __('Theme Options', 'crb'))
        ->add_fields(array(
            Field::make('text', 'crb_text', 'Text Field'),
        ));
}

//add_action( 'carbon_fields_register_fields', 'crb_attach_post_meta' );
//function crb_attach_post_meta() {
//    Container::make( 'post_meta', __( 'Post Options', 'crb' ) )
//        ->where( 'post_type', '=', 'post' )
//        ->add_fields( array(
//            Field::make( 'text', 'crb_venue', 'Venue' ),
//        ) );
//}

add_action('carbon_fields_register_fields', 'crb_attach_term_meta');
function crb_attach_term_meta()
{
    Container::make('term_meta', __('Term Options', 'crb'))
        ->where('term_taxonomy', '=', 'category') // only show our new field for categories
        ->add_fields(array(
            Field::make('color', 'crb_color', 'Color')
                ->set_required(true),
        ));
}

add_action('carbon_fields_register_fields', 'crb_attach_post_meta');
function crb_attach_post_meta()
{
    Container::make('post_meta', __('Выбор цвета товара', 'crb'))
        ->where('post_type', '=', 'product') // Тип записи + обозначение записи
        ->add_fields(array(
            Field::make('complex', 'crb_color', 'Цвет товара')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('text', 'title', 'Title'),
                    Field::make('color', 'title_color', 'Title Color'),
                    Field::make('image', 'image', 'Image'),
                ))
//                ->add_fields('related_posts', 'Related Posts', array(
//                    Field::make('association', 'posts', 'Posts')
//                        ->set_types(array(
//                            array(
//                                'type' => 'term',
//                                'post_type' => 'pa_second-atribute',
//                            ),
//                        )),
//                ))
        ));

}