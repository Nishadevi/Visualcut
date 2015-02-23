;(function ($) {
    $.fn.filestyle = function (options) {
        var settings = {
            width: 250
        };
        if (options) {
            $.extend(settings, options)
        };
        return this.each(function () {
            var self = this;
            if ($(self).css('opacity') != 0) {
                var wrapper = $('<div class="select-file">');
                var filename = $('<input class="file">').addClass($(self).attr("class")).css({
                    "display": "inline",
                    "width": settings.width + "px"
                });
                $(self).before(filename);
                $(self).wrap(wrapper);
                $(self).css({
                    "position": "relative",
                    "height": settings.imageheight + "px",
                    "width": settings.width + "px",
                    "display": "inline",
                    "cursor": "pointer",
                    "opacity": "0.0"
                });
                if ($.browser.mozilla) {
                    if (/Win/.test(navigator.platform)) {
                        $(self).css("margin-left", "-142px")
                    } else {
                        $(self).css("margin-left", "-168px")
                    }
                } else {
                    $(self).css("margin-left", settings.imagewidth - settings.width + "px")
                };
                $(self).bind("change", function () {
                    filename.val($(self).val())

                })
            }
        })
    }
})(jQuery);