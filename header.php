<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php 
        global $page, $paged;
        wp_title('|', true, 'right');
        bloginfo('name');
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page()))
            echo " | $site_description";
        if ($paged >= 2 || $page >= 2)
        echo ' | ' . sprintf(__('Page %s', 'twentyten'), max($paged, $page));
        ?>
    </title>
    <!-- favicon -->
    <meta name="msapplication-TileColor" content="#00AD4A">
    <meta name="theme-color" content="#00AD4A">
    <!-- ios -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#00AD4A">
    <!-- CSS -->
	<style>


		
/* CSS для попапа опций товара */
.product__item {
    position: relative;
}

.product-quick-options {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.95);
    z-index: 100;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.quick-options-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 15px;
}

.quick-options-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
}

.quick-options-title {
    font-weight: 600;
    font-size: 16px;
    color: #154928;
}

.quick-options-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #888;
    cursor: pointer;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-options-close:hover {
    color: #154928;
}

.quick-options-content {
    flex: 1;
    overflow-y: auto;
}

.product-options-form {
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.product-options-image {
    text-align: center;
    margin-bottom: 10px;
}

.product-options-image img {
    max-width: 80px;
    border-radius: 4px;
}

.product-options-price {
    font-size: 20px;
    font-weight: bold;
    color: #00ad4a;
    text-align: center;
    margin-bottom: 5px;
}

.product-option {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.product-option label {
    font-size: 14px;
    color: #333;
}

.option-select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 30px;
    font-size: 14px;
    color: #154928;
    background-color: #fff;
}

.add-to-cart-btn {
    background: #00ad4a;
    color: white;
    border: none;
    border-radius: 30px;
    padding: 10px 15px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 5px;
max-width: 100% !important;
    height: 50px !important;
}

.add-to-cart-btn:hover {
    background: #154928;
}

.add-to-cart-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.loading-spinner {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 0;
}

.loading-spinner:after {
    content: "";
    width: 24px;
    height: 24px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #00ad4a;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Стили для уведомлений */
.product-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 12px 20px;
    background: #fff;
    color: #333;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 9999;
    font-size: 14px;
}

.product-notification.show {
    transform: translateY(0);
    opacity: 1;
}

.product-notification-success {
    border-left: 4px solid #00ad4a;
}

.product-notification-error {
    border-left: 4px solid #f44336;
}
/* Стили для мини-попапа вариаций */
.product-options-form {
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.product-options-price {
    font-size: 20px;
    font-weight: bold;
    color: #00ad4a;
    text-align: center;
    margin-bottom: 5px;
}

.product-option {
    margin-bottom: 10px;
}

.product-option label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #333;
}

.product-option-field select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 24px;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
    padding-right: 30px;
}

.add-to-cart-btn {
    margin-top: 5px;
    padding: 12px;
    border: none;
    border-radius: 24px;
    background-color: #00ad4a;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s;
}

.add-to-cart-btn:hover {
    background-color: #008c3c;
}

.add-to-cart-btn:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

/* Стили для индикатора загрузки мини-корзины */
.mini_cart_item.removing {
    opacity: 0.5;
    transition: opacity 0.2s;
    pointer-events: none;
}

/* Заголовок в мини-попапе */
.quick-options-title {
    font-size: 18px;
    font-weight: 600;
    color: #154928;
}

