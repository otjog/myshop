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

        $this->metaTagsCreater  = $metaTagsCreater;

        $this->data['template'] = [];
    }

    public function index(){

        $this->data['global_data']['project_data'] = $this->settings->getParameters();

        $this->data['template'] ['banner']  = 'default';

        //  $this->data['template'] ['modules']['custom']  = 'shop-icons';

        $this->data['template'] ['modules']['offers']  = 'default';

        $this->data['meta'] = $this->metaTagsCreater->getTagsForPage($this->data);

        return view( '_raduga.index', $this->data);
    }

}
