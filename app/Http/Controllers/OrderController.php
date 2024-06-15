<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;

session_start();

class OrderController extends Controller
{
    public function orderTable () {
        $allTable = DB::table('qlbh_table')->get();
        return view('admin.order_table')->with('all_table', $allTable);
    }

    public function orderFood ($table_id) {
        $allProduct = DB::table('qlbh_products')->get();
        $allCategory = DB::table('qlbh_category_product')->get();
        return view('admin.order_food')->with('table_id', $table_id)->with('all_category', $allCategory)->with('all_product', $allProduct);
    }
}
