<?php

namespace Bex\merchant\service;

use Bex\config\Configuration;
use Bex\exceptions\MerchantServiceException;
use Bex\merchant\request\Builder;
use Bex\merchant\request\MerchantLoginRequest;
use Bex\merchant\request\TicketRequest;
use Bex\merchant\response\MerchantLoginResponse;
use Bex\merchant\response\nonce\MerchantNonceResponse;
use Bex\merchant\response\nonce\NonceResultResponse;
use Bex\merchant\response\PaymentResultResponse;
use Bex\merchant\response\TicketResponse;
use Bex\merchant\security\EncryptionUtil;
use Bex\merchant\token\Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use HttpRequestException;

class MerchantService
{
    protected $configuration;

    /**
     * MerchantService constructor.
     *
     * @param $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @throws MerchantServiceException
     *
     * @return MerchantLoginResponse
     */
    public function login()
    {
        $sign = EncryptionUtil::sign($this->configuration->getMerchantId(), $this->configuration->getMerchantPrivateKey());
        $merchantLoginRequest = new MerchantLoginRequest($this->configuration->getMerchantId(), $sign);
        $merchantId = $merchantLoginRequest->getName();
        $merchantSignature = $merchantLoginRequest->getPassword();
        $requestBody = $this->encodeMerchantLoginRequestObject($merchantId, $merchantSignature);
        $client = new Client();

        try {
            $res = $client->request('POST', $this->getMerchantLoginUrl(), $this->postRequestOptionsWithoutToken($requestBody));
            if ($res->getStatusCode() === 200) {
                $bodyData = json_decode($res->getBody()->getContents(), true);

                return new MerchantLoginResponse($bodyData['code'], $bodyData['call'], $bodyData['description'], $bodyData['message'], $bodyData['result'], $bodyData['parameters'], $bodyData['data']['id'], $bodyData['data']['path'], $bodyData['data']['token']);
            }
        } catch (HttpRequestException $exception) {
            throw new MerchantServiceException('Merchant login got connection problem.');
        }
    }

    /**
     * @param $id
     * @param $sign
     *
     * @return array
     */
    public function encodeMerchantLoginRequestObject($id, $sign)
    {
        return json_encode([
            'id'        => $id,
            'signature' => $sign,
        ]);
    }

    /**
     * @return string
     */
    public function getMerchantLoginUrl()
    {
        return $this->configuration->getBexApiConfiguration()->getBaseUrl().'merchant/login';
    }

    /**
     * @param $requestBody
     *
     * @return array
     */
    public function postRequestOptionsWithoutToken($requestBody)
    {
        return [
            'headers' => ['Content-Type' => 'application/json'],
            'curl'    => [CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2],
            'body'    => $requestBody,
        ];
    }

    /**
     * @param Token $connection
     * @param $amount
     * @param $installmentUrl
     *
     * @return TicketResponse
     */
    public function oneTimeTicket(Token $connection, $amount, $installmentUrl)
    {
        $builder = new Builder('payment');
        $builder->setAmount($amount);
        $builder->setInstallmentUrl($installmentUrl);
        $requestBody = Builder::newPayment('payment')->amountAndInstallmentUrl($builder);

        return $this->createOneTimeTicket($requestBody, $connection);
    }

    /**
     * @param TicketRequest $requestBody
     * @param  $token
     *
     * @throws MerchantServiceException
     *
     * @return TicketResponse
     */
    public function createOneTimeTicket($requestBody, Token $token)
    {
        $requestBody = $this->encodeTicketRequestObjectToJson($requestBody);

        try {
            $client = new Client();
            $res = $client->request('POST', $this->getMerchantCreateTicketUrl($token->getPath()), $this->postRequestOptionsWithToken($requestBody, $token->getToken()));
            if ($res->getStatusCode() === 200) {
                $bodyData = json_decode($res->getBody()->getContents(), true);

                return new TicketResponse($bodyData['code'], $bodyData['call'], $bodyData['description'], $bodyData['message'], $bodyData['result'], $bodyData['parameters'], $bodyData['data']['id'], $bodyData['data']['path'], $bodyData['data']['token']);
            }
        } catch (HttpRequestException $exception) {
            throw new MerchantServiceException('Ticket generation got connection problem.');
        }
    }

