@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Thêm bàn</h3>
    <form method="post" action="{{ URL::to('save-table') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="name-table">Tên bàn</label>
            <input autocomplete="off" type="text" name="name_table" class="form-control" id="name-table" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm bàn</button>
    </form>
</div>
@endsection