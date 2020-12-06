<?php

namespace App\Libraries\Services\Shipment\Contracts;

interface ShipmentServices
{
    public function getDeliveryCost($parcelData);

    public function getPointsInCity();
}