<?php
/**
 * Created by IntelliJ IDEA.
 * User: mrpehlivan
 * Date: 19/01/2017
 * Time: 15:55
 */

namespace Bex\merchant\response\nonce;


use Bex\merchant\response\PaymentResultResponse;

class NonceResultResponse
{
    public $code;
    public $call;
    public $description;
    public $message;
    public $result;
    public $parameters;
    public $bkmTokenId;
    public $totalAmount;
    public $installmentCount;
    public $cardFirst6;
    public $cardLast4;
    public $paymentPurchased;
    public $status;
    public $posResult;
    public $error;

    /**
     * NonceResultResponse constructor.
     * @param $code
     * @param $call
     * @param $description
     * @param $message
     * @param $result
     * @param $parameters
     * @param $bkmTokenId
     * @param $totalAmount
     * @param $installmentCount
     * @param $cardFirst6
     * @param $cardLast4
     * @param $paymentPurchased
     * @param $status
     * @param $posResult
     * @param $error
     */
    public function __construct($code, $call, $description, $message, $result, $parameters, $bkmTokenId, $totalAmount, $installmentCount, $cardFirst6, $cardLast4, $paymentPurchased, $status, $posResult, $error)
    {
        $this->code = $code;
        $this->call = $call;
        $this->description = $description;
        $this->message = $message;
        $this->result = $result;
        $this->parameters = $parameters;
        $this->bkmTokenId = $bkmTokenId;
        $this->totalAmount = $totalAmount;
        $this->installmentCount = $installmentCount;
        $this->cardFirst6 = $cardFirst6;
        $this->cardLast4 = $cardLast4;
        $this->paymentPurchased = $paymentPurchased;
        $this->status = $status;
        $this->posResult = new PosResult($posResult);
        $this->error = $error;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCall()
    {
        return $this->call;
    }

    /**
     * @param mixed $call
     */
    public function setCall($call)
    {
        $this->call = $call;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getBkmTokenId()
    {
        return $this->bkmTokenId;
    }

    /**
     * @param mixed $bkmTokenId
     */
    public function setBkmTokenId($bkmTokenId)
    {
        $this->bkmTokenId = $bkmTokenId;
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
    public function getInstallmentCount()
    {
        return $this->installmentCount;
    }

    /**
     * @param mixed $installmentCount
     */
    public function setInstallmentCount($installmentCount)
    {
        $this->installmentCount = $installmentCount;
    }

    /**
     * @return mixed
     */
    public function getCardFirst6()
    {
        return $this->cardFirst6;
    }

    /**
     * @param mixed $cardFirst6
     */
    public function setCardFirst6($cardFirst6)
    {
        $this->cardFirst6 = $cardFirst6;
    }

    /**
     * @return mixed
     */
    public function getCardLast4()
    {
        return $this->cardLast4;
    }

    /**
     * @param mixed $cardLast4
     */
    public function setCardLast4($cardLast4)
    {
        $this->cardLast4 = $cardLast4;
    }

    /**
     * @return mixed
     */
    public function getPaymentPurchased()
    {
        return $this->paymentPurchased;
    }

    /**
     * @param mixed $paymentPurchased
     */
    public function setPaymentPurchased($paymentPurchased)
    {
        $this->paymentPurchased = $paymentPurchased;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getPosResult()
    {
        return $this->posResult;
    }

    /**
     * @param mixed $posResult
     */
    public function setPosResult($posResult)
    {
        $this->posResult = $posResult;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }


}