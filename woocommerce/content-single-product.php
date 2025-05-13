<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

?>

<div class="container">
	<?php
		/**
		 * Hook: woocommerce_before_single_product.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 */
		do_action( 'woocommerce_before_single_product' );
	?>
</div>

<section class="bread-section">
	<div class="container">
		<?php
			if (function_exists('xakoch_breadcrumbs')) xakoch_breadcrumbs();
		?>
	</div>
</section>

<?php

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<section id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product', $product ); ?>>

	<div class="container">
		<div class="product__gallery">
			<div class="thumbs-gallery">
			    
			    <?php
					$product_img_id = $product->get_image_id();
					if ( $product_img_id ) {
						$main_img = wp_get_attachment_url( $product_img_id );
					} else {
						$main_img = wc_placeholder_img_src( 'woocommerce_full' );
					}
					$product_img_ids = $product->get_gallery_image_ids();
				?>

			    <div class="swiper gallery-swiper gallery-thumbs swiper-container">
			        <div class="swiper-wrapper">

			        	<div class="swiper-slide">
			            	<div class="gallery-thumbs__item">
				            	<img src="<?= $main_img; ?>" alt="<?= $product->get_title(); ?>">
			            	</div>
			                <!-- <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div> -->
			            </div>

			        	<?php if ( $product_img_ids ): ?>
			        		<?php foreach ( $product_img_ids as $product_img_id ): ?>

			            <div class="swiper-slide">
			            	<div class="gallery-thumbs__item">
				            	<img src="<?= wp_get_attachment_url( $product_img_id ); ?>" alt="<?= $product->get_title(); ?>">
			            	</div>
			                <!-- <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div> -->
			            </div>

				            <?php endforeach; ?>
						<?php endif; ?>

			        </div>
			    </div>

			    <div class="swiper gallery-swiper gallery-top swiper-container">
			        <div class="swiper-wrapper">

			        	<div class="swiper-slide">
			            	<div class="gallery-top__item">
				            	<img src="<?= $main_img; ?>" alt="<?= $product->get_title(); ?>">
			            	</div>
			                <!-- <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div> -->
			            </div>

						<?php if ( $product_img_ids ): ?>
			        		<?php foreach ( $product_img_ids as $product_img_id ): ?>

				            <div class="swiper-slide">
				            	<div class="gallery-top__item">
					            	<img src="<?= wp_get_attachment_url( $product_img_id ); ?>" alt="<?= $product->get_title(); ?>">
				            	</div>
				            	<!-- <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div> -->
				           	</div>
			           
							<?php endforeach; ?>
						<?php endif; ?>

			        </div>
			    </div>
			</div>
		</div>
		
		<style>
			.product__desc-text br {
				display: none;
			}
			.btn.add_to_cart_button {
				background: #00ad4a !important;
				color: #fff !important;
				border-radius: 24px !important;
				padding: 18px 24px !important;
			}
			.product__footer a.added_to_cart.wc-forward {
				text-align: center;
				color: #154928;
				margin-top: 15px;
			}
		</style>

		<div class="product__info">
			<div class="product__kod">Kod produktu: <?= $product->get_sku(); ?></div>
			
			<div class="product__title">
				<h1><?= $product->name; ?></h1>
			</div>
			
			<?= do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>

			<div class="product__price-wrap">
				<div class="product__price">

				<?php
					global $product;
					if ($product->is_on_sale()) { 
				?>

					<del aria-hidden="true">
						<span class="woocommerce-Price-amount amount">
							<?= wc_price($product->get_regular_price()); ?>
						</span>
					</del>
			
					<ins>
						<span class="woocommerce-Price-amount amount">
							<?= wc_price($product->get_sale_price()); ?>
						</span>
					</ins>

				<?php } else { ?>

					<ins>
						<span class="woocommerce-Price-amount amount">
							<?= wc_price($product->get_regular_price()); ?>
						</span>
					</ins>
				
				<?php } ?>

				</div>
			</div>

			<div class="product__weight-btns">
			
			<?php

				if($product->get_type() == "variable") {
					woocommerce_variable_add_to_cart();
				}

			?>

			</div>
			
			<div class="product__desc">
				<div class="product__desc-title">Opisy</div>
				<div class="product__desc-text">
					<?= apply_filters("the_content", $post->post_content); ?>
				</div>
			</div>
			
			<div class="product__docs">
				<div class="product__docs-item product__delivery">
					<a href="#" data-popup="delivery">DOSTAWA</a>
				</div>
				<div class="product__docs-item product__doc">
					<a href="#" data-popup="documents">DOKUMENTY</a>
				</div>
			</div>
			
			<div class="product__footer">
				<a class="btn btn-trans" data-popup="how-to-order" href="#">Jak złożyć zamówienie</a>
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>

		</div>

	</div>

	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products' );
	?>

