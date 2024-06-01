@extends('admin_layout')
@section('admin_content')
<div class="container-fluid p-4">
    <h3>Cập nhập bàn</h3>
    <form method="post" action="{{ URL::to('update-table/'.$table_edit->table_id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="name-food">Tên bàn</label>
            <input autocomplete="off" type="text" name="name_table" value="{{ $table_edit->table_name }}" class="form-control" id="name-food" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhập bàn</button>
    </form>
</div>
@endsection