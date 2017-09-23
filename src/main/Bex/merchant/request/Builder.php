<?php

namespace Bex\merchant\request;

use Bex\util\MoneyUtils;

class Builder extends TicketRequest
{
    private $ticketRequest;


    public function __construct($type)
    {
        parent::setType($type);
    }

    public static function newPayment($type)
    {
        return new Builder($type);
    }

    public function amountAndInstallmentUrl(Builder $builder)
    {
        $this->amount(MoneyUtils::enforceAmountFormat($builder->getAmount()));
        $this->installmentUrl($builder->getInstallmentUrl());
        $this->nonceUrl($builder->getNonceUrl());
        $this->campaignCode($builder->getCampaignCode());
        $this->orderId($builder->getOrderId());
        if ($builder->getTckn() != null) {
            $this->tckn($builder->getTckn()['no'], $builder->getTckn()['check']);
        }

        if ($builder->getMsisdn() != null) {
            $this->msisdn($builder->getMsisdn()['no'], $builder->getMsisdn()['check']);
        }
        $this->agreementUrl($builder->getAgreementUrl());
        $this->address($builder->getAddress());
        return $this;

    }

    public function amount($amount)
    {
        if ($amount == null) {
            return $this;
        }
        parent::setAmount($amount);
        return $this;
    }

    public function installmentUrl($installmentUrl)
    {
        if ($installmentUrl == null) {
            return $this;
        }
        parent::setInstallmentUrl($installmentUrl);
        return $this;
    }

    public function nonceUrl($nonceUrl)
    {
        if ($nonceUrl == null) {
            return $this;
        }
        parent::setNonceUrl($nonceUrl);
        return $this;
    }

    public function campaignCode($campaignCode)
    {
        if ($campaignCode == null) {
            return $this;
        }
        parent::setCampaignCode($campaignCode);
        return $this;
    }

    public function orderId($orderId)
    {
        if ($orderId == null) {
            return $this;
        }
        parent::setOrderId($orderId);
        return $this;
    }

    public function tckn($number, $check)
    {
        if ($number == null) {
            return $this;
        }
        parent::setTckn(array('no' => $number, 'check' => $check));
        return $this;
    }

    public function msisdn($phoneNumber, $check)
    {
        if ($phoneNumber == null) {
            return $this;
        }
        parent::setMsisdn(array(
            'no' => $phoneNumber,
            'check' => $check
        ));
        return $this;
    }

    public function agreementUrl($agreementUrl)
    {
        if ($agreementUrl == null) {
            return $this;
        }
        parent::setAgreementUrl($agreementUrl);
        return $this;
    }

    public function address($address)
    {
        if ($address == null) {
            return $this;
        }
        parent::setAddress($address);
        return $this;
    }

    public function build()
    {
        return $this->ticketRequest;
    }
}