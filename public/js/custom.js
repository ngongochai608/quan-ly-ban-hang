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

    // preview order food
    function previewOrderFood () {
        const foodItem = $('.qty-food-order');
        const previewWrap = $('#preview-food-order');
        const previewContent = $('#preview-food-order-content');
        const btnDone = $('#preview-food-order button[type="submit"]');
        const foodItemSelected = [];
        foodItem.each(function (index) {
            const value = $(this).val();
            if (value > 0) {
                foodItemSelected.push($(this));
            }
        });
        let html = '';
        foodItemSelected.forEach(element => {
            const qty = element.val();
            const name = element.data('name');
            const price = element.data('price');
            html = `${html}<div class="preview-food-order-item">
                <h6>${name} x ${qty}<br/><span>${price}</span></h6>
            </div>`;
        });
        if (html != '') {
            if ($(window).width() > 767) {
                previewWrap.css('display', 'block');
            }
            btnDone.css('display', 'block');
        } else {
            btnDone.css('display', 'none');
        }
        previewContent.html(html);
    }
    $('.order-food-wrap-tab-mobile .food-order').click(function () {
        $(this).removeClass('btn-secondary');
        $(this).addClass('btn-primary');
        $('.order-food-wrap-tab-mobile .food-order-selected').addClass('btn-secondary');
        $('.order-food-wrap-tab-mobile .food-order-selected').removeClass('btn-primary');
        $('#food-order').css('display', 'block');
        $('#preview-food-order').css('display', 'none');
    });
    $('.order-food-wrap-tab-mobile .food-order-selected').click(function () {
        $(this).removeClass('btn-secondary');
        $(this).addClass('btn-primary');
        $('.order-food-wrap-tab-mobile .food-order').addClass('btn-secondary');
        $('.order-food-wrap-tab-mobile .food-order').removeClass('btn-primary');
        $('#food-order').css('display', 'none');
        $('#preview-food-order').css('display', 'block');
    });
    $('.button-increment').click(function() {
        setTimeout(function () {
            previewOrderFood();
        }, 50);
    });
    $('.button-decrement').click(function() {
        setTimeout(function () {
            previewOrderFood();
        }, 50);
    });
});