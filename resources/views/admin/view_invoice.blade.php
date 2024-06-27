@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <?php
        $status_invoice = array(
            'unpaid' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán'
        );
    ?>
    <h5><span class="fw-light">Mã hoá đơn:</span> <span class="fw-normal">{{ $invoice->invoice_name }}</span></h5>
    <h6><span class="fw-light">Bàn:</span> <span class="fw-normal">{{ $table_invoice->table_name }}</span></h6>
    <h6><span class="fw-light">Trạng thái:</span> <span class="fw-normal">{{ $status_invoice[$invoice->invoice_status] }}</span></h6>
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
    <form action="{{ URL::to('update-invoice/'.$invoice->invoice_id) }}" method="post" class="mt-3">
        {{ csrf_field() }}
        <table class="table table-invoice">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                @foreach($invoice_info_full as $info_invoice)
                    <tr>
                        <th>{{ $stt; }}</th>
                        <td class="invoice-name-product">
                            <h5>{{ $info_invoice->product_name }}</h5>
                        </td>
                        <td style="width:220px;padding-right:40px;">
                            <div class="input-group number-input-group">
                                <div class="input-group-prepend">
                                    <a href="/invoice-change-qty-item/{{ $invoice->invoice_id }}/{{ $info_invoice->product_id }}/{{ ($info_invoice->qty - 1) }}" class="btn btn-outline-secondary button-decrement" type="button">-</a>
                                </div>
                                <input type="number" name="qty_product-{{ $info_invoice->product_id }}" class="form-control input-number ms-2 me-2 rounded-2 text-center" value="{{ $info_invoice->qty }}" min="1" max="100">
                                <div class="input-group-append">
                                    <a href="/invoice-change-qty-item/{{ $invoice->invoice_id }}/{{ $info_invoice->product_id }}/{{ ($info_invoice->qty + 1) }}" class="btn btn-outline-secondary button-increment" type="button">+</a>
                                </div>
                            </div>
                        </td>
                        <td class="invoice-price-product">{{ number_format(($info_invoice->product_price * $info_invoice->qty), 0, ',', '.') }}đ</td>
                        <td style="width:60px">
                            <a href="{{ URL::to('remove-item-invoice/'.$info_invoice->product_id.'/'.$invoice->invoice_id) }}" class="btn btn-danger">Xoá</a>
                        </td>
                    </tr>
                    <?php $stt++; ?>
                @endforeach
            </tbody>
        </table>
        <div class="input-group mb-3">
            <a href="{{ URL::to('invoice-add-food/'.$invoice->invoice_id) }}" class="btn btn-primary d-inline-block ml-auto">Thêm món</a>
        </div>
        <div class="input-group mb-3 max-width-400 ml-auto">
            <span class="input-group-text" id="invoice_discount_value">Giảm giá</span>
            @if (!empty($invoice->invoice_discount_value))
                <input type="number" value="{{ $invoice->invoice_discount_value }}" class="form-control" id="basic-url" name="invoice_discount_value" aria-describedby="invoice_discount_value">
            @else
                <input type="number" class="form-control" id="basic-url" name="invoice_discount_value" aria-describedby="invoice_discount_value">
            @endif
        </div>
        <div class="input-group mb-3 max-width-400 ml-auto">
            <label class="input-group-text" for="invoice_discount_type">Giảm theo</label>
            <select class="form-select" name="invoice_discount_type" id="invoice_discount_type">
                @if ($invoice->invoice_discount_type == 'money')
                    <option selected value="money">Tiền</option>
                    <option value="percent">Phần trăm</option>
                @elseif ($invoice->invoice_discount_type == 'percent')
                    <option value="money">Tiền</option>
                    <option selected value="percent">Phần trăm</option>
                @else
                    <option selected value="money">Tiền</option>
                    <option value="percent">Phần trăm</option>
                @endif
            </select>
        </div>
        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary text-end">Cập nhập</button>
            <a href="{{ URL::to('invoice-payment/'.$invoice->invoice_id) }}" class="btn btn-success text-end">Thanh Toán</a>
        </div>
        <div class="row">
            @if (!empty($invoice->invoice_discount_value))
                <h5 class="text-end">
                    @if ($invoice->invoice_discount_type == 'money')
                        Giảm: {{ number_format($invoice->invoice_discount_value, 0, ',', '.') }}đ
                    @else
                        Giảm: {{ $invoice->invoice_discount_value }}%
                    @endif
                </h5>
                <h5 class="text-end">
                    Giá gốc: {{ number_format($invoice->invoice_total_price_discount, 0, ',', '.') }}đ
                </h5>
            @endif
        </div>
        <div class="row">
            <h5 class="text-end">Thành tiền: {{ number_format($invoice->invoice_total_price, 0, ',', '.') }}đ</h5>
        </div>
    </form>
</div>
@endsection