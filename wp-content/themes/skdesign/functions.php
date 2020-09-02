<?php
require_once get_template_directory() . '/framework/startup.php';


/* Добавление тканей
 * Ткань имеет привязку к коллекции
 * Ткань имеет привязку к цвету
 * Ткань имеет изображение - основное
 * Ткань имеет доп изображение
 * Ткань имеет видео
 * */

function my_cloth_register_post_type_to_product() {
    register_taxonomy( 'my_cloth', 'product',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Моя ткань', 'taxonomy general name'),
                'singular_name' => _x('Моя ткань', 'taxonomy singular name'),
                'search_items' => __('Найти мою ткань'),
                'all_items' => __('Все Мои ткани'),
                'parent_item' => __('Родитель'),
                'parent_item_colon' => __('Родитель:'),
                'edit_item' => __('Редактировать'),
                'update_item' => __('Обновить'),
                'add_new_item' => __('Добавить Мою ткань'),
                'new_item_name' => __('Новая ткань'),
                'menu_name' => __('Мои ткани'),
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'type'),
            'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail')
        )
    );

    register_taxonomy( 'my_collection', 'product',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Моя коллекция', 'taxonomy general name'),
                'singular_name' => _x('Моя коллекция', 'taxonomy singular name'),
                'search_items' => __('Найти мою коллекцию'),
                'all_items' => __('Все Мои коллекции'),
                'parent_item' => __('Родитель'),
                'parent_item_colon' => __('Родитель:'),
                'edit_item' => __('Редактировать'),
                'update_item' => __('Обновить'),
                'add_new_item' => __('Добавить Мою коллекцию'),
                'new_item_name' => __('Новая коллекция'),
                'menu_name' => __('Мои коллекции'),
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'type'),
            'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail')
        )
    );

    add_metadata('term', 68, 'karakteristik', 'Характеристика', true);
}

add_action( 'init', 'my_cloth_register_post_type_to_product' );

    /* Данные мета улетают в таблицу wp_termmeta */
    add_term_meta(81, 'add_percent_cat_1', '0', true);
    add_term_meta(82, 'add_percent_cat_2', '0.1', true);
    add_term_meta(83, 'add_percent_cat_3', '0.3', true);
    add_term_meta(84, 'add_percent_cat_4', '0.4', true);
    add_metadata('term', 74, 'img_meta_to_fabric', 'url', true);
    add_metadata('term', 73, 'img_meta_to_fabric', 'url', true);
    add_metadata('term', 61, 'img_meta_to_fabric', 'url', true);
    add_metadata('term', 62, 'img_meta_to_fabric', 'url', true);


    /* Создание своей таблицы */
//    global $wpdb;
//    $result = false;
//
//    $sql = sprintf(
//        'CREATE TABLE IF NOT EXISTS `%smytermmeta` (
//	        meta_id bigint(20) UNSIGNED NOT NULL auto_increment,
//	        term_id bigint(20) UNSIGNED NOT NULL,
//	        meta_key varchar(255),
//	        meta_value longtext,
//	    PRIMARY KEY (meta_id)
//	)',
//    $wpdb->prefix
//    );
//
//    $result = $wpdb->query( $sql );
//___________________________________________________________________________________________________________________



//hook into the init action and call create_book_taxonomies when it fires
add_action('init', 'create_topics_hierarchical_taxonomy', 0);

//create a custom taxonomy name it topics for your posts

