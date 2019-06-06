<?php

namespace App\Service\Juno;

use App\Service\Juno\Support\Charge;
use App\Service\Juno\Support\Payer;
use Carbon\Carbon;

class JunoService 
{
    private $url_create_charge = 'https://sandbox.boletobancario.com/boletofacil/integration/api/v1/issue-charge';
    private $token = "73A1E357342EA88C7B9C187B0569E01F5B6C56790BFFEBC56BA14404E229C694";

    public $payer;
    public $charge;

    function __construct() 
    {
        
    }

    public function create_charge (Payer $payer, Charge $charge)
    {
        $this->payer = $payer;
        $this->charge = $charge;
    }

    public function generate_boleto()
    {
        $client = new \GuzzleHttp\Client();
        
        $body['token'] = $this->token;
        $body['description'] = $this->charge->description;
        $body['reference'] = $this->charge->reference;
        $body['amount'] = $this->charge->amount;
        $body['totalAmount'] = $this->charge->totalAmount;
        $body['dueDate'] = Carbon::parse($this->charge->dueDate)->format('d/m/Y');
        $body['installments'] = $this->charge->installments;
        $body['maxOverdueDays'] = $this->charge->maxOverdueDays;
        $body['fine'] = $this->charge->fine;
        $body['interest'] = $this->charge->interest;
        $body['discountAmount'] = $this->charge->discountAmount;
        $body['discountDays'] = $this->charge->discountDays;

        $body['payerName'] = $this->payer->payerName;
        $body['payerCpfCnpj'] = $this->payer->payerCpfCnpj;
        $body['payerEmail'] = $this->payer->payerEmail;
        $body['payerSecondaryEmail'] = $this->payer->payerSecondaryEmail;
        $body['payerPhone'] = $this->payer->payerPhone;
        $body['payerBirthDate'] = $this->payer->payerBirthDate;
        $body['billingAddressStreet'] = $this->payer->billingAddressStreet;
        $body['billingAddressNumber'] = $this->payer->billingAddressNumber;
        $body['billingAddressComplement'] = $this->payer->billingAddressComplement;
        $body['billingAddressNeighborhood'] = $this->payer->billingAddressNeighborhood;
        $body['billingAddressCity'] = $this->payer->billingAddressCity;
        $body['billingAddressState'] = $this->payer->billingAddressState;
        $body['billingAddressPostcode'] = $this->payer->billingAddressPostcode;
        $body['notifyPayer'] = $this->payer->notifyPayer;

        $body['notificationUrl'] = $this->charge->notificationUrl;
        $body['responseType'] = $this->charge->responseType;
        $body['feeSchemaToken'] = $this->charge->feeSchemaToken;
        $body['splitRecipient'] = $this->charge->splitRecipient;
        $body['paymentTypes'] = $this->charge->paymentTypes;
        $body['creditCardHash'] = $this->charge->creditCardHash;
        $body['creditCardStore'] = $this->charge->creditCardStore;
        $body['creditCardId'] = $this->charge->creditCardId;
        $body['paymentAdvance'] = $this->charge->paymentAdvance;

        $request = $client->request("POST",$this->url_create_charge,  ['form_params'=>$body]);
        $json =  $request->getBody()->getContents(); // retorno em json
        return json_decode($json);
  
        //return $response;
    }
}