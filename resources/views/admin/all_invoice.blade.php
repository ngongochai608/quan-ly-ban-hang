@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Danh sách hoá đơn</h3>
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
                    <th scope="col">Tên hoá đơn</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                @foreach($all_invoice as $invoice)
                    <tr>
                        <th>{{ $stt; }}</th>
                        <td><h5>{{ $invoice->invoice_name }}</h5></td>
                        <td>{{ number_format($invoice->invoice_total_price, 0, ',', '.') }}đ</td>
                        <td>
                            <a href="{{ URL::to('edit-invoice/'.$invoice->invoice_id) }}" class="btn btn-primary">Sửa</a>
                            <a href="{{ URL::to('remove-invoice/'.$invoice->invoice_id) }}" class="btn btn-danger">Xoá</a>
                        </td>
                    </tr>
                    <?php $stt++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection