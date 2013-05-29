var SnowcapBootstrap = (function() {
    /**
     * Modal class
     *
     */
    var Modal = Backbone.View.extend({
        tagName: 'div',
        className: 'modal hide fade',
        events: function() {
            return {
                'hidden': function() {
                    this.$el.empty();
                }
            };
        },
        initialize: function() {
            if(this.options.modalClass) {
                this.$el.addClass(this.options.modalClass);
            }
            this.$el.modal({show: false});
            this.on('modal:post_render', _.bind(this.postRender, this));
            this.render();
        },
        render: function() {
            var doneCallback = _.bind(function(data) {
                this.$el.html(data.content);
                this.$el.find('.modal-body').css('maxHeight', $(window).height() * 0.6);
                $('body').append(this.$el);
                this.$el.modal('show');
                this.trigger('modal:post_render');
            }, this);
            $.get(this.options.url)
                .done(doneCallback);
        },
        postRender: function() {
            this.$('*[data-prototype]').collectionForm(); //TODO: adapt when core use backbone too
        },
        close: function() {
            this.$el.modal('hide');
            this.remove();
        }
    });

    return {
        'Modal': Modal
    }
})();

(function($) {
    /**
     * Observe datalist triggers and create datalist
     * instances on click
     *
     */
    $('[data-bootstrap=modal]').each(function(offset, modalTrigger) {
        var $modalTrigger = $(modalTrigger);
        $($modalTrigger).on('click', function(event) {
            event.preventDefault();
            var options = {
                url: $modalTrigger.attr('href')
            };
            if($modalTrigger.data('options-modal-class')) {
                options.modalClass = $modalTrigger.data('options-modal-class');
            }
            new SnowcapBootstrap.Modal(options);
        });
    });
})(jQuery);