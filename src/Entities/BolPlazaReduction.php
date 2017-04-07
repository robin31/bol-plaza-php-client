<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaReduction
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $MaximumPrice
 * @property string $CostReduction
 * @property string $StartDate
 * @property string $EndDate
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
