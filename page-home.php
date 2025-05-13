<?php /* Template name: Home */ ?>

<?php get_header(); ?>

	<!-- hero -->
	<?php if( have_rows('slider') ): ?>
	<section class="hero">
		<div class="container">
			<div class="hero__slider swiper">
				<div class="swiper-wrapper">
					
					<?php while( have_rows('slider') ): the_row();
						$img = get_sub_field('hero_img');
					?>
					
					<div class="swiper-slide">
						<div class="hero__item">
							<div class="hero__content">
								<div class="hero__top">
									<h2><?php the_sub_field('hero_title'); ?></h2>
									<h4><?php the_sub_field('subtitle_1'); ?></h4>
								</div>
								<div class="hero__bottom">
									<p><?php the_sub_field('subtitle_2'); ?></p>
								</div>
							</div>	
							<div class="hero__img">
								<img src="<?= $img; ?>" alt="">
							</div>	
						</div>
					</div>
					
					<?php endwhile; ?>
					
				</div>
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</section>
	<?php endif; ?>

	<?php get_template_part('parts/cats'); ?>

	<!-- popular -->
	<section class="popular-products">
		<div class="container">
			
			<div class="section__header xs-none">
				<div class="section__title">
					<h2>Bestsellery</h2>
				</div>
				<a href="/produkty">
					<span>Wyświetl wszystkie -></span>
				</a>
			</div>

			<div class="section__header xs-show">
				<a href="/produkty" class="section__header--mobile">
					<div class="section__title">
						<h2>Bestsellery</h2>
					</div>
					<img src="<?= get_template_directory_uri(); ?>/assets/img/mob-up-right.png" alt="">
				</a>
			</div>
			
			<?= do_shortcode('[featured_products limit="4"]'); ?>

		</div>
	</section>

	<!-- banners -->
	<?php if( have_rows('banners') ): ?>
	<section class="banners padding-100 xs-none">
		<div class="container">
		
			<?php while( have_rows('banners') ): the_row();
				$img = get_sub_field('banner_img');
				$link = get_sub_field('banner_link');
				$theme_dark = get_sub_field('banner_dark');
			?>
		
			<div class="banner__item <?php if( $theme_dark ) { echo 'banner__item--dark'; } ?>">
				<div class="banner__top">
					<div class="banner__item-title">
						<h3><?php the_sub_field('banner_title'); ?></h3>
					</div>
					<div class="banner__item-text">
						<p><?php the_sub_field('banner_text'); ?></p>
					</div>
				</div>
				<div class="banner__item-btn">
					<a class="btn" href="<?= $link; ?>">Widok</a>
				</div>
				<img src="<?= $img; ?>" alt="">
			</div>
			
			<?php endwhile; ?>
			
		</div>
	</section>
	<?php endif; ?>
	
	<?php if( have_rows('banners') ): ?>
	<section class="banners banners--mobile xs-show">
		<div class="container">
			<div class="banners__slide swiper">
				<div class="swiper-wrapper">
				
				<?php while( have_rows('banners') ): the_row();
					$img = get_sub_field('banner_img');
					$link = get_sub_field('banner_link');
					$theme_dark = get_field('banner_dark');
				?>
					
					<div class="swiper-slide">
						<?php get_sub_field() ?>
						<div class="banner__item <?php if( $theme_dark ) { echo 'banner__item--dark'; } ?>">
							<div class="banner__top">
								<div class="banner__item-title">
									<h3><?php the_sub_field('banner_title'); ?></h3>
								</div>
								<div class="banner__item-text">
									<p><?php the_sub_field('banner_text'); ?></p>
								</div>
							</div>
							<div class="banner__item-btn">
								<a class="btn" href="<?= $link; ?>">Widok</a>
							</div>
							<img src="<?= $img; ?>" alt="">
						</div>
					</div>
					
				<?php endwhile; ?>
					
				</div>
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</section>
	<?php endif; ?>

	<!-- popular -->
	<section class="new-products">
		<div class="container">
			
			<div class="section__header xs-none">
				<div class="section__title">
					<h2>Nowości w ofercie</h2>
				</div>
				<a href="/produkty">
					<span>Wyświetl wszystkie -></span>
				</a>
			</div>

			<div class="section__header xs-show">
				<a href="/produkty" class="section__header--mobile">
					<div class="section__title">
						<h2>Nowości w ofercie</h2>
					</div>
					<img src="<?= get_template_directory_uri(); ?>/assets/img/mob-up-right.png" alt="">
				</a>
			</div>

 			<?= do_shortcode('[recent_products limit="4"]'); ?>
 			
		</div>
	</section>

	<?php get_template_part('parts/footer'); ?>

<?php get_footer(); ?>