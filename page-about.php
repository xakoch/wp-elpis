<?php /* Template name: About us */ ?>

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

	<section class="about mt-24">
		<div class="container">
			<div class="about__inner">
				<div class="about__content">
					<h3><?php the_field('about_title') ?></h3>
					<?php the_field('about_text'); ?>
				</div>
				<?php $aboutImg = get_field('about_img'); ?>
				<img src="<?= $aboutImg; ?>" alt="">
			</div>
		</div>
	</section>

	<section class="about mt-24">
		<div class="container">
			<div class="about__fact">
				<div class="about__fact-title">
					<h3><?php the_field('facts_title'); ?></h3>
				</div>
				
				<?php if( have_rows('facts_list') ): ?>
				
				<div class="about__fact-list">
					<?php while( have_rows('facts_list') ): the_row(); ?>
					
					<div class="about_fact-item">
						<div class="about__fact-num"><?php the_sub_field('fact_num'); ?></div>
						<div class="about__fact-text"><?php the_sub_field('fact_text'); ?></div>
					</div>
					
					<?php endwhile; ?>
				</div>
	
				<?php endif; ?>
				
			</div>
		</div>
	</section>

	<section class="about mt-24">
		<div class="container">
			<div class="about__geo">
				<h3><?php the_field('geo_title'); ?></h3>
				<?php the_field('geo_text'); ?>
				<?php $geoImg = get_field('geo_img'); ?>
				<img src="<?= $geoImg; ?>" alt="">
			</div>
		</div>
	</section>

	<?php get_template_part('parts/footer'); ?>

<?php get_footer(); ?>