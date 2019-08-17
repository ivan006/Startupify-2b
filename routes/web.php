<?php

use App\User;
use App\Http\Resources\User as UserResource;
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



// Route::get('/phpversion', function () {
//   echo phpversion();
// });
// Route::get('/blogApi/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}', 'blogApi@show');
//
Route::get('/', function(){
  return redirect( route('NetworkC.show'));
});



Route::group(['middleware' => 'ShortcodeMiddleware'], function() {
  Route::get(   '/showfileorineted/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'Network@show')->name('Network.show');
});
Route::get(   '/editfileorineted/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'Network@edit')->name('Network.edit');
Route::post(   '/storefileorineted/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'Network@store')->name('Network.store');


Route::group(['middleware' => 'ShortcodeMiddleware'], function() {
  Route::get(   '/show/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'NetworkC@show')->name('NetworkC.show');
});
Route::get(   '/edit/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'NetworkC@edit')->name('NetworkC.edit');
Route::post(   '/store/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'NetworkC@store')->name('NetworkC.store');

// Route::get(   '/index',                                           'Network@index')->name('Network.index');
// Route::get(   '/create/asset',                                    'Network@create')->name('Network.create');
// Route::patch( '/update/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}', 'Network@update')->name('Network.update');
// Route::delete('/destroy/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}','Network@destroy')->name('Network.destroy');


// Route::get(   '/SmartData/index/post',                                           'SmartData@index')->name('SmartData.index');
// Route::get(   '/SmartData/create/asset',                                    'SmartData@create')->name('SmartData.create');
// Route::patch( '/SmartData/update/asset/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}', 'SmartData@update')->name('SmartData.update');
// Route::delete('/SmartData/destroy/asset/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}','SmartData@destroy')->name('SmartData.destroy');
// Route::group(['middleware' => 'ShortcodeMiddleware'], function() {
//   Route::get(   '/SmartData/show/asset/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'SmartData@show')->name('SmartData.show');
// });
// Route::post(   '/SmartData/store/post/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'SmartData@store')->name('SmartData.store');
// Route::get(   '/SmartData/edit/post/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}',   'SmartData@edit')->name('SmartData.edit');
