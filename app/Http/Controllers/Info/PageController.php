<?php

namespace App\Http\Controllers\Info;

use App\Models\Site\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
class PageController extends Controller{

    protected $pages;

    protected $settings;

    protected $data = [];

    /**
     * Создание нового экземпляра контроллера.
     *
     * @param  Page $pages
     * @return void
     */
    public function __construct(Page $pages){

        $this->settings = Settings::getInstance();

        $this->data['global_data']['project_data'] = $this->settings->getParameters();

        $this->pages = $pages;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $this->data['template'] = config('template.content.info.page.list');

        $this->data['pages']  = $this->pages->getAllPages();

        return view('_raduga.components.info.page.index', $this->data);

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
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $this->data['template'] = config('template.info.page.show');

        $this->data['page']  = $this->pages->getPageIfActive($id);

        return view('_raduga.components.info.page.show', $this->data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

        $this->data['template'] = config('template.info.page.edit');

        $this->data['page']  = $this->pages->getPage($id);

        return view('_raduga.components.info.page.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $this->pages->updatePage($id, $request->all());

        return redirect()->route('pages.index');

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
