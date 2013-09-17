jQuery(document).ready(function ($) {
    //TODO: cleanup - what follows below has been superseded by the snowcap-bootstrap.js file

    // Modal
    $('#modal').modal({show:false});
    $('#modal').on('hidden', function (event) {
        $(this).empty();
    });

    // Confirm actions
    $('[data-confirm=confirm]').on('click', function(event) {
        event.preventDefault();
        var href = $(this).attr('href');
        var confirmButton = $('<a>').addClass('btn btn-large btn-primary').html($(this).data('confirm_confirm'));
        confirmButton.on('click', function(event) {
            event.preventDefault();
            window.location.href = href;
        });
        var modal = $('<div>')
            .addClass('modal fade')
            .attr({
                'id': 'modal',
                'tabindex': '-1',
                'role': 'dialog',
                'aria-hidden': 'true'
            });
        var modalDialog = $('<div class="modal-dialog"></div>');
        var modalContent = $('<div class="modal-content"></div>');
        var modalHeader = $('<div>').addClass('modal-header')
            .append($('<button>').addClass('close').attr({
                'type': 'button',
                'data-dismiss': 'modal',
                'aria-hidden': 'true'
            }).html('&times;'))
            .append($('<h4>').html($(this).data('confirm_title')));
        var modalBody = $('<div>').addClass('modal-body')
            .append($('<p>').html($(this).data('confirm_body')));
        var modalFooter = $('<div>').addClass('modal-footer')
            .append($('<a>').addClass('btn btn-large btn-default').attr('data-dismiss', 'modal').html($(this).data('confirm_cancel')))
            .append(confirmButton);
        modalContent.append(modalHeader).append(modalBody).append(modalFooter);
        modalDialog.append(modalContent);
        modal.append(modalDialog);

        $('body').append(modal);

        modal.modal('show');
    });

    // Tooltips
    $("[rel=tooltip]").tooltip().css({'cursor':'pointer'});
});
