<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;

session_start();

class ProductsController extends Controller
{
    public function addProduct () {
        $all_categorys = DB::table('qlbh_category_product')->get();
        return view('admin.add_product')->with('all_categorys', $all_categorys);
    }

    public function editProduct ($product_id) {
        $product_edit = DB::table('qlbh_products')->where('product_id', $product_id)->get()->first();
        $all_categorys = DB::table('qlbh_category_product')->get();
        return view('admin.edit_product')->with('all_categorys', $all_categorys)->with('product_edit', $product_edit);
    }

    public function updateProduct (Request $request, $product_id) {
        $nameProduct = $request->name_product;
        $priceProduct = $request->price_product;
        $categoryIdProduct = $request->product_category_id;
        $imageProduct = $request->file('image_product');

        $data = array();
        $data['product_name'] = $nameProduct;
        $data['product_price'] = $priceProduct;
        $data['product_category_id'] = $categoryIdProduct;

        if ($imageProduct) {
            $new_image = rand(11111,99999).'.'.$imageProduct->getClientOriginalExtension();
            $imageProduct->move('public/uploads/products', $new_image);
            $data['product_image'] = $new_image;
            DB::table('qlbh_products')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Đã cập nhập món '.$nameProduct);
            return Redirect::to('all-product');
        }
        DB::table('qlbh_products')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Đã cập nhập món '.$nameProduct);
        return Redirect::to('all-product');
    }

    public function removeProduct ($product_id) {
        $product_remove = DB::table('qlbh_products')->where('product_id', $product_id)->get()->first();
        $product_remove_name = $product_remove->product_name;
        DB::table('qlbh_products')->where('product_id', $product_id)->delete();
        $all_products = DB::table('qlbh_products')->get();
        Session::put('message', 'Đã xoá món '.$product_remove_name);
        return Redirect::to('all-product');
    }

    public function allProduct () {
        $all_product = DB::table('qlbh_products')->get();
        $all_category = DB::table('qlbh_category_product')->get();
        return view('admin.all_products')->with('all_product', $all_product)->with('all_category', $all_category);
    }

    public function saveProduct (Request $request) {
        $nameProduct = $request->name_product;
        $priceProduct = $request->price_product;
        $categoryIdProduct = $request->product_category_id;
        $imageProduct = $request->file('image_product');

        $data = array();
        $data['product_name'] = $nameProduct;
        $data['product_price'] = $priceProduct;
        $data['product_category_id'] = $categoryIdProduct;
        $data['product_status'] = '';

        if ($imageProduct) {
            $new_image = rand(11111,99999).'.'.$imageProduct->getClientOriginalExtension();
            $imageProduct->move('public/uploads/products', $new_image);
            $data['product_image'] = $new_image;
            DB::table('qlbh_products')->insert($data);
            Session::put('message', 'Đã thêm món '.$nameProduct);
            return Redirect::to('all-product');
        }
        $data['product_image'] = '';
        DB::table('qlbh_products')->insert($data);
        Session::put('message', 'Đã thêm món '.$nameProduct);
        return Redirect::to('all-product');
    }
}
