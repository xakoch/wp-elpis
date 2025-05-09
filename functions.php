<?php

	/**
	 * Определение константы THEME_DIR с путем к директории темы.
	 */
	define('THEME_DIR', get_template_directory());
	
    /**
	 * Подключение оптимизации темы
	 * 
	*/

	require_once ( THEME_DIR . '/inc/optimization.php');
	
    /**
	 * Подключение Custom Post Types
	 * 
	 */

	// require_once ( THEME_DIR . '/inc/cpt.php' );
	
    /**
	 * Подключение Custom Walker Menu
	 * 
	 */
	
	// require_once ( THEME_DIR . '/inc/custom-walker.php' );
	
    /**
	 * Connecting Some functions
	 * Подключает стили и скрипты проекта
	 * 
	 */

	// require_once ( THEME_DIR . '/inc/some-functions.php' );
	
    /**
	 * Подключение функции темы
	 * 
	 */

	require_once ( THEME_DIR . '/inc/theme-functions.php' );

    /**
	 * Подключение Styles / Scripts
	 * 
	 */

	require_once ( THEME_DIR . '/inc/ss.php' );
	
    /**
	 * Хлебныекрошки
	 * 
	 */

	require_once ( THEME_DIR . '/inc/breadcrumbs.php' );

    /**
	 * Woocommerce-hooks
	 * 
	 */

	require_once ( THEME_DIR . '/inc/woocommerce-hooks.php' );
	
    /**
	 * Подключение хелперов [Helpers]
	 * 
	 */

	// require_once ( THEME_DIR . '/inc/helpers.php' );
	
    /**
	 * SVG поддержка
	 * 
	*/

	require_once ( THEME_DIR . '/inc/upload.php' );
	
    /**
	 * Вывод API сайта по адресам:
	 * /wp-json/my-events/v1/my-all-events-on-json.json
	 * /wp-json/my-events/v1/my-all-events.json
	 * /wp-json/my-products/v1/my-all-products-on-json.json
	 * !IMPORTANT Важно что без необходимости не держать подключённым файл
	*/

	// require_once ( THEME_DIR . '/framework/api.php' );