<?php

namespace App\Http\Controllers\Shop\View;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product\Product;
use App\Facades\GlobalData;

class CategoryViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param string $view
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $products, $id, $view)
    {
        $data['parameters'] = $request->all();

        $data['products'] = $products->getProductsFromRoute($request->route()->parameters, $request->all());

        $path = str_replace(['/views', '/'.$view], '', $request->url());

        /*Убирает у ссылок пагинации параметр views/... */
        $data['products']->setPath($path);


        $data['global_data'] = GlobalData::getParameters();

        return view($view, $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    public function destroy($id)
    {
        //
    }
}
