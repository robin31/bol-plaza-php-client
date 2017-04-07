<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaShipment
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $ShipmentId
 * @property string $ShipmentDate
 * @property string $DateTimeDropShipper
 * @property BolPlazaShipmentDetails $CustomerDetails
 * @property BolPlazaShipmentTransport $Transport
 * @property BolPlazaShipmentItem[] $ShipmentItems
 */
class BolPlazaShipment extends BaseModel {

    protected $xmlEntityName = 'Shipment';

    protected $attributes = [
        'ShipmentId',
        'ShipmentDate',
        'DateTimeDropShipper'
    ];

    protected $nestedEntities = [
        'CustomerDetails' => 'BolPlazaShipmentDetails',
        'Transport' => 'BolPlazaShipmentTransport'
    ];

    protected $childEntities = [
        'ShipmentItems' => [
            'childName' => 'ShipmentItem',
            'entityClass' => 'BolPlazaShipmentItem'
        ]
    ];
}
