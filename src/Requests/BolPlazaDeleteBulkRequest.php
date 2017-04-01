<?php

namespace Wienkit\BolPlazaClient\Requests;

use Wienkit\BolPlazaClient\Entities\BaseModel;
use Wienkit\BolPlazaClient\Entities\BolPlazaRetailerOfferIdentifier;

/**
 * Class BolPlazaOfferCreate
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property BolPlazaRetailerOfferIdentifier RetailerOfferIdentifier
 */
class BolPlazaDeleteBulkRequest extends BaseModel {

    protected $xmlEntityName = 'DeleteBulkRequest';

    protected $childEntities = [
        'RetailerOfferIdentifier' => [
            'childName' => 'RetailerOfferIdentifier',
            'entityClass' => 'BolPlazaRetailerOfferIdentifier'
        ]
    ];
}
