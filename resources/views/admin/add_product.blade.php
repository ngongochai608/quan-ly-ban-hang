@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Thêm món ăn</h3>
    <form method="post" action="{{ URL::to('save-product') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="name-food">Tên món</label>
            <input autocomplete="off" type="text" name="name_product" class="form-control" id="name-food" required>
        </div>
        <div class="form-group mb-3">
            <label for="image-food">Hình món</label>
            <input type="file" name="image_product" class="form-control" id="image-food">
        </div>
        <div class="form-group mb-3">
            <label for="price-food">Giá món</label>
            <input type="number" name="price_product" class="form-control" id="price-food" placeholder="0.00" step="0.01" required>
        </div>
        <div class="form-group mb-3">
            <label for="category-food">Danh mục món</label>
            <select id="category-food" name="product_category_id" class="form-select mb-3" aria-label="Default select example" required>
                <option selected>Chọn danh mục sản phẩm</option>
                @foreach($all_categorys as $category)
                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm món</button>
    </form>
</div>
@endsection