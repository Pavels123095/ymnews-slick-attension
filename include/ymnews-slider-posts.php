<?php

class Ymnews_slider_posts_attension  {

    function __construct() {
        add_action('init', array($this, 'posts_attension_banner'));
    }

    function posts_attension_banner() {
        register_post_type( 'posts_banner', [
            'label'  => null,
            'labels' => [
                'name'               => 'Баннеры', // основное название для типа записи
                'singular_name'      => 'баннер', // название для одной записи этого типа
                'add_new'            => 'Добавить баннер', // для добавления новой записи
                'add_new_item'       => 'Добавление баннер', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактирование баннера', // для редактирования типа записи
                'new_item'           => 'Новый баннер', // текст новой записи
                'view_item'          => 'Смотреть баннер', // для просмотра записи этого типа.
                'search_items'       => 'Искать баннер', // для поиска по этим типам записи
                'not_found'          => 'Не найдено баннера', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине баннеров', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Баннеры', // название меню
            ],
            'description'         => '',
            'public'              => true,
            'show_in_menu'        => true, // показывать ли в меню адмнки
            'show_in_admin_bar'   => true, // зависит от show_in_menu
            'show_in_rest'        => null, // добавить в REST API. C WP 4.7
            'rest_base'           => null, // $post_type. C WP 4.7
            'menu_position'       => 7,
            'menu_icon'           => 'dashicons-star-filled',
            //'capability_type'   => 'post',
            //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
            //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
            'hierarchical'        => false,
            'supports'            => [ 'title', 'thumbnail' , 'custom-fields'  ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => [],
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ] );
    }

}
