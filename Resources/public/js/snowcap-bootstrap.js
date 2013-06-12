var SnowcapBootstrap = (function() {
    /**
     * Modal view
     *
     */
    var Modal = Backbone.View.extend({
        tagName: 'div',
        className: 'modal hide fade',
        events: function() {
            return {
                'submit form': 'submit',
                'click a': 'clickLink',
                'click [data-bootstrap=modal-confirm]': 'confirm',
                'hidden': function() {
                    this.$el.empty();
                }
            };
        },
        /**
         * Initialize
         *
         */
        initialize: function() {
            if(this.options.modalClass) {
                this.$el.addClass(this.options.modalClass);
            }

            var modalOptions = {show: false};
            if('undefined' !== typeof this.options.backdrop) {
                modalOptions.backdrop = this.options.backdrop;
            }
            this.$el.modal(modalOptions);
            this.on('ui:modal:render', SnowcapCore.Form.collectionFactory);

            this.render();
        },
        /**
         * Called when a confirm button (data-bootstrap=modal-confirm) is clicked
         *
         * @param event
         */
        confirm: function(event) {
            event.preventDefault();
            this.close();
            this.trigger('modal:confirm');
        },
        /**
         * Called when a modal within the form is submitted
         *
         * @param event
         */
        submit: function(event) {
            event.preventDefault();
            var $form = this.$el.find('form');
            $.post($form.attr('action'), $form.serialize(), null, "json")
                .done(_.bind(this.done, this))
                .fail(_.bind(this.fail, this));
        },
        /**
         * Called on submit success
         *
         * @param data
         */
        done: function(data) {
            this.trigger('ui:modal:success', data);
            this.$el.trigger('ui:modal:success', data);
            this.close();
        },
        /**
         * Called on submit "failure" (30x, 40x, 50x)
         *
         * @param jqXHR
         * @param textStatus
         */
        fail: function(jqXHR, textStatus) {
            switch(jqXHR.status) {
                case 301: // REDIRECTION
                    var response = JSON.parse(jqXHR.responseText);
                    window.location.href = response.redirect_url;
                    break;
                case 400:
                    var response = JSON.parse(jqXHR.responseText);
                    this.renderBody(response.content);
                    this.trigger('ui:modal:render');
                    break;
                default:
                    console.log(jqXHR);
                    console.log(textStatus);
                    break;
            }
        },
        /**
         * Update modal content with response provided by a link
         *
         * @param event
         */
        clickLink: function(event) {
            event.preventDefault();
            var $link = $(event.currentTarget);
            $.getJSON($link.attr('href'))
                .done(_.bind(function(data) {
                    this.$el.html(data.content);
                }, this));
        },
        /**
         * Close the modal
         *
         */
        close: function() {
            this.$el.modal('hide');
            this.remove();
        },
        /**
         * Render
         *
         */
        render: function() {
            $.get(this.options.url)
                .done(_.bind(function(data) {
                    this.renderBody(data.content);
                    $('body').append(this.$el);
                    this.$el.modal('show');
                    this.trigger('ui:modal:render');
                }, this));
        },
        /**
         * Render the body
         *
         * @param content
         */
        renderBody: function(content) {
            this.$el.html(content);
            this.$el.find('.modal-body').css('maxHeight', $(window).height() * 0.6);
        }
    });

    /**
     * Modal factory function
     *
     * @param $context
     */
    var modalFactory = function() {
        var $context = (0 === arguments.length) ? $('body') : arguments[0];
        $context.on('click', '[data-bootstrap=modal]', function(event) {
            event.preventDefault();
            var $modalTrigger = $(event.currentTarget);
            var options = {
                url: $modalTrigger.attr('href')
            };
            if($modalTrigger.data('options-modal-class')) {
                options.modalClass = $modalTrigger.data('options-modal-class');
            }
            options.backdrop = $modalTrigger.data('options-modal-backdrop');
            new SnowcapBootstrap.Modal(options);
        });
    };

    return {
        Modal: Modal,
        modalFactory: modalFactory
    }
})();

(function($) {

    SnowcapBootstrap.modalFactory();

})(jQuery);