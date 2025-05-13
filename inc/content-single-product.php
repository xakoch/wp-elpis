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
	<?
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
				
	</div>
</section>

<?

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

		<div class="product__info">
			<div class="product__kod">Kod produktu: <?= $product->get_sku(); ?></div>
			
			<div class="product__title">
				<h1><?= $product->name; ?></h1>
			</div>
			
			<!-- <button class="product__fav-btn">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.32 15.36C15.168 16.6306 12 19.68 12 19.68C12 19.68 8.83201 16.6306 7.68001 15.36C4.99201 12.3953 4.32001 11.2377 4.32001 9.12003C4.32001 7.00238 5.85601 5.28003 8.16001 5.28003C10.08 5.28003 11.232 6.55062 12 7.82121C12.768 6.55062 13.92 5.28003 15.84 5.28003C18.144 5.28003 19.68 7.00238 19.68 9.12003C19.68 11.2377 19.008 12.3953 16.32 15.36Z" stroke="#121923" stroke-width="1.2"/></svg>
			</button> -->

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

				<? } else { ?>

					<ins>
						<span class="woocommerce-Price-amount amount">
							<?= wc_price($product->get_regular_price()); ?>
						</span>
					</ins>
				
				<? } ?>

				</div>
			</div>

			<div class="product__weight-btns">
			
			<?php

				if($product->get_type() == "variable"){
					woocommerce_variable_add_to_cart();
				}

			?>

			</div>

<!-- 				<button class="product__weight-btn is-active">1KG</button>
				<button class="product__weight-btn">5KG</button> -->

			<div class="product__desc">
				<div class="product__desc-title">Opisy</div>
				<div class="product__desc-text">
					<?= apply_filters("woocommerce_short_description", $post->post_excerpt); ?>
				</div>
			</div>
			
			<div class="product__docs">
				<div class="product__docs-item product__delivery">
					<a href="#">DOSTAWA</a>
				</div>
				<div class="product__docs-item product__doc">
					<a href="#">DOKUMENTY</a>
				</div>
			</div>

			<div class="product__footer">
				<a class="btn btn-trans" href="#">Jak złożyć zamówienie</a>
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

<?php do_action( 'woocommerce_after_single_product' ); ?>