<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaDeliveryWindowTimeSlot
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @param BolPlazaDeliveryWindowTimeSlot $TimeSlot
 */
class BolPlazaDeliveryWindowTimeSlot extends BaseModel {

    protected $xmlEntityName = 'TimeSlot';

    protected $attributes = [
        'Start',
        'End'
    ];
}
