<?php


namespace App\Libraries\Services\Shipment;

use App\Libraries\Services\Shipment\Contracts\ShipmentServices;
use App\Facades\GlobalData;
use App\Models\Shop\Product\Product;

class OwnShipment implements ShipmentServices
{
    private $geoData;

    private $shipmentService;

    public function __construct($geoData, $shipmentService)
    {
        $this->shipmentService = $shipmentService;

        $this->geoData = $geoData;
    }

    public function getDeliveryCost($parcelData)
    {
        switch ($this->shipmentService->type) {
            case 'toTerminal' :
                if($this->geoData['region_code'] === '31') {
                    return [
                        "price" => [0],
                        "days" => [$this->shipmentService->processing_time],
                        "service_id" => "toTerminal",
                    ];
                }
                break;
        }

        return null;

    }

    public function getPointsInCity()
    {
        $data = [];

        $dataMarker = [
            'title' => 'Офис компании ' . GlobalData::getParameter('info.company_name'),
            'address' => GlobalData::getParameter('info.address'),
            'timeTable' => $this->getTimeTablePoint(),
        ];

        $data[] = [
            'geoCoordinates' => [
                'longitude' => '36.576676',
                'latitude' => '50.520770',
                ],
            'markerInfo' => view('_kp.modules.shop.shipment._elements.marker', ['point' => $dataMarker])->render(),
        ];

        return $data;
    }

    private function getTimeTablePoint()
    {
        return [
            ['day' => 'Пн', 'time' => '10:00 - 19:00'],
            ['day' => 'Вт', 'time' => '10:00 - 19:00'],
            ['day' => 'Ср', 'time' => '10:00 - 19:00'],
            ['day' => 'Чт', 'time' => '10:00 - 19:00'],
            ['day' => 'Пт', 'time' => '10:00 - 19:00'],
            ['day' => 'Сб', 'time' => '10:00 - 18:00'],
            ['day' => 'Вс', 'time' => 'Выходной'],
        ];
    }

}