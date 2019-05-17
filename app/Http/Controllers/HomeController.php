<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Site\Template;

class HomeController extends Controller{

    protected $categories;

    protected $data;

    protected $template;

    protected $globalData;

    protected $settings;

    public function __construct(Template $template){

        $this->settings = Settings::getInstance();

        $this->globalData = $this->settings->getParameters();

        $this->data =& $this->globalData['global_data'];

        $this->template = $template;

    }

    public function index(){

        $this->data['template'] = $this->template->getTemplateData($this->data,'home');

        return view( $this->data['template']['name'] . '.index', $this->globalData);
    }

}