function create_topics_hierarchical_taxonomy()
{

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

    $labels = array(
        'name' => _x('Topics', 'taxonomy general name'),
        'singular_name' => _x('Topic', 'taxonomy singular name'),
        'search_items' => __('Search Topics'),
        'all_items' => __('All Topics'),
        'parent_item' => __('Parent Topic'),
        'parent_item_colon' => __('Parent Topic:'),
        'edit_item' => __('Edit Topic'),
        'update_item' => __('Update Topic'),
        'add_new_item' => __('Add New Topic'),
        'new_item_name' => __('New Topic Name'),
        'menu_name' => __('Topics'),
    );

// Now register the taxonomy

    register_taxonomy('topics', array('post'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'topic'),
    ));

    $labels = array(
        'name' => _x('Topics_2', 'taxonomy general name'),
        'singular_name' => _x('Topic_2', 'taxonomy singular name'),
        'search_items' => __('Search Topics'),
        'all_items' => __('All Topics'),
        'parent_item' => __('Parent Topic'),
        'parent_item_colon' => __('Parent Topic:'),
        'edit_item' => __('Edit Topic'),
        'update_item' => __('Update Topic'),
        'add_new_item' => __('Add New Topic'),
        'new_item_name' => __('New Topic Name'),
        'menu_name' => __('Topics_2'),
    );

// Now register the taxonomy

    register_taxonomy('topics_2', array('post'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'topic'),
    ));

}

// A callback function to add a custom field to our "presenters" taxonomy
function presenters_taxonomy_custom_fields($tag)
{
    // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option("taxonomy_term_$t_id"); // Do the check

    echo '<pre>';
    var_dump($t_id);
    echo '</pre>';

    echo '<pre>';
    var_dump($term_meta);
    echo '</pre>';

    $terms = get_terms(array(
        'taxonomy' => 'topics_2',
        'hide_empty' => false,
    ));

    echo '<pre>';
    var_dump($terms);
    echo '</pre>';
    ?>


    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="term_meta[topics]"><?php _e('WordPress User ID'); ?></label>
        </th>
        <td>
            <select name="topics_int" id="topics_int">
                <?php foreach ($terms as $term) { ?>
                    <option value="<?php echo $term->term_id; ?>" <?php selected($term->term_id, (int) $term_meta["topics"]) ?>><?php echo $term->name; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>

    <?php
}

// A callback function to save our extra taxonomy field(s)
function save_taxonomy_custom_fields($term_id)
{
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_term_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array
        update_option("taxonomy_term_$t_id", $term_meta);
//        add_metadata( 'term', $t_id, 'favourite_colour', 'Green', true );
    }
}

// Add the fields to the "presenters" taxonomy, using our callback function
add_action('topics_edit_form_fields', 'presenters_taxonomy_custom_fields', 10, 2);

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action('edited_topics', 'save_taxonomy_custom_fields', 10, 2);



/* --------------------------------------------------------------------------------------------------------------------
 * Добавление пользовательского типа записи - ТКАНИ
 * */
