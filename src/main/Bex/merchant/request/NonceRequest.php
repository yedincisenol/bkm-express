<?php

namespace Bex\merchant\request;

class NonceRequest
{

    private $id;
    private $path;
    private $issuer;
    private $approver;
    private $token;
    private $signature;
    private $reply;


    /**
     * NonceRequest constructor.
     * @param $id
     * @param $path
     * @param $issuer
     * @param $approver
     * @param $token
     * @param $signature
     * @param $reply
     */
    public function __construct($id, $path, $issuer, $approver, $token, $signature, $reply)
    {
        $this->id = $id;
        $this->path = $path;
        $this->issuer = $issuer;
        $this->approver = $approver;
        $this->token = $token;
        $this->signature = $signature;
        $this->reply = $reply;
        $this->reply = new NonceData($reply);

        return $this;
    }


    /**
     * @return mixed
     */
    public function getTicketId()
    {
        return $this->reply->getTicketId();
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->reply->getOrderId();
    }


    /**
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->reply->getTotalAmount();
    }


    /**
     * @return mixed
     */
    public function getNumberOfInstallments()
    {
        return $this->reply->getNumberOfInstallments();
    }

    /**
     * @return mixed
     */
    public function getTotalAmountWithInstallmentCharge()
    {
        return $this->reply->getTotalAmountWithInstallmentCharge();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param mixed $issuer
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }

    /**
     * @return mixed
     */
    public function getApprover()
    {
        return $this->approver;
    }

    /**
     * @param mixed $approver
     */
    public function setApprover($approver)
    {
        $this->approver = $approver;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * @param mixed $reply
     */
    public function setReply($reply)
    {
        $this->reply = $reply;
    }




}