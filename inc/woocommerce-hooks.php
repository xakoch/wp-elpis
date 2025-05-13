<?php
/**
 * Оптимизация WooCommerce
 * Файл: inc/woocommerce-hooks.php
 */

// =======================================
// 1. Оптимизация страницы товара и списка товаров
// =======================================

// Удаляем ненужные элементы
add_action('init', 'remove_unnecessary_woocommerce_elements');
function remove_unnecessary_woocommerce_elements() {
    // Удаляем кнопку "Select options" и другие элементы
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    
    // Отключаем стили WooCommerce
    add_filter('woocommerce_enqueue_styles', '__return_false');
    
    // Модификация заголовка в списке товаров
    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
    add_action('woocommerce_shop_loop_item_title', function() {
        global $product;
        echo '<a href="' . $product->get_permalink() . '">
            <div class="product__item-title">' . $product->get_title() . '</div>
        </a>';
    });
    
    // Удаляем хлебные крошки и счетчик результатов
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
}

// Обновление информации о вариациях в режиме реального времени
add_action('woocommerce_after_add_to_cart_form', 'update_variation_info');
function update_variation_info() {
   global $product;
   if (!$product->is_type('variable')) return;
   
   wc_enqueue_js("
      $(document).on('found_variation', 'form.cart', function(event, variation) { 
         $('.product__price').html(variation.price_html);      
      });
   ");
}

// Добавляем кнопки плюс/минус для указания количества
add_action('woocommerce_before_quantity_input_field', 'quantity_plus_button', 25);
add_action('woocommerce_after_quantity_input_field', 'quantity_minus_button', 25);

function quantity_plus_button() {
   echo '<button type="button" class="plus">+</button>';
}

function quantity_minus_button() {
   echo '<button type="button" class="minus">-</button>';
}

// JavaScript для кнопок +/- количества
add_action('wp_footer', 'quantity_buttons_script');
function quantity_buttons_script() {
   if (!is_product() && !is_cart()) return;
   ?>
   <script type="text/javascript">
   jQuery(function($) {
      $(document).on('click', 'button.plus, button.minus', function() {
         var qty = $(this).parent('.quantity').find('.qty');
         var val = parseFloat(qty.val());
         var max = parseFloat(qty.attr('max'));
         var min = parseFloat(qty.attr('min'));
         var step = parseFloat(qty.attr('step'));
         
         if ($(this).is('.plus')) {
            if (max && (max <= val)) {
               qty.val(max).change();
            } else {
               qty.val(val + step).change();
            }
         } else {
            if (min && (min >= val)) {
               qty.val(min).change();
            } else if (val > 1) {
               qty.val(val - step).change();
            }
         }
      });
   });
   </script>
   <?php
}

// Автообновление корзины при изменении количества
add_action('wp_footer', 'auto_update_cart_script');
function auto_update_cart_script() {
    if (!is_cart()) return;
    ?>
    <script>
    jQuery('div.woocommerce').on('change', '.qty', function(){
        jQuery("[name='update_cart']").removeAttr("disabled").trigger("click");
        setTimeout(function() { jQuery("[name='update_cart']").trigger("click"); }, 1000);
    });
    </script>
    <?php
}

// Добавляем бейджи товаров (скидка, новинки, популярные)
add_action('woocommerce_sale_flash', 'display_product_badges', 25);
function display_product_badges() {
    global $product;

    // Рассчитываем максимальный процент скидки
    $max_percentage = 0;
    if ($product->is_on_sale()) {
        if ($product->is_type('simple')) {
            $max_percentage = (($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100;
        } elseif ($product->is_type('variable')) {
            foreach ($product->get_children() as $child_id) {
                $variation = wc_get_product($child_id);
                $price = $variation->get_regular_price();
                $sale = $variation->get_sale_price();
                if ($price != 0 && !empty($sale)) {
                    $percentage = ($price - $sale) / $price * 100;
                    if ($percentage > $max_percentage) {
                        $max_percentage = $percentage;
                    }
                }
            }
        }
    }

    // Проверяем, новый ли товар (добавлен в течение последних 7 дней)
    $post_date = get_post_time('U', false, $product->get_id());
    $new_days = 7; 
    $threshold_timestamp = strtotime('-' . $new_days . ' days');
    $is_new = $post_date > $threshold_timestamp;

    // Проверяем, является ли товар популярным
    $is_featured = has_term('featured', 'product_cat', $product->get_id());

    // Выводим бейджи если есть
    if ($max_percentage > 0 || $is_new || $is_featured) {
        echo '<div class="product__img--top">';
        if ($is_featured) {
            echo '<div class="product__react-icon product__top"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.15221 11.6692C4.97115 11.6692 4.90478 11.5441 5.00422 11.3894L10.6536 2.60148C10.7529 2.44697 10.8335 2.47026 10.8335 2.66202V7.99052C10.8335 8.17846 10.9856 8.33081 11.1613 8.33081H14.5117C14.6927 8.33081 14.7591 8.45588 14.6597 8.61056L9.01027 17.3985C8.91095 17.553 8.83043 17.5297 8.83043 17.338V12.0095C8.83043 11.8215 8.67828 11.6692 8.5026 11.6692H5.15221Z" fill="white" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg></div>';
        }
        if ($is_new) {
            echo '<div class="product__react-icon product__new">NEW</div>';
        }
        if ($max_percentage > 0) {
            echo '<div class="product__react-icon product__onsale">-' . round($max_percentage) . '%</div>';
        }
        echo '</div>';
    }
}

// =======================================
// 2. Оптимизированный попап выбора вариаций товара
// =======================================

// AJAX функция для получения опций товара
function get_product_options() {
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(['message' => 'ID produktu jest wymagane']);
        return;
    }
    
    $product_id = intval($_POST['product_id']);
    $product = wc_get_product($product_id);
    
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error(['message' => 'Produkt nie znaleziony lub nie jest produktem zmiennym']);
        return;
    }
    
    // Получаем вариации и атрибуты
    $variations = $product->get_available_variations();
    $attributes = $product->get_variation_attributes();
    
    ob_start();
    ?>
    <form class="product-options-form">
        <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
        
        <!-- Убрано фото товара для оптимизации -->
        
        <div class="product-options-price">
            <?php echo $product->get_price_html(); ?>
        </div>
        
        <?php foreach ($attributes as $attribute_name => $options) : 
            $attribute_label = wc_attribute_label($attribute_name);
            
            // Заменяем английские названия на польские
            if (strtolower($attribute_label) == 'weight') {
                $attribute_label = 'Waga';
            }
        ?>
            <div class="product-option">
                <label><?php echo esc_html($attribute_label); ?>:</label>
                <div class="product-option-field">
                    <select name="attribute_<?php echo sanitize_title($attribute_name); ?>" class="option-select" data-attribute="<?php echo sanitize_title($attribute_name); ?>" required>
                        <option value=""><?php echo esc_html(sprintf(__('Wybierz %s', 'woocommerce'), $attribute_label)); ?></option>
                        <?php foreach ($options as $option) : ?>
                            <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        <?php endforeach; ?>
        
        <!-- Данные о вариациях для обновления цены через JS -->
        <div class="variations-data" style="display:none;" 
             data-product-variations="<?php echo esc_attr(wp_json_encode($variations)); ?>">
        </div>
        
        <button type="submit" class="add-to-cart-btn" disabled><?php echo __('Dodaj do koszyka', 'woocommerce'); ?></button>
    </form>
    <?php
    $html = ob_get_clean();
    
    wp_send_json_success(['html' => $html]);
}

// Регистрируем AJAX обработчики для попапа вариаций
add_action('wp_ajax_get_product_options', 'get_product_options');
add_action('wp_ajax_nopriv_get_product_options', 'get_product_options');

// AJAX обработчик для добавления вариации в корзину
function add_to_cart_variation() {
    if (!isset($_POST['product_id'])) {
        wp_send_json_error([
            'success' => false,
            'message' => 'ID produktu jest wymagane'
        ]);
        wp_die();
    }
    
    $product_id = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // Получаем товар
    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error([
            'success' => false,
            'message' => 'Nie znaleziono produktu'
        ]);
        wp_die();
    }
    
    // Обработка вариативного товара
    if ($product->is_type('variable')) {
        // Собираем атрибуты
        $attributes = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'attribute_') === 0) {
                $attributes[$key] = wc_clean($value);
            }
        }
        
        // Ищем подходящую вариацию
        $variation_id = false;
        $available_variations = $product->get_available_variations();
        
        foreach ($available_variations as $variation) {
            $match = true;
            foreach ($attributes as $key => $value) {
                $attr_key = str_replace('attribute_', '', $key);
                if (!isset($variation['attributes']['attribute_' . $attr_key]) || 
                    $variation['attributes']['attribute_' . $attr_key] != $value && 
                    $variation['attributes']['attribute_' . $attr_key] != '') {
                    $match = false;
                    break;
                }
            }
            
            if ($match) {
                $variation_id = $variation['variation_id'];
                break;
            }
        }
        
        if (!$variation_id) {
            wp_send_json_error([
                'success' => false,
                'message' => 'Nie znaleziono pasującej wersji produktu'
            ]);
            wp_die();
        }
        
        // Добавляем в корзину
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $attributes);
    } else {
        // Простой товар
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);
    }
    
    // Проверяем результат
    if ($cart_item_key) {
        wp_send_json_success([
            'success' => true,
            'message' => 'Produkt dodany do koszyka',
            'cart_count' => WC()->cart->get_cart_contents_count()
        ]);
    } else {
        wp_send_json_error([
            'success' => false,
            'message' => 'Nie udało się dodać produktu do koszyka'
        ]);
    }
    
    wp_die();
}

