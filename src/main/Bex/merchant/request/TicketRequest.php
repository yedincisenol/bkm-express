<?php

namespace Bex\merchant\request;

class TicketRequest
{
    private $type;
    private $installmentUrl;
    private $nonceUrl;
    private $amount ;
    private $orderId;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }



    /**
     * @return mixed
     */
    public function getInstallmentUrl()
    {
        return $this->installmentUrl;
    }

    /**
     * @param mixed $installmentUrl
     */
    public function setInstallmentUrl($installmentUrl)
    {
        $this->installmentUrl = $installmentUrl;
    }

    /**
     * @return mixed
     */
    public function getNonceUrl()
    {
        return $this->nonceUrl;
    }

    /**
     * @param mixed $nonceUrl
     */
    public function setNonceUrl($nonceUrl)
    {
        $this->nonceUrl = $nonceUrl;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

}
