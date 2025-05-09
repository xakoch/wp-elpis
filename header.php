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
.woocommerce-message {
    background: #abefc9;
    padding: 15px;
    border-radius: 18px;
}
		.m-cart__title {
			font-size: 14px !important;
			line-height: 130%;
		}
		.thwvsf-wrapper-ul .thwvsf-wrapper-item-li.thwvsf-label-li.attr_swatch_design_2 {
			width: auto;
			height: 32px !important;
			color: #154928 !important;
			background-color: #fff;
			box-shadow: none !important;
			border: 1px solid #154928 !important;
			border-radius: 30px;
		}
		.thwvsf-wrapper-ul .thwvsf-wrapper-item-li.attr_swatch_design_2.thwvsf-selected {
			background-color: #154928 !important;
			color: #fff !important;
		}
		.thwvsf-wrapper-ul .thwvsf-label-li.attr_swatch_design_2 .thwvsf-item-span.item-span-text {
			font-size: 12px !important;
			padding: 0 10px !important;
		}
		.product__info .woocommerce-variation-add-to-cart.variations_button.woocommerce-variation-add-to-cart-enabled {
			display: none;
		}
		.product__info .product__weight-btns {
			position: static !important;
			margin-bottom: 20px;
		}
		.product__item .yith-wcwl-add-button .add_to_wishlist svg.yith-wcwl-icon-svg, 
		.product__info .yith-wcwl-add-button .add_to_wishlist svg.yith-wcwl-icon-svg {
			margin-right: 0;
		}
		.product__info .yith-wcwl-add-to-wishlist svg.yith-wcwl-icon-svg {
			width: 22px;
		}
		.product__title h1 {
			max-width: 95%;
		}
		.product__title h1,
		.product__item-title {
			line-height: 130%;
		}
		.product__kod {
			margin-bottom: 18px !important;
		}
		.product__info .yith-wcwl-add-button {
			top: 0;
			right: 0;
			width: 42px;
			height: 42px;
		}
		.cat__item {
			width: 180px !important;
		}
		.wishlist_table .woocommerce table.shop_table.wishlist_table tr td,
		table.wishlist_table tbody td {
			background: none !important;
		}
		table.wishlist_table table.shop_table .product-remove a,
		.remove.remove_from_wishlist {
			min-width: 32px !important;
		}
		ul.page-numbers {
			display: flex;
			justify-content: center;
			grid-gap: 20px;
			margin-top: 60px !important;
		}
		a.page-numbers,
		span.page-numbers {
			background: #fff;
			color: #154928;
			border-radius: 50%;
			width: 50px;
			height: 50px;
			text-align: center;
			display: block;
			line-height: 48px;
			border: 1px solid #154928;
			transition: .2s ease;
			font-size: 22px;
		}
		a.page-numbers:hover {
			background: #154928;
			color: #fff;		
		}
		span.page-numbers.current {
			background: #154928;
			color: #fff;
		}
		@media only screen and (max-width: 991px) {
			a.page-numbers,
			span.page-numbers {
				font-size: 16px;
				width: 40px;
				height: 40px;
				line-height: 38px;
			}
		}
		.product__footer {
			margin-bottom: auto;
		}
		.product__info .single_variation_wrap {
			display: none !important;
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