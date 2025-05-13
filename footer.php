    <div class="overlay"></div>

	    <div class="m-cart">
	        <div class="m-cart__head">
	            <h4>Podgląd</h4>
	            <a href="#" class="m-cart__close">
	                <img src="<?= get_template_directory_uri(); ?>/assets/img/close.svg" alt="">
	            </a>
	        </div>
	        
	        <?php woocommerce_mini_cart(); ?>
	    </div>
	</div>
	
	<!-- Variation Popup -->
	<div class="variation-popup-overlay" id="variationPopup">
		<div class="variation-popup">
			<button class="popup-close" aria-label="Close">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
			<div class="popup-content">
				<!-- Контент будет загружен динамически -->
			</div>
		</div>
	</div>

    <?php wp_footer(); ?>

	</body>
</html>