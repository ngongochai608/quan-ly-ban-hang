<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;

session_start();

class InvoiceController extends Controller
{
    function createNameInvoiceNew() {
        $number_invoice = DB::table('qlbh_invoice')->get()->count();
        $name_invoice = 'OXSG_'.($number_invoice + 1);
        return $name_invoice;
    }

    public function createInvoice (Request $request) {
        $table_id = $request->table_id;
        $currentDateTime = date('Y-m-d H:i:s');
        $all_products = DB::table('qlbh_products')->get();
        $data_qty_product = array();
        foreach ($all_products as $product) {
            $data_qty_product[$product->product_id] = +$request['qty_product-'.$product->product_id];
        }
        $data_qty_product_validation = array_filter($data_qty_product, function($value) {
            return $value != 0;
        });
        
        $total_price = 0;

        foreach($data_qty_product_validation as $product_id => $product_qty) {
            $product_price = DB::table('qlbh_products')->where('product_id', $product_id)->pluck('product_price')->first();
            $price = +$product_price * +$product_qty;
            $total_price += $price;
        }
        $data = array();
        $data['invoice_name'] = $this->createNameInvoiceNew();
        $data['invoice_info'] = json_encode($data_qty_product_validation);
        $data['invoice_table_id'] = $table_id;
        $data['invoice_status'] = 'unpaid';
        $data['invoice_discount_value'] = '';
        $data['invoice_discount_type'] = '';
        $data['invoice_total_price'] = $total_price;
        $data['invoice_total_price_discount'] = '';
        $data['created_at'] = $currentDateTime;

        $id_invoice = DB::table('qlbh_invoice')->insertGetId($data);

        $data_table = array(
            'table_status' => 'active',
            'table_invoice_id' => $id_invoice
        );
        DB::table('qlbh_table')->where('table_id', $table_id)->update($data_table);

        return Redirect::to('view-invoice/'.$id_invoice);
    }

    public function viewInvoice ($invoice_id) {
        $invoice = DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->get()->first();
        $invoice_info = json_decode($invoice->invoice_info);
        $invoice_info_full = array();
        foreach($invoice_info as $id => $qty) {
            $product = DB::table('qlbh_products')->where('product_id', $id)->get()->first();
            $product->qty = $qty;
            $invoice_info_full[] = $product;
        }
        if ($invoice->invoice_table_id == 'take-away') {
            $table_invoice = 'Mua mang về';
        } else {
            $table_invoice = DB::table('qlbh_table')->where('table_id', $invoice->invoice_table_id)->get()->first();
        }
        $table_empty = DB::table('qlbh_table')->where('table_status', 'empty')->get();
        return view('admin.view_invoice')->with('invoice', $invoice)->with('invoice_info_full', $invoice_info_full)->with('table_invoice', $table_invoice)->with('table_empty', $table_empty);
    }

    public function allInvoice () {
        $all_invoice = DB::table('qlbh_invoice')->get();
        return view('admin.all_invoice')->with('all_invoice', $all_invoice);
    }

    public function updateInvoice (Request $request, $invoice_id) {
        $all_products = DB::table('qlbh_products')->get();
        $data_qty_product = array();
        foreach ($all_products as $product) {
            $data_qty_product[$product->product_id] = +$request['qty_product-'.$product->product_id];
        }
        $data_qty_product_validation = array_filter($data_qty_product, function($value) {
            return $value != 0;
        });
        
        $total_price = 0;

        foreach($data_qty_product_validation as $product_id => $product_qty) {
            $product_price = DB::table('qlbh_products')->where('product_id', $product_id)->pluck('product_price')->first();
            $price = +$product_price * +$product_qty;
            $total_price += $price;
        }

        $data = array();

        if (!empty($request->invoice_discount_value)) {
            $total_price_discount = $total_price;
            if ($request->invoice_discount_type == 'money') {
                $total_price = $total_price - $request->invoice_discount_value;
            }
            if ($request->invoice_discount_type == 'percent') {
                $percent_value = ($total_price * $request->invoice_discount_value) / 100;
                $total_price = $total_price - $percent_value;
            }
            $data['invoice_discount_value'] = $request->invoice_discount_value;
            $data['invoice_discount_type'] = $request->invoice_discount_type;
            $data['invoice_total_price_discount'] = $total_price_discount;
        } else {
            $data['invoice_discount_value'] = '';
            $data['invoice_discount_type'] = '';
            $data['invoice_total_price_discount'] = '';
        }
        $data['invoice_info'] = json_encode($data_qty_product_validation);
        $data['invoice_total_price'] = $total_price;

        DB::table('qlbh_invoice')->update($data);

        return Redirect::to('view-invoice/'.$invoice_id);
    }

    public function removeProductInvoice ($invoice_product_id, $invoice_id) {
        $invoice = DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->first();
        $invoice_info = json_decode($invoice->invoice_info, true);
        unset($invoice_info[$invoice_product_id]);
        $total_price = 0;
        foreach($invoice_info as $product_id => $product_qty) {
            $product_price = DB::table('qlbh_products')->where('product_id', $product_id)->pluck('product_price')->first();
            $price = +$product_price * +$product_qty;
            $total_price += $price;
        }
        $data = array();
        $data['invoice_info'] = json_encode($invoice_info);
        $data['invoice_total_price'] = $total_price;
        DB::table('qlbh_invoice')->update($data);
        return Redirect::to('view-invoice/'.$invoice_id);
    }

