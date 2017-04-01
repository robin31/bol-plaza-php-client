<?php

namespace Wienkit\BolPlazaClient\Entities;


class BolPlazaRetailerOfferIdentifier extends BaseModel
{
    protected $xmlEntityName = 'BolPlazaRetailerOfferIdentifier';

    protected $attributes = [
        'EAN',
        'Condition'
    ];
}