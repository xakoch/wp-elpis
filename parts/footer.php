    <footer class="footer">
    	<div class="container">
    		<div class="footer__inner">
				<div class="footer__col">
    				<a class="footer__logo" href="/">
						<?php $footerLogo = get_field('footer_logo','option'); ?>
    					<img src="<?= $footerLogo; ?>" alt="">
    				</a>
					
					<?php if( have_rows('socials_list','option') ): ?>
						<div class="footer__socials">
							<?php while( have_rows('socials_list','option') ): the_row(); 
								$link = get_sub_field('social_link','option');
								$icon = get_sub_field('social_icon','icon');
							?>
								<a href="<?= $link; ?>" target="_blank">
									<img src="<?= $icon; ?>" alt="social">
								</a>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				
					<?php $partnerLogo = get_field('partner_logo','option'); ?>
					<img class="euro-logo desktop" src="<?= $partnerLogo; ?>" alt="">
				</div>
    			
				<div class="footer__col footer__items">
<!--     				<div class="footer__item">
    					<div class="footer__item--title">Firma</div>
    					<ul class="footer__nav">
    						<li><a href="/par-mums">O nas</a></li>
    						<li><a href="#" data-open="1">Adresy sklepów</a></li>
    						<li><a href="#" data-open="1">Gwarancja</a></li>
    						<li><a href="#" data-open="1">Dla biznesu</a></li>
    						<li><a href="#" data-open="1">Wakat</a></li>
    					</ul>
    				</div>
    				<div class="footer__item">
    					<div class="footer__item--title">Katalog</div>
    					<ul class="footer__nav">
    						<li><a href="#" data-open="1">Akcje</a></li>
    						<li><a href="#" data-open="1">Częste pytania</a></li>
    						<li><a href="#" data-open="1">Dostawa</a></li>
    						<li><a href="#" data-open="1">Płatność</a></li>
    					</ul>
    				</div> -->
    				<div class="footer__item">
    					<div class="footer__item--title">Kontakt z nami</div>
    					<div class="footer__contacts--tel">
    						<a href="tel:<?php the_field('phone_number','option'); ?>"><?php the_field('phone_number','option'); ?></a>
    					</div>
    					<div class="footer__contacts--mail">
    						<a href="mailto:<?php the_field('email','option'); ?>"><?php the_field('email','option'); ?></a>
    					</div>
    					<div class="footer__contacts--address">
    						<address><?php the_field('address','option'); ?></address>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="footer__bottom">
    			<div class="footer__col footer__copyright">
                    <?php $partnerLogo = get_field('partner_logo','option'); ?>
					<img class="euro-logo mobile" src="<?= $partnerLogo; ?>" alt="">
    				<p>© <?= date('Y'); ?> — <?php the_field('copyright_text','option'); ?></p>
    			</div>
    			<div class="footer__col">
    				<ul class="footer__bottom-nav">
    					<li><a href="/cookie">Polityka wykorzystywania plików cookie ELPIS SIA</a></li>
    					<li><a href="/privacy-policy">Polityka prywatności ELPIS SIA</a></li>
						<li><a href="/regulamin-sprzedazy-i-swiadczenia/">Regulamin sprzedaży i świadczenia</a></li>
    				</ul>
    			</div>
    		</div>
    	</div>
    </footer>