// Регистрируем AJAX обработчик для добавления в корзину
add_action('wp_ajax_add_to_cart_variation', 'add_to_cart_variation');
add_action('wp_ajax_nopriv_add_to_cart_variation', 'add_to_cart_variation');

// =======================================
// 3. Оптимизация мини-корзины
// =======================================

// Получение обновленной мини-корзины через AJAX
function get_refreshed_mini_cart() {
    ob_start();
    
    // Отключаем фильтры, которые могут мешать правильному отображению
    remove_all_filters('woocommerce_before_mini_cart');
    remove_all_filters('woocommerce_after_mini_cart');
    
    // Убедимся, что объект корзины инициализирован
    if (WC()->cart === null) {
        wc_load_cart();
    }
    
    // Пересчитываем корзину
    WC()->cart->calculate_totals();
    
    // Выводим мини-корзину
    woocommerce_mini_cart();
    
    $mini_cart_html = ob_get_clean();
    
    wp_send_json_success([
        'html' => $mini_cart_html,
        'count' => WC()->cart->get_cart_contents_count()
    ]);
    
    wp_die();
}

// Регистрируем AJAX обработчики для мини-корзины
add_action('wp_ajax_get_refreshed_mini_cart', 'get_refreshed_mini_cart');
add_action('wp_ajax_nopriv_get_refreshed_mini_cart', 'get_refreshed_mini_cart');

