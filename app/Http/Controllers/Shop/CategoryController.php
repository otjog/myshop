<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Libraries\Seo\MetaTagsCreater;
use App\Models\Shop\Order\Basket;
use Illuminate\Http\Request;
use App\Models\Shop\Category\Category;
use App\Models\Shop\Product\Product;
use App\Models\Settings;
use App\Models\Site\Template;

class CategoryController extends Controller{

    protected $categories;

    protected $baskets;

    protected $settings;

    protected $template;

    protected $data;

    protected $globalData;

    protected $metaTagsCreater;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Category $categories
     * @return void
     */
    public function __construct(Category $categories, Basket $baskets, MetaTagsCreater $metaTagsCreater, Template $template){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template         = $template;

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

        $this->data['template']['schema'] = $this->template->getTemplateWithContent('shop.category.list');

        $this->data['categories']  =  $this->categories->getCategoriesTree();

        $this->data['header_page'] =  'Категории';

        return view( $this->data['template']['name'] . '.components.shop.category.list', $this->globalData);
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

        $this->data['template']['schema'] = $this->template->getTemplateWithContent('shop.category.show');

        $category = $this->categories->getCategory($id);

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

        $this->data['metatags'] = $this->metaTagsCreater->getTagsForPage($this->data);

        return view( $this->data['template']['name'] . '.components.shop.category.show', $this->globalData);
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
