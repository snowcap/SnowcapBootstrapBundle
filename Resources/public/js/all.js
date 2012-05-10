jQuery(document).ready(function ($) {
    // Modal
    $('#modal').modal({show:false}); //TODO: create modals on demand
    $('#modal').on('hidden', function (event) {
        $(this).empty();
    });

    // Confirm actions
    $('*[data-confirm="confirm"]').on('click', function(event) {
        event.preventDefault();
        var href = $(this).attr('href');
        var confirmButton = $('<a>').addClass('btn btn-large btn-primary').html($(this).data('confirm_confirm'));
        confirmButton.on('click', function(event) {
            event.preventDefault();
            window.location.href = href;
        })
        var modal = $('#modal');
        var modalHeader = $('<div>').addClass('modal-header')
            .append($('<a>').addClass('close').attr('data-dismiss', 'modal').html('x'))
            .append($('<h3>').html($(this).data('confirm_title')));
        var modalBody = $('<div>').addClass('modal-header')
            .append($('<p>').html($(this).data('confirm_body')));
        var modalFooter = $('<div>').addClass('modal-footer')
            .append($('<a>').addClass('btn btn-large').attr('data-dismiss', 'modal').html($(this).data('confirm_cancel')))
            .append(confirmButton);
        modal.append(modalHeader).append(modalBody).append(modalFooter);

        modal.modal('show');
    });
});
