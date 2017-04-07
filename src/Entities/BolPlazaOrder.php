<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaOrder
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $OrderId
 * @property string $DateTimeCustomer
 * @property string $DateTimeDropShipper
 * @property BolPlazaCustomerDetails $CustomerDetails
 * @property BolPlazaOrderItem[] $OrderItems
 */
class BolPlazaOrder extends BaseModel {

    protected $xmlEntityName = 'Order';

    protected $attributes = [
        'OrderId',
        'DateTimeCustomer',
        'DateTimeDropShipper'
    ];

    protected $nestedEntities = [
        'CustomerDetails' => 'BolPlazaCustomerDetails'
    ];

    protected $childEntities = [
        'OrderItems' => [
            'childName' => 'OrderItem',
            'entityClass' => 'BolPlazaOrderItem'
        ]
    ];
}
