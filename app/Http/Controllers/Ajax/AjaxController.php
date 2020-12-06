<?php

namespace App\Http\Controllers\Ajax;

use App\Facades\GlobalData;
use App\Models\Shop\Order\Basket;
use App\Models\Shop\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Services\ShipmentService;
use App\Models\Geo\GeoData;

class AjaxController extends Controller{

    /**Инициализируем массив пришедших параметров*/
    protected $request = [];

    /**Инициализируем массив для хранения данных ответа*/
    protected $data = [];

    /**Инициализируем массив для хранения заголовков ответа*/
    protected $headers = [];

    /**Инициализируем переменную Ответ Сервера*/
    protected $response;

    public function index(Request $request){

        $this->request = $request->all();

        if(isset($this->request['module']) && $this->request['module'] !== null){

            //todo вернуть $next если нет Module

            switch($this->request['module']){

                case 'shipment' :

                    $ds = new ShipmentService();

                    $this->data = $ds->getPrices($this->request);

                    break;

                case 'points' :

                    $ds = new ShipmentService();

                    $this->data = $ds->getPoints($this->request['alias']);

                    break;

                case 'geo'  :

                    /** Записываем введенную пользователем Геолокацию в Сессию */
                    $geoDataObj = GeoData::getInstance();
                    $geoDataObj->setGeoInput($this->request);

                    /**
                     * Получаем гео-данные
                     *
                     * После мы их отправим в виде json
                     *
                     * @var array data
                     */
                    $this->data = $geoDataObj->getGeoData();

                    /** Записываем обновленные данные в Глобальный массив */
                    GlobalData::addParameter('geo', $this->data);

                    break;

                case 'map'  :

                    $geoDataObj = GeoData::getInstance();
                    $this->data = $geoDataObj->getGeoData();

                    break;
            }

            return $this->sendResponse();

        }

    }

    private function sendResponse(){

        if ($this->request['response'] === null) {
            return null;
        }
        //Присваиваем переменной экземпляр Ответа Сервера
        $this->response = response();

        if($this->request['response'] === 'json') {
            $this->response = $this->response->json($this->data);
        }

        if($this->request['response'] === 'view'){

            $data['ajax'] = $this->data;

            //Получаем обновленные данные из Глобального массива для передачи во фронт
            $globalData = GlobalData::pushArrayParameters($data);

            $view = $globalData['template']['name'] . '.modules.shop.' . $this->request['module'] . '._reload.' . $this->request['view'];

            //Добавляем к ответу Представление и обновленную переменную с данными
            $this->response = $this->response->view($view, ['global_data' => $globalData]);
        }

        if( count($this->headers) > 0){
            $this->response = $this->response->withHeaders($this->headers);
        }

        return $this->response;
    }

}
