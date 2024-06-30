@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-3">
    <h3>Tất cả món ăn</h3>
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
    <div class="d-flex justify-content-between gap-3">
        <div class="flex-grow-1" id="food-order">
            <div class="input-group order-food-search-wrap">
                <input id="order-food-search" type="text" class="form-control" placeholder="Tìm món..." />
                <div id="order-food-search-clear" style="display: none;"><i class="fa-solid fa-circle-xmark text-danger"></i></div>
            </div>
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
                                <img src="{{ asset('public/uploads/products/'.$img_name) }}" class="card-img-top {{ $class_img }}" width="150" height="150">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->product_name }}</h5>
                                    <p class="card-text price">{{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                                    <div class="btn-group mt-auto" role="group" aria-label="Basic example">
                                        <a href="{{ URL::to('edit-product/'.$product->product_id) }}" class="btn btn-primary">Sửa</a>
                                        <a href="{{ URL::to('remove-product/'.$product->product_id) }}" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#popupconfirm">Xóa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection