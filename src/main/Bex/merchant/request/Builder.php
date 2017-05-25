<?php
namespace Bex\merchant\request;

use Bex\util\MoneyUtils;

class Builder extends TicketRequest
{
    public $ticketRequest;


    public function __construct($type)
    {
        parent::setType($type);
    }

    public static function newPayment($type)
    {
        return new Builder($type);
    }

    public function amountAndInstallmentUrl($amount, $installmentUrl)
    {

        parent::setAmount(MoneyUtils::enforceAmountFormat($amount));
        parent::setInstallmentUrl($installmentUrl);

        return $this;
    }

    public function amountAndInstallmentUrlAndNonceUrl($amount, $installmentUrl, $nonceUrl)
    {

        parent::setAmount(MoneyUtils::enforceAmountFormat($amount));
        parent::setInstallmentUrl($installmentUrl);
        parent::setNonceUrl($nonceUrl);


        return $this;
    }

    public function orderId($orderId)
    {
        parent::setOrderId($orderId);
        return $this;

    }

    public function nonceUrl($nonceUrl)
    {
        parent::setNonceUrl($nonceUrl);
        return $this;
    }

    public function build()
    {
        return $this->ticketRequest;
    }
}