@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Thêm danh mục</h3>
    <form method="post" action="{{ URL::to('save-category') }}">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="name-food">Tên danh mục</label>
            <input autocomplete="off" type="text" name="name_category" class="form-control" id="name-food" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm danh mục</button>
    </form>
</div>
@endsection