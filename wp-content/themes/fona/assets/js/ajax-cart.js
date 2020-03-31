(function ($) {
    "use strict";
    jQuery(document).ready(function () {
        $(document).on('click', '.wrap-icon-cart, .mask-close, .close', function (e) {
            e.preventDefault();
            zoo_CartVisible();
        });
        $(document).bind('cleverswatch_before_add_to_cart', function () {
            zoo_CartVisible();
            $('.wrap-mini-cart').addClass('loading');
        });

        function zoo_CartVisible() {
            $('body').toggleClass('cart-active');
        }

        if (typeof wc_add_to_cart_params === 'undefined') {
            return false;
        }
        //Ajax Remove Cart ===================================
        $(document).on('click', '.mini_cart_item .remove', function (event) {
            event.preventDefault();

            var $this = $(this);
            var product_id = $this.data('product_id');
            $this.parents('.mini_cart_item').addClass('loading');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: wc_add_to_cart_params.ajax_url,
                data: {
                    action: "cart_remove_product",
                    product_key: product_id
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log('AJAX Remove ' + errorThrown);
                },
                success: function (data) {
                    var $cart = $('.wrap-mini-cart');
                    $cart.find('.pre-remove').addClass('removed');
                    $this.parents('.mini_cart_item').addClass('pre-remove');
                    $cart.find('.removed').fadeOut();
                    if (data.cart_count == 0) {
                        $cart.find('.wrap-bottom-cart').fadeOut();
                    } else {
                        $cart.find('.total .woocommerce-Price-amount').replaceWith(data.cart_subtotal);
                        $('.zoo-mini-cart.cart-notice-active .free-shipping-required-notice').replaceWith(data.free_shipping_cart_notice);
                    }
                    $('.total-cart').html(data.cart_subtotal);
                    $('.top-cart-total span').html(data.cart_count);
                    $('.sticky-cart .top-cart-total').html(data.cart_count);
                    $this.parents('.mini_cart_item').removeClass('loading');
                    setTimeout(function () {
                        $cart.find('.removed').remove();
                    }, 500);
                }
            });
            return false;
        });
        //Ajax Restore Cart Item===================================
        $(document).on('click', '.mini_cart_item .revert-cart-item', function (event) {
            event.preventDefault();
            var $this = $(this);
            var cart_item_key = $this.data('cart_item_key');
            $this.parents('.mini_cart_item').addClass('loading');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: wc_add_to_cart_params.ajax_url,
                data: {
                    action: "restore_cart_item",
                    cart_item_key: cart_item_key
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log('AJAX Restore ' + errorThrown);
                    console.log('AJAX Restore ' + cart_item_key);
                },
                success: function (data) {
                    var $cart = $('.wrap-mini-cart');
                    $this.parents('.mini_cart_item').removeClass('pre-remove');
                    $cart.find('.total .woocommerce-Price-amount').replaceWith(data.cart_subtotal);
                    if (!$cart.find('.wrap-bottom-cart').is(":visible")) {
                        $cart.find('.wrap-bottom-cart').fadeIn();
                    }
                    $('.total-cart').html(data.cart_subtotal);
                    $('.top-cart-total span').html(data.cart_count);
                    $('.sticky-cart .top-cart-total').html(data.cart_count);
                    $('.zoo-mini-cart.cart-notice-active .free-shipping-required-notice').replaceWith(data.free_shipping_cart_notice);
                    $this.parents('.mini_cart_item').removeClass('loading');
                }
            });
            return false;
        });

        //Ajax Add to Cart ===================================
        $(document).on('click', '.add_to_cart_button:not(.product_type_variable)', function () {
            zoo_CartVisible();
            $('.wrap-mini-cart').addClass('loading');
        });
        //Update mini top cart ajax
        $(document).bind('added_to_cart', function (event, fragments, cart_hash, $button) {
            var $fragments = $(fragments['#top-cart']);
            $fragments = $fragments.find('.top-cart-total');
            $('#mini-top-cart .top-cart-total').replaceWith($fragments);
            zoo_add_to_cart_mess(fragments['zoo_add_to_cart_message']);
        });

        //Function for Add to Cart message
        function zoo_add_to_cart_mess($zoo_mess) {
            if (!!$zoo_mess) {
                if ($('#zoo-add-to-cart-message')[0]) {
                    $('#zoo-add-to-cart-message').replaceWith($zoo_mess);
                } else {
                    $('body').append($zoo_mess);
                }
                setTimeout(function () {
                    $('#zoo-add-to-cart-message').addClass('active');
                }, 100);
                setTimeout(function () {
                    $('#zoo-add-to-cart-message').removeClass('active');
                }, 3500);
            }
        }

        //Ajax Add to Cart Detail ===================================
        $(document).on('click', 'button.single_add_to_cart_button', function (event) {
            var $this = $(this);
            var $productForm = $this.closest('form');
            var data = {
                product_id: $productForm.find("*[name*='add-to-cart']").val(),
                product_variation_data: $productForm.serialize()
            };
            if (!!data.product_id) {
                event.preventDefault();
                zoo_CartVisible();
                $('.wrap-mini-cart').addClass('loading');
                $('.zoo-quickview-mask').css('opacity', '0');
                $('#zoo-quickview-lb').css({'top': 'calc(50% + 150px)', 'opacity': '0'});
                setTimeout(function () {
                    $('#zoo-quickview-lb').remove();
                    $('.zoo-quickview-mask').remove();
                }, 500);

                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: normally_url_cart(document.location.search, 'add-to-cart', data.product_id, false),
                    data: data.product_variation_data,
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log('AJAX error - SubmitForm() - ' + errorThrown);
                    },
                    success: function (response) {
                        var $response = $(response),
                            $shopNotices = $response.find('.woocommerce-message');
                        // Shop notices
                        //Get replacement elements/values
                        var fragments = {
                            '#top-cart .top-cart-total,#mini-top-cart .top-cart-total': $response.find('#top-cart .top-cart-total'), // Header menu cart count
                            '.sticky-cart .top-cart-total': $response.find('.sticky-cart .top-cart-total'), // Header menu cart count
                            '.total-cart': $response.find('.total-cart'), // Header menu cart count
                            '.woocommerce-message': $shopNotices,
                            '.wrap-mini-cart': $response.find('.wrap-mini-cart') // Widget panel mini cart
                        };
                        // Replace elements
                        $.each(fragments, function (selector, $element) {
                            if ($element.length) {
                                $(selector).replaceWith($element);
                            }
                        });
                        $('.wrap-mini-cart').removeClass('loading');
                    }
                });
                return false;
            }
            else {
                console.log('(Error): No product id found');
                return;
            }
        });

        //Normally Ajax url, for multi language
        function normally_url_cart(url, parameterName, parameterValue, atStart) {
            var replaceDuplicates = true;
            var urlhash = '';
            var cl = url.length;
            if (url.indexOf('#') > 0) {
                cl = url.indexOf('#');
                urlhash = url.substring(url.indexOf('#'), url.length);
            }
            var sourceUrl = url.substring(0, cl);

            var urlParts = sourceUrl.split("?");
            var newQueryString = "";

            if (urlParts.length > 1) {
                var parameters = urlParts[1].split("&");
                for (var i = 0; (i < parameters.length); i++) {
                    var parameterParts = parameters[i].split("=");
                    if (!(replaceDuplicates && parameterParts[0] == parameterName)) {
                        if (newQueryString == "")
                            newQueryString = "?";
                        else
                            newQueryString += "&";
                        newQueryString += parameterParts[0] + "=" + (parameterParts[1] ? parameterParts[1] : '');
                    }
                }
            }
            if (newQueryString == "")
                newQueryString = "?";

            if (atStart) {
                newQueryString = '?' + parameterName + "=" + parameterValue + (newQueryString.length > 1 ? '&' + newQueryString.substring(1) : '');
            } else {
                if (newQueryString !== "" && newQueryString != '?')
                    newQueryString += "&";
                newQueryString += parameterName + "=" + (parameterValue ? parameterValue : '');
            }
            return urlParts[0] + newQueryString + urlhash;
        };
    })
})(jQuery);