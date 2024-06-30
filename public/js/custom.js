jQuery(document).ready(function ($) {
    // button up and down quantity
    document.querySelectorAll('.button-increment').forEach(function(button) {
        button.addEventListener('click', function() {
            var inputName = this.closest('.number-input-group').querySelector('.input-number').getAttribute('name');
            var inputs = document.querySelectorAll(`.input-number[name="${inputName}"]`);
            inputs.forEach(input => {
                var currentValue = parseInt(input.value);
                var maxValue = parseInt(input.max);
                if (!isNaN(currentValue) && currentValue < maxValue) {
                    input.value = currentValue + 1;
                }
            });
        });
    });

    document.querySelectorAll('.button-decrement').forEach(function(button) {
        button.addEventListener('click', function() {
            var inputName = this.closest('.number-input-group').querySelector('.input-number').getAttribute('name');
            var inputs = document.querySelectorAll(`.input-number[name="${inputName}"]`);
            inputs.forEach(input => {
                var currentValue = parseInt(input.value);
                var minValue = parseInt(input.min);
                if (!isNaN(currentValue) && currentValue > minValue) {
                    input.value = currentValue - 1;
                }
            });
        });
    });

    // tabs order
    $('#tabs-order .nav-link').click(function () {
        $('#tabs-order .nav-link').removeClass('active');
        $(this).addClass('active');
        if ($(this).data('category-id') == 'all') {
            $('#tabs-content-order .qlbh-template-grid-food-item').css('display', 'block');
        } else {
            $('#tabs-content-order .qlbh-template-grid-food-item').css('display', 'none');
            $(`#tabs-content-order .qlbh-template-grid-food-item[data-category-id="${$(this).data('category-id')}"]`).css('display', 'block');
        }
    });

    // preview order food
    const previewOrderFood = function () {
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
    previewOrderFood();
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

    // Search Order Food
    const debounceSearch = function (func, delay) {
        let timer;
        return function() {
            clearTimeout(timer);
            timer = setTimeout(func, delay);
        };
    }

    const handleSearchOrderFood = function (keyword) {
        const btnClear = $('#order-food-search-clear');
        const itemFoods = $('.qlbh-template-grid-food-item');
        if (keyword != '') {
            btnClear.css('display', 'block');
            itemFoods.each(function () {
                const nameFood = $.trim($(this).data('name-food').toLowerCase());
                if (itemFoods == nameFood || nameFood.indexOf(keyword) !== -1) {
                    $(this).css('display', 'block');
                } else {
                    $(this).css('display', 'none');
                }
            });
        } else {
            btnClear.css('display', 'none');
            itemFoods.css('display', 'block');
        }
    }

    $('#order-food-search').keyup(debounceSearch(function() {
        const keyword = $.trim($('#order-food-search').val().toLowerCase());
        handleSearchOrderFood(keyword);
    }, 500));

    $('#order-food-search-clear').click(function () {
        $('#order-food-search').val('');
        $('#order-food-search').trigger('keyup');
    });

    // Popup confirm
    $('[data-bs-target="#popupconfirm"]').click(function () {
        const href = $(this).attr('href');
        $('#confirmDeleteBtn').data('link-confirm', href);
        $('#confirmDeleteBtn').click(function () {
            const linkConfirm = $(this).data('link-confirm');
            window.location.href = linkConfirm;
        });
    });
});