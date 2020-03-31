(function ($, window, wp) {
    'use strict';
    jQuery.fn.extend({
        media_upload: function() {
            var _custom_media = true,
                _orig_send_attachment = wp.media.editor.send.attachment;
            $(this).live('click', function (e) {
                var button_id = '#' + $(this).attr('id');
                var wrapper_id = '#' + $(this).parent('p').attr('id');
                var button = $(button_id);
                var id = button.attr('id').replace('_button', '');
                _custom_media = true;
                wp.media.editor.send.attachment = function (props, attachment) {
                    if (_custom_media) {
                        $(wrapper_id).find('.custom_media_url').val(attachment.url);
                        $(wrapper_id).find('.custom_media_image').attr('src', attachment.url).css('display', 'block');
                    } else {
                        return _orig_send_attachment.apply(button_id, [props, attachment]);
                    }
                }
                wp.media.editor.open(button);
                return false;
            });
        }
    });

    jQuery(document).ready(function () {
       $('.custom_media_button.button').media_upload();
    });

    // Switch theme advanced options tabs
    if ($(".zoo-theme-settings .nav-item")) {
        var adaptiveImageCheckbox = $("#enable-adaptive-images-checkbox"),
            adaptiveImageSizesRow = $("#adaptive-image-sizes-row")
        if (adaptiveImageCheckbox.is(":checked")) {
            adaptiveImageSizesRow.show();
        } else {
            adaptiveImageSizesRow.hide();
        }
        adaptiveImageCheckbox.on("change", function()
        {
            if (adaptiveImageCheckbox.is(":checked")) {
                adaptiveImageSizesRow.show();
            } else {
                adaptiveImageSizesRow.hide();
            }
        });
        $(".zoo-theme-settings .nav-item").on("click", function(e)
        {
            e.preventDefault();

            var items, tabs, activeItem, activeTab;

            activeItem = $(this);
            items = $(".zoo-theme-settings .nav-item");
            tabs = $(".zoo-theme-settings .tab-table");
            activeTab = $(activeItem.attr("href"));

            items.removeClass("active-item");
            activeItem.addClass("active-item");
            tabs.hide();
            tabs.removeClass("active-tab");
            activeTab.addClass("active-tab");
            activeTab.show();
        });
    }
})(jQuery, window, wp)