    public function paymentInvoice ($invoice_id) {
        DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->update(['invoice_status' => 'paid']);
        $invoice = DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->get()->first();
        $invoice_info = json_decode($invoice->invoice_info);
        $invoice_info_full = array();
        foreach($invoice_info as $id => $qty) {
            $product = DB::table('qlbh_products')->where('product_id', $id)->get()->first();
            $product->qty = $qty;
            $invoice_info_full[] = $product;
        }
        if ($invoice->invoice_table_id == 'take-away') {
            $table_invoice = 'Mua mang về';
        } else {
            $table_invoice = DB::table('qlbh_table')->where('table_id', $invoice->invoice_table_id)->get()->first();
            DB::table('qlbh_table')->where('table_id', $table_invoice->table_id)->update(['table_status' => 'empty']);
        }
        return view('admin.print_invoice')->with('invoice', $invoice)->with('table_invoice', $table_invoice)->with('invoice_info_full', $invoice_info_full);
    }

    public function addItemInvoice ($invoice_id) {
        $invoice = DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->get()->first();
        $allProduct = DB::table('qlbh_products')->get();
        $allCategory = DB::table('qlbh_category_product')->get();
        $allProductWithCategory = array();
        foreach ($allCategory as $category) {
            $products = DB::table('qlbh_products')->where('product_category_id', $category->category_id)->get();
            $allProductWithCategory[$category->category_id] = $products;
        }
        $invoice_info = json_decode($invoice->invoice_info);
        $invoice_info_full = array();
        foreach($invoice_info as $id => $qty) {
            $product = DB::table('qlbh_products')->where('product_id', $id)->get()->first();
            $product->qty = $qty;
            $invoice_info_full[$id] = $product;
        }
        return view('admin.add_item_invoice')
            ->with('all_products_with_category', $allProductWithCategory)
            ->with('table_id', $invoice->invoice_table_id)
            ->with('all_category', $allCategory)
            ->with('all_product', $allProduct)
            ->with('invoice_info_full', $invoice_info_full)
            ->with('invoice_id', $invoice_id);
    }

    public function changQuantityInvoiceItem ($invoice_id, $product_id, $quantity) {
        $invoice = DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->get()->first();
        $invoice_info = json_decode($invoice->invoice_info);
        $invoice_info_update = array();
        foreach($invoice_info as $id => $qty) {
            if ($id == $product_id) {
                $invoice_info_update[$id] = $quantity;
            } else {
                $invoice_info_update[$id] = $qty;
            }
        }
        $total_price = 0;
        foreach($invoice_info_update as $id => $qty) {
            $product_price = DB::table('qlbh_products')->where('product_id', $id)->pluck('product_price')->first();
            $price = +$product_price * +$qty;
            $total_price += $price;
        }
        $invoice_info_update_json = json_encode($invoice_info_update);
        $data_update = array(
            'invoice_info' => $invoice_info_update_json,
        );
        if (!empty($invoice->invoice_discount_type)) {
            $total_price_discount = $total_price;
            $data_update['invoice_total_price_discount'] = $total_price_discount;
            if ($invoice->invoice_discount_type  == 'money') {
                $total_price = $total_price - $invoice->invoice_discount_value;
                if ($request->invoice_discount_type == 'percent') {
                    $percent_value = ($total_price * $request->invoice_discount_value) / 100;
                    $total_price = $total_price - $percent_value;
                }
            }
            if ($invoice->invoice_discount_type == 'percent') {
                $percent_value = ($total_price * $invoice->invoice_discount_value) / 100;
                $total_price = $total_price - $percent_value;
            }
        }
        $data_update['invoice_total_price'] = $total_price;

        DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->update($data_update);
        return Redirect::to('view-invoice/'.$invoice_id);
    }
    public function removeInvoice ($invoice_id) {
        $invoice_remove = DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->get()->first();
        $invoice_remove_name = $invoice_remove->invoice_name;
        DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->delete();
        Session::put('message', 'Đã xoá hóa đơn '.$invoice_remove_name);
        return Redirect::to('all-invoice');
    }
    public function changeTable ($invoice_id, $table_id) {
        $invoice = DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->get()->first();
        $table_id_curent = $invoice->invoice_table_id;
        DB::table('qlbh_invoice')->where('invoice_id', $invoice_id)->update(['invoice_table_id' => $table_id]);
        DB::table('qlbh_table')->where('table_id', $table_id_curent)->update(['table_status' => 'empty']);
        DB::table('qlbh_table')->where('table_id', $table_id)->update(['table_status' => 'active', 'table_invoice_id' => $invoice_id]);
        return Redirect::to('view-invoice/'.$invoice_id)->with('message', 'Đã thay đổi từ bàn '.$table_id_curent.' sang bàn '.$table_id);
    }
}
