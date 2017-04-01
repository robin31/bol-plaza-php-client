<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 4/1/17
 * Time: 5:13 PM
 */

namespace Wienkit\BolPlazaClient\Entities;


class BolPlazaRetailerOffer extends BaseModel
{
    protected $xmlEntityName = 'RetailerOffer';

    protected $attributes = [
        'EAN',
        'Condition',
        'Price',
        'DeliveryCode',
        'QuantityInStock',
        'Publish',
        'ReferenceCode',
        'Description',
        'Title',
        'Fulfillment'
    ];
}