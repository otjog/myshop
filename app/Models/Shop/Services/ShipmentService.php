<?php

namespace App\Models\Shop\Services;

use App\Models\Shop\Order\Basket;
use App\Models\Shop\Order\Order;
use App\Models\Shop\Order\Shipment;
use App\Models\Shop\Product\Product;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Services\Shipment\Dpd;
use App\Libraries\Services\Shipment\Cdek;
use App\Libraries\Services\Shipment\Pochta;
use App\Libraries\Services\Shipment\CustomDelivery;
use App\Libraries\Helpers\DeclesionsOfWord;
use App\Models\Geo\GeoData;
use App\Models\Site\Image;

class ShipmentService extends Model
{
    public function getPrices($shipmentData)
    {
        $shipments = new Shipment();

        $shipmentService = $shipments->getShipmentServiceByAlias($shipmentData['alias']);

        $shipmentData['parcel_data'] = $this->getParcelParameters($shipmentData['parcel_data']);

        $serviceObj = $this->getServiceObject($shipmentData['alias']);

        $data = $serviceObj->getDeliveryCost($shipmentData['parcel_data'], $shipmentData['type']);

        if ( count($data) > 0 ) {

            $data['declision'] = $this->getDeclisionOfDays($data['days']);

            $shipmentService[0]->offer = $data;

        }

        return $shipmentService[0];

    }

    public function getPoints($shipmentServiceAlias)
    {
        $shipments = new Shipment();

        $shipment = $shipments->getShipmentServiceByAlias($shipmentServiceAlias);

        $image = new Image();

        $data = [];

        $serviceObj = $this->getServiceObject($shipmentServiceAlias);

        if ($serviceObj !== null) {
            $data[$shipmentServiceAlias]['points'] = $serviceObj->getPointsInCity();
            if(count($data[$shipmentServiceAlias]['points']) > 0)
                $data[$shipmentServiceAlias]['mapMarker'] = $image->getSrcImage('default', 'marker', $shipment[0]->images[0]->src, $shipment[0]->id, 'png');
        }

        return $data;
    }

    public function getDeliveryDataFromRequest($data)
    {
        if (count($data) > 0) {

            $parcels = [];

            foreach ($data as $name => $params) {

                $arr = explode('|', $params);

                foreach ($arr as $key => $param) {

                    $parcels[$key][$name] = $param;

                }
            }
        }

        return $parcels;

    }

    private function getServiceObject($shipmentServiceAlias)
    {
        $geo = new GeoData();

        $geoData = $geo->getGeoData();

        $serviceObj = null;

        switch ($shipmentServiceAlias) {

            case 'dpd'      :
                $serviceObj = new Dpd($geoData);
                break;

            case 'cdek'     :
                $serviceObj = new Cdek($geoData);
                break;

            case 'pochta'   :
                $serviceObj = new Pochta($geoData);
                break;

            case 'custom'   :
                $serviceObj = new CustomDelivery($geoData);
                break;

        }

        return $serviceObj;

    }

    private function getDeclisionOfDays($days)
    {
        $daysArray = explode('-', $days);

        if (count($daysArray) > 1)
            $maxDay = (int)$daysArray[1];
        else
            $maxDay = (int)$daysArray[0];

        return DeclesionsOfWord::make($maxDay, ['день', 'дня', 'дней']);
    }

    private function getParcelParameters($json)
    {
        return json_decode($json, true);
    }
}