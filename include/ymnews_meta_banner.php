 <?php
class Ymnews_meta_box_banner {

    function __construct()
    {
		global $meta_fields;
		$meta_fields = array(  
			array(  
				'label' => 'Под пагинацией',  
				'desc'  => 'Отображение под пагинацией основных постов',  
				'id'    => 'views_paginate',  // даем идентификатор.
				'type'  => 'checkbox'  // Указываем тип поля.
			),  
			array(
				'label' => 'В сайдбаре (добавить в виджет)',  
				'desc'  => 'Отображение в сайдбаре (виджете)',  
				'id'    => 'view_sidebar',  // даем идентификатор.
				'type'  => 'checkbox'  // Указываем тип поля.
			),
			array(
				'label' => 'В подвале (добавить в виджет)',  
				'desc'  => 'Отображение в подвале (виджете)',  
				'id'    => 'view_footer',  // даем идентификатор.
				'type'  => 'checkbox'  // Указываем тип поля.
			)
		);
		add_action('add_meta_boxes', array($this, 'my_meta_box'));
		add_action('save_post', array($this,'save_my_meta_fields'));

	}

	function my_meta_box() {  
		add_meta_box(  
			'my_meta_box', // Идентификатор(id)
			'Местоположение баннера', // Заголовок области с мета-полями(title)
			'show_my_metabox', // Вызов(callback)
			'posts_banner', // Где будет отображаться наше поле, в нашем случае в Записях
			'normal',
			'high'
		);
		function show_my_metabox() {  
			global $meta_fields; // Обозначим наш массив с полями глобальным
			global $post;  // Глобальный $post для получения id создаваемого/редактируемого поста
			// Выводим скрытый input, для верификации. Безопасность прежде всего!
			echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';  
				// Начинаем выводить таблицу с полями через цикл
				echo '<table class="form-table">';  
				foreach ($meta_fields as $field) {  
					// Получаем значение если оно есть для этого поля
					$meta = get_post_meta($post->ID, $field['id'], true);  
					// Начинаем выводить таблицу
					echo '<tr>
							<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
							<td>';  
							switch($field['type']) {  
								// Выводить поля будем здесь
									// Текстовое поле
									case 'text':  
										echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
											<br /><span class="description">'.$field['desc'].'</span>';  
									break;
									case 'textarea':  
										echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
											<br /><span class="description">'.$field['desc'].'</span>';  
									break;
									case 'checkbox':  
										echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
											<label for="'.$field['id'].'">'.$field['desc'].'</label>';  
									break;
									
							}
					echo '</td></tr>';  
				}  
				echo '</table>';
		}
	}  

	function save_my_meta_fields($post_id) {  
		global $meta_fields;  // Массив с нашими полями
	 
		// проверяем наш проверочный код
		if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))  
			return $post_id;  
		// Проверяем авто-сохранение
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
			return $post_id;  
		// Проверяем права доступа  
		if ('page' == $_POST['post_type']) {  
			if (!current_user_can('edit_page', $post_id))  
				return $post_id;  
			} elseif (!current_user_can('edit_post', $post_id)) {  
				return $post_id;  
		}  
	 
		// Если все отлично, прогоняем массив через foreach
		foreach ($meta_fields as $field) {  
			$old = get_post_meta($post_id, $field['id'], true); // Получаем старые данные (если они есть), для сверки
			$new = $_POST[$field['id']];  
			if ($new && $new != $old) {  // Если данные новые
				update_post_meta($post_id, $field['id'], $new); // Обновляем данные
			} elseif ('' == $new && $old) {  
				delete_post_meta($post_id, $field['id'], $old); // Если данных нету, удаляем мету.
			}  
		} // end foreach  
	}  
}