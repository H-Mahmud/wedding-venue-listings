jQuery(document).ready(function ($) {

    $('[data-component-type="wlval-modal-trigger"]').on('click', function () {
        var targetModal = $(this).data('target-modal');
        $(targetModal).addClass('flex');
        $(targetModal).removeClass('hidden');
    });

    // Close modal when close button is clicked
    $('[data-component-type="wvl-modal"] .close-btn').click(function () {
        var modal = $(this).closest('[data-component-type="wvl-modal"]');
        modal.addClass('hidden');
        modal.removeClass('flex');
    });

    // Close modal when clicking outside the modal content area
    $(window).click(function (event) {
        if ($(event.target).is('[data-component-type="wvl-modal"] .modal-content') || $(event.target).is('[data-component-type="wvl-modal"]')) {
            $('[data-component-type="wvl-modal"]').each(function () {
                $(this).addClass('hidden');
                $(this).removeClass('flex');
            });
        }
    });

});
