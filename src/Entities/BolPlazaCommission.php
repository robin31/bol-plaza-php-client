<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaCommission
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $FixedAmount
 * @property string $Percentage
 * @property string $TotalCost
 * @property string $TotalCostWithoutReduction
 * @property BolPlazaReduction[] $Reductions
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
