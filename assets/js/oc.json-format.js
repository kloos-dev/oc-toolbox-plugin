+function ($) { "use strict";
    var Base = $.oc.foundation.base,
        BaseProto = Base.prototype

    var JsonFormatControl = function (element, options) {
        this.$el = $(element)
        this.options = options || {}

        $.oc.foundation.controlUtils.markDisposable(element)
        Base.call(this)
        this.init()
    }

    JsonFormatControl.prototype = Object.create(BaseProto)
    JsonFormatControl.prototype.constructor = JsonFormatControl

    JsonFormatControl.prototype.init = function() {
        this.json = this.$el.html();
        this.$el.jJsonViewer(this.json);
        this.$el.show();
    }

    JsonFormatControl.prototype.dispose = function() {


        this.$el = null

        // In some cases options could contain callbacks,
        // so it's better to clean them up too.
        this.options = null

        BaseProto.dispose.call(this)
    }

    JsonFormatControl.DEFAULTS = {
        someParam: null
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.jsonFormatControl

    $.fn.jsonFormatControl = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), items, result

        items = this.each(function () {
            var $this   = $(this)
            var data    = $this.data('oc.jsonFormatControl')
            var options = $.extend({}, JsonFormatControl.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.jsonFormatControl', (data = new JsonFormatControl(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : items
    }

    $.fn.jsonFormatControl.Constructor = JsonFormatControl

    $.fn.jsonFormatControl.noConflict = function () {
        $.fn.jsonFormatControl = old
        return this
    }

    // Add this only if required
    $(document).render(function (){
        $('[data-control="json"]').jsonFormatControl()
    })

}(window.jQuery);
