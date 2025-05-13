<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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

do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="widget_shopping_cart_content">

    <div class="m-cart__top">
    
    	<?php if ( ! WC()->cart->is_empty() ) : ?>
    
    
        <ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
            
    		<?php
    		do_action( 'woocommerce_before_mini_cart_contents' );
    
    		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
    			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
    
    			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
    				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
    				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
    				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
    				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
    				?>
    
                    <li class="woocommerce-mini-cart-item mini_cart_item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
                        
    					<?php if ( empty( $product_permalink ) ) : ?>
    						<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    					<?php else : ?>
                            <a href="<?php echo esc_url( $product_permalink ); ?>">
    							<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </a>
    					<?php endif; ?>
    					
    					<div class="mini_cart_item_right">
        		        	<div class="mini_cart_item_right_header">
        			        	<div class="m-cart__title">
        			        	    <?php echo wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        			        	</div>
        		        	</div>
        		        	<div class="mini_cart_item_right_footer">
        				        <span class="mini_cart_item_right_price"><?php echo $product_price; ?></span>
        				        <span class="mini_cart_item_right_price">x<?php echo $cart_item['quantity']; ?></span>
        				        
        				       <?php
    								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    									'woocommerce_cart_item_remove_link',
    									sprintf(
    										'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="14" height="14" fill="white" style="mix-blend-mode:multiply"/><path d="M6.125 5.25H5.25V10.5H6.125V5.25Z" fill="#154928"/><path d="M8.75 5.25H7.875V10.5H8.75V5.25Z" fill="#154928"/><path d="M1.75 2.625V3.5H2.625V12.25C2.625 12.4821 2.71719 12.7046 2.88128 12.8687C3.04538 13.0328 3.26794 13.125 3.5 13.125H10.5C10.7321 13.125 10.9546 13.0328 11.1187 12.8687C11.2828 12.7046 11.375 12.4821 11.375 12.25V3.5H12.25V2.625H1.75ZM3.5 12.25V3.5H10.5V12.25H3.5Z" fill="#154928"/><path d="M8.75 0.875H5.25V1.75H8.75V0.875Z" fill="#154928"/></svg></a>',
    										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
    										/* translators: %s is the product name */
    										esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
    										esc_attr( $product_id ),
    										esc_attr( $cart_item_key ),
    										esc_attr( $_product->get_sku() )
    									),
    									$cart_item_key
    								);
    								?>
        		        	</div>
        		        </div>
                    </li>
    
    			<?php }
    
    		}
    
    		do_action( 'woocommerce_mini_cart_contents' );
    
    		?>
    
        </ul>
            
    </div>
            
    <div class="m-cart__footer">
        <p class="woocommerce-mini-cart__total total">
    		<?php
    		/**
    		 * Hook: woocommerce_widget_shopping_cart_total.
    		 *
    		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
    		 */
    		do_action( 'woocommerce_widget_shopping_cart_total' );
    		?>
        </p>
    
    	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
    
        <div class="woocommerce-mini-cart__buttons buttons">
            <a href="<?php echo wc_get_cart_url(); ?>"
               class="button wc-forward"><?php _e( 'Zobacz koszyk', 'wooeshop' ); ?></a>
            <a href="<?php echo wc_get_checkout_url(); ?>"
               class="button checkout wc-forward"><?php _e( 'Podsumowanie', 'wooeshop' ); ?></a>
        </div>
    
    	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
    
    </div>
    
    <?php else : ?>
    
    <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>
    
    <?php endif; ?>
    
    <?php do_action( 'woocommerce_after_mini_cart' ); ?>

</div>
