@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Danh sách bàn</h3>
    <?php
        $table_status_val = array(
            'empty' => 'Trống',
            'full' => 'Đã ra món',
            'close' => 'Đóng',
            'waiting' => 'Đang chờ món',
            'adding' => 'Thêm món'
        );
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
    <div class="row">
        @foreach($all_table as $table)
            <div class="order-table-item col-6 col-md-4 col-lg-3 col-xl-2 min-w-200 mt-3 mb-3">
                <div class="card">
                    <img src="public/uploads/table/table-default.png" class="card-img-top" width="150" height="150">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $table->table_name }}</h5>
                        <div class="btn-group w-100">
                            <a href="{{ URL::to('edit-table/'.$table->table_id) }}" class="btn btn-primary">Sửa</a>
                            <a href="{{ URL::to('remove-table/'.$table->table_id) }}" class="btn btn-danger">Xoá</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection