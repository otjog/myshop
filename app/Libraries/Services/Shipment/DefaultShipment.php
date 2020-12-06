<?php

namespace App\Libraries\Services\Shipment;

use App\Libraries\Services\Shipment\Contracts\ShipmentServices;

class DefaultShipment implements ShipmentServices
{
    protected $shipmentService;

    public function __construct($shipmentService)
    {
        $this->shipmentService = $shipmentService;
    }

    public function getDeliveryCost($parcelData)
    {
        return [
            'error' => [
                'message' => 'У данного метода доставки нет Сервиса Расчета Доставки'
            ],
            'days'  => ['~'],
            'price' => ['~'],
        ];
    }

    public function getPointsInCity()
    {
        return [];
    }
}