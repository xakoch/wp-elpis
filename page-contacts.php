<?php /* Template name: Contacts */ ?>

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

	<section class="contacts">
		<div class="container">
			<div class="contacts__inner">
				<div class="contacts__info">
					<h3>Kontakt z nami</h3>
					<div class="contacts__item">
						<span>Telefon</span>
						<a href="tel:<?php the_field('phone_number','option'); ?>"><?php the_field('phone_number','option'); ?></a>
					</div>
					<div class="contacts__item">
						<span>Email</span>
						<a href="mailto:<?php the_field('email','option'); ?>"><?php the_field('email','option'); ?></a>
					</div>
					<div class="contacts__item">
						<span>Adres</span>
						<address><?php the_field('address','option'); ?></address>
					</div>
				</div>
				<div class="contacts__map">
					<?php $mapImg = get_field('map_img','option'); ?>
					<img src="<?= $mapImg; ?>" alt="">
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part('parts/footer'); ?>

<?php get_footer(); ?>