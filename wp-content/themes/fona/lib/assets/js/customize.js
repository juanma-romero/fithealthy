// Customizer Reset

;(function(window, $)
{
    "use strict";

    /**
     * ZooCustomizer
     */
    function ZooCustomize()
    {
        // Handle import event
        this.import = function(e)
        {
            e.preventDefault();

            var btn = $(this);

            btn.prop("disabled", true);

            if (!$("#zoo-customize-import-file").val()) {
                return;
            }

            var body	 = $('body'),
				form	 = $('<form method="POST" enctype="multipart/form-data"></form>'),
				controls = $('#zoo-customizer-import-controls');


            var r = confirm(ZooCustomizeSettings.confirmImport);

            if (!r) {
                btn.prop("disabled", false);
                return;
            } else {
                $(window).off('beforeunload');
    			body.append(form);
    			form.append(controls);
    			form.submit();
            }
        }

        // Handle export event
        this.export = function(e)
        {
            window.location.href = ZooCustomizeSettings.url + '?zoo-customize-export=' + ZooCustomizeSettings.nonce;
        }

        // Handle reset
        this.reset = function(e)
        {
            e.preventDefault();

            var btn = $(this);

            btn.prop("disabled", true);

            var data = {
                wp_customize: "on",
                action: "customize_reset",
                nonce: ZooCustomizeSettings.nonce
            };

            var r = confirm(ZooCustomizeSettings.confirmReset);

            if (!r) {
                btn.prop("disabled", false);
                return;
            } else {
                var settings = {
                    url: ajaxurl,
                    method: "POST",
                    data: data
                };

                $.ajax(settings).done(function(r)
                {
                    btn.prop("disabled", false);

                    wp.customize.state("saved").set(true);

                    window.location.reload();;
                }).fail(function(r)
                {
                    console.log(r.message);

                    btn.prop("disabled", false);
                });
            }
        }

        // Bind events
        this.init = function()
        {
            var importBtn = $("#zoo-customize-import-btn"),
                exportBtn = $("#zoo-customize-export-btn"),
                resetBtn  = $("#zoo-customize-reset-btn");

            if (importBtn) {
                importBtn.on("click", window.ZooCustomize.import);
            }

            if (exportBtn) {
                exportBtn.on("click", window.ZooCustomize.export);
            }

            if (resetBtn) {
                resetBtn.on("click", window.ZooCustomize.reset);
            }
        }
    }

    // Init
    $(window.document).ready(function()
    {
        window.ZooCustomize = new ZooCustomize();
        window.ZooCustomize.init();
    });

})(window, jQuery);
