<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */
defined( 'ABSPATH' ) || exit;

// Отключаем стандартное сообщение о пустой корзине
remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message' );

// Добавляем наши стили и макет
?>
<div class="empty-cart-container" style="text-align: center; padding: 40px 20px;">

    <!-- Иконка корзины с X -->
    <div class="empty-cart-icon" style="margin-bottom: 30px;">
        <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M116.667 35L105 105H35L23.3333 35H116.667Z" stroke="#E8E6E0" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M88.3333 45.8333L70 64.1667M70 45.8333L88.3333 64.1667" stroke="#E8E6E0" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="43.75" cy="105" r="8.75" fill="#E8E6E0"/>
            <circle cx="96.25" cy="105" r="8.75" fill="#E8E6E0"/>
        </svg>
    </div>
    
    <!-- Заголовок "Корзина пуста" -->
    <h1 style="font-size: 36px; color: #333; margin-bottom: 20px;">Twój koszyk jest pusty.</h1>
    
    <!-- Объясняющий текст -->
    <p style="font-size: 16px; color: #666; max-width: 600px; margin: 0 auto 30px;">
        Przed przejściem do kasy musisz dodać produkty do koszyka. Znajdziesz wiele interesujących produktów na naszej stronie "Sklep".
    </p>
    
    <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <p class="return-to-shop">
            <a class="button wc-backward btn" style="background-color: #00ad4a; color: white; padding: 16px 40px; width: fit-content; border-radius: 30px; text-decoration: none; font-weight: bold; display: inline-block;" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                <?php echo esc_html( 'Powrót Do Sklepu' ); ?>
            </a>
        </p>
    <?php endif; ?>
</div>