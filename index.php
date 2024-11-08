<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('log_errors', TRUE); 
ini_set('error_log', './logs/php/php-errors.log');

use App\Route;
use App\Helpers\AuthHelper;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once 'config.php';
//  Gọi đến middleware;
/* AuthHelper::middleware(); */
// exit();


// ********************************** CLIENT ********************************
// ------- HEADER--------
Route::get('/', 'App\Controllers\Client\HomeController@index');
Route::get('/contact', 'App\Controllers\Client\HomeController@contact');
Route::get('/about', 'App\Controllers\Client\HomeController@about');
Route::get('/Search', 'App\Controllers\Client\HomeController@search');

//---------------------------[ TÀI KHOẢN ]---------------------------
Route::get('/Account', 'App\Controllers\Client\AuthController@Account');

Route::get('/ForgotPassword', 'App\Controllers\Client\AuthController@ForgotPassword');

Route::get('/Resetpassword', 'App\Controllers\Client\AuthController@Resetpassword');

Route::get('/logout', 'App\Controllers\Client\AuthController@logout');

Route::get('/user', 'App\Controllers\Client\AuthController@profile');

//hiển thị thông tin tài khoản
Route::get('/user/{id}', 'App\Controllers\Client\AuthController@edit');

//-----------------------[ ĐĂNG KÝ ]--------------------------
Route::post('/home-register', 'App\Controllers\Client\AuthController@registerAction');

//-----------------------[ ĐĂNG Nhập ]--------------------------
Route::post('/home-login', 'App\Controllers\Client\AuthController@loginAction');

//-----------------------[ SẢN PHẨM ]--------------------------------
Route::get('/shop', 'App\Controllers\Client\ProductController@index'); 
Route::get('/product', 'App\Controllers\Client\ProductController@detail');

//----------------------[ SP THEO DANH MỤC ]-----------------------
Route::get('/product/categories/{id}', 'App\Controllers\Client\ProductController@getProductByCategory');

Route::get('/product/parent/{id}','App\Controllers\Client\ProductController@showSubCategories');

//-----------------------[ GIỎ HÀNG ]--------------------------------
Route::get('/cart', 'App\Controllers\Client\CartController@index'); 

Route::get('/checkout', 'App\Controllers\Client\CartController@checkout'); 

Route::get('/history', 'App\Controllers\Client\CartController@history'); 

//-----------------------[ KỸ THUÊTJ TRỒNG CÂY ]--------------------------------
Route::get('/blog', controllerMethod: 'App\Controllers\Client\HomeController@instruction'); 

// **************************** ADMIN ********************************

Route::get('/admin', 'App\Controllers\Admin\HomeController@index');

//---------------------------[ SẢN PHẨM ]--------------------------------
Route::get('/admin/Product', 'App\Controllers\Admin\ProductController@Index');

Route::get('/admin/products/create', 'App\Controllers\Admin\ProductController@create');
Route::post('/admin/products', 'App\Controllers\Admin\ProductController@store');

/* Route::get('/admin/products/{id}', 'App\Controllers\Admin\ProductController@edit');
Route::put('/admin/products/{id}', 'App\Controllers\Admin\ProductController@update');

Route::delete('/admin/products/{id}', 'App\Controllers\Admin\ProductController@delete'); */

//--------------------------[ DANH MỤC ]--------------------------
Route::get('/admin/categories', 'App\Controllers\Admin\CategoryController@Index');

Route::get('/admin/categories/create', 'App\Controllers\Admin\CategoryController@create');
Route::post('/admin/categories', 'App\Controllers\Admin\CategoryController@store');

Route::get('/admin/categories/{id}', 'App\Controllers\Admin\CategoryController@edit');
Route::put('/admin/categories/{id}', 'App\Controllers\Admin\CategoryController@update'); 
Route::delete('/admin/categories/{id}', 'App\Controllers\Admin\CategoryController@delete');

//---------------------------[ TÀI KHOẢN ]---------------------------
Route::get('/admin/users', 'App\Controllers\Admin\UserController@Index');

Route::get('/admin/users/{id}', 'App\Controllers\Admin\UserController@edit');
Route::put('/admin/users/{id}', 'App\Controllers\Admin\UserController@update');

Route::delete('/admin/users/{id}', 'App\Controllers\Admin\UserController@delete'); 

//--------------------------[ ĐƠN HÀNG ]-------------------------------
Route::get('/admin/order', 'App\Controllers\Admin\OrderController@Index');

/* Route::get('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@edit');
Route::put('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@update');

Route::delete('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@delete'); */

//--------------------------[ BÌNH LUẬN ]-------------------------------
Route::get('/admin/comments', 'App\Controllers\Admin\CommentController@Index');

/* Route::get('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@edit');
Route::put('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@update');

Route::delete('/admin/comments/{id}', 'App\Controllers\Admin\CommentController@delete'); */


 //------------------[ BẮT TÀI KHOẢN ĐĂNG NHẬP ]------------------
Route::dispatch($_SERVER['REQUEST_URI']);
