<?php

namespace Bex\merchant\request;


class NonceData
{
    private  $ticketId;
    private  $orderId;
    private  $totalAmount;
    private  $totalAmountWithInstallmentCharge;
    private  $numberOfInstallments;


    /**
     * NonceData constructor.
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->ticketId = $reply['ticketId'];
        $this->orderId =  $reply['orderId'];
        $this->totalAmount =  $reply['totalAmount'];
        $this->totalAmountWithInstallmentCharge =  $reply['totalAmountWithInstallmentCharge'];
        $this->numberOfInstallments =  $reply['numberOfInstallments'];
        return $this;
    }


    /**
     * @return mixed
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * @param mixed $ticketId
     */
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;
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

    /**
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param mixed $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return mixed
     */
    public function getTotalAmountWithInstallmentCharge()
    {
        return $this->totalAmountWithInstallmentCharge;
    }

    /**
     * @param mixed $totalAmountWithInstallmentCharge
     */
    public function setTotalAmountWithInstallmentCharge($totalAmountWithInstallmentCharge)
    {
        $this->totalAmountWithInstallmentCharge = $totalAmountWithInstallmentCharge;
    }

    /**
     * @return mixed
     */
    public function getNumberOfInstallments()
    {
        return $this->numberOfInstallments;
    }

    /**
     * @param mixed $numberOfInstallments
     */
    public function setNumberOfInstallments($numberOfInstallments)
    {
        $this->numberOfInstallments = $numberOfInstallments;
    }



}