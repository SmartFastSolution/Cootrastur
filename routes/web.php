<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



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

//ruta para inicio con video
Route::get('/', function () {
    if (Auth::guest()) {
        return redirect('/home');
    }else{
        return view('auth/login');
    }
});

Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('index');  // para que acceda solo a home sin entrar a welcome nse comenta
Route::post('/changepassword', 'HomeController@iniciarPrimero')->name('change');


/*Guardando los documentos temporalmente*/
/* /* para filepond */
/* Route::post('/upload/{id}', 'Tienda\ClienteController@store')->name('documentos.files.stores');
 */
