<?php

namespace App\Service\Juno\Support;

class Payer 
{

    public $payerName; //required
    public $payerCpfCnpj; //required
    public $payerEmail;
    public $payerSecondaryEmail; 
    public $payerPhone;
    public $payerBirthDate;
    public $billingAddressStreet;
    public $billingAddressNumber;
    public $billingAddressComplement;
    public $billingAddressNeighborhood;
    public $billingAddressCity;
    public $billingAddressState;
    public $billingAddressPostcode;
    public $notifyPayer; // se true a juno informa o comprador (DEFAULT true)


    function __construct(String $payerName, String $payerCpfCnpj) 
    {
        $this->payerName       = $payerName;
        $this->payerCpfCnpj    = $payerCpfCnpj;
    }
}