// Оптимизация фрагментов корзины
add_filter('woocommerce_add_to_cart_fragments', 'optimized_cart_fragments');
function optimized_cart_fragments($fragments) {
    $fragments['span.mini-cart-btn-count'] = '<span class="action-number mini-cart-btn-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
}

// Оптимизированный JavaScript для корзины
add_action('wp_footer', 'optimized_cart_js', 99);
function optimized_cart_js() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Кеширование DOM элементов
        const body = document.body;
        const miniCart = document.querySelector('.m-cart');
        const overlay = document.querySelector('.overlay');
        
        // Обработчик события добавления в корзину
        if (typeof jQuery !== 'undefined') {
            jQuery(body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
                // Открываем мини-корзину
                openMiniCart();
                
                // Удаляем класс added с кнопки
                if ($button && $button.length) {
                    setTimeout(function() {
                        $button.removeClass('added');
                        
                        // Удаляем ссылку "Zobacz koszyk"
                        const $productBtn = $button.closest('.product__btn');
                        if ($productBtn.length) {
                            $productBtn.find('.added_to_cart').remove();
                        }
                    }, 10);
                }
            });
            
            // Обработка удаления товара из мини-корзины
            jQuery(body).on('click', '.remove_from_cart_button', function(e) {
                e.preventDefault();
                
                // Добавляем класс для визуальной индикации загрузки
                const $item = jQuery(this).closest('.mini_cart_item');
                if ($item.length) {
                    $item.addClass('removing');
                }
            });
        }
        
        // Функция открытия мини-корзины
        function openMiniCart() {
            if (miniCart && overlay) {
                body.classList.add('overflow');
                overlay.classList.add('is-active');
                miniCart.classList.add('is-active');
            }
        }
    });
    </script>
    
    <style>
    /* Стили для улучшения UX при загрузке */
    .mini_cart_item.removing {
        opacity: 0.5;
        pointer-events: none;
    }
    </style>
    <?php
}

