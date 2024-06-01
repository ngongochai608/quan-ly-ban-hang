@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Danh sách món ăn</h3>
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
    <div class="qlbh-template-grid-food row">
        @foreach($all_products as $product)
            <?php
                $class_img = '';
                $img_name = $product->product_image;
                if (empty($img_name)) {
                    $img_name = 'img-food-default.png';
                    $class_img = 'default';
                }
            ?>
            <div class="qlbh-template-grid-food-item col-6 col-md-4 col-lg-3 col-xl-2 min-w-200 mt-2 mb-2">
                <div class="card">
                    <img src="public/uploads/products/{{ $img_name }}" class="card-img-top {{ $class_img }}" width="150" height="150">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text">{{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                        <a href="{{ URL::to('edit-product/'.$product->product_id) }}" class="btn btn-primary">Sửa</a>
                        <a href="{{ URL::to('remove-product/'.$product->product_id) }}" class="btn btn-danger">Xoá</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection