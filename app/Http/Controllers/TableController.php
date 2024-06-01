<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;

session_start();

class TableController extends Controller
{
    public function addTable () {
        return view('admin.add_table');
    }

    public function saveTable (Request $request) {
        $nameTable = $request->name_table;
        $data = array();
        $data['table_name'] = $nameTable;
        $data['table_status'] = 'empty';
        $data['table_invoice_id'] = '';
        DB::table('qlbh_table')->insert($data);
        return Redirect::to('all-table');
    }

    public function allTable () {
        $all_table = DB::table('qlbh_table')->get();
        return view('admin.all_table')->with('all_table', $all_table);
    }

    public function editTable ($table_id) {
        $table_edit = DB::table('qlbh_table')->where('table_id', $table_id)->get()->first();
        return view('admin.edit_table')->with('table_edit', $table_edit);
    }

    public function updateTable (Request $request, $table_id) {
        $nameTable = $request->name_table;

        $data = array();
        $data['table_name'] = $nameTable;
        DB::table('qlbh_table')->where('table_id', $table_id)->update($data);
        Session::put('message', 'Đã cập nhập bàn '.$nameTable);
        return Redirect::to('all-table');
    }
}
