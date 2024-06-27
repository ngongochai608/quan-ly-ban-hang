@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-3">
    <h3>Đặt bàn</h3>
    <?php
        $table_status_val = array(
            'empty' => 'Trống',
            'active' => 'Đang sử dung',
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

        $color_table_status = '';

    ?>
    <div class="row">
        @foreach($all_table as $table)
            <?php
                if ($table->table_status == 'empty') {
                    $color_table_status = 'text-success';
                }
                if ($table->table_status == 'active') {
                    $color_table_status = 'text-warning';
                }

                if ($table->table_status == 'empty') {
                    $table_target = 'order-food/'.$table->table_id;
                }
                if ($table->table_status == 'active') {
                    $table_target = 'view-invoice/'.$table->table_invoice_id;
                }
            ?>
            <div class="order-table-item col-6 col-md-4 col-lg-3 col-xl-2 min-w-200 mt-3">
                <a href="{{ URL::to($table_target) }}">
                    <div class="card">
                        <img src="public/uploads/table/table-default.png" class="card-img-top" width="150" height="150">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $table->table_name }}</h5>
                            <p class="card-text {{ $color_table_status }}">{{ $table_status_val[$table->table_status] }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection