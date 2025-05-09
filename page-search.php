<?php /* Template name: Search */ ?>

<?php get_header(); ?>

	<section class="search__section">
		<div class="container">
			<div class="search__title">
				<h1>Znajdź dla siebie najbardziej odpowiednie produkty</h1>
			</div>
			<div class="search__form">
				<?= do_shortcode('[fibosearch]'); ?>
			</div>
		</div>
	</section>

	<?php get_template_part('parts/cats'); ?>

<?php get_footer(); ?>