/**
 * Lazy Load
 */
const observer = lozad();
observer.observe();

/**
 * Swiper Slider
 */
var heroSlide = new Swiper(".hero__slider", {
    slidesPerView: 1,
    loop: true,
    pauseOnMouseEnter: true,
    effect: "fade",
	pagination: {
		el: ".swiper-pagination",
		type: "fraction",
	},
    autoplay: {
        delay: 2500,
        disableOnInteraction: true
    }
});

/**
 * Category Slider
 */
var catSlide = new Swiper(".cat__slider", {
    slidesPerView: 2,
    spaceBetween: 8,
    // loop: true,
    pauseOnMouseEnter: true,
    navigation: {
        nextEl: ".cat--arrow-right",
        prevEl: ".cat--arrow-left",
    },
    breakpoints: {
        568: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 12,
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 14,
        },
    },
});

/**
 * Banner Slider
 */
var bannerSlide = new Swiper(".banners__slide", {
    slidesPerView: 1,
    loop: true,
    pauseOnMouseEnter: true,
    effect: "fade",
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    // autoplay: {
    //     delay: 2500,
    //     disableOnInteraction: true
    // }
});

/**
 *  Show more / Hide less - text
 */
new ShowMore('.product__desc-text', { config: {
    type: "text",
    limit: 100,
    element: 'div',
    more: 'Czytaj więcej <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.5999 8.40002L9.9999 12L6.3999 8.40002" stroke="#101112" stroke-width="1.2" stroke-linejoin="round"/></svg>',
    less: 'Zwinąć <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.4001 11.6L10.0001 7.99998L13.6001 11.6" stroke="#101112" stroke-width="1.2" stroke-linejoin="round"/></svg>'
}});

/**
 *  Product slider
 */
var galleryThumbs = new Swiper(".gallery-thumbs", {
    centeredSlides: true,
    centeredSlidesBounds: true,
    direction: "horizontal",
    slidesPerView: 3,
    // lazy: true,
    breakpoints: {
        767: {
            direction: "vertical",
        }
    }
});

var galleryTop = new Swiper(".gallery-top", {
    lazy: true,
    keyboard: {
        enabled: true,
    },
    thumbs: {
        swiper: galleryThumbs
    }
});

galleryTop.on("slideChangeTransitionStart", function() {
    galleryThumbs.slideTo(galleryTop.activeIndex);
});

galleryThumbs.on("transitionStart", function() {
    galleryTop.slideTo(galleryThumbs.activeIndex);
});

// Mini cart - открытие
document.querySelectorAll('.cart-btn').forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        document.body.classList.add('overflow');
        document.querySelector('.overlay')?.classList.add('is-active');
        document.querySelector('.m-cart')?.classList.add('is-active');
    });
});

// Mini cart - закрытие
document.querySelectorAll('.m-cart__close').forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        document.body.classList.remove('overflow');
        document.querySelector('.overlay')?.classList.remove('is-active');
        document.querySelector('.m-cart')?.classList.remove('is-active');
    });
});

// Обработка события добавления товара в корзину
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('added_to_cart', function() {
        // Открываем мини-корзину
        const event = new Event('wc_fragment_refresh');
        document.body.dispatchEvent(event);

        document.body.classList.add('overflow');
        document.querySelector('.overlay')?.classList.add('is-active');
        document.querySelector('.m-cart')?.classList.add('is-active');
    });

    // Установка vh-переменной для мобильных устройств
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
});



/**************************************************************
* Header / Menu burger
**************************************************************/
const body = document.querySelector('body');
const burger = document.querySelector('.burger');
const menu = document.querySelectorAll('.nav__mobile--content');
const menuOverlay = document.querySelectorAll('.nav__mobile--background');
const links = document.querySelectorAll('.nav__mobile--menu a');

function toggleMobileMenu() {
    if (!burger.classList.contains('is-open')) {
        burger.classList.add('is-open');
        body.classList.add('overflow');
        gsap.to(menu, { autoAlpha: 1, ease: "power2" })
        menuOverlay.forEach(element => element.classList.add('is-open'));
    } else {
        burger.classList.remove('is-open');
        body.classList.remove('overflow');
        gsap.to(menu, { autoAlpha: 0, ease: "power2" })
        menuOverlay.forEach(element => element.classList.remove('is-open'));
    }
}

burger.addEventListener('click', e => {
    e.preventDefault();
    toggleMobileMenu();
});

links.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        burger.classList.remove('is-open');
        body.classList.remove('overflow');
        gsap.to(menu, { autoAlpha: 0, ease: "power2" })
        menuOverlay.forEach(element => element.classList.remove('is-open'));
    });
});