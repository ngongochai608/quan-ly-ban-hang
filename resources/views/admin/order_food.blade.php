@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Chọn món ăn</h3>
    <div class="d-flex justify-content-between gap-3">
        <form action="{{ URL::to('create-invoice') }}" method="post" class="flex-grow-1">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-success">Xong</button>
            <?php
                $message = Session::get('message');
                if ($message) {
                    ?>
                    <div class="toast align-items-center text-bg-success border-0 show mt-4 mb-4" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ $message }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <?php
                    Session::put('message', null);
                }
            ?>
            <input type="hidden" name="table_id" value="{{ $table_id }}" />
            <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#tab-all" type="button" role="tab" aria-controls="all" aria-selected="true">Tất cả</button>
                </li>
                @foreach ($all_category as $category)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="{{ $category->category_id }}-tab" data-bs-toggle="pill" data-bs-target="#tab-{{ $category->category_id }}" type="button" role="tab" aria-controls="{{ $category->category_id }}" aria-selected="false">{{ $category->category_name }}</button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="tab-all" role="tabpanel" aria-labelledby="all-tab">
                    <div class="qlbh-template-grid-food row">
                        @foreach ($all_product as $product)
                            <?php
                                $class_img = '';
                                $img_name = $product->product_image;
                                if (empty($img_name)) {
                                    $img_name = 'img-food-default.png';
                                    $class_img = 'default';
                                }
                            ?>
                            <div class="qlbh-template-grid-food-item col-6 col-md-4 col-lg-3 col-xl-2 min-w-200">
                                <div class="card">
                                    <img src="../public/uploads/products/{{ $img_name }}" class="card-img-top {{ $class_img }}" width="150" height="150">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->product_name }}</h5>
                                        <p class="card-text price">{{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                                        <div class="input-group number-input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary button-decrement" type="button">-</button>
                                            </div>
                                            <input type="number" name="qty_product-{{ $product->product_id }}" data-name="{{ $product->product_name }}" data-price="{{ number_format($product->product_price, 0, ',', '.') }}đ" class="qty-food-order form-control input-number ms-2 me-2 rounded-2 text-center" value="0" min="0" max="100">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary button-increment" type="button">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @foreach($all_products_with_category as $key => $products)
                    <div class="tab-pane" id="tab-{{ $key }}" role="tabpanel" aria-labelledby="{{ $key }}-tab">
                        <div class="qlbh-template-grid-food row">
                            @foreach($products as $product)
                                <?php
                                    $class_img = '';
                                    $img_name = $product->product_image;
                                    if (empty($img_name)) {
                                        $img_name = 'img-food-default.png';
                                        $class_img = 'default';
                                    }
                                ?>
                                <div class="qlbh-template-grid-food-item col-6 col-md-4 col-lg-3 col-xl-2 min-w-200">
                                    <div class="card">
                                        <img src="../public/uploads/products/{{ $img_name }}" class="card-img-top {{ $class_img }}" width="150" height="150">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->product_name }}</h5>
                                            <p class="card-text">{{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                                            <div class="input-group number-input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary button-decrement" type="button">-</button>
                                                </div>
                                                <input type="number" name="qty_product-{{ $product->product_id }}" data-name="{{ $product->product_name }}" data-price="{{ number_format($product->product_price, 0, ',', '.') }}đ" class="qty-food-order form-control input-number ms-2 me-2 rounded-2 text-center" value="0" min="0" max="100">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary button-increment" type="button">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
        <div id="preview-food-order"></div>
    </div>
</div>
<script>
    function previewOrderFood () {
        const foodItem = document.querySelectorAll('.qty-food-order');
        const seenfoodItems = {};
        const uniquefoodItems = [];
        foodItem.forEach(element => {
            const name = element.getAttribute('name');
            if (!seenfoodItems[name]) {
                uniquefoodItems.push(element);
                seenfoodItems[name] = true;
            }
        });
        const foodItemSelected = [];
        uniquefoodItems.forEach(element => {
            const value = element.value;
            if (value > 0) {
                foodItemSelected.push(element);
            }
        });
        let html = '';
        foodItemSelected.forEach(element => {
            const qty = element.value;
            const name = element.dataset.name;
            const price = element.dataset.price;
            html = `${html}<div class="preview-food-order-item">
                <h6>${name} x ${qty}<br/><span>${price}</span></h6>
            </div>`;
        });
        document.getElementById('preview-food-order').innerHTML = html;
    }
    document.querySelectorAll('.button-increment').forEach(function(button) {
        button.addEventListener('click', function() {
            setTimeout(function () {
                previewOrderFood();
            }, 50);
        });
    });
    document.querySelectorAll('.button-decrement').forEach(function(button) {
        button.addEventListener('click', function() {
            setTimeout(function () {
                previewOrderFood();
            }, 50);
        });
    });
</script>
@endsection