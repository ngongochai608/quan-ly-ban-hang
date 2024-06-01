@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
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
    <div class="qlbh-template-grid-food row">
        <?php
            $count = 1;
        ?>
        @foreach($all_category as $category)
            <ul class="list-group list-group-horizontal mb-2">
                <li class="list-group-item">{{ $count }}</li>
                <li class="list-group-item flex-grow-1">{{ $category->category_name }}</li>
                <li class="list-group-item">
                    <a href="{{ URL::to('edit-category/'.$category->category_id) }}" class="btn btn-primary">Sửa</a>
                    <a href="{{ URL::to('remove-category/'.$category->category_id) }}" class="btn btn-danger">Xoá</a>
                </li>
            </ul>
        @endforeach
    </div>
</div>
@endsection