<?php

// Удаляем кнопку "Select options" внизу страницы товара
add_action('init', 'remove_select_options_button');
function remove_select_options_button() {
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', function () {
	global $product;
	echo '<a href="' . $product->get_permalink() . '">
		<div class="product__item-title">' . $product->get_title() . '</div>
    </a>';
});

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

// 
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
 	$fragments['span.mini-cart-btn-count'] = '<span class="action-number mini-cart-btn-count">' . count( WC()->cart->get_cart() ) . '</span>';
 	return $fragments;
} );

/**
 * @snippet       Get Current Variation Info @ WooCommerce Single Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 7
 * @community     https://businessbloomer.com/club/
 */
 
add_action( 'woocommerce_after_add_to_cart_form', 'bbloomer_echo_variation_info' );
function bbloomer_echo_variation_info() {
   global $product;
   if ( ! $product->is_type( 'variable' ) ) return;
   // echo '<div class="product__price"></div>';
   wc_enqueue_js( "
      $(document).on('found_variation', 'form.cart', function( event, variation ) { 
         $('.product__price').html(variation.price_html); // SIMPLY CHANGE price_html INTO ONE OF THE KEYS BELOW       
      });
   " );
}


// 1. Кнопки плюс/минус для добавления количества на странице товара и в корзине.
add_action( 'woocommerce_after_quantity_input_field', 'truemisha_quantity_minus', 25 );
add_action( 'woocommerce_before_quantity_input_field', 'truemisha_quantity_plus', 25 );
 
function truemisha_quantity_minus() {
	echo '<button type="button" class="minus">-</button>';
}

function truemisha_quantity_plus() {
   echo '<button type="button" class="plus">+</button>';
}
 

// 2. jQuery script для кнопок.
add_action( 'wp_footer', 'my_quantity_plus_minus' );
function my_quantity_plus_minus() {
 
   if ( ! is_product() && ! is_cart() ) return;
   ?>
      <script type="text/javascript">
 
      jQuery( function( $ ) {   
         $(document).on( 'click', 'button.plus, button.minus', function() {
 
         var qty = $( this ).parent( '.quantity' ).find( '.qty' );
         var val = parseFloat(qty.val());
         var max = parseFloat(qty.attr( 'max' ));
         var min = parseFloat(qty.attr( 'min' ));
         var step = parseFloat(qty.attr( 'step' ));
 
         if ( $( this ).is( '.plus' ) ) {
            if ( max && ( max <= val ) ) {
               qty.val( max ).change();
            } else {
               qty.val( val + step ).change();
            }
         } else {
            if ( min && ( min >= val ) ) {
               qty.val( min ).change();
            } else if ( val > 1 ) {
               qty.val( val - step ).change();
            }
         }
       });

 });
       </script>
   <?php
}

// Авто обновление корзины при добавление количества.
add_action( 'wp_footer', 'cart_update_qty_script' );
function cart_update_qty_script() {
    if (is_cart()) :
    ?>
    <script>
        jQuery('div.woocommerce').on('change', '.qty', function(){
            jQuery("[name='update_cart']").removeAttr("disabled").trigger("click");
	        setTimeout(function () {  jQuery("[name='update_cart']").trigger("click"); }, 1000);
        });
    </script>
    <?php
    endif;
}

// remove item from account nav bar
add_filter( 'woocommerce_account_menu_items', 'eplis_remove_downloads_tab_my_account', 999 );
function eplis_remove_downloads_tab_my_account( $items ) {
   // You can add other tab names
   unset($items['downloads']);
   return $items;
}

// remove order notes
add_filter('woocommerce_enable_order_notes_field', '__return_false');

// remove some fields from billings form
add_filter( 'woocommerce_checkout_fields', 'wpbl_remove_some_fields', 9999 );
function wpbl_remove_some_fields( $array ) {
 
    unset( $array['order']['order_comments'] ); // Примечание к заказу
 
    unset( $array['billing']['billing_company'] ); // Компания
    unset( $array['billing']['billing_address_2'] ); // 2-ая строка адреса 
    // unset( $array['billing']['billing_city'] ); // Населённый пункт
    unset( $array['billing']['billing_state'] ); // Область / район
    // unset( $array['billing']['billing_postcode'] ); // Почтовый индекс
     
    // Возвращаем обработанный массив
    return $array;
}

// account - cancel button
add_filter( 'woocommerce_valid_order_statuses_for_cancel', 'wpsh_add_cancel_button', 20, 2 );
function wpsh_add_cancel_button( $statuses, $order = '' ){

    // Set HERE the order statuses where you want the cancel button to appear
    $custom_statuses    = array( 'pending', 'processing', 'on-hold', 'failed' );

    // Set HERE the delay (in days)
    $duration = 3; // 3 days

    // UPDATE: Get the order ID and the WC_Order object
    if( ! is_object( $order ) && isset($_GET['order_id']) )
        $order = wc_get_order( absint( $_GET['order_id'] ) );

    $delay = $duration*24*60*60; // (duration in seconds)
    $date_created_time  = strtotime($order->get_date_created()); // Creation date time stamp
    $date_modified_time = strtotime($order->get_date_modified()); // Modified date time stamp
    $now = strtotime("now"); // Now  time stamp

    // Using Creation date time stamp
    if ( ( $date_created_time + $delay ) >= $now ) return $custom_statuses;
    else return $statuses;
}

// account - detail order
add_filter( 'woocommerce_my_account_my_orders_columns', 'wpsh_product_column', 10, 1 );
function wpsh_product_column( $columns ) {
    $new_columns = [];

    foreach ( $columns as $key => $name ) {
        $new_columns[ $key ] = $name;

        if ( 'order-status' === $key ) {
            $new_columns['order-items'] = __( 'Product | Qty', 'woocommerce' );
        }
    }
    return $new_columns;
}

// account - detail order
add_action( 'woocommerce_my_account_my_orders_column_order-items', 'wpsh_product_column_content', 10, 1 );
function wpsh_product_column_content( $order ) {
    $details = array();

    foreach( $order->get_items() as $item )
        $details[] = $item->get_name() . ' × ' . $item->get_quantity();

    echo count( $details ) > 0 ? implode( '<br>', $details ) : '–';
}


// Set Woocommerce my account page orders display limit
add_filter( 'woocommerce_my_account_my_orders_query', 'wpsh_my_account_orders_limit', 10, 1 );
function wpsh_my_account_orders_limit( $args ) {
    // Set the post per page
    $args['limit'] = 5;
    return $args;
}


// Add "Order again" button to Woocommerce my account page
add_filter( 'woocommerce_my_account_my_orders_actions', 'wpsh_order_again_button', 9999, 2 );
function wpsh_order_again_button( $actions, $order ) {
    if ( $order->has_status( 'completed' ) ) {
        $actions['order-again'] = array(
            'url' => wp_nonce_url( add_query_arg( 'order_again', $order->get_id(), wc_get_cart_url() ), 'woocommerce-order_again' ),
            'name' => __( 'Order again', 'woocommerce' ),
        );
    }
    return $actions;
}


// Add sale badge and new badge to product image top
add_action( 'woocommerce_sale_flash', 'display_product_badges', 25 );
function display_product_badges() {
    global $product;

    // Check if product is on sale and calculate maximum sale percentage
    $max_percentage = 0;
    if ( $product->is_on_sale() ) {
        if ( $product->is_type( 'simple' ) ) {
            $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
        } elseif ( $product->is_type( 'variable' ) ) {
            foreach ( $product->get_children() as $child_id ) {
                $variation = wc_get_product( $child_id );
                $price = $variation->get_regular_price();
                $sale = $variation->get_sale_price();
                if ( $price != 0 && ! empty( $sale ) ) {
                    $percentage = ( $price - $sale ) / $price * 100;
                    if ( $percentage > $max_percentage ) {
                        $max_percentage = $percentage;
                    }
                }
            }
        }
    }

    // Get the product's post date
    $post_date = get_post_time( 'U', false, $product->get_id() );

    // Get the number of days you consider a product as "new"
    $new_days = 7; // Change this value as per your requirement

    // Calculate the timestamp for the threshold date
    $threshold_timestamp = strtotime( '-' . $new_days . ' days' );

    // Check if the product is considered new
    $is_new = $post_date > $threshold_timestamp;

    // Check if the product is popular (e.g., has a certain category)
    $is_featured = has_term( 'featured', 'product_cat', $product->get_id() );

    // Output the badges
    if ( $max_percentage > 0 || $is_new || $is_featured ) {
        echo '<div class="product__img--top">';
        if ( $is_featured ) {
            echo '<div class="product__react-icon product__top"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.15221 11.6692C4.97115 11.6692 4.90478 11.5441 5.00422 11.3894L10.6536 2.60148C10.7529 2.44697 10.8335 2.47026 10.8335 2.66202V7.99052C10.8335 8.17846 10.9856 8.33081 11.1613 8.33081H14.5117C14.6927 8.33081 14.7591 8.45588 14.6597 8.61056L9.01027 17.3985C8.91095 17.553 8.83043 17.5297 8.83043 17.338V12.0095C8.83043 11.8215 8.67828 11.6692 8.5026 11.6692H5.15221Z" fill="white" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg></div>';
        }
        if ( $is_new ) {
            echo '<div class="product__react-icon product__new">NEW</div>';
        }
        if ( $max_percentage > 0 ) {
            echo '<div class="product__react-icon product__onsale">-' . round( $max_percentage ) . '%</div>';
        }
        echo '</div>';
    }
}

// =======================================
// Wishlist custom button / ajax
// =======================================
if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_get_items_count' ) ) {
  function yith_wcwl_get_items_count() {
    ob_start();
    ?>

      <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" class="action-btn favorite-btn">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.32 15.36C15.168 16.6306 12 19.68 12 19.68C12 19.68 8.83201 16.6306 7.68001 15.36C4.99201 12.3953 4.32001 11.2377 4.32001 9.12003C4.32001 7.00238 5.85601 5.28003 8.16001 5.28003C10.08 5.28003 11.232 6.55062 12 7.82121C12.768 6.55062 13.92 5.28003 15.84 5.28003C18.144 5.28003 19.68 7.00238 19.68 9.12003C19.68 11.2377 19.008 12.3953 16.32 15.36Z" stroke="#154928" stroke-width="1.2"/></svg>
          <span class="action-number yith-wcwl-items-count">
            <?php echo esc_html( yith_wcwl_count_all_products() ); ?>
          </span>
      </a>

    <?php
    return ob_get_clean();
  }
  add_shortcode( 'yith_wcwl_items_count', 'yith_wcwl_get_items_count' );
}

if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_ajax_update_count' ) ) {
  function yith_wcwl_ajax_update_count() {
    wp_send_json( array(
      'count' => yith_wcwl_count_all_products()
    ) );
  }

  add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
  add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
}

if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_enqueue_custom_script' ) ) {
  function yith_wcwl_enqueue_custom_script() {
    wp_add_inline_script(
      'jquery-yith-wcwl',
      "
        jQuery( function( $ ) {
          $( document ).on( 'added_to_wishlist removed_from_wishlist', function() {
            $.get( yith_wcwl_l10n.ajax_url, {
              action: 'yith_wcwl_update_wishlist_count'
            }, function( data ) {
              $('.yith-wcwl-items-count').html( data.count );
            } );
          } );
        } );
      "
    );
  }
  add_action( 'wp_enqueue_scripts', 'yith_wcwl_enqueue_custom_script', 20 );
}