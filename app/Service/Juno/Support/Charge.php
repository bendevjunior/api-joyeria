<?php

namespace App\Service\Juno\Support;

class Charge 
{

    public $token; //required
    public $description; //required
    public $reference; //required id que o sistema informa qnd tiver o callback 
    public $amount;  //required valor de cada parcela
    public $totalAmount; //caso seja parcelado
    public $dueDate; //required - dd/mm/yyyy
    public $installments; //Número de parcelas da cobrança - default 1
    public $maxOverdueDays; // Número máximo de dias que o boleto poderá ser pago após o vencimento
    public $fine; //Multa para pagamento após o venciment | Só é efetivo se maxOverdueDays for maior que zero | Formato: Decimal, separado por ponto. Maior ou igual a 0.00 e menor ou igual a 20.00 (2.00 é o valor máximo permitido por lei)
    public $interest; //Juro mensal para pagamento após o vencimento | Só é efetivo se maxOverdueDays for maior que zero
    public $discountAmount; //Valor do desconto | Decimal, separado por ponto. Maior ou igual a 0.00 e menor que o valor da cobrança (amount)
    public $discountDays; //Dias concessão de desconto para pagamento antecipado. Exemplo: Até 10 dias antes do vencimento. Formato: Número inteiro maior ou igual a -1
    public $notificationUrl; //Define uma URL de notificação para que o Boleto Fácil envie notificações ao seu sistema sempre que houver algum evento de pagamento desta cobrança.
    public $responseType; //Define o tipo de resposta à esta requisição | Formato: JSON ou XML | Valor padrão: JSON
    public $feeSchemaToken; //Define o token de um esquema de taxas e comissionamento alternativo
    public $splitRecipient; //Destinatário da divisão de receitas (split), caso os boletos sejam emitidos pelo "dono" do esquema de taxas e comissionamento (split invertido)
    public $paymentTypes; // Define o(s) tipo(s) de pagamento da cobrança | Formato: BOLETO e/ou CREDIT_CARD
    public $creditCardHash; //Hash referente aos dados criptografados do cartão de crédito
    public $creditCardStore; // Define se os dados do cartão de crédito serão armazenados. | Se definido como true, será retornado uma identificação única do cartão de crédito (creditCardId) que poderá ser utilizado para pagamentos futuros. | Formato: true ou false | Valor padrão: false
    public $creditCardId; // Identificação única do cartão de crédito previamente armazenado | Formato: Código de identificação do cartão de crédito
    public $paymentAdvance; // Define se o pagamento via cartão de crédito será antecipado | Formato: true ou false | Valor padrão: false

    function __construct(String $description, String $reference, $amount, $dueDate) 
    {
        $this->description  = $description;
        $this->reference    = $reference;
        $this->amount       = $amount;
        $this->dueDate      = $dueDate;
    }
}