/**
 * Главный JavaScript файл
 * assets/js/app.js
 */

document.addEventListener('DOMContentLoaded', function() {
    /**
     * =============================================
     * 1. ИНИЦИАЛИЗАЦИЯ КОМПОНЕНТОВ
     * =============================================
     */

    // Lazy Load - инициализация загрузки изображений
    const observer = lozad();
    observer.observe();

    /**
     * Корректировка высоты для мобильных устройств
     */
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);

    /**
     * =============================================
     * 2. СЛАЙДЕРЫ И ГАЛЕРЕЯ
     * =============================================
     */

    // Hero Slider - главный слайдер
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

    // Category Slider - слайдер категорий
    var catSlide = new Swiper(".cat__slider", {
        slidesPerView: 2,
        spaceBetween: 8,
        pauseOnMouseEnter: true,
        navigation: {
            nextEl: ".cat--arrow-right",
            prevEl: ".cat--arrow-left",
        },
        breakpoints: {
            568: { slidesPerView: 3, spaceBetween: 10 },
            768: { slidesPerView: 4, spaceBetween: 12 },
            1024: { slidesPerView: 5, spaceBetween: 14 },
        },
    });

    // Banner Slider - слайдер баннеров
    var bannerSlide = new Swiper(".banners__slide", {
        slidesPerView: 1,
        loop: true,
        pauseOnMouseEnter: true,
        effect: "fade",
        pagination: {
            el: ".swiper-pagination",
            type: "fraction",
        },
    });

    // Product Gallery - слайдер галереи товара
    var galleryThumbs = new Swiper(".gallery-thumbs", {
        centeredSlides: true,
        centeredSlidesBounds: true,
        direction: "horizontal",
        slidesPerView: 3,
        breakpoints: {
            767: { direction: "vertical" }
        }
    });

    var galleryTop = new Swiper(".gallery-top", {
        lazy: true,
        keyboard: { enabled: true },
        thumbs: { swiper: galleryThumbs }
    });

    // Синхронизация галереи с миниатюрами
    galleryTop.on("slideChangeTransitionStart", function() {
        galleryThumbs.slideTo(galleryTop.activeIndex);
    });

    galleryThumbs.on("transitionStart", function() {
        galleryTop.slideTo(galleryThumbs.activeIndex);
    });

    /**
     * Show more / Hide less - функция "Показать больше" в описании товара
     */
    new ShowMore('.product__desc-text', { config: {
        type: "text",
        limit: 100,
        element: 'div',
        more: 'Czytaj więcej <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.5999 8.40002L9.9999 12L6.3999 8.40002" stroke="#101112" stroke-width="1.2" stroke-linejoin="round"/></svg>',
        less: 'Zwinąć <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.4001 11.6L10.0001 7.99998L13.6001 11.6" stroke="#101112" stroke-width="1.2" stroke-linejoin="round"/></svg>'
    }});

    /**
     * =============================================
     * 3. ОБРАБОТЧИК ВАРИАЦИЙ ТОВАРА
     * =============================================
     */
    const ProductVariationHandler = {
        init() {
            // Обработка изменений в селектах опций товара
            document.addEventListener('change', (e) => {
                if (e.target.classList.contains('option-select')) {
                    const form = e.target.closest('.product-options-form');
                    if (form) {
                        this.handleVariationChange(form);
                    }
                }
            });
        },
        
        handleVariationChange(form) {
            // Получаем все селекты и проверяем все ли выбраны
            const selects = form.querySelectorAll('.option-select');
            const allSelected = Array.from(selects).every(select => select.value !== '');
            
            // Кнопка добавления в корзину
            const addToCartBtn = form.querySelector('.add-to-cart-btn');
            if (addToCartBtn) {
                addToCartBtn.disabled = !allSelected;
            }
            
            // Если все атрибуты выбраны, находим соответствующую вариацию и обновляем цену
            if (allSelected) {
                const variationsData = form.querySelector('.variations-data');
                if (!variationsData) return;
                
                try {
                    // Получаем данные вариаций из атрибута
                    const variations = JSON.parse(variationsData.dataset.productVariations);
                    
                    // Собираем выбранные атрибуты
                    const selectedAttributes = {};
                    selects.forEach(select => {
                        selectedAttributes[`attribute_${select.dataset.attribute}`] = select.value;
                    });
                    
                    // Ищем подходящую вариацию
                    const matchingVariation = this.findMatchingVariation(variations, selectedAttributes);
                    
                    // Если найдена, обновляем цену
                    if (matchingVariation) {
                        const priceElement = form.querySelector('.product-options-price');
                        if (priceElement && matchingVariation.price_html) {
                            priceElement.innerHTML = matchingVariation.price_html;
                        }
                    }
                } catch (error) {
                    console.error('Ошибка при обработке вариаций:', error);
                }
            }
        },
        
        findMatchingVariation(variations, attributes) {
            for (const variation of variations) {
                let isMatch = true;
                
                for (const [key, value] of Object.entries(attributes)) {
                    // Если у вариации есть этот атрибут и он не совпадает, это не та вариация
                    if (variation.attributes[key] && 
                        variation.attributes[key] !== '' && 
                        variation.attributes[key] !== value) {
                        isMatch = false;
                        break;
                    }
                }
                
                if (isMatch) {
                    return variation;
                }
            }
            
            return null;
        }
    };

    /**
     * =============================================
     * 4. ПОПАП ВАРИАЦИЙ ТОВАРА
     * =============================================
     */
    const ProductQuickOptions = {
        init() {
            // Находим все кнопки открытия попапа
            this.optionButtons = document.querySelectorAll('.quick-options-button');
            if (!this.optionButtons.length) return;
            
            // Добавляем обработчики событий
            this.bindEvents();
        },
        
        bindEvents() {
            // Открытие попапа
            this.optionButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.openPopup(button);
                });
            });
            
            // Делегирование событий для динамически добавленных элементов
            document.addEventListener('click', (e) => {
                // Закрытие попапа
                if (e.target.classList.contains('quick-options-close')) {
                    const popup = e.target.closest('.product-quick-options');
                    if (popup) this.closePopup(popup);
                }
                
                // Обработка формы добавления в корзину
                if (e.target.classList.contains('add-to-cart-btn')) {
                    e.preventDefault();
                    const form = e.target.closest('.product-options-form');
                    if (form) this.addToCart(form);
                }
            });
            
            // Обработчик изменения селектов
            document.addEventListener('change', (e) => {
                if (e.target.classList.contains('option-select')) {
                    this.handleSelectChange(e.target);
                }
            });
        },
        
        openPopup(button) {
            const productId = button.dataset.productId;
            if (!productId) return;
            
            const popup = document.getElementById('product-popup-' + productId);
            if (!popup) return;
            
            // Показываем попап
            popup.style.display = 'block';
            
            // Загружаем данные о товаре
            this.loadProductOptions(productId, popup);
        },
        
        closePopup(popup) {
            popup.style.display = 'none';
        },
        
        async loadProductOptions(productId, popup) {
            const contentArea = popup.querySelector('.quick-options-content');
            if (!contentArea) return;
            
            try {
                contentArea.innerHTML = '<div class="loading-spinner"></div>';
                
                // Используем FormData для передачи данных
                const formData = new FormData();
                formData.append('action', 'get_product_options');
                formData.append('product_id', productId);
                formData.append('_cache_buster', new Date().getTime());
                
                // Отправляем AJAX запрос
                const response = await fetch(woocommerce_params.ajax_url, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    cache: 'no-cache',
                    mode: 'cors'
                });
                
                if (!response.ok) {
                    throw new Error(`Błąd sieci: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    contentArea.innerHTML = data.data.html;
                } else {
                    this.showError(contentArea, data.data?.message || 'Błąd ładowania opcji');
                }
            } catch (error) {
                console.error('Error loading product options:', error);
                this.showError(contentArea, 'Nie udało się załadować opcji produktu: ' + error.message);
            }
        },
        
        showError(container, message) {
            container.innerHTML = `<div class="error-message">${message}</div>`;
        },
        
        handleSelectChange(select) {
            const form = select.closest('.product-options-form');
            if (!form) return;
            
            const allSelects = form.querySelectorAll('.option-select');
            const addToCartBtn = form.querySelector('.add-to-cart-btn');
            
            // Проверяем что все опции выбраны
            const allSelected = Array.from(allSelects).every(s => s.value !== '');
            
            // Активируем/деактивируем кнопку
            if (addToCartBtn) {
                addToCartBtn.disabled = !allSelected;
            }
        },
        
        async addToCart(form) {
            const button = form.querySelector('.add-to-cart-btn');
            if (!button) return;
            
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Dodawanie...';
            
            try {
                const formData = new FormData(form);
                formData.append('action', 'add_to_cart_variation');
                formData.append('_cache_buster', new Date().getTime());
                
                const response = await fetch(woocommerce_params.ajax_url, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    cache: 'no-cache',
                    mode: 'cors'
                });
                
                if (!response.ok) {
                    throw new Error(`Błąd sieci: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    // Обновление счетчика корзины
                    const cartCountElements = document.querySelectorAll('.mini-cart-btn-count');
                    if (cartCountElements.length && data.cart_count) {
                        cartCountElements.forEach(el => {
                            el.textContent = data.cart_count;
                        });
                    }
                    
                    // Закрытие попапа
                    const popup = form.closest('.product-quick-options');
                    if (popup) this.closePopup(popup);
                    
                    // Показ уведомления
                    this.showNotification('Produkt dodany do koszyka', 'success');
                    
                    // Открытие мини-корзины
                    const miniCart = document.querySelector('.m-cart');
                    const overlay = document.querySelector('.overlay');
                    if (miniCart && overlay) {
                        document.body.classList.add('overflow');
                        overlay.classList.add('is-active');
                        miniCart.classList.add('is-active');
                    }
                } else {
                    this.showError(form, data.message || 'Błąd dodawania do koszyka');
                    this.showNotification('Nie udało się dodać produktu do koszyka', 'error');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                this.showError(form, 'Błąd: ' + error.message);
                this.showNotification('Błąd: ' + error.message, 'error');
            } finally {
                button.disabled = false;
                button.textContent = originalText;
            }
        },
        
        showNotification(message, type = 'success') {
            // Создаем уведомление
            const notification = document.createElement('div');
            notification.className = `product-notification product-notification-${type}`;
            notification.textContent = message;
            
            // Добавляем на страницу
            document.body.appendChild(notification);
            
            // Показываем
            setTimeout(() => {
                notification.classList.add('show');
            }, 10);
            
            // Удаляем через 3 секунды
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    };

    /**
     * =============================================
     * 5. МИНИ-КОРЗИНА И УПРАВЛЕНИЕ КОРЗИНОЙ
     * =============================================
     */
    const MiniCartFix = {
        init() {
            // Проверяем, мобильное ли устройство
            this.isMobile = window.innerWidth < 768;
            
            // Кеширование DOM-элементов
            this.miniCart = document.querySelector('.m-cart');
            this.overlay = document.querySelector('.overlay');
            this.miniCartContent = document.querySelector('.widget_shopping_cart_content');
            
            // Инициализация обработчиков событий
            this.setupEventHandlers();
        },
        
        setupEventHandlers() {
            // Используем делегирование событий для всех кнопок добавления в корзину
            document.addEventListener('click', (e) => {
                const addToCartButton = e.target.closest('.add_to_cart_button, .add-to-cart-btn');
                if (addToCartButton) {
                    // При нажатии на кнопку сохраняем ID товара для последующего отслеживания
                    this.lastAddedProductId = addToCartButton.dataset.productId;
                }
            });
            
            // Открытие корзины
            document.querySelectorAll('.cart-btn').forEach(button => {
                button.addEventListener('click', e => {
                    e.preventDefault();
                    this.openMiniCart();
                });
            });
            
            // Закрытие корзины
            document.querySelectorAll('.m-cart__close').forEach(button => {
                button.addEventListener('click', e => {
                    e.preventDefault();
                    document.body.classList.remove('overflow');
                    this.overlay?.classList.remove('is-active');
                    this.miniCart?.classList.remove('is-active');
                });
            });
            
            // Обработка события добавления товара в корзину
            if (typeof jQuery !== 'undefined') {
                jQuery(document.body).on('added_to_cart', (event, fragments, cart_hash, button) => {
                    // Открываем мини-корзину с задержкой для загрузки фрагментов
                    this.handleAddedToCart();
                    
                    // Удаляем класс added и ссылку "Zobacz koszyk" с кнопки
                    if (button && button.length) {
                        button.removeClass('added');
                        const productBtn = button.closest('.product__btn');
                        if (productBtn.length) {
                            productBtn.find('.added_to_cart').remove();
                        }
                    }
                });
                
                // Обработка удаления товара из мини-корзины
                jQuery(document.body).on('click', '.remove_from_cart_button', function(e) {
                    e.preventDefault();
                    
                    // Добавляем класс для визуальной индикации загрузки
                    const $item = jQuery(this).closest('.mini_cart_item');
                    if ($item.length) {
                        $item.addClass('removing');
                    }
                });
            } else {
                // Для ванильного JavaScript
                document.addEventListener('added_to_cart', (e) => {
                    this.handleAddedToCart();
                    
                    // Удаляем класс added и ссылку "Zobacz koszyk" с кнопки
                    const button = e.detail?.data?.button;
                    if (button) {
                        button.classList.remove('added');
                        const productBtn = button.closest('.product__btn');
                        if (productBtn) {
                            const addedToCartLink = productBtn.querySelector('.added_to_cart');
                            if (addedToCartLink) {
                                addedToCartLink.remove();
                            }
                        }
                    }
                });
                
                // Добавляем скрипт для создания кастомного события
                this.createCustomEvent();
            }
        },
        
        handleAddedToCart() {
            // Проверяем, есть ли уже товары в корзине перед открытием
            if (this.miniCartContent) {
                // Получаем актуальное содержимое корзины
                this.refreshCartContent(() => {
                    // Открываем мини-корзину только после получения содержимого
                    this.openMiniCart();
                });
            } else {
                // Если не можем найти содержимое корзины, используем задержку
                setTimeout(() => {
                    this.openMiniCart();
                }, 500);
            }
        },
        
        refreshCartContent(callback) {
            // Для мобильных устройств используем AJAX-запрос для получения актуального содержимого
            if (this.isMobile) {
                const formData = new FormData();
                formData.append('action', 'get_refreshed_mini_cart');
                formData.append('_cache_buster', new Date().getTime());
                
                // Отправляем запрос на получение актуального содержимого корзины
                fetch(woocommerce_params.ajax_url, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    cache: 'no-cache'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.html) {
                        // Обновляем содержимое мини-корзины
                        if (this.miniCartContent) {
                            this.miniCartContent.innerHTML = data.data.html;
                        }
                        
                        // Вызываем колбэк после обновления содержимого
                        if (typeof callback === 'function') {
                            callback();
                        }
                    } else {
                        // Если не удалось получить содержимое, все равно открываем корзину
                        if (typeof callback === 'function') {
                            callback();
                        }
                    }
                })
                .catch(error => {
                    console.error('Ошибка при обновлении мини-корзины:', error);
                    
                    // В случае ошибки все равно открываем корзину
                    if (typeof callback === 'function') {
                        callback();
                    }
                });
            } else {
                // Для десктопов просто вызываем колбэк
                if (typeof callback === 'function') {
                    callback();
                }
            }
        },
        
        openMiniCart() {
            if (this.miniCart && this.overlay) {
                document.body.classList.add('overflow');
                this.overlay.classList.add('is-active');
                this.miniCart.classList.add('is-active');
            }
        },
        
        createCustomEvent() {
            // Слушаем оригинальное событие через jQuery если доступно
            if (typeof jQuery !== 'undefined') {
                jQuery(document.body).on('added_to_cart', function(event, fragments, cart_hash, button) {
                    // Создаем и вызываем событие для нашего JavaScript
                    const customEvent = new CustomEvent('added_to_cart', {
                        detail: {
                            data: {
                                fragments: fragments,
                                cart_hash: cart_hash,
                                button: button ? button[0] : null
                            }
                        }
                    });
                    document.dispatchEvent(customEvent);
                });
            }
        }
    };

    /**
     * =============================================
     * 6. ОПТИМИЗИРОВАННЫЙ ОБРАБОТЧИК КОРЗИНЫ
     * =============================================
     */
    const FastCartHandler = {
        init() {
            // Кешируем DOM-элементы 
            this.body = document.body;
            this.miniCart = document.querySelector('.m-cart');
            this.overlay = document.querySelector('.overlay');
            this.cartCount = document.querySelectorAll('.mini-cart-btn-count');
            
            // Инициализируем обработчики событий
            this.setupEventHandlers();
        },
        
        setupEventHandlers() {
            // Используем делегирование событий
            document.addEventListener('click', (e) => {
                // Обработка кнопок "Dodaj do koszyka"
                if (e.target.classList.contains('add_to_cart_button') || 
                    e.target.closest('.add_to_cart_button')) {
                    const button = e.target.classList.contains('add_to_cart_button') 
                        ? e.target 
                        : e.target.closest('.add_to_cart_button');
                    
                    // Устанавливаем флаг, что кнопка была нажата
                    this.lastClickedButton = button;
                }
                
                // Обработка кнопок удаления из мини-корзины
                if (e.target.classList.contains('remove_from_cart_button') || 
                    e.target.closest('.remove_from_cart_button')) {
                    const removeButton = e.target.classList.contains('remove_from_cart_button') 
                        ? e.target 
                        : e.target.closest('.remove_from_cart_button');
                    
                    const item = removeButton.closest('.mini_cart_item');
                    if (item) {
                        // Добавляем класс для визуального отображения удаления
                        item.classList.add('removing');
                    }
                }
            });
            
            // Обработка события added_to_cart из WooCommerce
            this.setupAddedToCartListener();
        },
        
        setupAddedToCartListener() {
            // Для jQuery
            if (typeof jQuery !== 'undefined') {
                jQuery(document.body).on('added_to_cart', (event, fragments, cart_hash, button) => {
                    // Удаляем ненужные классы и элементы
                    this.cleanUpAfterAdd(button[0]);
                    
                    // Открываем мини-корзину
                    this.openMiniCart();
                });
                
                // Оптимизация для события обновления корзины
                jQuery(document.body).on('updated_cart_totals removed_from_cart', () => {
                    // Удаляем классы "removing" со всех элементов мини-корзины
                    document.querySelectorAll('.mini_cart_item.removing').forEach(item => {
                        item.classList.remove('removing');
                    });
                });
            } else {
                // Для ванильного JavaScript
                document.addEventListener('added_to_cart', (e) => {
                    if (e.detail && e.detail.data && e.detail.data.button) {
                        // Удаляем ненужные классы и элементы
                        this.cleanUpAfterAdd(e.detail.data.button);
                    } else if (this.lastClickedButton) {
                        // Используем сохраненную ссылку на кнопку
                        this.cleanUpAfterAdd(this.lastClickedButton);
                    }
                    
                    // Открываем мини-корзину
                    this.openMiniCart();
                });
                
                // Добавляем необходимый код для событий без jQuery
                this.createCustomEvents();
            }
        },
        
        cleanUpAfterAdd(button) {
            if (!button) return;
            
            // Используем setTimeout для исключения гонки событий с WooCommerce
            setTimeout(() => {
                // Удаляем класс added
                button.classList.remove('added');
                
                // Находим и удаляем ссылку "Zobacz koszyk"
                const productBtn = button.closest('.product__btn');
                if (productBtn) {
                    const addedToCartLink = productBtn.querySelector('.added_to_cart');
                    if (addedToCartLink) {
                        addedToCartLink.remove();
                    }
                }
            }, 10);
        },
        
        openMiniCart() {
            if (this.miniCart && this.overlay) {
                this.body.classList.add('overflow');
                this.overlay.classList.add('is-active');
                this.miniCart.classList.add('is-active');
            }
        },
        
        createCustomEvents() {
            // Для создания совместимости в случае отсутствия jQuery
            if (typeof jQuery !== 'undefined') {
                jQuery(document.body).on('added_to_cart removed_from_cart updated_cart_totals', function(event, fragments, cart_hash, button) {
                    const customEvent = new CustomEvent(event.type, {
                        detail: {
                            data: {
                                fragments: fragments,
                                cart_hash: cart_hash,
                                button: button ? button[0] : null
                            }
                        }
                    });
                    document.dispatchEvent(customEvent);
                });
            }
        }
    };

    /**
     * =============================================
     * 7. ФИКС ВЛОЖЕННЫХ КОНТЕЙНЕРОВ КОРЗИНЫ
     * =============================================
     */
    const NestedCartFix = {
        init() {
            // Функция для исправления вложенных контейнеров
            this.fixNestedContainers();
            
            // Обработчик событий для кнопок удаления товаров
            document.body.addEventListener('click', (event) => {
                // Ищем ближайшую кнопку удаления
                const removeButton = event.target.closest('.remove_from_cart_button');
                
                if (removeButton) {
                    // Ждем завершения AJAX-запроса WooCommerce
                    setTimeout(() => this.fixNestedContainers(), 300);
                }
            });
            
            // Обработчик событий для добавления товаров
            document.body.addEventListener('added_to_cart', () => {
                setTimeout(() => this.fixNestedContainers(), 300);
            });
            
            // Обработчик для других AJAX-событий WooCommerce
            document.body.addEventListener('wc_fragments_refreshed', () => {
                setTimeout(() => this.fixNestedContainers(), 300);
            });
            
            document.body.addEventListener('wc_fragments_loaded', () => {
                setTimeout(() => this.fixNestedContainers(), 300);
            });
            
            // Обработчик для обновления страницы
            window.addEventListener('load', () => this.fixNestedContainers());
            
            // Создаем MutationObserver для отслеживания изменений в DOM
            this.setupMutationObserver();
        },
        
        fixNestedContainers() {
            // Находим все вложенные .widget_shopping_cart_content
            const nestedContainers = document.querySelectorAll('.widget_shopping_cart_content .widget_shopping_cart_content');
            
            nestedContainers.forEach((container) => {
                // Переносим содержимое вложенного контейнера на уровень выше
                const parent = container.parentElement;
                
                // Перемещаем дочерние элементы
                while (container.firstChild) {
                    parent.insertBefore(container.firstChild, container);
                }
                
                // Удаляем пустой вложенный контейнер
                parent.removeChild(container);
            });
        },
        
        setupMutationObserver() {
            // Создаем MutationObserver для отслеживания изменений в DOM
            const observer = new MutationObserver((mutations) => {
                let needsFixing = false;
                
                mutations.forEach((mutation) => {
                    // Проверяем, содержит ли изменение добавление корзины
                    if (mutation.type === 'childList') {
                        // Проверяем новые узлы
                        for (let i = 0; i < mutation.addedNodes.length; i++) {
                            const node = mutation.addedNodes[i];
                            if (node.nodeType === 1) { // Это элемент DOM
                                if (node.classList && node.classList.contains('widget_shopping_cart_content')) {
                                    needsFixing = true;
                                    break;
                                }
                                
                                // Проверяем также вложенные элементы
                                if (node.querySelector && node.querySelector('.widget_shopping_cart_content')) {
                                    needsFixing = true;
                                    break;
                                }
                            }
                        }
                    }
                });
                
                if (needsFixing) {
                    setTimeout(() => this.fixNestedContainers(), 50);
                }
            });
            
            // Наблюдаем за всем телом документа для отлавливания AJAX-изменений
            observer.observe(document.body, { 
                childList: true, 
                subtree: true
            });
        }
    };

    /**
     * =============================================
     * 8. МОБИЛЬНОЕ МЕНЮ
     * =============================================
     */
    const MobileMenu = {
        init() {
            this.body = document.querySelector('body');
            this.burger = document.querySelector('.burger');
            this.menu = document.querySelectorAll('.nav__mobile--content');
            this.menuOverlay = document.querySelectorAll('.nav__mobile--background');
            this.links = document.querySelectorAll('.nav__mobile--menu a');
            
            if (!this.burger) return;
            
            // Клик по бургеру
            this.burger.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleMobileMenu();
            });
            
            // Клик по ссылкам в меню
            this.links.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.burger.classList.remove('is-open');
                    this.body.classList.remove('overflow');
                    gsap.to(this.menu, { autoAlpha: 0, ease: "power2" });
                    this.menuOverlay.forEach(element => element.classList.remove('is-open'));
                });
            });
        },
        
        toggleMobileMenu() {
            if (!this.burger.classList.contains('is-open')) {
                this.burger.classList.add('is-open');
                this.body.classList.add('overflow');
                gsap.to(this.menu, { autoAlpha: 1, ease: "power2" });
                this.menuOverlay.forEach(element => element.classList.add('is-open'));
            } else {
                this.burger.classList.remove('is-open');
                this.body.classList.remove('overflow');
                gsap.to(this.menu, { autoAlpha: 0, ease: "power2" });
                this.menuOverlay.forEach(element => element.classList.remove('is-open'));
            }
        }
    };

    /**
     * =============================================
     * ИНИЦИАЛИЗАЦИЯ ВСЕХ КОМПОНЕНТОВ
     * =============================================
     */
    // Инициализация обработчиков вариаций
    ProductVariationHandler.init();
    
    // Инициализация фикса мини-корзины
    MiniCartFix.init();
    
    // Инициализация быстрого попапа вариаций
    ProductQuickOptions.init();
    
    // Инициализация оптимизированного обработчика корзины
    FastCartHandler.init();
    
    // Инициализация фикса вложенных контейнеров
    NestedCartFix.init();
    
    // Инициализация мобильного меню
    MobileMenu.init();
    
    // Добавляем стили для animation-spinner и прочих элементов
    const style = document.createElement('style');
    style.textContent = `
        .mini_cart_item.removing {
            opacity: 0.5;
            pointer-events: none;
        }
        .loading-spinner {
            width: 40px;
            height: 40px;
            margin: 20px auto;
            border: 3px solid rgba(0,0,0,0.1);
            border-radius: 50%;
            border-top-color: #3498db;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .product-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 4px;
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        }
        .product-notification.show {
            transform: translateY(0);
            opacity: 1;
        }
        .product-notification-success {
            border-left: 4px solid #4CAF50;
        }
        .product-notification-error {
            border-left: 4px solid #F44336;
        }
    `;
    document.head.appendChild(style);
});