add_action('init', 'my_custom_post_tkan');
function my_custom_post_tkan(){
    register_post_type('mycustomposttkan', array(
        'labels'             => array(
            'name'               => 'ТКАНЬ', // Основное название типа записи
            'singular_name'      => 'ТКАНЬ', // отдельное название записи типа Book
            'add_new'            => 'Добавить новую ТКАНЬ',
            'add_new_item'       => 'Добавить новую ТКАНЬ',
            'edit_item'          => 'Редактировать ТКАНЬ',
            'new_item'           => 'Новая ТКАНЬ',
            'view_item'          => 'Посмотреть ТКАНЬ',
            'search_items'       => 'Найти ТКАНЬ',
            'not_found'          => 'ТКАНЬ не найдена',
            'not_found_in_trash' => 'В корзине ТКАНЕЙ не найдено',
            'parent_item_colon'  => '',
            'menu_name'          => 'ТКАНИ'
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title','editor','author','thumbnail','excerpt','comments')
    ) );
}


/* Добавление ТАКСОНОМИИ для пользовательского типа записей - ТКАНИ
 * ТАКСОНОМИИ:
 * Цвет (изображение)
 * Материал
 * Коллекция
 * Категория (наценка)
 * */
add_action( 'init', 'my_taxonomy_for_our_custom_post_type_tkani' );
function my_taxonomy_for_our_custom_post_type_tkani() {
    /* Таксономия - Материалы
     * */
    register_taxonomy( 'ct_material_for_tkani', 'mycustomposttkan',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Материал ткани', 'taxonomy general name'),
                'singular_name' => _x('Материал ткани', 'taxonomy singular name'),
                'search_items' => __('Найти материал ткани'),
                'all_items' => __('Все материалы тканей'),
                'parent_item' => __('Родитель'),
                'parent_item_colon' => __('Родитель:'),
                'edit_item' => __('Редактировать'),
                'update_item' => __('Обновить'),
                'add_new_item' => __('Добавить материал ткани'),
                'new_item_name' => __('Новая материал ткани'),
                'menu_name' => __('Материалы тканей'),
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'type'),
            'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail')
        )
    );
    /* Таксономия - Коллекция
     * */
    register_taxonomy( 'ct_collection_for_tkani', 'mycustomposttkan',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Коллекция тканей', 'taxonomy general name'),
                'singular_name' => _x('Коллекция тканей', 'taxonomy singular name'),
                'search_items' => __('Найти коллекцию тканей'),
                'all_items' => __('Все коллекции тканей'),
                'parent_item' => __('Родитель'),
                'parent_item_colon' => __('Родитель:'),
                'edit_item' => __('Редактировать'),
                'update_item' => __('Обновить'),
                'add_new_item' => __('Добавить коллекцию ткани'),
                'new_item_name' => __('Новая коллекция тканей'),
                'menu_name' => __('Мои коллекции тканей'),
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'type'),
            'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail')
        )
    );
    /* Таксономия - Категория
     * */
    register_taxonomy( 'ct_category_for_tkani', 'mycustomposttkan',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Категория тканей', 'taxonomy general name'),
                'singular_name' => _x('Категория тканей', 'taxonomy singular name'),
                'search_items' => __('Найти категорию тканей'),
                'all_items' => __('Все категории тканей'),
                'parent_item' => __('Родитель'),
                'parent_item_colon' => __('Родитель:'),
                'edit_item' => __('Редактировать'),
                'update_item' => __('Обновить'),
                'add_new_item' => __('Добавить категорию ткани'),
                'new_item_name' => __('Новая категория тканей'),
                'menu_name' => __('Мои категории тканей'),
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'type'),
            'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail')
        )
    );
    /* Таксономия - Цвета
     * */
    register_taxonomy( 'ct_color_for_tkani', 'mycustomposttkan',
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Цвета тканей', 'taxonomy general name'),
                'singular_name' => _x('Цвета тканей', 'taxonomy singular name'),
                'search_items' => __('Найти цвет тканей'),
                'all_items' => __('Все цвета тканей'),
                'parent_item' => __('Родитель'),
                'parent_item_colon' => __('Родитель:'),
                'edit_item' => __('Редактировать'),
                'update_item' => __('Обновить'),
                'add_new_item' => __('Добавить цвет ткани'),
                'new_item_name' => __('Новая цвет тканей'),
                'menu_name' => __('Мои цвета тканей'),
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'type'),
            'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail')
        )
    );
    /* Добавление мета-данных для кастомной таксономии
    * */
//    add_metadata('term', 68, 'karakteristik', 'Характеристика', true);

    /* Регистрация своей таблицы, для сохранения метаданных для кастомной таксономии */
    global $wpdb;
    $wpdb->termmeta = $wpdb->prefix.'mytermmeta';

    /* Мета данные улетают в таблицу wp_mytermmeta */
    add_metadata( 'term', 110, 'extra_percent_for_cat_tkani_1', '0', true );
    add_metadata( 'term', 110, 'extra_percent_for_cat_tkani_2', '0.1', true );
    add_metadata( 'term', 110, 'extra_percent_for_cat_tkani_3', '0.2', true );
    add_metadata( 'term', 110, 'extra_percent_for_cat_tkani_4', '0.3', true );
}



