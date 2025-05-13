<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>

<div <?php wc_product_class( 'product__item', $product ); ?>>
	<?php
	
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	?>

	<div class="product__img">
		<?php

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );

		?>

		<?= do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>

	</div>

	<div class="product__footer">
		<?php

		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );

		?>
	</div>

	<!-- Замените в woocommerce/content-product.php (в блоке product__btn) -->

	<div class="product__btn">
		<?php
		global $product;

		if ($product->is_type('variable')) {
			// Уникальный ID для попапа
			$popup_id = 'product-popup-' . $product->get_id();
			?>
			<a href="#" 
			   class="button btn quick-options-button" 
			   data-product-id="<?php echo esc_attr($product->get_id()); ?>">
				<?php echo __('Wybierz opcje', 'woocommerce'); ?>
			</a>

			<!-- Попап товара (скрыт по умолчанию) -->
			<div id="<?php echo esc_attr($popup_id); ?>" class="product-quick-options" style="display: none;">
				<div class="quick-options-inner">
					<div class="quick-options-header">
						<span class="quick-options-title"><?php echo __('Wybierz opcje', 'woocommerce'); ?></span>
						<button type="button" class="quick-options-close">&times;</button>
					</div>
					<div class="quick-options-content">
						<!-- Контент будет загружен через AJAX -->
						<div class="loading-spinner"></div>
					</div>
				</div>
			</div>
			<?php
		} else {
			do_action('woocommerce_after_shop_loop_item');
		}
		?>
	</div>

</div>