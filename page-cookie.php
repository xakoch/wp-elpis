<?php /* Template name: Cookie */ ?>

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

    <section>
        <div class="container">
            <?= the_content(); ?>
        </div>
    </section>

	<?php get_template_part('parts/footer'); ?>

<?php get_footer(); ?>