.quick-options-header {
    padding-bottom: 10px;
    margin-bottom: 15px;
    border-bottom: 1px solid #eee;
}
    @media only screen and (max-width: 991px) {
        .quick-options-title {
            font-size: 14px;
        }
        .add-to-cart-btn {
            padding: 0 !important;
            font-size: 12px !important;
            height: 40px !important;
            background: #00ad4a;
        }
    }
	</style>
    <?php wp_head(); ?>
    <!-- Google Tag Manager -->
    
    <!-- End Google Tag Manager -->
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
    <!-- Google Tag Manager (noscript) -->
    
    <!-- End Google Tag Manager (noscript) -->

    <header class="header">
        <div class="container">
            <div class="header__inner">
                <div class="header__col header__left">
                
                    <a href="/">
                        <?php $logo = get_field('logo','option'); ?>
    					<img src="<?= $logo; ?>" alt="Elpis">
                    </a>

                    <?php

                        wp_nav_menu([
                            'theme_location'  => 'primary',
                            'menu'            => '',
                            'container'       => '',
                            'container_class' => '',
                            'container_id'    => '',
                            'menu_class'      => 'header__menu',
                            'echo'            => true,
                            'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                            'depth'           => 0,
                        ]);

                    ?>
                    <!-- ./desktop menu -->
                
                </div>
                <div class="header__col header__right">
                    <div class="component__btns">
                        
                        <a href="/search" class="component-btn search-btn">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.9121 14.4121L20.5 20" stroke="#154928" stroke-linecap="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 16C13.8137 16 16.5 13.3137 16.5 10C16.5 6.68629 13.8137 4 10.5 4C7.18629 4 4.5 6.68629 4.5 10C4.5 13.3137 7.18629 16 10.5 16Z" stroke="#154928"/></svg>
                            <span class="btn-text">Szukaj</span>
                        </a>

                        <?php if (is_user_logged_in()): ?>

                        <a href="<?= get_permalink(wc_get_page_id("myaccount")); ?>" class="component-btn cabinet-btn">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 20C4.5 17 8.5 17 10.5 15C11.5 14 8.5 14 8.5 9C8.5 5.667 9.833 4 12.5 4C15.167 4 16.5 5.667 16.5 9C16.5 14 13.5 14 14.5 15C16.5 17 20.5 17 20.5 20" stroke="#154928" stroke-width="1.2" stroke-linecap="round"/></svg>
                            <span class="btn-text">Mans konts</span>
                        </a>

                        <?php elseif(!is_user_logged_in()): ?>

                        <a href="<?= get_permalink(wc_get_page_id("myaccount")); ?>" class="component-btn cabinet-btn">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 20C4.5 17 8.5 17 10.5 15C11.5 14 8.5 14 8.5 9C8.5 5.667 9.833 4 12.5 4C15.167 4 16.5 5.667 16.5 9C16.5 14 13.5 14 14.5 15C16.5 17 20.5 17 20.5 20" stroke="#154928" stroke-width="1.2" stroke-linecap="round"/></svg>
                            <span class="btn-text">Logins</span>
                        </a>

                        <?php endif; ?>
                    
                    </div>
                    
                    <div class="action__btns">

                        <?= do_shortcode('[yith_wcwl_items_count]'); ?>
                        
                        <a href="#" class="action-btn cart-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12.4799V21.1199M12 12.4799L4.32001 7.67988M12 12.4799L19.68 7.67988M8.16001 5.27988L15.84 10.0799M4.32001 7.67988L12 2.87988L19.68 7.67988V16.3199L12 21.1199L4.32001 16.3199V7.67988Z" stroke="#154928" stroke-width="1.2"/></svg>
                            <span class="action-number mini-cart-btn-count">
                                <?= count(WC()->cart->get_cart()); ?>
                            </span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <header class="header header__mobile">
        <div class="container">
            <div class="header__inner">
                <div class="header__col header__left">
                    <button class="burger" type="button">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <a href="/">
                        <img src="<?= get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Elpis">
                    </a>
                </div>
                <div class="header__col header__right">
                    <div class="action__btns">
                        <?= do_shortcode('[yith_wcwl_items_count]'); ?>
                        <a href="#" class="action-btn cart-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12.4799V21.1199M12 12.4799L4.32001 7.67988M12 12.4799L19.68 7.67988M8.16001 5.27988L15.84 10.0799M4.32001 7.67988L12 2.87988L19.68 7.67988V16.3199L12 21.1199L4.32001 16.3199V7.67988Z" stroke="#154928" stroke-width="1.2"/></svg>
                            <span class="action-number mini-cart-btn-count">
                                <?= count(WC()->cart->get_cart()); ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="nav__mobile">

        <div class="nav__mobile--content">
            <div class="nav__mobile--top">
                <a href="/search" class="component-btn search-btn">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.9121 14.4121L20.5 20" stroke="#154928" stroke-linecap="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 16C13.8137 16 16.5 13.3137 16.5 10C16.5 6.68629 13.8137 4 10.5 4C7.18629 4 4.5 6.68629 4.5 10C4.5 13.3137 7.18629 16 10.5 16Z" stroke="#154928"/></svg>
                    <span class="btn-text">Szukaj</span>
                </a>

                <?php if (is_user_logged_in()): ?>

                <a href="<?= get_permalink(wc_get_page_id("myaccount")); ?>" class="component-btn cabinet-btn">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 20C4.5 17 8.5 17 10.5 15C11.5 14 8.5 14 8.5 9C8.5 5.667 9.833 4 12.5 4C15.167 4 16.5 5.667 16.5 9C16.5 14 13.5 14 14.5 15C16.5 17 20.5 17 20.5 20" stroke="#154928" stroke-width="1.2" stroke-linecap="round"/></svg>
                    <span class="btn-text">Mans konts</span>
                </a>

                <?php elseif(!is_user_logged_in()): ?>

                <a href="<?= get_permalink(wc_get_page_id("myaccount")); ?>" class="component-btn cabinet-btn">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 20C4.5 17 8.5 17 10.5 15C11.5 14 8.5 14 8.5 9C8.5 5.667 9.833 4 12.5 4C15.167 4 16.5 5.667 16.5 9C16.5 14 13.5 14 14.5 15C16.5 17 20.5 17 20.5 20" stroke="#154928" stroke-width="1.2" stroke-linecap="round"/></svg>
                    <span class="btn-text">Logins</span>
                </a>

                <?php endif; ?>
            </div>
            
            <?php
                wp_nav_menu([
                    'theme_location'  => 'primary',
                    'menu'            => '',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'header__menu nav__mobile--menu',
                    'echo'            => true,
                    'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                    'depth'           => 0,
                ]);
            ?>

            <div class="header__cta nav__mobile--cta">
                <span>Kontakt z nami</span>
                <a class="header-phone" href="tel:<?php the_field('phone_number','option'); ?>"><?php the_field('phone_number','option'); ?></a>
                <a class="header-mail" href="mailto:<?php the_field('email','option'); ?>"><?php the_field('email','option'); ?></a>
                <address><?php the_field('address','option'); ?></address>
            </div>

        </div>
    </div>