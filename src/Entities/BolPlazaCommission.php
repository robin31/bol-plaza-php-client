<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaCommission
 * @package Wienkit\BolPlazaClient\Entities
 *
 */
class BolPlazaCommission extends BaseModel {

    protected $xmlEntityName = 'Order';

    protected $attributes = [
        'FixedAmount',
        'Percentage',
        'TotalCost',
        'TotalCostWithoutReduction'
    ];

    protected $childEntities = [
        'Reductions' => [
            'childName' => 'Reduction',
            'entityClass' => 'BolPlazaReduction'
        ]
    ];
}
