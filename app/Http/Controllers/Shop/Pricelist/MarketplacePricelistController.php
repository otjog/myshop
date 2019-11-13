<?php

namespace App\Http\Controllers\Shop\Pricelist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Marketplace;

class MarketplacePricelistController extends Controller
{

    public $marketplaceModel;

    public function __construct(Marketplace $marketplaceModel)
    {
        $this->marketplaceModel = $marketplaceModel;
    }

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
     * @param  string  $mp_alias Alias of MarketPlace, ex.: ozon
     * @param  string  $pl_alias Alias of PriceList, ex.: yml
     * @return \Illuminate\Http\Response
     */
    public function show($mp_alias, $pl_alias)
    {
        $marketplace = $this->marketplaceModel->getMarketplacesWithProducts($mp_alias);

        dd($marketplace);
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