    /**
     * @param $ticketRequest
     *
     * @return string
     */
    public function encodeTicketRequestObjectToJson(TicketRequest $ticketRequest)
    {
        $amount = $ticketRequest->getAmount() != null ? $ticketRequest->getAmount() : '';
        $nonceUrl = $ticketRequest->getNonceUrl() != null ? $ticketRequest->getNonceUrl() : '';
        $installmentUrl = $ticketRequest->getInstallmentUrl() != null ? $ticketRequest->getInstallmentUrl() : '';
        $orderId = $ticketRequest->getOrderId() != null ? $ticketRequest->getOrderId() : '';
        $tckn = $ticketRequest->getTckn() != null ? $ticketRequest->getTckn() : '';
        $msisdn = $ticketRequest->getMsisdn() != null ? $ticketRequest->getMsisdn() : '';
        $campaignCode = $ticketRequest->getCampaignCode() != null ? $ticketRequest->getCampaignCode() : '';
        $address = $ticketRequest->getAddress() != null ? $ticketRequest->getAddress() : false;
        $agreementUrl = $ticketRequest->getAgreementUrl() != null ? $ticketRequest->getAgreementUrl() : '';
        $jsonArray = [
            'amount'   => $amount,
            'nonceUrl' => $nonceUrl,
            'address'  => (boolean) $address,
        ];

        if (isset($installmentUrl) && strlen($installmentUrl) > 0) {
            $jsonArray['installmentUrl'] = $installmentUrl;
        }
        if (isset($orderId) && strlen($orderId) > 0) {
            $jsonArray['orderId'] = $orderId;
        }
        if (isset($tckn) && isset($tckn['no']) && strlen($tckn['no']) > 0) {
            $jsonArray['tckn'] = $tckn;
        }
        if (isset($msisdn) && isset($msisdn['no']) && strlen($msisdn['no']) > 0) {
            $jsonArray['msisdn'] = $msisdn;
        }
        if (isset($campaignCode) && strlen($campaignCode) > 0) {
            $jsonArray['campaignCode'] = $campaignCode;
        }

        if (isset($agreementUrl) && strlen($agreementUrl) > 0) {
            $jsonArray['agreementUrl'] = $agreementUrl;
        }

        return json_encode($jsonArray);
    }

    /**
     * @param $merchantPath
     *
     * @return string
     */
    public function getMerchantCreateTicketUrl($merchantPath)
    {
        return $this->configuration->getBexApiConfiguration()->getBaseUrl().'merchant/'.$merchantPath.'/ticket?type=payment';
    }

    /**
     * @param $requestBody
     * @param $token
     *
     * @return array
     */
    public function postRequestOptionsWithToken($requestBody, $token)
    {
        return [
            'headers' => ['Content-Type' => 'application/json', 'Bex-Connection' => $token],
            'curl'    => [CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2],
            'body'    => $requestBody,
        ];
    }

    /**
     * @param Token $connection
     * @param $amount
     * @param $installmentUrl
     * @param $nonceUrl
     *
     * @return TicketResponse
     */
    public function oneTimeTicketWithNonce(Token $connection, $amount, $installmentUrl, $nonceUrl)
    {
        $builder = new Builder('payment');
        $builder->setAmount($amount);
        $builder->setInstallmentUrl($installmentUrl);
        $builder->setNonceUrl($nonceUrl);
        $requestBody = Builder::newPayment('payment')->amountAndInstallmentUrl($builder);

        return $this->createOneTimeTicket($requestBody, $connection);
    }

    /**
     * @param Token $connection
     * @param $amount
     *
     * @return TicketResponse
     */
    public function oneTimeTicketWithoutInstallmentUrl(Token $connection, $amount)
    {
        $builder = new Builder('payment');
        $builder->setAmount($amount);

        $requestBody = Builder::newPayment('payment')->amountAndInstallmentUrl($builder);

        return $this->createOneTimeTicket($requestBody, $connection);
    }

    /**
     * @param Token $connection
     * @param $amount
     * @param $nonceUrl
     *
     * @return TicketResponse
     */
    public function oneTimeTicketWithoutInstallmentUrlWithNonce(Token $connection, $amount, $nonceUrl)
    {
        $builder = new Builder('payment');
        $builder->setAmount($amount);
        $builder->setNonceUrl($nonceUrl);
        $requestBody = Builder::newPayment('payment')->amountAndInstallmentUrl($builder);

        return $this->createOneTimeTicket($requestBody, $connection);
    }

    /**
     * @param Token   $connection
     * @param Builder $builder
     *
     * @return TicketResponse
     */
    public function oneTimeTicketWithBuilder(Token $connection, Builder $builder)
    {
        $requestBody = $builder;

        return $this->createOneTimeTicket($requestBody, $connection);
    }

