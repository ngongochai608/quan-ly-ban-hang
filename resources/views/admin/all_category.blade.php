@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-3">
    <h3>Danh sách danh mục</h3>
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
    <div class="qlbh-template-grid-food">
        <table class="table table-bordered table-invoice">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên danh mục</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                @foreach($all_category as $category)
                    <tr>
                        <th>{{ $count; }}</th>
                        <td><h5>{{ $category->category_name }}</h5></td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ URL::to('edit-category/'.$category->category_id) }}" class="btn btn-primary">Sửa</a>
                                <a href="{{ URL::to('remove-category/'.$category->category_id) }}" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#popupconfirm">Xoá</a>
                            </div>
                        </td>
                    </tr>
                    <?php $count++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection