<?php

class trueTopPostsWidget extends WP_Widget {
 
    /*
     * создание виджета
     */
    function __construct() {
        parent::__construct(
            'widgets_attension_post', 
            'Вывод рекламных баннеров', // заголовок виджета
            array( 'description' => 'Вывод рекламных баннеров для сайдбара' ) // описание
        );
    }
            /*
            * фронтэнд виджета
            */
            public function widget( $args, $instance ) {
                $title = apply_filters( 'widget_title', $instance['title'] ? '' : 'Заголовок'); // к заголовку применяем фильтр (необязательно)
                $views_posts = $instance['views_posts'] ? 1 : 0;
                global $key;
                echo $args['before_widget'];
        
                if ( ! empty( $title ) )
                    echo $args['before_title'] . $title . $args['after_title'];
                        $key = 'view_sidebar';
                        $args_at = array(
                            'post_type' => 'posts_banner',
                            'meta_query' => array(
                                'key' => $key,
                                'value' => 'on',
                                'compare' => 'NOT LIKE'
                            ),
                        );
                        $atten = new WP_Query( $args_at ); ?>
                        <div class="ymnews-widgets-before-main-wrapper">
                            <div class="ymnews-widget-before-content">
                        <?php 
                                if ($atten->have_posts()):
                                    while ($atten->have_posts()): $atten->the_post(); $id = get_the_ID(); 
                                    $keys = get_post_meta($id, 'view_sidebar' , true);
                                    if ($keys): ?>
                                        <div class="ymnews-attension-post">
                                            <img src="<?php echo ymnews_minify_thumbnail(); ?>" alt="<?php the_title(); ?>">
                                        </div>
                                    <?php endif; endwhile; endif; wp_reset_postdata(); ?>
                                    </div>
                                </div> 
                <?php        
                echo $args['after_widget'];
            }
        
            /*
            * бэкэнд виджета
            */
            public function form( $instance ) {
                if ( isset( $instance[ 'title' ] ) ) {
                    $title = $instance[ 'title' ];
                }
                if ( isset( $instance[ 'views_posts' ] ) ) {
                    $views_posts = $instance[ 'views_posts' ];
                }
                ?>
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label> 
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'views_posts' ); ?>">Укажите положение виджета</label> 
                    <input id="<?php echo $this->get_field_id( 'views_posts' ); ?>" name="<?php echo $this->get_field_name( 'views_posts' ); ?>" type="text" value="<?php echo ($views_posts) ? esc_attr( $views_posts ) : '1'; ?>" size="3" />
                </p>
                <?php 
            }
        
            /*
            * сохранение настроек виджета
            */
            public function update( $new_instance, $old_instance ) {
                $instance = array();
                $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
                $instance['views_posts'] = ( is_numeric( $new_instance['views_posts'] ) ) ? $new_instance['views_posts'] : '1'; 
                return $instance;
            }
        }
        
        /*
        * регистрация виджета
        */
        function true_top_posts_widget_load() {
            register_widget( 'trueTopPostsWidget' );
        }

add_action( 'widgets_init', 'true_top_posts_widget_load' );