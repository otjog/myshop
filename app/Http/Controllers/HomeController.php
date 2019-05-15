<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Libraries\Seo\MetaTagsCreater;
use App\Models\Site\Template;

class HomeController extends Controller{

    protected $categories;

    protected $data;

    protected $template;

    protected $globalData;

    protected $settings;

    protected $metaTagsCreater;

    public function __construct(MetaTagsCreater $metaTagsCreater, Template $template){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

        $this->metaTagsCreater  = $metaTagsCreater;

    }

    public function index(){

        $this->data['template']['schema'] = $this->template->getTemplateWithContent('home');

        $this->data['metatags'] = $this->metaTagsCreater->getTagsForPage($this->data);

        return view( $this->data['template']['name'] . '.index', $this->globalData);
    }

}
