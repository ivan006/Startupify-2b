<?php


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

Route::get('/', function () {
    return redirect(route('NetworkC.edit'));
});

Route::group(['middleware' => 'ShortcodeMiddleware'], function () {
    Route::get('/show/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}', 'NetworkC@show')->name('NetworkC.show');
});
Route::get('/edit/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}', 'NetworkC@edit')->name('NetworkC.edit');
Route::post('/store/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}', 'NetworkC@store')->name('NetworkC.store');
