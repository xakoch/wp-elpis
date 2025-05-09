<?php /* Template name: Wishlist */ ?>

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

	<section class="elpis-wishlist">
		<div class="container">
			<?= do_shortcode('[yith_wcwl_wishlist]'); ?>
		</div>
	</section>

	<?php get_template_part('parts/footer'); ?>

<?php get_footer(); ?>