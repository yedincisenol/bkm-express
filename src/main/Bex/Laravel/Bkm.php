<?php

namespace Bex\Laravel;

use Bex\config\BexPayment;
use Bex\merchant\request\InstallmentRequest;
use Bex\merchant\request\NonceRequest;
use Bex\merchant\request\VposConfig;
use Bex\merchant\response\InstallmentsResponse;
use Bex\merchant\response\nonce\MerchantNonceResponse;
use Bex\merchant\security\EncryptionUtil;
use Bex\merchant\service\MerchantService;

class Bkm
{
    /**
     * Config variables.
     *
     * @var
     */
    private $config;

    /**
     * Ticket object.
     *
     * @var
     */
    private $ticket;

    /**
     * @var
     */
    private $bkmConfig;

    /**
     * Bkm constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Init BKM express config;.
     *
     * @return mixed
     */
    public function config()
    {
        return BexPayment::startBexPayment(
            $this->config['environment'],
            $this->config['merchant_id'],
            $this->config['private_key']
        );
    }

    /**
     * Get connection tkoen.
     *
     * @param $config
     *
     * @return mixed
     */
    private function merchantService($config)
    {
        return new MerchantService($config);
    }

    /**
     * @param $amount
     *
     * @return mixed
     */
    public function init($amount)
    {
        //BKM Config
        $this->bkmConfig = $this->config();
        $merchantService = $this->merchantService($this->bkmConfig);
        $connectionToken = $merchantService->login()->getToken();
        $this->ticket = $merchantService->oneTimeTicketWithoutInstallmentUrlWithNonce(
            $connectionToken, $amount, url(config('bkmexpress.nonce_path'))
        );

        return $this;
    }

    /**
     * Check payment status.
     *
     * @param $ticketID
     *
     * @return bool
     */
    public function check($ticketID)
    {
        $merchantService = $this->merchantService($this->config());
        $merchantResponse = $merchantService->login();
        $paymentStatus = $merchantService->result(
            $merchantResponse->getConnectionToken(),
            $merchantResponse->getPath(),
            $ticketID
        );

        if ($paymentStatus->status == 'ok' &&
            $paymentStatus->posResult->orderId &&
            $paymentStatus->paymentPurchased == 1) {
            return true;
        }

        return false;
    }

    /**
     * Return active ticket.
     *
     * @return mixed
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Return bkm config object.
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->bkmConfig;
    }

    /**
     * Get installments.
     *
     * @param InstallmentRequest $installmentRequest
     *
     * @return array|\Bex\merchant\response\Installment
     */
    private function installment(InstallmentRequest $installmentRequest)
    {
        $posConfig = $this->posConfig();

        $installmentAmount = \Bex\util\MoneyUtils::toFloat($installmentRequest->getTotalAmount());
        $installmentAmount = \Bex\util\MoneyUtils::formatTurkishLira($installmentAmount);

        $installment = new \Bex\merchant\response\Installment(
            1, $installmentAmount, '', $installmentRequest->getTotalAmount(), $posConfig
        );

        $installment = [
            'numberOfInstallment' => $installment->getNumberOfInstallment(),
            'installmentAmount'   => $installment->getInstallmentAmount(),
            'totalAmount'         => $installment->getTotalAmount(),
            'vposConfig'          => $installment->getVposConfig(),
        ];

        return $installment;
    }

    /**
     * @param $request
     *
     * @return bool
     */
    public function security($request)
    {
        return EncryptionUtil::verifyBexSign($request->getTicketId(), $request->getSignature());
    }

    /**
     * Pos information.
     *
     * @param $bins
     * @param $totalAmount
     * @param $ticketId
     * @param $signature
     *
     * @return \Bex\merchant\response\BinAndInstallments
     */
    public function pos($bins, $totalAmount, $ticketId, $signature)
    {
        $installmentRequest = new InstallmentRequest(
            $bins, $totalAmount, $ticketId, $signature
        );

        $binAndBank = $installmentRequest->getBinNo()[0];

        $this->security($installmentRequest);

        foreach ($bins as $bin) {
            list($binCode, $bankBin) = explode('@', $binAndBank);
            $installments = $this->installment($installmentRequest);
            $binAndInstallments = new \Bex\merchant\response\BinAndInstallments();
            $installmentResponse = new InstallmentsResponse();
            $installmentResponse->setInstallments($installments);
            $installmentResponse->setStatus('ok');
            $installmentResponse->setBin($binCode);
            $installment = [];

            $installment[$installmentResponse->getBin()] = $installmentResponse->getInstallments();
            $binAndInstallments->setInstallments($installment);
        }

        return $binAndInstallments;
    }

    /**
     * Retrievs post config.
     *
     * @return VposConfig
     */
    private function posConfig()
    {
        $posConfig = new VposConfig();
        $posConfig->setVposUserId(array_get($this->config, 'pos.user_id'));
        $posConfig->setVposPassword(array_get($this->config, 'pos.password'));
        $posConfig->addExtra('ClientId', array_get($this->config, 'pos.client_id'));
        $posConfig->addExtra('storekey', array_get($this->config, 'pos.store_key'));
        $posConfig->setBankIndicator(array_get($this->config, 'pos.bank_bin'));
        $posConfig->setServiceUrl(array_get($this->config, 'pos.url'));

        return $posConfig;
    }

    /**
     * Nonce request object.
     *
     * @param $id
     * @param $path
     * @param $issuer
     * @param $approver
     * @param $token
     * @param $signature
     * @param $reply
     *
     * @return NonceRequest
     */
    public function nonceRequest($id, $path, $issuer, $approver, $token, $signature, $reply)
    {
        return new NonceRequest($id, $path, $issuer, $approver, $token, $signature, $reply);
    }

    /**
     * @param NonceRequest $request
     * @param string       $message
     * @param bool         $result
     *
     * @return MerchantNonceResponse
     */
    public function sendNonceResponse(NonceRequest $request, $message = '', $result = false)
    {
        $merchantService = $this->merchantService($this->config());
        $merchantResponse = $merchantService->login();
        $nonceResponse = new MerchantNonceResponse();

        $nonceResponse->setResult($result);
        $nonceResponse->setNonce($request->getToken());
        $nonceResponse->setId($request->getPath());
        $nonceResponse->setMessage($message);
        $merchantService->sendNonceResponse($nonceResponse, $merchantResponse->getPath(), $request->getPath(), $merchantResponse->getConnectionToken(), $request->getToken());

        return $nonceResponse;
    }
}
