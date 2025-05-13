<?php
/**
 * Подключение скриптов и стилей
 */
if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'stm_load_theme_ss');
}

function stm_load_theme_ss() {
    // Стили
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/assets/css/style.min.css', NULL, filemtime(get_stylesheet_directory() . '/assets/css/style.min.css'), 'all');
    
    // Сохраняем jQuery для плагинов WordPress, но загружаем его в футере
    wp_scripts()->add_data('jquery', 'group', 1);
    wp_scripts()->add_data('jquery-core', 'group', 1);
    wp_scripts()->add_data('jquery-migrate', 'group', 1);
    
    // Регистрируем библиотеки без зависимости от jQuery
    wp_enqueue_script('libs', get_template_directory_uri() . '/assets/js/lib.js', [], filemtime(get_template_directory() . '/assets/js/lib.js'), TRUE);
    
    // Используем случайное число в версии для предотвращения кеширования
    $version = time();
    wp_enqueue_script('app', get_template_directory_uri() . '/assets/js/app.js', [], $version, TRUE);
    
    // Локализация параметров WooCommerce для AJAX
    if (function_exists('WC')) {
        wp_localize_script('app', 'woocommerce_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
            'add_to_cart_nonce' => wp_create_nonce('add-to-cart')
        ));
    }
}