<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaInventoryOffer
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $EAN
 * @property string $BSKU
 * @property string $Title
 * @property string $Stock
 * @property string $NCKStock
 */
class BolPlazaInventoryOffer extends BaseModel {

    protected $xmlEntityName = 'Offer';

    protected $attributes = [
        'EAN',
        'BSKU',
        'Title',
        'Stock',
        'NCK-Stock'
    ];
}