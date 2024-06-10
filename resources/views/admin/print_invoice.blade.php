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
    <table class="table table-invoice">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $stt = 1; ?>
            @foreach($invoice_info_full as $info_invoice)
                <tr>
                    <th>{{ $stt; }}</th>
                    <td class="invoice-name-product">{{ $info_invoice->product_name }}</td>
                    <td style="width:220px;padding-right:40px;">{{ $info_invoice->qty }}</td>
                    <td class="invoice-price-product">{{ number_format($info_invoice->product_price, 0, ',', '.') }}đ</td>
                </tr>
                <?php $stt++; ?>
            @endforeach
        </tbody>
    </table>
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
</div>
<div class="container-fluid p-4">
    <button id="btn-invoice-print" class="btn btn-primary d-block ml-auto">In hoá đơn</button>
</div>
<div id="invoice-print-area" class="container-fluid p-4 d-none">
    <?php
        $status_invoice = array(
            'unpaid' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán'
        );
    ?>
    <h5><span class="fw-light">Mã hoá đơn:</span> <span class="fw-normal">{{ $invoice->invoice_name }}</span></h5>
    <h6><span class="fw-light">Bàn:</span> <span class="fw-normal">{{ $table_invoice->table_name }}</span></h6>
    <h6><span class="fw-light">Trạng thái:</span> <span class="fw-normal">{{ $status_invoice[$invoice->invoice_status] }}</span></h6>
    <table class="table table-bordered table-invoice">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $stt = 1; ?>
            @foreach($invoice_info_full as $info_invoice)
                <tr>
                    <th>{{ $stt; }}</th>
                    <td class="invoice-name-product">{{ $info_invoice->product_name }}</td>
                    <td style="width:220px;padding-right:40px;">{{ $info_invoice->qty }}</td>
                    <td class="invoice-price-product">{{ number_format($info_invoice->product_price, 0, ',', '.') }}đ</td>
                </tr>
                <?php $stt++; ?>
            @endforeach
        </tbody>
    </table>
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
    <img class="d-block mx-auto mt-0 mb-0" src="{{ asset('public/uploads/qr.png') }}" width="300" height="300">
    <div class="row text-center">
        <h5>Ốc xinh sài gòn</h5>
        <h6>Xin cảm ơn, hẹn gặp lại quý khách!</h6>
    </div>
</div>
<script>
    const invoicePrintArea = document.getElementById('invoice-print-area').innerHTML;
    const originalContent = document.body.innerHTML;
    const btnPrint = document.getElementById('btn-invoice-print');
    btnPrint.addEventListener('click', function () {
        document.body.innerHTML = invoicePrintArea;
        window.print();
        document.body.innerHTML = originalContent;
    });
</script>
@endsection