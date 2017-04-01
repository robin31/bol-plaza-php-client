<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaReduction
 * @package Wienkit\BolPlazaClient\Entities
 *
 */
class BolPlazaReduction extends BaseModel {

    protected $xmlEntityName = 'Order';

    protected $attributes = [
        'MaximumPrice',
        'CostReduction',
        'StartDate',
        'EndDate'
    ];
}
