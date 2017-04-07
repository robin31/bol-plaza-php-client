<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaRetailerOfferIdentifier
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $EAN
 * @property string $Condition
 */
class BolPlazaRetailerOfferIdentifier extends BaseModel
{
    protected $xmlEntityName = 'RetailerOfferIdentifier';

    protected $attributes = [
        'EAN',
        'Condition'
    ];
}