/* ------------------------------------------------------------------------------------------------------------------
 * Вывод пользовательского типа записи в товаре Woocommerce
 * ------------------------------------------------------------------------------------------------------------------
 */
//add_action( 'woocommerce_product_options_general_product_data', 'my_show_meta' );
//function my_show_meta() {
//    woocommerce_wp_select( array(
//        'id'      => 'variable_fabric',
//        'label' => 'Выберите ткань',
//        'desc_tip' => true,
//        'style' => 'margin-bottom:40px;',
//        'value' => get_post_type_object( 'mycustomposttkan' ),
////        'options' => array(
////            '' => 'Выберите...',
////            'el' => 'Эльбрус',
////            'rz' => 'Роза Хутор',
////            'mt' => 'Маттерхорн'
////        )
//    ) );
//}

/**
 * @snippet       Add Custom Field to Product Variations - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @sourcecode    https://businessbloomer.com/?p=73545
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.5.6
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

// -----------------------------------------
// 1. Add custom field input @ Product Data > Variations > Single Variation

add_action( 'woocommerce_variation_options_pricing', 'bbloomer_add_custom_field_to_variations', 10, 3 );

function bbloomer_add_custom_field_to_variations( $loop, $variation_data, $variation ) {

    $options = array();
    $margs = array('post_type' => 'mycustomposttkan');
    $ppp = get_post_types($margs);
    foreach ($ppp as $option) {
        $options = $option->name;
    }

    $post_types = get_posts( array('post_type'   => 'mycustomposttkan') );
    $rrr = array();

    foreach( $post_types as $post_type ) {
        $rrr = $post_type->post_title;
    }
    $obj = get_posts( array('post_type' => 'mycustomposttkan') );
    foreach( $obj as $ptype ) {
        $obj = $ptype;
        var_dump($obj);
    }

    $args = array(
        'label' => 'Выберите ткань', // Text in Label
        'class' => 'select short',
//        'style' => '',
        'wrapper_class' => 'form-row form-row-full',
//        'value' => get_posts( array('post_type'   => 'mycustomposttkan') ), // if empty, retrieved from post meta where id is the meta_key
//        'id' => '', // required
//        'name' => '', //name will set from id if empty
        'options' => array(
            'one'   => __( $obj->post_title ),
            'two'   => __( 'Option 2', 'woocommerce' ),
            'three' => __( 'Option 3', 'woocommerce' ),
        ),
//        'desc_tip' => '',
//        'custom_attributes' => '', // array of attributes
//        'description' => ''
    );

    woocommerce_wp_select( $args );
}

// -----------------------------------------
// 2. Save custom field on product variation save

add_action( 'woocommerce_save_product_variation', 'bbloomer_save_custom_field_variations', 10, 2 );

function bbloomer_save_custom_field_variations( $variation_id, $i ) {
    $custom_field = $_POST['custom_field'][$i];
    if ( isset( $custom_field ) ) update_post_meta( $variation_id, 'custom_field', esc_attr( $custom_field ) );
}

// -----------------------------------------
// 3. Store custom field value into variation data

add_filter( 'woocommerce_available_variation', 'bbloomer_add_custom_field_variation_data' );

function bbloomer_add_custom_field_variation_data( $variations ) {
    $variations['custom_field'] = '<div class="woocommerce_custom_field">Custom Field: <span>' . get_post_meta( $variations[ 'variation_id' ], 'custom_field', true ) . '</span></div>';
    return $variations;
}

/* --------------------------------------------------------------------------------------------------------------------
 * Добавление миниатюр изображений для таксономий
 * --------------------------------------------------------------------------------------------------------------------
 */

