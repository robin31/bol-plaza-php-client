<?php
namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaRetailerOfferStatus
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @property string $Published
 * @property string $ErrorCode
 * @property string $ErrorMessage
 */
class BolPlazaRetailerOfferStatus extends BaseModel
{
    protected $xmlEntityName = 'Status';

    protected $attributes = [
        'Published',
        'ErrorCode',
        'ErrorMessage'
    ];
}
