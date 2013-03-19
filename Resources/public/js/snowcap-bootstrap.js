(function($) {
    /**
     * Modal class
     *
     */
    var Modal = Backbone.View.extend({
        tagName: 'div',
        className: 'modal hide fade',
        events: {
            'click button[data-admin=modal-cancel]': function(event) {
                this.$el.modal('hide');
            },
            'hidden': function() {
                this.$el.empty();
            }
        },
        initialize: function() {
            this.$trigger = $(this.options.trigger);
            this.$el.modal({show: false});
            this.render();
        },
        render: function() {
            var doneCallback = _.bind(function(data) {
                this.$el.html(data);
                $('body').append(this.$el);
                this.$el.modal('show');
            }, this);
            $.get(this.$trigger.attr('href'))
                .done(doneCallback);
        }
    });

    /**
     * Observe datalist triggers and create datalist
     * instances on click
     *
     */
    $('[data-bootstrap=modal]').each(function(offset, modalTrigger) {
        $(modalTrigger).on('click', function(event) {
            event.preventDefault();
            new Modal({'trigger': modalTrigger});
        });
    });
})(jQuery);