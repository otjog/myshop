<?php

namespace App\Models\Shop\Services;

use App\Models\Shop\Order\Shipment;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Delivery\Dpd;
use App\Libraries\Delivery\Cdek;
use App\Libraries\Delivery\Pochta;
use App\Libraries\Delivery\CustomDelivery;
use App\Libraries\Helpers\DeclesionsOfWord;
use App\Models\Geo\GeoData;
use App\Models\Site\Image;

class Delivery extends Model
{
    public function getPrices($parcel, $shipmentServiceAlias, $destinationType, $productIds)
    {
        $shipments = new Shipment();

        $geo = new GeoData();

        $geoData = $geo->getGeoData();

        $shipmentService = $shipments->getShipmentServiceByAlias($shipmentServiceAlias);

        $parcelParameters = $this->getDeliveryDataFromRequest($parcel);

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
                $serviceObj = new CustomDelivery($geoData, $productIds);
                break;

            default : break; //todo сделать выход из foreach

        }

        $data = $serviceObj->getDeliveryCost($parcelParameters, $destinationType);

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

        $geo = new GeoData();

        $geoData = $geo->getGeoData();

        $image = new Image();

        $data = [];

        $serviceObj = null;

        switch ($shipmentServiceAlias) {

            case 'dpd'  : $serviceObj = new Dpd($geoData); break;

            case 'cdek' : $serviceObj = new Cdek($geoData); break;
        }

        if ($serviceObj !== null) {
            $data[$shipmentServiceAlias]['points'] = $serviceObj->getPointsInCity();
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

    private function getDeclisionOfDays($days)
    {
        $daysArray = explode('-', $days);

        if (count($daysArray) > 1)
            $maxDay = (int)$daysArray[1];
        else
            $maxDay = (int)$daysArray[0];

        return DeclesionsOfWord::make($maxDay, ['день', 'дня', 'дней']);
    }
}