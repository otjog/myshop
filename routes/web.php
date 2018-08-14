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
    //Home
    Route::get('/',         'HomeController@index'          )->name('home');

    //Search
    Route::get('/search',    'Search\SearchController@show' )->name('search');

    //Products
    Route::resource('/products',    'Shop\ProductController',   [ 'only' => [ 'show' ]]);

    //Categories
    Route::resource('/categories',  'Shop\CategoryController',  [ 'only' => [ 'index', 'show' ]]);

    //Orders
    Route::resource('/orders',      'Shop\OrderController',     [ 'only' => [ 'store', 'create', 'show' ]]);

    //Pages
    Route::resource('/pages',       'Info\PageController',      [ 'only' => [ 'show' ]]);

    //Basket
    Route::resource('/baskets',     'Shop\BasketController',    [ 'only' => [ 'store', 'edit', 'update' ]]);

    //Forms
    Route::group(['prefix' => 'form'], function () {

        //GeoData
        Route::post('geodata', function (\Illuminate\Http\Request $request, \App\Models\GeoData $geoData){
            $geoData->setGeoInput( $request->address_json );
            return back();
        })->name('GetGeo');

    });


    /************************Админка*************************************************/
    Auth::routes();

    Route::group(['prefix' => 'adminio', 'middleware' => ['auth']], function () {

        //Admin Home
        Route::get('/', 'Admin\AdminController@index')->name('admin');

        //Admin Products
        Route::resource('products',     'Shop\ProductController',       [ 'except' => [ 'show' ]]);

        //Admin Categories
        Route::resource('categories',   'Shop\CategoryController',      [ 'except' => [ 'show' ]]);

        //Admin Pages
        Route::resource('pages',        'Info\PageController',          [ 'except' => [ 'show' ]]);

    });


    /******************Конец*Админка*************************************************/

    Route::get('/parseXl', 'Parse\FromXlsxController@parse');
    Route::get('/parseSite', 'Parse\FromSiteController@parse');
