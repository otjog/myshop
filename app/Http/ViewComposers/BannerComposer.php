<?php
/**
 * Created by PhpStorm.
 * User: otjog
 * Date: 17.09.18
 * Time: 17:45
 */

namespace App\Http\ViewComposers;

use App\Models\Site\Banner;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class BannerComposer{

    protected $banners;

    public function __construct(Banner $banner)
    {
        $this->banners = Cache::remember('site:banners:activeBanners', '1440', function() use ($banner){
            return $banner->getActiveBanners();
        });
    }

    public function compose(View $view){
        $view->with('banners', $this->banners);
    }

}