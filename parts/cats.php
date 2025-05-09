<!-- cats -->
<section class="cat padding-100 cat--desktop">
	<div class="container">
		<div class="section__title">
			<h2>Kategoria</h2>
		</div>
		<div class="cat__list">
			<?php

				$prod_cat_args = array(
					'taxonomy'    => 'product_cat',
					'orderby'     => 'id', // здесь по какому полю сортировать
					'hide_empty'  => true, // скрывать категории без товаров или нет
					'parent'      => 0 // id родительской категории
				);

				$woo_categories = get_categories( $prod_cat_args );
				  foreach ( $woo_categories as $woo_cat ) {
				      $woo_cat_id = $woo_cat->term_id; //category ID
				      $woo_cat_name = $woo_cat->name; //category name
				      $woo_cat_slug = $woo_cat->slug; //category slug

				$category_thumbnail_id = get_woocommerce_term_meta($woo_cat_id, 'thumbnail_id', true);
				$thumbnail_image_url = wp_get_attachment_url($category_thumbnail_id);

			    // Получаем количество товаров в категории
			    $term = get_term($woo_cat_id, 'product_cat');
			    $product_count = $term->count;

			?>

			<a href="<?= get_term_link( $woo_cat_id, 'product_cat' ) ?>" class="cat__item">
				<div class="cat__img" style="background-image: url('<?= $thumbnail_image_url; ?>');">
					<span><?= $product_count; ?></span>
				</div>
				<div class="cat__title"><?= $woo_cat_name; ?></div>
			</a>

			<?php } ?>
		</div>
	</div>
</section>

<!-- cats -->
<section class="cat cat--mobile">
	<div class="container">
		<div class="section__title">
			<h2>Kategoria</h2>
			<div class="cat--arrows">
				<button class="cat--arrow cat--arrow-left">
					<img src="<?= get_template_directory_uri(); ?>/assets/img/mob-arrow-left.png" alt="">
				</button>
				<button class="cat--arrow cat--arrow-right">
					<img src="<?= get_template_directory_uri(); ?>/assets/img/mob-arrow-right.png" alt="">
				</button>
			</div>
		</div>
		<div class="cat__slider swiper">
			<div class="swiper-wrapper">
				
				<?php

					$prod_cat_args = array(
						'taxonomy'    => 'product_cat',
						'orderby'     => 'id', // здесь по какому полю сортировать
						'hide_empty'  => true, // скрывать категории без товаров или нет
						'parent'      => 0 // id родительской категории
					);

					$woo_categories = get_categories( $prod_cat_args );
					  foreach ( $woo_categories as $woo_cat ) {
					      $woo_cat_id = $woo_cat->term_id; //category ID
					      $woo_cat_name = $woo_cat->name; //category name
					      $woo_cat_slug = $woo_cat->slug; //category slug

					$category_thumbnail_id = get_woocommerce_term_meta($woo_cat_id, 'thumbnail_id', true);
					$thumbnail_image_url = wp_get_attachment_url($category_thumbnail_id);

				    // Получаем количество товаров в категории
				    $term = get_term($woo_cat_id, 'product_cat');
				    $product_count = $term->count;

				?>

				<div class="swiper-slide">
					<a href="<?= get_term_link( $woo_cat_id, 'product_cat' ) ?>" class="cat__item">
						<div class="cat__img" style="background-image: url('<?= $thumbnail_image_url; ?>');">
							<span><?= $product_count; ?></span>
						</div>
						<div class="cat__title"><?= $woo_cat_name; ?></div>
					</a>
				</div>

				<?php } ?>
				
			</div>
		</div>
	</div>
</section>
