<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Libraries\Seo\MetaTagsCreater;
use App\Models\Shop\Order\Basket;
use Illuminate\Http\Request;
use App\Models\Shop\Category\Category;
use App\Models\Shop\Product\Product;
use App\Models\Settings;

class CategoryController extends Controller{

    protected $categories;

    protected $baskets;

    protected $settings;

    protected $data = [];

    protected $metaTagsCreater;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Category $categories
     * @return void
     */
    public function __construct(Category $categories, Basket $baskets, MetaTagsCreater $metaTagsCreater){

        $this->settings = Settings::getInstance();

        $this->data['global_data']['project_data'] = $this->settings->getParameters();

        $this->categories       = $categories;

        $this->baskets          = $baskets;

        $this->metaTagsCreater  = $metaTagsCreater;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $this->data['template'] = config('template.content.shop.category.list');

        $this->data['categories']  =  $this->categories->getCategoriesTree();
        $this->data['header_page'] =  'Категории';

        return view( $this->settings->data['template_name'] . '.components.shop.category.list', $this->data);
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
     * @param  Request $request
     * @param  Product $products
     * @param  int  $id
     * @return array
     */
    public function show(Request $request, Product $products, $id){

        $this->data['template'] = config('template.content.shop.category.show');

        $category = $this->categories->getCategory($id);

        $this->data['template']['sidebar']             = 'product_filter';
        $this->data['template']['filter-tags']         = 'filter-tags';
        $this->data['category']            = $category;
        $this->data['children_categories'] = $this->categories->getActiveChildrenCategories($id);
        $this->data['header_page']         = $category[0]->name;
        $this->data['parameters']          = [];

        if( count( $request->query ) > 0 ){

            $filterData = $request->toArray();

            $routeData = ['category' => $id];

            $this->data['products'] = $products->getFilteredProducts($routeData, $filterData);

            $this->data['parameters'] = $request->toArray();


        }else{

            $this->data['products'] = $products->getActiveProductsFromCategory($id);

        }

        $this->data['meta'] = $this->metaTagsCreater->getTagsForPage($this->data);

        return view( $this->settings->data['template_name'] . '.components.shop.category.show', $this->data);
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
    public function update(Request $request, $id){
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

}
