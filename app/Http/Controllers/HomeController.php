<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Libraries\Seo\MetaTagsCreater;

class HomeController extends Controller{

    protected $categories;

    protected $data = [];

    protected $settings;

    protected $metaTagsCreater;

    public function __construct(MetaTagsCreater $metaTagsCreater){

        $this->settings = Settings::getInstance();

        $this->data['global_data']['project_data'] = $this->settings->getParameters();

        $this->metaTagsCreater  = $metaTagsCreater;

    }

    public function index(){

        $this->data['template'] = config('template.content.home');

        $this->data['meta'] = $this->metaTagsCreater->getTagsForPage($this->data);

        return view( '_raduga.index', $this->data);
    }

}
