    <div class="overlay"></div>

    <div class="m-cart">
        <div class="m-cart__head">
            <h4>Podgląd</h4>
            <a href="#" class="m-cart__close">
                <img src="<?= get_template_directory_uri(); ?>/assets/img/close.svg" alt="">
            </a>
        </div>
        
        <?php 
            woocommerce_mini_cart( [ 'list_class' => 'my-css-class' ] );
        ?>
    </div>

<!--     <div id="popup-1" class="popup">

        <div class="popup__head">
            <h4>Title popup</h4>
            <a href="#" class="popup__close">
                <img src="<?= get_template_directory_uri(); ?>/assets/img/close.svg" alt="">
            </a>
        </div>

    </div> -->

    <?php wp_footer(); ?>

</body>
</html>