<?php get_header(); ?>

	<style>
		.notfound a.btn {
			display: flex;
			background: #154928;
			color: #fff;
			margin: 50px auto;
			max-width: max-content;
		}
	</style>

	<!-- banner -->
	<section class="banner banner--dark notfound">
		<div class="container">

			<div class="banner__inner">
				<div class="banner__title">
					<h1>Strony nie znaleziono</h1>
				</div>

				<div class="banner__footer">
					<?php if (function_exists('xakoch_breadcrumbs')) xakoch_breadcrumbs(); ?>
				</div>
			</div>
			
			<a class="btn" href="/">Idź do domu &#8617;</a>

		</div>
	</section>

	<?php get_template_part('parts/footer'); ?>

<?php get_footer(); ?>