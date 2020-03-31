//**All config js of theme
(function ($) {
    'use strict';
    jQuery(document).ready(function ($) {
        /*Sec menu js*/
        $(document).on('click', '#sec-nav>.menu-title', function () {
            $('.sec-menu, #sec-nav .cmm-container').toggleClass('active');
        });
        /*End Sec menu js*/
        $('.btn-anm').on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top - $('#main-header').outerHeight(true)
            }, 500);
        });
        /*Blog Js*/
        $('.full-width.single-image .wrap-header-post-info').css('margin-top', $('#main-header').outerHeight(true) / 2);
        //Comment form effect
        $(document).on('focusin', '.wrap-text-field input, .wrap-text-field textarea', function () {
            $(this).parents('.wrap-text-field').addClass('focus');
        });
        $(document).on('focusout', '.wrap-text-field input, .wrap-text-field textarea', function () {
            if ($(this).val() == '')
                $(this).parents('.wrap-text-field').removeClass('focus');
        });
        $('.wrap-text-field input, .wrap-text-field textarea').each(function () {
            if ($(this).val() != '')
                $(this).parents('.wrap-text-field').addClass('focus');
        });
        //Full width media for block
        MediaFullWidth($('.media-block iframe'));
        //Masonry layout
        $(window).load(function () {
            if ($('.masonry-layout')[0]) {
                $('.masonry-layout .row').isotope({
                    itemSelector: '.masonry-layout-item'
                });
            }
        });
        /*End Blog Js*/
        $(document).on('click', '.canvas-sidebar-trigger', function (e) {
            e.preventDefault();
            $('body').addClass('canvas-sidebar-active');
        });
        $(document).on('click', '.mask-canvas-sidebar, .close-canvas', function (e) {
            e.preventDefault();
            $('body').removeClass('canvas-sidebar-active');
        });
        $('.search-trigger, #search-mobile-trigger').on('click', function (e) {
            e.preventDefault();
            $('.header-search-block').toggleClass('active');
            setTimeout(function () {
                $('.header-search-block.active input.ipt').focus();
            }, 100);
        });
        $(document).on('click', '.close-search', function () {
            $('.header-search-block').removeClass('active');
        });
        $(".zoo-carousel").each(function () {
            var data = JSON.parse($(this).attr('data-config'));
            var item = data['item'];
            var pag = false;
            if (data['pagination'] != undefined && data['pagination'] == 'true') {
                pag = true;
            }
            var nav = false;
            if (data['navigation'] != undefined && data['navigation'] == 'true') {
                nav = true;
            }
            var wrap = data['wrap'] != undefined ? data['wrap'] : '';
            var wrapcaroul = wrap != '' ? $(this).find(wrap) : $(this);
            wrapcaroul.slick({
                slidesToShow: item,
                slidesToScroll: item > 5 ? Math.round(item / 2) : 1,
                arrows: nav,
                dots: pag,
                autoplay: true,
                prevArrow: '<span class="zoo-carousel-btn prev-item"><i class="cs-font clever-icon-arrow-left-1"></i></span>',
                nextArrow: '<span class="zoo-carousel-btn next-item "><i class="cs-font clever-icon-arrow-right-1"></i></span>',
                autoplaySpeed: 5000,
                rtl: $('body.rtl')[0] ? true : false,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: item > 4 ? 4 : item,
                            slidesToScroll: item > 4 ? 2 : 1
                        }
                    }, {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: item > 2 ? 2 : item,
                            slidesToScroll: 1
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }
                ]
            });
        });
        $(window).on('resize', function () {
            if ($(window).width() < 981) {
                $(".sticker").unstick();
                if (!$('.menu-bottom')[0])
                    $('.wrap-header-block').sticky({zIndex: 4});
                else
                    $('.wrap-header-block.menu-bottom-layout').sticky({zIndex: 4});
                if ($('.stack-center-layout:not(.style-3)')[0] || $('.menu-bottom')[0]) {
                    $('#zoo-header').addClass('search-popup');
                }
            } else {
                if ($('.stack-center-layout:not(.style-3)')[0]) {
                    $('#zoo-header').removeClass('search-popup');
                }
                if ($('.sticky-wrapper')[0]) {
                    $('.wrap-header-block').unstick();
                }
                if ($('#wpadminbar')[0]) {
                    $(".sticker").sticky({zIndex: '4', topSpacing: $('#wpadminbar').height()});
                } else {
                    $(".sticker").sticky({zIndex: '4'});
                }
            }
        }).resize();
        $('.wrap-mobile-nav').zoo_MobileNav();

        //Lazy img
        $('.clever_wrap_lazy_img').each(function () {
            if ($(this).find('.lazy-img')[0]) {
                var res = $(this).data('resolution');
                var w = $(this).width();
                $(this).outerWidth(w).height(w / res);
                $(this).find('.lazy-img').not('.loaded').parent().addClass('loading');
                $(this).find('.lazy-img').not('.loaded').lazyload({
                    effect: 'fadeIn',
                    threshold: $(window).height(),
                    load: function () {
                        $(this).parent().removeClass('loading');
                        $(this).addClass('loaded');
                    }
                });
            }
        });
        //Toggle nav sidebar
        var zoo_sidebar_nav = $('.sidebar .widget_nav_menu, .sidebar .widget_categories, .sidebar .widget_pages');
        zoo_sidebar_nav.find('li>ul').slideUp();
        zoo_sidebar_nav.find('li:has(ul)').append('<span class="zoo-nav-toggle"><i class="cs-font clever-icon-down"></i></span>');
        $(document).on('click', '.zoo-nav-toggle', function () {
            $(this).parent().children('ul').slideToggle();
            $(this).toggleClass('active');
        });

        // Fixes rows in RTL
        function zoo_fix_vc_full_width_row() {
            var $elements = jQuery('[data-vc-full-width="true"]');
            jQuery.each($elements, function () {
                var $el = jQuery(this);
                $el.css('right', $el.css('left')).css('left', '');
            });
        }

        jQuery(document).on('vc-full-width-row', function () {
            if ($('body.rtl')[0]) {
                zoo_fix_vc_full_width_row();
            }
        });

        // Run one time because it was not firing in Mac/Firefox and Windows/Edge some times
        zoo_fix_vc_full_width_row();
        //Full width embed
        $(window).resize(function () {
            if ($('.post-image iframe')[0]) {
                $('.post-image iframe').each(function () {
                    let ration = $(this).width() / $(this).height();
                    let wrap_width = $(this).parents('.post-image').width();
                    $(this).width(wrap_width);
                    $(this).height(wrap_width * ration);
                })
            }
        }).resize();
        if ($('.post-slider')[0]) {
            $('.post-slider').slick({
                autoplay: true,
                prevArrow: '<span class="zoo-carousel-btn prev-item"><i class="cs-font clever-icon-arrow-left-1"></i></span>',
                nextArrow: '<span class="zoo-carousel-btn next-item "><i class="cs-font clever-icon-arrow-right-1"></i></span>',
                autoplaySpeed: 3000,
            });
        }
    });
    $(window).on('load', function () {
        $('#page-load').addClass('deactive');
        $(window).resize(function () {
            //Fix position menu
            var window_w = $(window).width();
            $('.pos-left').removeClass('pos-left');
            $('#main-navigation .children, #main-navigation .sub-menu, .top-head-widget .sub-menu, .bottom-main-footer-block .sub-menu').each(function () {
                if (window_w < parseInt($(this).offset()['left'] + $(this).width())) {
                    $(this).addClass('pos-left');
                }
            });
        }).resize();
    });
    jQuery.fn.extend({
        zoo_MobileNav: function () {
            $(this).find('li:has("ul")>a').after('<span class="triggernav"><i class="cs-font clever-icon-plus"></i></span>');
            $('.triggernav').zoo_toggleMobileNav();
            $(document).on('click', '#menu-mobile-trigger', function (e) {
                e.preventDefault();
                $(this).toggleClass('active');
                $('.wrap-mobile-nav').toggleClass('active');
                $('body').toggleClass('menu-active');
            });
            $(document).on('click', '.menu-active .close-nav, .menu-active .mask-nav', function (e) {
                e.preventDefault();
                $('.wrap-mobile-nav,#menu-mobile-trigger').toggleClass('active');
                $('body.menu-active').toggleClass('menu-active');
            })
        },
        zoo_toggleMobileNav: function () {
            $('.wrap-mobile-nav li ul').slideUp();
            $(this).on("click", function () {
                $(this).toggleClass('active');
                $(this).next().slideToggle();
                if (!$(this).hasClass('active')) {
                    $(this).next().find('ul').slideUp();
                    $(this).next().find('.triggernav').removeClass('active');
                }
            });
        },
        ActiveScreen: function () {
            var itemtop, windowH, scrolltop;
            itemtop = $(this).offset().top;
            windowH = $(window).height();
            scrolltop = $(window).scrollTop();
            if (itemtop < scrolltop + windowH * 2 / 3) {
                return true;
            }
            else {
                return false;
            }
        },

    });
    var MediaFullWidth = function (selector) {
        $(window).resize(function () {
            selector.each(function () {
                let aspectRatio = $(this).height() / $(this).width();
                $(this).removeAttr('height').removeAttr('width');
                let newWidth = jQuery(this).parent().width();
                $(this).width(newWidth).height(newWidth * aspectRatio);
            });
        }).resize();
    };
})(jQuery);