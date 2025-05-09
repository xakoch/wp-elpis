<?php /* Template name: Cart */ ?>

<?php get_header(); ?>

	<!-- banner -->
	<section class="banner banner--dark">
		<div class="container">

			<div class="banner__inner">
				<div class="banner__title">
					<h1><?php the_title(); ?></h1>
				</div>

				<div class="banner__footer">
					<?php

						if (function_exists('xakoch_breadcrumbs')) xakoch_breadcrumbs();

					?>
					
					<!-- <div class="found__count">Znaleziono: 76</div> -->
				</div>
			</div>

		</div>
	</section>

	<div class="cart__table" style="margin: 50px 0;">
		<div class="container">
			<?= do_shortcode('[woocommerce_cart]'); ?>	
		</div>
	</div>

	<!-- popular -->
<!-- 	<section class="popular-products">
		<div class="container">
			
			<div class="section__header xs-none">
				<div class="section__title">
					<h2>Nowe produkty</h2>
				</div>
				<a href="/produkti">
					<span>Wyświetl wszystkie -></span>
				</a>
			</div>

			<div class="section__header xs-show">
				<a href="/produkti" class="section__header--mobile">
					<div class="section__title">
						<h2>Nowe produkty</h2>
					</div>
					<img src="<?= get_template_directory_uri(); ?>/assets/img/mob-up-right.png" alt="">
				</a>
			</div>
			
			<?= do_shortcode('[featured_products limit="4"]'); ?>

		</div>
	</section> -->

	<?php get_template_part('parts/footer'); ?>

<?php get_footer(); ?>