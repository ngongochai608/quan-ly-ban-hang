<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;

session_start();

class CategorysController extends Controller
{
    public function addCategory () {
        return view('admin.add_category');
    }

    public function allCategory () {
        $all_category = DB::table('qlbh_category_product')->get();
        return view('admin.all_category')->with('all_category', $all_category);
    }

    public function removeCategory ($category_id) {
        DB::table('qlbh_category_product')->where('category_id', $category_id)->delete();
        Session::put('message', 'Xoá danh mục thành công');
        return Redirect::to('all-category');
    }

    public function saveCategory (Request $request) {
        $nameCategory = $request->name_category;
        $statusCategory = $request->name_product;
        $data['category_name'] = $nameCategory;
        $data['category_status'] = '1';
        DB::table('qlbh_category_product')->insert($data);
        Session::put('message', 'Thêm danh mục thành công');
        return Redirect::to('all-category');
    }
}
