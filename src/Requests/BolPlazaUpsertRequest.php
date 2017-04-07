<?php

namespace Wienkit\BolPlazaClient\Requests;

use Wienkit\BolPlazaClient\Entities\BaseModel;
use Wienkit\BolPlazaClient\Entities\BolPlazaRetailerOffer;

/**
 * Class BolPlazaUpsertRequest
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property BolPlazaRetailerOffer RetailerOffer
 */
class BolPlazaUpsertRequest extends BaseModel {

    protected $xmlEntityName = 'UpsertRequest';

    protected $nestedEntities = [
        'RetailerOffer' => 'BolPlazaRetailerOffer'
    ];
}
