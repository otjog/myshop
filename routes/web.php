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

    /** VIEW Route **/
        //Home
        Route::get('/',         'HomeController@index'          )->name('home');

        //Search
        Route::get('/search',    'Search\SearchController@show' )->name('search');

        //Products
        Route::resource('/products',    'Shop\ProductController',   [ 'only' => [ 'show' ]]);

        //Categories
        Route::resource('/categories',  'Shop\CategoryController',  [ 'only' => [ 'index', 'show' ]]);

        //CategoryFilter
        Route::resource('/categories.filters',  'Shop\CategoryController',  [ 'only' => 'show' ]);

        //Brands
        Route::resource('/brands',      'Shop\BrandController',     [ 'only' => [ 'index', 'show' ]]);

        //Orders
        Route::resource('/orders',      'Shop\OrderController',     [ 'only' => [ 'store', 'create', 'show' ]]);

        //Pages
        Route::resource('/pages',       'Info\PageController',      [ 'only' => [ 'show' ]]);

        //Basket
        Route::resource('/baskets',     'Shop\BasketController',    [ 'only' => [ 'show', 'store', 'edit', 'update' ]]);

        //ProductInBasket
        Route::resource('/baskets.products', 'Shop\BasketProductController');

        //Pricelists
        Route::resource('/pricelists',  'Shop\PricelistController', [ 'only' => [ 'show' ]]);

        //PricelistsForMarketplaces
        Route::resource('/marketplaces.pricelists',     'Shop\Pricelist\MarketplacePricelistController',
            [ 'only' => [ 'show' ]]);

        //Image
        Route::get('/models/{models}/sizes/{sizes}/images/{images}/modelid/{modelId?}/extension/{extension?}',     'Image\ImageController@show')
            ->where('images', '.*')
            ->name('getImage');

        //Forms
        Route::group(['prefix' => 'form'], function () {

            //GeoData

            Route::post('geodata', function (\Illuminate\Http\Request $request, \App\Models\Geo\GeoData $geoData){
                $geoData->setGeoInput( $request->address_json );
                return back();
            })->name('GetGeo');

        });

    //ProductView
    Route::resource('/products.views',      'Shop\View\ProductViewController',  [ 'only' => [ 'show' ]]);

    //CategoryView
    Route::resource('/categories.views',    'Shop\View\CategoryViewController', [ 'only' => [ 'show' ]]);

    //BasketView
    Route::resource('/baskets.views',       'Shop\View\BasketViewController',   [ 'only' => [ 'show' ]]);

    //SearchView
    Route::get('/search/views/{view}',             'Search\SearchController@showView' );


    //Pay
    Route::group(['prefix' => 'pay'], function(){

        Route::post('/confirm', 'Shop\PayController@confirm');

        Route::post('/execute', 'Shop\PayController@execute');

        Route::post('/redirect/{msg}', 'Shop\PayController@redirect');
    });

    //Messages
    Route::post('/message', function(\Illuminate\Http\Request $request){
        \Illuminate\Support\Facades\Mail::send(new \App\Mail\SendMessage($request->all()));
        return back();
    })->name('sendmessage');

    Route::get('/mailling/unsubscribe/{email}', 'Mailling\RunMaillingController@unsubscribe')->name('unsubscribe');

    //Ajax
    Route::match(['get', 'post'], '/ajax', 'Ajax\AjaxController@index');

    Auth::routes();