// Добавляем JavaScript для вывода параметров WooCommerce
add_action('wp_footer', 'add_cart_scripts', 20);
function add_cart_scripts() {
    ?>
    <script type="text/javascript">
    (function() {
        // Обеспечиваем глобальную доступность параметров WooCommerce
        if (typeof woocommerce_params === 'undefined') {
            window.woocommerce_params = {
                ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>'
            };
        }
    })();
    </script>
    <?php
}

// =======================================
// 4. Настройки аккаунта пользователя
// =======================================

// Удаляем вкладку "Загрузки" из меню аккаунта
add_filter('woocommerce_account_menu_items', 'remove_downloads_tab_my_account', 999);
function remove_downloads_tab_my_account($items) {
   unset($items['downloads']);
   return $items;
}

// Удаляем примечания к заказу
add_filter('woocommerce_enable_order_notes_field', '__return_false');

// Удаляем ненужные поля из формы оформления заказа
add_filter('woocommerce_checkout_fields', 'simplify_checkout_fields', 9999);
function simplify_checkout_fields($array) {
    unset($array['order']['order_comments']); // Примечание к заказу
    unset($array['billing']['billing_company']); // Компания
    unset($array['billing']['billing_address_2']); // 2-ая строка адреса 
    unset($array['billing']['billing_state']); // Область / район
    
    return $array;
}

// Добавляем кнопку отмены заказа с ограничением по времени (3 дня)
add_filter('woocommerce_valid_order_statuses_for_cancel', 'add_cancel_button', 20, 2);
function add_cancel_button($statuses, $order = '') {
    $custom_statuses = array('pending', 'processing', 'on-hold', 'failed');
    $duration = 3; // 3 days

    if(!is_object($order) && isset($_GET['order_id']))
        $order = wc_get_order(absint($_GET['order_id']));

    $delay = $duration * 24 * 60 * 60; 
    $date_created_time = strtotime($order->get_date_created());
    $now = strtotime("now");

    if(($date_created_time + $delay) >= $now) return $custom_statuses;
    else return $statuses;
}

// Показываем информацию о товарах в списке заказов
add_filter('woocommerce_my_account_my_orders_columns', 'add_product_column', 10, 1);
function add_product_column($columns) {
    $new_columns = [];

    foreach($columns as $key => $name) {
        $new_columns[$key] = $name;

        if('order-status' === $key) {
            $new_columns['order-items'] = __('Product | Qty', 'woocommerce');
        }
    }
    return $new_columns;
}

// Выводим товары в колонке заказов
add_action('woocommerce_my_account_my_orders_column_order-items', 'show_product_column_content', 10, 1);
function show_product_column_content($order) {
    $details = array();

    foreach($order->get_items() as $item)
        $details[] = $item->get_name() . ' × ' . $item->get_quantity();

    echo count($details) > 0 ? implode('<br>', $details) : '–';
}

// Ограничиваем количество заказов на странице аккаунта
add_filter('woocommerce_my_account_my_orders_query', 'limit_account_orders', 10, 1);
function limit_account_orders($args) {
    $args['limit'] = 5;
    return $args;
}