</section>

<!-- В конце того же файла добавьте модальные окна: -->
<!-- Модалка Доставка -->
<div id="popup-delivery" class="popup">
    <div class="popup__head">
        <h4>Dostawa</h4>
        <a href="#" class="popup__close">
            <img src="<?= get_template_directory_uri(); ?>/assets/img/close.svg" alt="">
        </a>
    </div>
    <div class="popup__content">
        <?php 
        // Получаем контент из ACF поля для доставки
        $delivery_content = get_field('delivery_info');
        if($delivery_content) {
            echo $delivery_content;
        } else {
            echo '<p>Brak informacji o dostawie</p>';
        }
        ?>
    </div>
</div>

<!-- Модалка Документы -->
<div id="popup-documents" class="popup">
    <div class="popup__head">
        <h4>Dokumenty</h4>
        <a href="#" class="popup__close">
            <img src="<?= get_template_directory_uri(); ?>/assets/img/close.svg" alt="">
        </a>
    </div>
    <div class="popup__content">
        <?php if (have_rows('pro_docs')) : ?>
            <div class="documents-list">
                <?php while (have_rows('pro_docs')) : the_row(); 
                    $document = get_sub_field('pro_doc'); // Поле файла внутри repeater
                    
                    if($document) : ?>
                        <div class="document-item">
                            <a href="<?= esc_url($document['url']); ?>" target="_blank" class="document-link">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14 2H6C4.9 2 4 2.9 4 4v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z" fill="#154928"/>
                                </svg>
                                <span><?= esc_html($document['filename']); ?></span>
                            </a>
                            <div class="document-info">
                                <span class="document-size"><?= size_format($document['filesize']); ?></span>
                                <span class="document-type"><?= strtoupper($document['subtype']); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p>Brak dokumentów</p>
        <?php endif; ?>
    </div>
</div>

<!-- Модалка Как оформить заказ -->
<div id="popup-how-to-order" class="popup">
    <div class="popup__head">
        <h4>Jak złożyć zamówienie</h4>
        <a href="#" class="popup__close">
            <img src="<?= get_template_directory_uri(); ?>/assets/img/close.svg" alt="">
        </a>
    </div>
    <div class="popup__content">
        <?php 
        // Получаем контент из ACF поля
        $how_to_order_content = get_field('how_to_order', 'option');
        if($how_to_order_content) {
            echo $how_to_order_content;
        } else {
            echo '<p>Brak instrukcji zamawiania</p>';
        }
        ?>
    </div>
</div>

<!-- CSS для модальных окон (если нужны дополнительные стили): -->
<style>
.documents-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.document-item {
    background: #f5f5f5;
    padding: 15px;
    border-radius: 12px;
}

.document-link {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #154928;
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 8px;
}

.document-link:hover {
    color: #00ad4a;
}

.document-link:hover svg path {
    fill: #00ad4a;
}

.document-link svg {
    flex-shrink: 0;
}

.document-info {
    display: flex;
    gap: 15px;
    font-size: 13px;
    color: #666;
    padding-left: 36px;
}

.document-type {
    background: #e0e0e0;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    text-transform: uppercase;
}

.document-size {
    color: #888;
}

.popup__content {
    padding: 20px 0;
    max-height: 60vh;
    overflow-y: auto;
}

.popup__content p {
    margin-bottom: 10px;
}

.popup__content ul {
    margin-left: 20px;
}

@media only screen and (max-width: 767px) {
    .popup__content {
        max-height: 50vh;
    }
}
</style>

<script>
// Открытие модальных окон на странице товара
document.addEventListener('DOMContentLoaded', function() {
    // Обработчик для кнопок открытия попапов
    document.querySelectorAll('[data-popup]').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const popupId = this.getAttribute('data-popup');
            const popup = document.querySelector('#popup-' + popupId);
            
            if (popup) {
                document.body.classList.add('overflow');
                document.querySelector('.overlay')?.classList.add('is-active');
                popup.classList.add('is-active');
            }
        });
    });
    
    // Закрытие попапов
    document.querySelectorAll('.popup__close').forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.remove('overflow');
            document.querySelector('.overlay')?.classList.remove('is-active');
            document.querySelectorAll('.popup').forEach(function(popup) {
                popup.classList.remove('is-active');
            });
        });
    });
    
    // Закрытие по клику на оверлей
    document.querySelector('.overlay')?.addEventListener('click', function() {
        document.body.classList.remove('overflow');
        this.classList.remove('is-active');
        document.querySelectorAll('.popup').forEach(function(popup) {
            popup.classList.remove('is-active');
        });
    });
});
</script>

<?php do_action( 'woocommerce_after_single_product' ); ?>