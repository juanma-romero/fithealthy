//**All js for woocommerce of theme
(function ($) {
    'use strict';
    jQuery(document).ready(function () {

        $(document).bind('zoo_ln_after_filter', function (event, response) {
            $('.products').zoo_WooSmartLayout();
            setTimeout(function () {
                $('.sidebar-active').removeClass('sidebar-active');
            }, 100);
            setTimeout(function () {
                //Ajax change layout
                $('.products:not(.carousel)').isotope('reloadItems');
            }, 350);
        });
        $(window).load(function () {
            $(window).resize(function () {
                $('.woocommerce-page .products').zoo_WooSmartLayout();
                $('.cvca-wrap-products-sc .products:not(.products-carousel)').zoo_WooSmartLayout();
            }).resize();
        });
        $('.page').find('.lazy-img').zoo_lazyImg();
        $(document).on('hover','ul.products  li.product',function () {
            var $this=$(this).find('.sec-img');
            if(!!$this.data('original')){
                $this.attr('src',$this.data('original'));
                $this.attr('srcset',$this.data('srcset'));
            }
        });
        //Quickview js
        $(document).on('click','.quick-view.btn', function (e) {
            e.preventDefault();
            if(!$('.zoo-quickview-mask')[0]) {
                $('body').append('<div class="zoo-quickview-mask"></div>');
            }
            $('.zoo-quickview-mask').addClass('active');
            var load_product_id = $(this).attr('data-product_id');
            var data = {action: 'zoo_quickview', product_id: load_product_id};
            $(this).parent().addClass('loading');
            var $this = $(this);
            $.ajax({
                url: ajaxurl,
                data: data,
                type: "POST",
                success: function (response) {
                    $('body').append(response);
                    $this.parent().removeClass('loading');
                    // Variation Form
                    var form_variation = $(document).find('#zoo-quickview-lb .variations_form');
                    form_variation.wc_variation_form();
                    form_variation.trigger('check_variations');
                    zoo_qv_gal();
                    setTimeout(function () {
                        $('#zoo-quickview-lb,.zoo-quickview-mask').css('opacity', '1');
                    }, 10);
                }
            });
        });
        $(document).on('click', '.wrap-cart-coupon .heading-coupon', function () {
            $('.wrap-cart-coupon .custom-coupon').slideToggle();
        });
        $(document).on('click', '.zoo-quickview-mask, .close-quickview', function (e) {
            e.preventDefault();
            zoo_remove_qv_lb();
        });

        function zoo_remove_qv_lb() {
            $('.zoo-quickview-mask').removeClass('active');
            $('#zoo-quickview-lb').css({'top': 'calc(50% + 150px)', 'opacity': '0'});
            setTimeout(function () {
                $('#zoo-quickview-lb').remove();
            }, 500)
        }

        function zoo_qv_gal() {
            if ($('#zoo-quickview-lb .wrap-top-single-product .wrap-single-carousel')[0]) {
                $('#zoo-quickview-lb .wrap-top-single-product .wrap-single-carousel').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    rtl: $('body.rtl')[0] ? true : false,
                    swipe: true,
                    prevArrow: '<span class="zoo-carousel-btn prev-item"><i class="cs-font clever-icon-arrow-left-1"></i></span>',
                    nextArrow: '<span class="zoo-carousel-btn next-item "><i class="cs-font clever-icon-arrow-right-1"></i></span>',
                });
                $('#zoo-quickview-lb .wrap-single-carousel .woocommerce-main-image').ZooMove();
            }
        }

        /*Woocommerce Form Login*/
        $('.icon-user.login>a').on('click', function (e) {
            e.preventDefault();
            $('body').addClass('active-login-form');
            $('.login-form-popup .login').show();
            $('body').removeClass('active-login-error');
        });
        if ($('.woocommerce-error')[0]) {
            $('body').addClass('active-login-error');
        }

        $(document).on('click', '.login-form-popup .close-login,.login-form-popup .overlay', function (e) {
            $('body').removeClass('active-login-form');
            $('body').removeClass('active-login-error');
        });
        //Sidebar control
        $('.mask-sidebar, .close-sidebar').on('click', function (e) {
            e.preventDefault();
            $('.sidebar-control').removeClass('active');
            $('body').removeClass('sidebar-active');
        });
        $('.sidebar-control').on('click', function (e) {
            e.preventDefault();
            if($('.top-sidebar')[0]){
                $('#top-shop-widget').slideToggle();
            }else{
                $('body').addClass('sidebar-active');
            }

        });
        //Shortcode product group
        if ($('.shortcode-product-carousel-group')[0]) {
            $('.shortcode-product-carousel-group  .wrap-carousel-products').slick({
                slidesToShow: $('.shortcode-product-carousel-group').data('config')['columns'],
                slidesToScroll: 1,
                rtl: $('body.rtl')[0] ? true : false,
                swipe: true,
                prevArrow: '<span class="zoo-carousel-btn prev-item"><i class="cs-font clever-icon-arrow-left-1"></i></span>',
                nextArrow: '<span class="zoo-carousel-btn next-item "><i class="cs-font clever-icon-arrow-right-1"></i></span>',
            });
        }
        $(window).load(function () {
            $(window).resize(function () {
                if($(window).width()>769) {
                    //tippy js for tooltip
                    if (typeof tippy !== 'undefined') {
                        $('.products .product:not(.default, .style-2)').find('.wrap-product-button .button, .btn, .zoo-custom-wishlist-btn a').attr('data-tippy-placement', 'left-top');
                        tippy('.wrap-product-button .added_to_cart, .product .wrap-product-button .button, .product .wrap-product-button .btn, .zoo-custom-wishlist-btn a', {
                            arrow: true,
                            animation: 'fade',
                            dynamicTitle: true
                        });
                        //Bind for button if button is Add to Cart
                        $(document).bind('cleverswatch_button_add_cart', function (event, response) {
                            var add_to_cart_button = response.selector;
                            add_to_cart_button.attr('title', add_to_cart_button.find('.zoo_cw_add_to_cart_button_label').text());
                        });
                        $(document).bind('cleverswatch_button_out_stock', function (event, response) {
                            var add_to_cart_button = response.selector;
                            add_to_cart_button.attr('title', add_to_cart_button.find('.zoo_cw_add_to_cart_button_label').text());
                        });
                        $(document).bind('cleverswatch_button_select_option', function (event, response) {
                            var add_to_cart_button = response.selector;
                            add_to_cart_button.attr('title', add_to_cart_button.find('.zoo_cw_add_to_cart_button_label').text());
                        });
                    }
                    $(document).bind('added_to_cart', function (event, fragments, cart_hash, $button) {
                        if (typeof tippy !== 'undefined') {
                            $('.products .product:not(.default, .style-2)').find('.wrap-product-button .button, .btn, .zoo-custom-wishlist-btn a').attr('data-tippy-placement', 'left-top');
                            tippy('.wrap-product-button .added_to_cart, .product .wrap-product-button .button, .product .wrap-product-button .btn, .zoo-custom-wishlist-btn a', {
                                arrow: true,
                                animation: 'fade',
                                dynamicTitle: true
                            });
                        }
                    });
                }
            }).resize();
        });
        //**Single product js**//
        $(window).load(function () {
            //Call Variable js
            zoo_VaritionImg();
        });

        //product carousel layout
        zoo_product_carousel();
        //Product Zoom feature
        if ($('.zoo-product-zoom')[0]) {
            $('.zoo-product-zoom .wrap-single-carousel .woocommerce-main-image').ZooMove();
        }
        $(document).bind('cleverswatch_update_gallery', function (event, response) {
            setTimeout(function () {
                if (!$('#zoo-quickview-lb')[0]) {
                    $('#product-' + response.product_id + '.zoo-product-zoom .wrap-single-carousel .woocommerce-main-image').ZooMove();
                    zoo_product_carousel();
                }
                else {
                    zoo_qv_gal();
                }
            }, 500);
        });
        //Product qty
        $(document).zoo_CartQuantity('.quantity .qty-nav');
        //**End Single js**//
        //For resize window
        $(window).resize(function () {
            //Stick filter
            if ($(window).width() < 769) {
                $('#top-product-page').sticky({
                    zIndex: '1',
                    topSpacing: $('#zoo-header .sticker').outerHeight()
                });
            } else {
                if ($('#top-product-page-sticky-wrapper')[0]) {
                    $('#top-product-page').unstick();
                }
            }
            //Clear cookie sidebar in mobile
            if ($(window).width() < 769) {
                if ($('.zoo-woo-page')[0]) {
                    setCookie('sidebar-status', '');
                    $('.disable-sidebar').removeClass('disable-sidebar');
                    $('.zoo-woo-sidebar').css('margin', '0');
                }
            }
            //Sidebar toogle
            if ($('.zoo-woo-page')[0]) {
                if ($('#primary').offset().left < 290) {
                    $('.zoo-woo-page.sidebar-onscreen').removeClass('sidebar-onscreen');
                }
                else {
                    $('.zoo-woo-page:not(.sidebar-onscreen)').addClass('sidebar-onscreen');
                }
            }
            //Stick gallery
            if ($('.wrap-top-single-product')[0]) {
                if ($(window).width() < 768) {
                    $('.wrap-top-single-product.sticky .wrap-single-carousel:not(.slick-slider), .images-center.zoo-single-product .wrap-single-carousel').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        swipe: true,
                        rtl: $('body.rtl')[0] ? true : false,
                        prevArrow: '<span class="zoo-carousel-btn prev-item"><i class="cs-font clever-icon-arrow-left-1"></i></span>',
                        nextArrow: '<span class="zoo-carousel-btn next-item "><i class="cs-font clever-icon-arrow-right-1"></i></span>',
                    });
                } else {
                    $('.wrap-top-single-product.sticky .wrap-single-carousel.slick-slider').slick('destroy');
                    $('.images-center.zoo-single-product .wrap-single-carousel.slick-slider').slick('destroy');
                }
            }
        });
        var window_w_o = $(window).width();
        $(window).resize(function () {
            if (window_w_o != $(window).width()) {
                window_w_o = $(window).width();
                setTimeout(function () {
                    $('.products').zoo_WooSmartLayout();
                    $('.zoo-single-product.carousel .wrap-single-carousel').slick('reinit');
                    $('.zoo-single-product.vertical-gallery .wrap-single-carousel,.zoo-single-product.center .wrap-single-carousel, .zoo-single-product.horizontal-gallery .wrap-single-carousel').slick('reinit');
                }, 400);
                if ($('.products:not(.carousel)')[0] && !!$('.products').attr('data-width')) {
                    setTimeout(function () {
                        $('.products:not(.carousel)').isotope({layoutMode: 'fitRows'});
                    }, 800);
                }

            }
        }).resize();
        /*Woocommerce Form Login*/
        $('.btn-show-register').on('click', function (e) {
            e.preventDefault();
            $('.login.form').slideUp();
            $('.register.form').slideDown();
        });
        $('.btn-show-login').on('click', function (e) {
            e.preventDefault();
            $('.login.form').slideDown();
            $('.register.form').slideUp();
        });
        //product lightbox
        $(document).on('click', '.zoo-woo-lightbox', function (e) {
            e.preventDefault();
            var pswpElement = $('.pswp')[0],
                items = $(this).zoogetGalleryItems(),
                c_index = $(this).parent().index();
            if ($(this).parent().hasClass('slick-slide')) {
                if ($('.carousel.zoo-single-product')[0]) {
                    var total_sl_active = $('.wrap-single-image .slick-active').length;
                    if (total_sl_active == 0) {
                        c_index = $(this).parent().index();
                    }
                    else {
                        c_index = $(this).parent().index() - total_sl_active - 1;
                    }
                }
                else {
                    c_index = $(this).parent().index() - 1;
                }

            }
            var options = {
                index: c_index,
                shareEl: false,
                closeOnScroll: false,
                history: false,
                hideAnimationDuration: 0,
                showAnimationDuration: 0
            };
            // Initializes and opens PhotoSwipe.
            var photoswipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            photoswipe.init();
        });
        /*Custom product tab*/
        if ($('.zoo-product-tabs')[0]) {
            var tab_active, first_tab = $('.zoo-product-tabs .zoo-tabs li:first-child');
            first_tab.addClass('active');
            tab_active = first_tab.find('a').attr('href');
            $(tab_active).addClass('active');
        }
        $('.zoo-product-tabs .zoo-tabs a').on('click', function (e) {
            e.preventDefault();
            var tab = $(this).attr('href');
            $('.zoo-product-tabs .zoo-tabs .active').removeClass('active');
            $(this).parent().addClass('active');
            $(this).parents('.zoo-product-tabs').find('.zoo-custom-tab.active').removeClass('active');
            $(tab).addClass('active');
        });
        //Columns control
        $(document).on('click', '.layout-control-column .item', function () {
            $('.layout-control-column .item').removeClass('active');
            $(this).addClass('active');
            setCookie('col-control', $(this).data('column'));
            $('.products').zoo_WooSmartLayout();
            setTimeout(function () {
                $('.products').zoo_WooSmartLayout();
            }, 350);
        });
        //Accordion tab
        if ($('.zoo-accordion')[0]) {
            $('.zoo-accordion .tab-content .zoo-group-accordion:not(.accordion-active)').find('.panel').slideUp();
        }
        $('.zoo-group-accordion .tab-heading').on('click', function () {
            if ($(this).parent().hasClass('accordion-active')||$(this).next().is(":visible")) {
                $(this).next().slideUp();
                $(this).parent().removeClass('accordion-active');
            }
            else {
                $(this).parents('.tab-content').find('.panel:visible').slideUp();
                $(this).parents('.tab-content').find('.accordion-active').removeClass('accordion-active');
                $(this).next().slideDown();
                $(this).parent().addClass('accordion-active');
            }
            if($('.tabs.wc-tabs.zoo-tabs')[0]){
                console.log($(this).next().attr('id'));
                $('.tabs.wc-tabs.zoo-tabs').find('.active').removeClass('active');
                $('.tabs.wc-tabs.zoo-tabs').find('a[href="#'+$(this).next().attr('id')+'"]').parent().addClass('active');
            }
        });
    });

    //Variable js
    function zoo_VaritionImg() {
        if (jQuery("form.variations_form")[0] && !$('.zoo-cw-page')[0]) {
            var orginal_image = $('.slick-current.woocommerce-main-image img').attr('src');
            jQuery("form.variations_form").on("show_variation", function (event, variation) {
                if (variation.image.full_src != '') {
                    var newimg = variation.image.full_src;
                    $('.slick-current.woocommerce-main-image img').attr('src', newimg);
                    $('.slick-current.woocommerce-main-image img').attr('srcset', newimg);
                    $('.slick-current.woocommerce-main-image a').attr('href', newimg);
                    $('.slick-current.woocommerce-main-image .zoo-img').css('background-image', 'url(' + newimg + ')');
                }
            });
            jQuery(".reset_variations").on("click", function (event) {
                event.preventDefault();
                $('.slick-current.woocommerce-main-image img').attr('src', orginal_image);
                $('.slick-current.woocommerce-main-image img').attr('srcset', orginal_image);
                $('.slick-current.woocommerce-main-image a').attr('href', orginal_image);
                $('.slick-current.woocommerce-main-image .zoo-img').css('background-image', 'url(' + orginal_image + ')');
            });
        }
    }

    $(window).on('load', function () {
        //Sticky product
        $(window).on('resize', function () {
            if($(window).width()>769) {
                if ($('.sticky.zoo-single-product')[0] || $('.images-center.zoo-single-product')[0]) {
                    var offset = 0;
                    if ($('#zoo-header .sticky-wrapper')[0]) {
                        offset = $('#zoo-header .sticky-wrapper').height() + 30;
                    }
                    $('.wrap-right-single-product').stick_in_parent({offset_top: offset});
                    $('.images-center.zoo-single-product .zoo-woo-tabs.zoo-accordion').stick_in_parent();
                }
            }
        }).resize();
        if ($('.woocommerce-cart')[0]) {
            setTimeout($('.products').zoo_WooSmartLayout(), 300);
        }

    });

