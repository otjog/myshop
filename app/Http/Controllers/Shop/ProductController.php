<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\ShopBasket;
use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Shop\BasketController;

class ProductController extends Controller{

    protected $products;
    protected $baskets;
    protected $data;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Product $products
     * @return void
     */
    public function __construct(Product $products, ShopBasket $baskets ){
        $this->products = $products;
        $this->baskets = $baskets;
        $this->data = [
            'template' => [
                'component' => 'shop',
                'resource'  => 'product'
            ]
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $this->data['template']['view'] = 'show';
        $this->data['data']['product']  = $this->products->getActiveProduct($id);

        $this->data['template']['custom'][] = 'shop-icons';

        return view( 'templates.default', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }

    public function toBasket(Request $request, $id){
        $basket = new BasketController($this->baskets);
        $basket->postAdd($request);

        //return $this->show($id);
        return redirect()->route('products.show', ['id' => $id]);
    }
}
