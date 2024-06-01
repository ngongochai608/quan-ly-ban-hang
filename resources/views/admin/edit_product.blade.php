@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Cập nhập món ăn</h3>
    <form method="post" action="{{ URL::to('update-product/'.$product_edit->product_id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="name-food">Tên món</label>
            <input autocomplete="off" type="text" name="name_product" value="{{ $product_edit->product_name }}" class="form-control" id="name-food" required>
        </div>
        <div class="form-group mb-3">
            <label for="image-food">Hình món</label>
            <input type="file" name="image_product" class="form-control" id="image-food">
        </div>
        <div class="form-group mb-3">
            <label for="price-food">Giá món</label>
            <input type="number" name="price_product" class="form-control" id="price-food" value="{{ $product_edit->product_price }}" placeholder="0.00" step="any" required>
        </div>
        <div class="form-group mb-3">
            <label for="category-food">Danh mục món</label>
            <select id="category-food" name="product_category_id" class="form-select mb-3" aria-label="Default select example" required>
                <option>Chọn danh mục sản phẩm</option>
                @foreach($all_categorys as $category)
                    @if ($product_edit->product_category_id == $category->category_id)
                        <option value="{{ $category->category_id }}" selected>{{ $category->category_name }}</option>
                    @else
                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhập món</button>
    </form>
</div>
@endsection