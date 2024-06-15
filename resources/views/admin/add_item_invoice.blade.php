@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <form action="{{ URL::to('update-invoice/'.$invoice_id) }}" method="post">
        {{ csrf_field() }}
        <h3>Chọn món ăn</h3>
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
        <ul id="tabs-order" class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" type="button" role="tab" data-controls="all">Tất cả</button>
            </li>
            @foreach ($all_category as $category)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" type="button" role="tab" data-controls="{{ $category->category_id }}">{{ $category->category_name }}</button>
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
                    <div class="qlbh-template-grid-food-item col-6 col-md-4 col-lg-3 col-xl-2 min-w-200" data-controls="{{ $product->product_category_id }}">
                        <div class="card">
                            <img src="../public/uploads/products/{{ $img_name }}" class="card-img-top {{ $class_img }}" width="150" height="150">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <p class="card-text">{{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                                <div class="input-group number-input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary button-decrement" type="button">-</button>
                                    </div>
                                    @if (isset($invoice_info_full[$product->product_id]))
                                        <input type="number" name="qty_product-{{ $product->product_id }}" class="form-control input-number ms-2 me-2 rounded-2 text-center" value="{{ $invoice_info_full[$product->product_id]->qty }}" min="0" max="100">
                                    @else
                                        <input type="number" name="qty_product-{{ $product->product_id }}" class="form-control input-number ms-2 me-2 rounded-2 text-center" value="0" min="0" max="100">
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
    </form>
</div>
@endsection