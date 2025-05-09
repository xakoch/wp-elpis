<?php /* Template name: Privacy */ ?>

<?php get_header(); ?>

	<!-- banner -->
	<section class="banner banner--dark">
		<div class="container">

			<div class="banner__inner">
				<div class="banner__title">
					<h1><?php the_title(); ?></h1>
				</div>

				<div class="banner__footer">
					<?php if (function_exists('xakoch_breadcrumbs')) xakoch_breadcrumbs(); ?>
				</div>
			</div>

		</div>
	</section>
	
	<style>
		.special-page {
			margin-top: 60px;
		}
		.special-page__content {
			display: flex;
			flex-direction: column;
			grid-gap: 20px;
		}
		.special-page ol {
			list-style-type: auto !important;
			margin-left: 20px !important;
			color: #888;
			display: flex;
			flex-direction: column;
			grid-gap: 20px;
		}
	</style>

    <section class="special-page">
        <div class="container">
			<div class="special-page__content">
				<?= the_content(); ?>
			</div>
        </div>
    </section>

	<?php get_template_part('parts/footer'); ?>

<?php get_footer(); ?>