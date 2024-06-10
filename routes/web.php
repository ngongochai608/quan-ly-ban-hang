<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategorysController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('admin', [
    AdminController::class,
    'login'
]);

Route::get('logout', [
    AdminController::class,
    'logout'
]);

Route::post('admin-login', [
    AdminController::class,
    'actionLogin'
]);

Route::get('dashboard', [
    AdminController::class,
    'adminShowDashboard'
]);

// Product
Route::get('add-product', [
    ProductsController::class,
    'addProduct'
]);

Route::get('edit-product/{product_id}', [
    ProductsController::class,
    'editProduct'
]);

Route::post('update-product/{product_id}', [
    ProductsController::class,
    'updateProduct'
]);

Route::get('remove-product/{product_id}', [
    ProductsController::class,
    'removeProduct'
]);

Route::get('all-product', [
    ProductsController::class,
    'allProduct'
]);

Route::post('save-product', [
    ProductsController::class,
    'saveProduct'
]);

// Category
Route::get('add-category', [
    CategorysController::class,
    'addCategory'
]);

Route::get('all-category', [
    CategorysController::class,
    'allCategory'
]);

Route::post('save-category', [
    CategorysController::class,
    'saveCategory'
]);

Route::get('remove-category/{category_id}', [
    CategorysController::class,
    'removeCategory'
]);

// Table
Route::get('add-table', [
    TableController::class,
    'addTable'
]);

Route::get('edit-table/{table_id}', [
    TableController::class,
    'editTable'
]);

Route::post('update-table/{table_id}', [
    TableController::class,
    'updateTable'
]);

Route::get('remove-table/{table_id}', [
    TableController::class,
    'removeTable'
]);

Route::get('all-table', [
    TableController::class,
    'allTable'
]);

Route::post('save-table', [
    TableController::class,
    'saveTable'
]);

// Order 
Route::get('order-table', [
    OrderController::class,
    'orderTable'
]);

Route::get('order-food/{table_id}', [
    OrderController::class,
    'orderFood'
]);


// Invoice
Route::get('view-invoice/{invoice_id}', [
    InvoiceController::class,
    'viewInvoice'
]);
Route::post('update-invoice/{invoice_id}', [
    InvoiceController::class,
    'updateInvoice'
]);
Route::get('remove-item-invoice/{invoice_product_id}/{invoice_id}', [
    InvoiceController::class,
    'removeProductInvoice'
]);
Route::get('all-invoice', [
    InvoiceController::class,
    'allInvoice'
]);
Route::get('invoice-payment/{invoice_id}', [
    InvoiceController::class,
    'paymentInvoice'
]);
Route::get('invoice-add-food/{invoice_id}', [
    InvoiceController::class,
    'addItemInvoice'
]);
Route::post('create-invoice', [
    InvoiceController::class,
    'createInvoice'
]);


