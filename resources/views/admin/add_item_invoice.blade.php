@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-3">
    <h3>Đặt món</h3>
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
    <div class="order-food-wrap-tab-mobile btn-group">
        <button class="btn btn-primary food-order">Món ăn</button>
        <button class="btn btn-secondary food-order-selected">Món đã chọn</button>
    </div>
    <form action="{{ URL::to('update-invoice/'.$invoice_id) }}" method="post">
        <div class="d-flex justify-content-between gap-3">
            <div class="flex-grow-1" id="food-order">
                {{ csrf_field() }}
                <div class="input-group order-food-search-wrap">
                    <input id="order-food-search" type="text" class="form-control" placeholder="Tìm món..." />
                    <div id="order-food-search-clear" style="display: none;"><i class="fa-solid fa-circle-xmark text-danger"></i></div>
                </div>
                <input type="hidden" name="table_id" value="{{ $table_id }}" />
                <ul id="tabs-order" class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" type="button" role="tab" data-category-id="all">Tất cả</button>
                    </li>
                    @foreach ($all_category as $category)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" type="button" role="tab" data-category-id="{{ $category->category_id }}">{{ $category->category_name }}</button>
                        </li>
                    @endforeach
                </ul>
                <div id="tabs-content-order" class="tab-content">
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
                            <div class="qlbh-template-grid-food-item col-6 col-md-4 col-lg-3 col-xl-2 min-w-200" data-category-id="{{ $product->product_category_id }}" data-name-food="{{ $product->product_name }}">
                                <div class="card">
                                    <img src="../public/uploads/products/{{ $img_name }}" class="card-img-top {{ $class_img }}" width="150" height="150">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->product_name }}</h5>
                                        <p class="card-text price">{{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                                        <div class="input-group number-input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary button-decrement" type="button">-</button>
                                            </div>
                                            @if (isset($invoice_info_full[$product->product_id]))
                                                <input type="number" name="qty_product-{{ $product->product_id }}" data-name="{{ $product->product_name }}" data-price="{{ number_format($product->product_price, 0, ',', '.') }}đ" class="qty-food-order form-control input-number ms-2 me-2 rounded-2 text-center" value="{{ $invoice_info_full[$product->product_id]->qty }}" min="0" max="100">
                                            @else
                                                <input type="number" name="qty_product-{{ $product->product_id }}" data-name="{{ $product->product_name }}" data-price="{{ number_format($product->product_price, 0, ',', '.') }}đ" class="qty-food-order form-control input-number ms-2 me-2 rounded-2 text-center" value="0" min="0" max="100">
                                            @endif
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
            </div>
            <div id="preview-food-order" style="display: none;">
                <h5 class="preview-food-order-label">Món ăn đã chọn</h5>
                <div class="preview-food-order-wrap">
                    <div id="preview-food-order-content"></div>
                    <button type="submit" class="btn btn-success w-100" style="display: none;">Xong</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection