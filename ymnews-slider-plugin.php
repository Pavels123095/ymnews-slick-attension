<?php
/*
 Plugin Name: Yanmaar Slider Attension
 Plugin URI: http://yanmaar.ru
 Description: Шорткод для встаки на страницу [ymnews_slider_atten]
 Для отображения и добавления рекламных баннеров
 Version: 1.0
 Author: Prizrak
 Author URI: 
 License: GPL2
 */

function ym_slider_styles() {
	wp_register_style( 'ymnews_slick_plugin_css', plugins_url( 'ymnews_slick_plugin/ymnews-slider.css' ) );
	wp_enqueue_style( 'ymnews_slick_plugin_css' );
}

function ym_slider_js() {
    wp_register_script( 'ymnews_slick_plugin_js', plugins_url( 'ymnews_slick_plugin/ymnews-slick-atten.js' ), array( 'jquery' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'ymnews_slick_plugin_js' );
}

add_shortcode( 'ymnews_slider_atten', 'yanmaar_slider_attension' );

add_action( 'wp_enqueue_scripts', 'ym_slider_styles' );
add_action( 'wp_enqueue_scripts', 'ym_slider_js', 10 );

require_once WP_PLUGIN_DIR . '/ymnews_slick_plugin/include/' . 'ymnews-slider-posts.php';
new Ymnews_slider_posts_attension();
require_once WP_PLUGIN_DIR . '/ymnews_slick_plugin/include/' . 'ymnews_meta_banner.php';
new Ymnews_meta_box_banner();
require_once WP_PLUGIN_DIR . '/ymnews_slick_plugin/include/' . 'ymnews_widgets_atten.php';
require_once WP_PLUGIN_DIR . '/ymnews_slick_plugin/include/' . 'ym_slick_widget_footer.php';

