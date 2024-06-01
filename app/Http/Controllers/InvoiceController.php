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
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
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
        $data['invoice_name'] = $this->generateRandomString();
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
            'table_status' => 'waiting',
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
        $table_invoice = DB::table('qlbh_table')->where('table_id', $invoice->invoice_table_id)->get()->first();
        return view('admin.view_invoice')->with('invoice', $invoice)->with('invoice_info_full', $invoice_info_full)->with('table_invoice', $table_invoice);
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
}
