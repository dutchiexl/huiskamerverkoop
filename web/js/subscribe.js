jQuery(document).ready(function ($) {
    $('input[name="subscribe_form[day]"]').on('change', function () {
        var selectedDay = $(this).val();
        $('.hour-wrapper').addClass('hidden');
        var $daySelect = $('.hour-wrapper[data-day-id="' + selectedDay + '"]');
        $daySelect.removeClass('hidden');
        console.log($daySelect);
    });
});
