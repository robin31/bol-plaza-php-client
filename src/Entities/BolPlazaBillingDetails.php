<?php

namespace Wienkit\BolPlazaClient\Entities;

/**
 * Class BolPlazaBillingDetails
 * @package Wienkit\BolPlazaClient\Entities
 *
 * @param string $SalutationCode
 * @param string $FirstName
 * @param string $Surname
 * @param string $Streetname
 * @param string $Housenumber
 * @param string $HousenumberExtended
 * @param string $AddressSupplement
 * @param string $ExtraAddressInformation
 * @param string $ZipCode
 * @param string $City
 * @param string $CountryCode
 * @param string $Email
 * @param string $DeliveryPhoneNumber
 * @param string $Company
 * @param string $VatNumber
 */
class BolPlazaBillingDetails extends BolPlazaShipmentDetails {

    protected $xmlEntityName = 'BillingDetails';

}