//Product carousel
    var slide_h, thumb_h, items;

    function zoo_product_carousel() {
        //Carousel Gallery
        if ($('.zoo-single-product')[0]) {
            $('.zoo-single-product.carousel .wrap-single-carousel').slick({
                slidesToScroll: 1,
                slidesToShow: 3,
                centerMode: true,
                rtl: $('body.rtl')[0] ? true : false,
                autoplay: true,
                autoplaySpeed: 5000,
                prevArrow: '<span class="zoo-carousel-btn prev-item"><i class="cs-font clever-icon-arrow-left-1"></i></span>',
                nextArrow: '<span class="zoo-carousel-btn next-item "><i class="cs-font clever-icon-arrow-right-1"></i></span>',
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
            //Horizontal gallery
            $('.zoo-single-product.vertical-gallery .wrap-single-carousel,.zoo-single-product.center .wrap-single-carousel, .zoo-single-product.horizontal-gallery .wrap-single-carousel').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                swipe: true,
                rtl: $('body.rtl')[0] ? true : false,
                asNavFor: '.wrap-top-single-product .wrap-thumbs-gal',
                prevArrow: '<span class="zoo-carousel-btn prev-item"><i class="cs-font clever-icon-arrow-left-1"></i></span>',
                nextArrow: '<span class="zoo-carousel-btn next-item "><i class="cs-font clever-icon-arrow-right-1"></i></span>',
            });
        }
        if ($('.zoo-single-product.vertical-gallery')[0]) {
            if ($('.wrap-top-single-product .wrap-thumbs-gal')[0]) {
                if (!(!!items)) {
                    slide_h = $('.zoo-single-product.vertical-gallery .wrap-single-carousel').height(),
                        thumb_h = $('.wrap-thumbs-gal .product-thumb-gal').height() + 5,
                        items = Math.floor(slide_h / thumb_h);
                }
                $('.wrap-top-single-product .wrap-thumbs-gal').slick({
                    slidesToShow: items,
                    slidesToScroll: 1,
                    vertical: true,
                    verticalSwiping: true,
                    focusOnSelect: true,
                    rtl: $('body.rtl')[0] ? true : false,
                    asNavFor: '.wrap-top-single-product .wrap-single-carousel',
                    prevArrow: '<span class="zoo-carousel-btn vertical-btn prev-item"><i class="cs-font clever-icon-up"></i></span>',
                    nextArrow: '<span class="zoo-carousel-btn  vertical-btn next-item "><i class="cs-font clever-icon-down"></i></span>',
                });
            }
        }
        if ($('.zoo-single-product.horizontal-gallery .wrap-thumbs-gal')[0] || $('.zoo-single-product.center .wrap-thumbs-gal')[0]) {
            $('.zoo-single-product.horizontal-gallery .wrap-thumbs-gal, .zoo-single-product.center .wrap-thumbs-gal').slick({
                focusOnSelect: true,
                slidesToScroll: 1,
                slidesToShow: 4,
                swipe: true,
                speed: 300,
                rtl: $('body.rtl')[0] ? true : false,
                asNavFor: '.wrap-top-single-product .wrap-single-carousel',
                prevArrow: '<span class="zoo-carousel-btn prev-item"><i class="cs-font clever-icon-arrow-left-1"></i></span>',
                nextArrow: '<span class="zoo-carousel-btn next-item "><i class="cs-font clever-icon-arrow-right-1"></i></span>',
            });
        }
    }

