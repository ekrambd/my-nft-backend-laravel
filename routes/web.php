<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/do', function(){
// 	$data = array();
// 	$data['name'] = 'Admin';
// 	$data['role'] = 'admin';
// 	$data['wallet_address'] = '0x4d2F6E73e744346c1B9046B8F931331e8a2F2805';
// 	$data['password'] = bcrypt('123456');
// 	DB::table('users')->insert($data);
// 	return back();
// });