// Добавляем кнопку "Заказать снова" в аккаунте
add_filter('woocommerce_my_account_my_orders_actions', 'add_order_again_button', 9999, 2);
function add_order_again_button($actions, $order) {
    if($order->has_status('completed')) {
        $actions['order-again'] = array(
            'url' => wp_nonce_url(add_query_arg('order_again', $order->get_id(), wc_get_cart_url()), 'woocommerce-order_again'),
            'name' => __('Order again', 'woocommerce'),
        );
    }
    return $actions;
}

// =======================================
// 5. Интеграция с Wishlist (YITH)
// =======================================

if(defined('YITH_WCWL') && !function_exists('yith_wcwl_get_items_count')) {
  function yith_wcwl_get_items_count() {
    ob_start();
    ?>
      <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" class="action-btn favorite-btn">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.32 15.36C15.168 16.6306 12 19.68 12 19.68C12 19.68 8.83201 16.6306 7.68001 15.36C4.99201 12.3953 4.32001 11.2377 4.32001 9.12003C4.32001 7.00238 5.85601 5.28003 8.16001 5.28003C10.08 5.28003 11.232 6.55062 12 7.82121C12.768 6.55062 13.92 5.28003 15.84 5.28003C18.144 5.28003 19.68 7.00238 19.68 9.12003C19.68 11.2377 19.008 12.3953 16.32 15.36Z" stroke="#154928" stroke-width="1.2"/></svg>
          <span class="action-number yith-wcwl-items-count">
            <?php echo esc_html(yith_wcwl_count_all_products()); ?>
          </span>
      </a>
    <?php
    return ob_get_clean();
  }
  add_shortcode('yith_wcwl_items_count', 'yith_wcwl_get_items_count');
}

// AJAX обновление счетчика Wishlist
if(defined('YITH_WCWL') && !function_exists('yith_wcwl_ajax_update_count')) {
  function yith_wcwl_ajax_update_count() {
    wp_send_json(array(
      'count' => yith_wcwl_count_all_products()
    ));
  }
  add_action('wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count');
  add_action('wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count');
}

// Подключаем JavaScript для AJAX обновления Wishlist
if(defined('YITH_WCWL') && !function_exists('yith_wcwl_enqueue_custom_script')) {
  function yith_wcwl_enqueue_custom_script() {
    wp_add_inline_script(
      'jquery-yith-wcwl',
      "
        jQuery(function($) {
          $(document).on('added_to_wishlist removed_from_wishlist', function() {
            $.get(yith_wcwl_l10n.ajax_url, {
              action: 'yith_wcwl_update_wishlist_count'
            }, function(data) {
              $('.yith-wcwl-items-count').html(data.count);
            });
          });
        });
      "
    );
  }
  add_action('wp_enqueue_scripts', 'yith_wcwl_enqueue_custom_script', 20);
}

// =======================================
// 6. Оптимизация производительности
// =======================================

// Отключаем ненужные хуки, которые могут замедлять корзину
add_action('init', 'disable_unnecessary_cart_hooks');
function disable_unnecessary_cart_hooks() {
    // Отключаем медленные хуки
    remove_action('woocommerce_before_calculate_totals', 'custom_price_calculation', 10);
    remove_action('woocommerce_add_to_cart', 'custom_add_to_cart_action', 10);
    remove_action('woocommerce_cart_item_removed', 'custom_cart_item_removed_action', 10);
    
    // Отключаем WooCommerce AJAX fragments, если они замедляют работу
    add_filter('woocommerce_cart_fragment_refresh', '__return_false');
}

// Быстрый вариант добавления в корзину
function direct_add_to_cart() {
    if(!isset($_POST['product_id'])) {
        wp_send_json_error(['message' => 'ID produktu jest wymagane']);
        wp_die();
    }
    
    $product_id = absint($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;
    
    // Добавляем в корзину напрямую
    $added = WC()->cart->add_to_cart($product_id, $quantity);
    
    if($added) {
        wp_send_json_success([
            'cart_count' => WC()->cart->get_cart_contents_count()
        ]);
    } else {
        wp_send_json_error(['message' => 'Nie udało się dodać produktu do koszyka']);
    }
    
    wp_die();
}
add_action('wp_ajax_direct_add_to_cart', 'direct_add_to_cart');
add_action('wp_ajax_nopriv_direct_add_to_cart', 'direct_add_to_cart');