//Cookie
    function setCookie(cname, cvalue) {
        document.cookie = cname + "=" + cvalue + "; ";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    jQuery.fn.extend({
        zoo_WooSmartLayout: function () {
            if (jQuery(this)[0]) {
                jQuery(this).each(function () {
                    if (!$(this).hasClass('carousel')) {
                        var col, img_w, $this = jQuery(this), wrap_w = Math.floor($this.outerWidth()), res = '';
                        var hl_featured = $(this).data('highlight-featured');
                        if (hl_featured == '1' && $(this).find('.featured')[0]) {
                            hl_featured = '1'
                        } else {
                            hl_featured = '0'
                        }
                        $this.find('.product').outerHeight('auto');
                        if ($this.find('.lazy-img')[0]) {
                            res = $this.find('.lazy-img').parent().data('resolution');
                        }
                        var item_w = jQuery(this).data('width'),
                            columns = $('.layout-control-column .item.active').data('column');
                        if (!!columns) {
                            if ($(window).width() <= 769) {
                                if (columns > 3 && $(window).width() >= 481) {
                                    columns = 3;
                                    $('.layout-control-column .item.active').removeClass('active');
                                    $('.layout-control-column .item:nth-child(3)').addClass('active');
                                }else if (columns > 2 && ($(window).width() < 481 && $(window).width() > 370)) {
                                    columns = 2;
                                    $('.layout-control-column .item.active').removeClass('active');
                                    $('.layout-control-column .item:nth-child(2)').addClass('active');
                                }else if($(window).width() < 369){
                                    columns = 1;
                                    $('.layout-control-column .item.active').removeClass('active');
                                    $('.layout-control-column .item:nth-child(1)').addClass('active');
                                }

                            }
                            item_w = Math.floor($this.width() / columns);
                        }
                        if (!!item_w) {
                            if ($this.hasClass('grid')) {
                                if (item_w) {
                                    var col_w;
                                    if (!!columns) {
                                        col_w = item_w;
                                        col = columns;
                                    }
                                    else {
                                        if (jQuery(window).width() > 369) {
                                            col = Math.floor(wrap_w / item_w);
                                        } else {
                                            col = 1;
                                        }
                                        col_w = Math.floor(wrap_w / col);
                                    }
                                    if (hl_featured == '1') {
                                        $this.find('.product:not(.featured)').outerWidth(col_w);
                                        if (col_w < jQuery(this).width()) {
                                            $this.find('.product.featured').outerWidth(col_w * 2);
                                        }
                                    } else {
                                        $this.find('.product').outerWidth(col_w);
                                    }
                                }
                                if (!!res) {
                                    img_w = col_w - parseInt($this.find('.product').css('padding-right')) - parseInt($this.find('.product').css('padding-left'));
                                    if (hl_featured == '1') {
                                        $this.find('.product:not(.featured) .lazy-img').parent().outerWidth(img_w).height(img_w / res);
                                        if (col_w < jQuery(this).width()) {
                                            let img_w2 = parseInt(col_w * 2) - parseInt($this.find('.product').css('padding-right')) - parseInt($this.find('.product').css('padding-left'));
                                            $this.find('.product.featured .lazy-img').parent().outerWidth(img_w2).height(img_w2 / res);
                                        } else {
                                            $this.find('.product.featured .lazy-img').parent().outerWidth(img_w).height(img_w / res);
                                        }
                                    }
                                    else {
                                        $this.find('.product .lazy-img').parent().outerWidth(img_w).height(img_w / res);
                                    }
                                }
                            }
                            if ($this.hasClass('list')) {
                                $this.find('.product').outerWidth(wrap_w);
                                if (!!res) {
                                    img_w = $this.find('.product').width() * 0.25;
                                    $this.find('.lazy-img').parent().outerWidth(img_w).height(img_w / res);
                                }
                            }
                            if (item_w) {
                                setTimeout(function () {
                                    if (hl_featured == '1' && (columns > 2 || !columns)) {
                                        if ($this.hasClass('grid')) {
                                            var height = 0;
                                            $this.find('.product:not(.featured)').each(function () {
                                                if ($(this).outerHeight(true) > height) {
                                                    height = $(this).outerHeight(true);
                                                }
                                            });
                                            $this.find('.product:not(.featured)').outerHeight(height);
                                            $this.find('.product.featured').outerHeight(height * 2);
                                        } else {
                                            $this.find('.product').outerHeight('auto');
                                        }
                                        $this.isotope({
                                            layoutMode: 'masonry',
                                            itemSelector: '.product',
                                            percentPosition: true,
                                            masonry: {
                                                columnWidth: '.product:not(.featured)'
                                            }
                                        });
                                    } else {
                                        $this.find('.product').outerHeight('auto');
                                        $this.isotope({
                                            layoutMode: 'fitRows'
                                        });
                                    }
                                }, 500);
                            }
                        }
                        $this.find('.lazy-img').zoo_lazyImg();
                    } else {
                        $(this).find('.lazy-img').each(function () {
                            $(this).attr('src', $(this).data('original'));
                            $(this).attr('srcset', $(this).data('srcset'));
                        });
                    }
                });
            }
        },
        //Lazy Img Config
        zoo_lazyImg: function () {
            if ($(this)[0]) {
                var img_srcset = '';
                $(this).not('.sec-img, .loaded').parent().addClass('loading');
                $(this).not('.sec-img, .loaded').lazyload({
                    effect: 'fadeIn',
                    threshold: $(window).height(),
                    load: function () {
                        $(this).parent().removeClass('loading');
                        $(this).addClass('loaded');
                        img_srcset = $(this).data('srcset');
                        if (!!img_srcset) {
                            $(this).attr('srcset', img_srcset);
                        }
                    }
                });
            }
        },
        //Product Qty
        zoo_CartQuantity: function (target) {
            if ($(this)[0]) {
                $(this).on("click", target, function () {
                    var parent = jQuery(this).parents('.quantity').find('input.qty');
                    var val = parseInt(parent.val());
                    if ($(this).hasClass('increase')) {
                        parent.val(val + 1);
                    }
                    else {
                        if ($(this).closest('.woocommerce-grouped-product-list')[0]) {
                            if (val > 0) {
                                parent.val(val - 1);
                            }
                        } else {
                            if (val > 1) {
                                parent.val(val - 1);
                            }
                        }
                    }
                    parent.trigger('change');
                });
            }
        },
        //Push product images to list
        zoogetGalleryItems: function () {
            var $slides = this.parents('.wrap-single-image').find('.woocommerce-main-image:not(.slick-cloned)'),
                items = [];
            if ($slides.length > 0) {
                $slides.each(function (i, el) {
                    var img = $(el).find('img'),
                        large_image_src = img.attr('data-large_image'),
                        large_image_w = img.attr('data-large_image_width'),
                        large_image_h = img.attr('data-large_image_height'),
                        item = {
                            src: large_image_src,
                            w: large_image_w,
                            h: large_image_h,
                            title: img.attr('title')
                        };
                    items.push(item);
                });
            }
            return items;
        }
    });
})
(jQuery);