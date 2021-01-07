+function ($) { "use strict";
    var AjaxPanelControl = function (element, options) {
        this.$el = $(element)
        this.options = options || {}
        this.init()
    }

    AjaxPanelControl.prototype.constructor = AjaxPanelControl

    AjaxPanelControl.prototype.init = function() {
        // Place init code here
        this.setupLoadingIndicator();
        this.setupContentWrapper();
        this.startListeners();
        this.setupResizable();
    }

    AjaxPanelControl.prototype.setupResizable = function () {
        $('[data-panel-type="ajax"]').resizable({
            handles: 'w',
            autoHide: true,
            minWidth: 400,
        }).on('resize', function (event, ui) {
            $('[data-panel-type="ajax"]').css({
                right: 0,
                top: 0,
                left: 'auto',
                width: ui.size.width + 30
            });
        });
    }

    AjaxPanelControl.prototype.startListeners = function () {
        let self = this;

        $(document).on('click', function (e) {
            if ($(e.target).hasClass('panel-trigger')) {
                return;
            }

            if (!$(e.target).parents("[data-panel-type]").length && self.$el.is(':visible') && !e.target.hasAttribute('data-panel-type')) {
                self.close();
            }
        });

        this.$el.on('open-panel', function (e, params) {
            setTimeout(function () {
                self.open();

                $.request(self.options.panelHandler, {
                    data: params,
                }).then(function (res) {
                    self.$el.find('.panel-content').html(res.result);
                    self.$el.find('.loading-indicator').hide();
                    self.$el.find('.panel-content').show();
                });
            }, 500);
        });
    }

    AjaxPanelControl.prototype.open = function () {
        this.$el.show();
    }

    AjaxPanelControl.prototype.close = function () {
        this.$el.find('.panel-content').html('').hide();
        this.$el.find('.loading-indicator').show();
        this.$el.hide();
    }

    AjaxPanelControl.prototype.setupLoadingIndicator = function () {
        this.$el.append('<span class="loading-indicator"><i class="fas fa-spinner fa-spin loading-indicator"></i></span>');
    }

    AjaxPanelControl.prototype.startLoading = function () {}

    AjaxPanelControl.prototype.setupContentWrapper = function () {
        this.$el.append('<div class="panel-content"></div>');
    }

    AjaxPanelControl.DEFAULTS = {
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.ajaxPanelControl

    $.fn.ajaxPanelControl = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), items, result

        items = this.each(function () {
            var $this   = $(this)
            var data    = $this.data('oc.ajaxPanelControl')
            var options = $.extend({}, AjaxPanelControl.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.ajaxPanelControl', (data = new AjaxPanelControl(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : items
    }

    $.fn.ajaxPanelControl.Constructor = AjaxPanelControl

    $.fn.ajaxPanelControl.noConflict = function () {
        $.fn.ajaxPanelControl = old
        return this
    }

    // Add this only if required
    $(document).render(function (){
        $('[data-panel-type="ajax"]').ajaxPanelControl()
    })

}(window.jQuery);