if( is_admin() && ! class_exists('Term_Meta_Image') ){

    // init
    //add_action('current_screen', 'Term_Meta_Image_init');
    add_action( 'admin_init', 'Term_Meta_Image_init' );
    function Term_Meta_Image_init(){
        $GLOBALS['Term_Meta_Image'] = new Term_Meta_Image();
    }

    class Term_Meta_Image {
        /*
         * Для каких таксономий включить код. По умолчанию для всех публичных
         * пример: array('category', 'post_tag');
         */
        static $taxes = [];

        /*
         * Название мета-ключа
         */
        static $meta_key = '_thumbnail_id';
        static $attach_term_meta_key = 'img_term';

        /*
         * URL пустой картинки (заглушка)
         */
        static $add_img_url = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkAQMAAABKLAcXAAAABlBMVEUAAAC7u7s37rVJAAAAAXRSTlMAQObYZgAAACJJREFUOMtjGAV0BvL/G0YMr/4/CDwY0rzBFJ704o0CWgMAvyaRh+c6m54AAAAASUVORK5CYII=';

        public function __construct(){
            if( isset($GLOBALS['Term_Meta_Image']) )
                return $GLOBALS['Term_Meta_Image'];

            $taxes = self::$taxes ? self::$taxes : get_taxonomies( [ 'public' =>true ], 'names' );

            foreach( $taxes as $taxname ){
                add_action( "{$taxname}_add_form_fields",   [ $this, 'add_term_image' ],     10, 2 );
                add_action( "{$taxname}_edit_form_fields",  [ $this, 'update_term_image' ],  10, 2 );
                add_action( "created_{$taxname}",           [ $this, 'save_term_image' ],    10, 2 );
                add_action( "edited_{$taxname}",            [ $this, 'updated_term_image' ], 10, 2 );

                add_filter( "manage_edit-{$taxname}_columns",  [ $this, 'add_image_column' ] );
                add_filter( "manage_{$taxname}_custom_column", [ $this, 'fill_image_column' ], 10, 3 );
            }
        }
        /*
         * Поля при создании термина
         */
        public function add_term_image( $taxonomy ){
            /*
             * Подключение стилей МЕДИА, если их нет
             */
            wp_enqueue_media();

            add_action('admin_print_footer_scripts', [ $this, 'add_script' ], 99 );
            $this->css();
            ?>
            <div class="form-field term-group">
                <label><?php _e('Image', 'default'); ?></label>
                <div class="term__image__wrapper">
                    <a class="termeta_img_button" href="#">
                        <img src="<?php echo self::$add_img_url ?>" alt="">
                    </a>
                    <input type="button" class="button button-secondary termeta_img_remove" value="<?php _e( 'Remove', 'default' ); ?>" />
                </div>

                <input type="hidden" id="term_imgid" name="term_imgid" value="">
            </div>
            <?php
        }
        /*
         * Поля при редактировании термина
         */
        public function update_term_image( $term, $taxonomy ){
            wp_enqueue_media(); // подключим стили медиа, если их нет

            add_action('admin_print_footer_scripts', [ $this, 'add_script' ], 99 );

            $image_id = get_term_meta( $term->term_id, self::$meta_key, true );
            $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : self::$add_img_url;
            $this->css();
            ?>
            <tr class="form-field term-group-wrap">
                <th scope="row"><?php _e( 'Image', 'default' ); ?></th>
                <td>
                    <div class="term__image__wrapper">
                        <a class="termeta_img_button" href="#">
                            <?php echo '<img src="'. $image_url .'" alt="">'; ?>
                        </a>
                        <input type="button" class="button button-secondary termeta_img_remove" value="<?php _e( 'Remove', 'default' ); ?>" />
                    </div>

                    <input type="hidden" id="term_imgid" name="term_imgid" value="<?php echo $image_id; ?>">
                </td>
            </tr>
            <?php
        }

        public function css(){
            ?>
            <style>
                .termeta_img_button{ display:inline-block; margin-right:1em; }
                .termeta_img_button img{ display:block; float:left; margin:0; padding:0; min-width:100px; max-width:150px; height:auto; background:rgba(0,0,0,.07); }
                .termeta_img_button:hover img{ opacity:.8; }
                .termeta_img_button:after{ content:''; display:table; clear:both; }
            </style>
            <?php
        }

        /*
         * Подключение скрипта
         */
        public function add_script(){
            // выходим если не на нужной странице таксономии
            //$cs = get_current_screen();
            //if( ! in_array($cs->base, array('edit-tags','term')) || ! in_array($cs->taxonomy, (array) $this->for_taxes) )
            //  return;

            $title = __('Featured Image', 'default');
            $button_txt = __('Set featured image', 'default');
            ?>
            <script>
                jQuery(document).ready(function($){
                    var frame,
                        $imgwrap = $('.term__image__wrapper'),
                        $imgid   = $('#term_imgid');

                    // добавление
                    $('.termeta_img_button').click( function(ev){
                        ev.preventDefault();

                        if( frame ){ frame.open(); return; }

                        // задаем media frame
                        frame = wp.media.frames.questImgAdd = wp.media({
                            states: [
                                new wp.media.controller.Library({
                                    title:    '<?php echo $title ?>',
                                    library:   wp.media.query({ type: 'image' }),
                                    multiple: false,
                                    //date:   false
                                })
                            ],
                            button: {
                                text: '<?php echo $button_txt ?>', // Set the text of the button.
                            }
                        });

                        // выбор
                        frame.on('select', function(){
                            var selected = frame.state().get('selection').first().toJSON();
                            if( selected ){
                                $imgid.val( selected.id );
                                $imgwrap.find('img').attr('src', selected.sizes.thumbnail.url );
                            }
                        } );

                        // открываем
                        frame.on('open', function(){
                            if( $imgid.val() ) frame.state().get('selection').add( wp.media.attachment( $imgid.val() ) );
                        });

                        frame.open();
                    });

                    // удаление
                    $('.termeta_img_remove').click(function(){
                        $imgid.val('');
                        $imgwrap.find('img').attr('src','<?php echo self::$add_img_url ?>');
                    });
                });
            </script>

            <?php
        }

        ## Добавляет колонку картинки в таблицу терминов
        public function add_image_column( $columns ){
            // fix column width
            add_action( 'admin_notices', function(){
                echo '<style>.column-image{ width:50px; text-align:center; }</style>';
            });

            // column without name
            return array_slice( $columns, 0, 1 ) + [ 'image' =>'' ] + $columns;
        }

        public function fill_image_column( $string, $column_name, $term_id ){

            if( 'image' === $column_name && $image_id = get_term_meta( $term_id, self::$meta_key, 1 ) ){
                $string = '<img src="'. wp_get_attachment_image_url( $image_id, 'thumbnail' ) .'" width="50" height="50" alt="" style="border-radius:4px;" />';
            }

            return $string;
        }

        ## Save the form field
        public function save_term_image( $term_id, $tt_id ){
            if( isset($_POST['term_imgid']) && $attach_id = (int) $_POST['term_imgid'] ){
                update_term_meta( $term_id,   self::$meta_key,             $attach_id );
                update_post_meta( $attach_id, self::$attach_term_meta_key, $term_id );
            }
        }

        ## Update the form field value
        public function updated_term_image( $term_id, $tt_id ){
            if( ! isset($_POST['term_imgid']) )
                return;

            $cur_term_attach_id = (int) get_term_meta( $term_id, self::$meta_key, 1 );

            if( $attach_id = (int) $_POST['term_imgid'] ){
                update_term_meta( $term_id,   self::$meta_key,             $attach_id );
                update_post_meta( $attach_id, self::$attach_term_meta_key, $term_id );

                if( $cur_term_attach_id != $attach_id )
                    wp_delete_attachment( $cur_term_attach_id );
            }
            else {
                if( $cur_term_attach_id )
                    wp_delete_attachment( $cur_term_attach_id );

                delete_term_meta( $term_id, self::$meta_key );
            }
        }

    }

}
