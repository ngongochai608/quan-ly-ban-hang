jQuery(document).ready(function ($) {
    // tabs order
    $('#tabs-order .nav-link').click(function () {
        $('#tabs-order .nav-link').removeClass('active');
        $(this).addClass('active');
        console.log($(this).data('controls'));
        if ($(this).data('controls') == 'all') {
            $('#tabs-content-order .qlbh-template-grid-food-item').css('display', 'block');
        } else {
            $('#tabs-content-order .qlbh-template-grid-food-item').css('display', 'none');
            $(`#tabs-content-order .qlbh-template-grid-food-item[data-controls="${$(this).data('controls')}"]`).css('display', 'block');
        }
    });
});