    /**
     * @param $token
     * @param $connectionId
     * @param $ticketId
     *
     * @throws MerchantServiceException
     *
     * @return PaymentResultResponse
     */
    public function result($token, $connectionId, $ticketId)
    {
        $client = new Client();

        try {
            $res = $client->request('POST', $this->getMerchantResultUrl($connectionId, $ticketId), $this->getRequestOptions($token));
            if ($res->getStatusCode() === 200) {
                $bodyData = json_decode($res->getBody()->getContents(), true);

                return new PaymentResultResponse($bodyData['code'], $bodyData['call'],
                    $bodyData['description'], $bodyData['message'], $bodyData['result'],
                    $bodyData['parameters'], $bodyData['data']['bkmTokenId'], $bodyData['data']['totalAmount'],
                    $bodyData['data']['installmentCount'], $bodyData['data']['cardFirst6'], $bodyData['data']['cardLast4'],
                    $bodyData['data']['paymentPurchased'], $bodyData['data']['status'], $bodyData['data']['posResult'], $bodyData['data']['cardHash']);
            }
        } catch (HttpRequestException $exception) {
            throw new MerchantServiceException('Ticket result got connection problem.');
        } catch (ServerException $exception) {
            throw new MerchantServiceException($exception->getMessage());
        }
    }

    /**
     * @param $connectionId
     * @param $ticketId
     *
     * @return string
     */
    public function getMerchantResultUrl($connectionId, $ticketId)
    {
        return $this->configuration->getBexApiConfiguration()->getBaseUrl().'merchant/'.$connectionId.'/ticket/'.$ticketId.'/operate?name=result';
    }

    /**
     * @param $token
     *
     * @return array
     */
    public function getRequestOptions($token)
    {
        return [
            'headers' => ['Content-Type' => 'application/json', 'Bex-Connection' => $token],
            'curl'    => [CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2],
        ];
    }

    /**
     * @param MerchantNonceResponse $response
     * @param $connectionId
     * @param $ticketId
     * @param $connectionToken
     * @param $nonceToken
     *
     * @return NonceResultResponse
     */
    public function sendNonceResponse(MerchantNonceResponse $response, $connectionId, $ticketId, $connectionToken, $nonceToken)
    {
        return $this->nonce($response, $connectionId, $ticketId, $connectionToken, $nonceToken);
    }

    /**
     * @param $requestBody
     * @param $connectionId
     * @param $ticketId
     * @param $connectionToken
     * @param $nonceToken
     *
     * @throws MerchantServiceException
     *
     * @return NonceResultResponse
     */
    public function nonce($requestBody, $connectionId, $ticketId, $connectionToken, $nonceToken)
    {
        $requestBody = $this->encodeMerchantNonceRequestObjectToJson($requestBody);

        try {
            $client = new Client();
            $res = $client->request('POST', $this->getMerchantNonceUrl($connectionId, $ticketId), $this->postRequestOptionsWithNonceTokenAndToken($requestBody, $connectionToken, $nonceToken));
            if ($res->getStatusCode() === 200) {
                $bodyData = json_decode($res->getBody()->getContents(), true);

                return new NonceResultResponse(
                    $bodyData['code'], $bodyData['call'],
                    $bodyData['description'], $bodyData['message'], $bodyData['result'],
                    $bodyData['parameters'], $bodyData['data']['bkmTokenId'], $bodyData['data']['totalAmount'],
                    $bodyData['data']['installmentCount'], $bodyData['data']['cardFirst6'], $bodyData['data']['cardLast4'],
                    $bodyData['data']['paymentPurchased'], $bodyData['data']['status'], $bodyData['data']['posResult'], $bodyData['data']['cardHash'], @$bodyData['data']['error']
                );
            }
        } catch (HttpRequestException $exception) {
            throw new MerchantServiceException($exception->getMessage());
        }
    }

    /**
     * @param MerchantNonceResponse $merchantNonceResponse
     *
     * @return mixed
     */
    public function encodeMerchantNonceRequestObjectToJson(MerchantNonceResponse $merchantNonceResponse)
    {
        return json_encode([
            'result'  => $merchantNonceResponse->getResult(),
            'nonce'   => $merchantNonceResponse->getNonce(),
            'id'      => $merchantNonceResponse->getId(),
            'message' => $merchantNonceResponse->getMessage(),
        ]);
    }

    /**
     * @param $connectionId
     * @param $ticketId
     *
     * @return string
     */
    public function getMerchantNonceUrl($connectionId, $ticketId)
    {
        return $this->configuration->getBexApiConfiguration()->getBaseUrl().'merchant/'.$connectionId.'/ticket/'.$ticketId.'/operate?name=commit';
    }

    /**
     * @param $requestBody
     * @param $connectionToken
     * @param $nonceToken
     *
     * @return array
     */
    public function postRequestOptionsWithNonceTokenAndToken($requestBody, $connectionToken, $nonceToken)
    {
        return [
            'headers' => ['Content-Type' => 'application/json', 'Bex-Connection' => $connectionToken, 'Bex-Nonce' => $nonceToken],
            'curl'    => [CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2],
            'body'    => $requestBody,
        ];
    }
}
