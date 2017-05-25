<?php
require_once dirname(dirname(dirname(__DIR__)))."/src/main/Bex/Bex.php";

use \Bex\config\BexPayment;
use Bex\enums\Banks;
use Bex\merchant\request\InstallmentRequest;
use Bex\merchant\request\NonceRequest;
use Bex\merchant\response\BinAndInstallments;
use Bex\merchant\response\Installment;
use Bex\merchant\response\InstallmentsResponse;
use Bex\merchant\response\nonce\MerchantNonceResponse;
use Bex\merchant\security\EncryptionUtil;
use Bex\merchant\service\MerchantService;
use Bex\util\MoneyUtils;
use Bex\merchant\request\VposConfig;

class SampleSetup
{
    const merchantSecretKey = "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAOLA7InQdCbT8n5Rx8zk8uSCFQ5q4Tyxl0Kr02DoykWxLMBUl1p0YU9hoiocv6Hako5rZssHG0Eb4prh2nmZNpyfhOoOw48Pzg3eB7hKjpXLEPKdK8oemonBcvJ+E9/at4KLg4epyGum1cGdiaYkVF8frG+z53b0ngEq7/CzU8htAgMBAAECgYBNn6OZzf1lKVsy+QX/00R/CzTwGZB/eYABd9bFrwtHbk6WjJ6/fWWuigq8hdjoLG3NSWEIEae30zbwtG5ZACUcNa00Ar9mjsQncZXvLXp9hNb6/TR/mKQvZTjXgoRgn/ltS48GSpqWKbmKVl5JQWgNTb1zHGs2igBb161/ag16tQJBAPzVo2YAVcqXCvuNEWhkqsW1+74GSCrX5QcQwv8qwpt7raumojoFCdeW+xt1Je/bsw01pywkvI3cIO0pdHKwDDcCQQDll7GOPUT/q3Gvmw+kCTnvEH/yYSR2XsPLfEvewxp7SbFI1orLO61A+r5uLDGcfPoxQ7AORzf/OpSfNTD7IGZ7AkAUs5Fbaq+blN5rVlOUjpmE8q+YEX+bMm4oM/EjX2brwCaqJUynH358znnk96SRjRWOAVScwq1FmD6B7KECOvPlAkEA4GaWlXbPFLFGKaP98o9N/5p547YMxGE1L5LqOO0q2euaCp4fBCrs2MD7FYW+a7w/cZ0924bCdYSVNNLxb9IoNwJAJ6PVEsZWT5uGTxqlbTBDFSjHF79OLFWllHsa+2uwf/f6OwNAAMagVbWSdAIlZtaiifDhhXkC4h3ozI1f3xolJg==";
    const environment = 'DEV';
    const merchantId = '219be6b7-b3ca-4bd1-9886-a16d40b0bfe2';

    const INSTALLMENT_URL = "http://bex-demo-php.finartz.com/index.php?installment=checkout";
    const CUSTOM_INSTALLMENT_URL = "http://bex-demo-php.finartz.com/customController.php?installment=custom";
    const NONCE_URL = "http://bex-demo-php.finartz.com/customController.php?nonce=custom";

    public $success;
    public $amount ;
    public $baseJsUrl ;
    public $ticketId ;
    public $ticketPath ;
    public $ticketToken ;
    public $merchantToken ;
    public $config ;
    public $connectionId;
    public $baseUrl;
    public $customData;
    public $merchantNonceResponseData;


    /**
     * SampleSetup constructor.
     */
    public function __construct($data,$integrationType)
    {
        if($integrationType =="custom"){
            $config = BexPayment::startBexPayment(self::environment,$data->merchantId,$data->merchantPrivateKey);
            $merchantService = new MerchantService($config);
            $merchantResponse = $merchantService->login();
            $this->setCustomData($data);
            if($data->sendInstallmentUrl){
                if($data->useNonce){
                    $ticketResponse = $merchantService->oneTimeTicketWithNonce($merchantResponse->getToken(), $data->amount, self::CUSTOM_INSTALLMENT_URL,self::NONCE_URL);
                }else{
                    $ticketResponse = $merchantService->oneTimeTicket($merchantResponse->getToken(), $data->amount, self::CUSTOM_INSTALLMENT_URL);
                }
            }else{
                if($data->useNonce){
                    $ticketResponse = $merchantService->oneTimeTicketWithoutInstallmentUrlWithNonce($merchantResponse->getToken(), $data->amount,self::NONCE_URL);
                }else{
                    $ticketResponse = $merchantService->oneTimeTicketWithoutInstallmentUrl($merchantResponse->getToken(), $data->amount);

                }
            }

            if($merchantResponse->getResult() == 'ok' && $ticketResponse->getResult() == 'ok'){
                $this->success = true;
                $this->amount = $data->amount;
                $this->baseJsUrl = $config->getBexApiConfiguration()->getBaseJs();
                $this->ticketId = $ticketResponse->getTicketShortId();
                $this->ticketPath = $ticketResponse->getTicketPath();
                $this->ticketToken = $ticketResponse->getTicketToken();
                $this->merchantToken = $merchantResponse->getConnectionToken();
                $this->config = $config;
                $this->connectionId = $merchantResponse->getPath();
                $this->baseUrl = $config->getBexApiConfiguration()->getBaseUrl();
                $this->merchantNonceResponseData = $merchantResponse;

                return $this;
            }
        }else{
            $config = BexPayment::startBexPayment(self::environment,self::merchantId,self::merchantSecretKey);
            $merchantService = new MerchantService($config);
            $merchantResponse = $merchantService->login();
            $ticketResponse = $merchantService->oneTimeTicket($merchantResponse->getToken(), "1000,52", self::INSTALLMENT_URL);
            if($merchantResponse->getResult() == 'ok' && $ticketResponse->getResult() == 'ok'){
                $this->success = true;
                $this->amount = "1000,52";
                $this->baseJsUrl = $config->getBexApiConfiguration()->getBaseJs();
                $this->ticketId = $ticketResponse->getTicketShortId();
                $this->ticketPath = $ticketResponse->getTicketPath();
                $this->ticketToken = $ticketResponse->getTicketToken();
                $this->merchantToken = $merchantResponse->getConnectionToken();
                $this->config = $config;
                $this->connectionId = $merchantResponse->getPath();
                $this->baseUrl = $config->getBexApiConfiguration()->getBaseUrl();
                return $this;
            }
        }
    }


    public  function callResult($requestTicketId){
            $merchantService = new MerchantService($this->config);
            $resultResponse = $merchantService->result($this->merchantToken,$this->connectionId,$requestTicketId);
            return $resultResponse;

    }

    public  function callReInitTicket(){
        $config = BexPayment::startBexPayment(self::environment,self::merchantId,self::merchantSecretKey);
        $merchantService = new MerchantService($config);
        $merchantResponse = $merchantService->login();
        $ticketResponse = $merchantService->oneTimeTicket($merchantResponse->getToken(), "1000,52", self::INSTALLMENT_URL);
        return $ticketResponse;
    }


    public  function callReInitTicketForCustom(){
        $config = BexPayment::startBexPayment(self::environment,$this->customData->merchantId,$this->customData->merchantPrivateKey);
        $merchantService = new MerchantService($config);
        $merchantResponse = $merchantService->login();
        $ticketResponse = $merchantService->oneTimeTicket($merchantResponse->getToken(), "1000,52", self::INSTALLMENT_URL);
        return $ticketResponse->getTicketPath();
    }

    public function  getInstallmentResponseForCustom(InstallmentRequest $installmentRequest){
        $installmentResponse = new InstallmentsResponse();
        return $this->initInstallmentForCustom($installmentRequest,$installmentResponse);
    }

    function searchForKey($keyOfArray, $array) {
        foreach ($array as $key => $val) {
            if ($val->bankCode === $keyOfArray) {
                return $key;
            }
        }
        return null;
    }

    //Normal Entegrasyon
    private function  initInstallmentForCustom(InstallmentRequest $installmentRequest , InstallmentsResponse $installmentResponse){
        if(!isset($installmentRequest)){
            $installmentResponse->setError("Request Body can not be null !");
            return $installmentResponse;
        }else if (empty($installmentRequest->getBinNo()) || empty($installmentRequest->getTotalAmount()) || empty($installmentRequest->getTicketId())) {
            $installmentResponse->setError("Request Body variables can not be null !");
            return $installmentResponse;
        }else if (!EncryptionUtil::verifyBexSign($installmentRequest->getTicketId(),$installmentRequest->getSignature())){
            $installmentResponse->setError("Signature verification failed");
            return $installmentResponse;
        }
        $installments = array();
        $banksData = $this->customData->banks;
        if(!isset($banksData) && empty($banksData)){
            throw new \Bex\exceptions\BexException("Can not get banksData data");
        }
        $binAndBank = $installmentRequest->getBinNo()[0] ;
        $explodedArr = explode("@",$binAndBank);
        $key = $this->searchForKey($explodedArr[1],$banksData);
        if(isset($key)){
            $customInstallmentData = $banksData[$key]->installments;
            if(!isset($customInstallmentData) && empty($customInstallmentData)){
                throw new \Bex\exceptions\BexException("Can not get installment data");
            }
            for ($i=0 ; $i < count($customInstallmentData) ; $i++){
                $instalmentAmount = MoneyUtils::toFloat($this->customData->amount) / floatval($customInstallmentData[$i]->installmentCount);
                $label = (string)$customInstallmentData[$i]->label ? (string)$customInstallmentData[$i]->label : "test";
                $instalmentAmount = MoneyUtils::formatTurkishLira($instalmentAmount);
                $vposConfigData = $customInstallmentData[$i]->vposConfig;
                $encryptedVpos= EncryptionUtil::encryptWithBex(json_encode($vposConfigData));
                $installment = new Installment((string)$customInstallmentData[$i]->installmentCount,$instalmentAmount,$label,$this->customData->amount,$vposConfigData);
                $out =  array('numberOfInstallment' => $installment->getNumberOfInstallment() , 'installmentAmount' => $installment->getInstallmentAmount() ,
                    'totalAmount' => $installment->getTotalAmount() ,
                    'vposConfig' => $encryptedVpos);
                array_push($installments,$out);
            }

        }
        $binAndInstallments = new BinAndInstallments();
        $installmentResponse->setInstallments($installments);
        $installmentResponse->setStatus("ok");
        $installmentResponse->setBin($explodedArr[0]);
        $returnArray = array();
        $returnArray[$installmentResponse->getBin()] = $installmentResponse->getInstallments();
        $binAndInstallments->setInstallments($returnArray);
        return $binAndInstallments;
    }

    public function  getInstallmentResponse(InstallmentRequest $installmentRequest){
        $installmentResponse = new InstallmentsResponse();
        return $this->initInstallment($installmentRequest,$installmentResponse);
    }

    //Normal Entegrasyon
    private function  initInstallment(InstallmentRequest $installmentRequest , InstallmentsResponse $installmentResponse){
        if(!isset($installmentRequest)){
            $installmentResponse->setError("Request Body can not be null !");
            return $installmentResponse;
        }else if (empty($installmentRequest->getBinNo())  || empty($installmentRequest->getTotalAmount()) || empty($installmentRequest->getTicketId())) {
            $installmentResponse->setError("Request Body variables can not be null !");
            return $installmentResponse;
        }else if (!EncryptionUtil::verifyBexSign($installmentRequest->getTicketId(),$installmentRequest->getSignature())){
            $installmentResponse->setError("Signature verification failed");
            return $installmentResponse;
        }

        $installments = array();
        $binAndBank = $installmentRequest->getBinNo()[0] ;
        $explodedArr = explode("@",$binAndBank);
        $count = substr($explodedArr[1],3);
        $count = (int)$count + 2;
        for ($i=1 ; $i < $count ; $i++){
            $instalmentAmount = MoneyUtils::toFloat($installmentRequest->getTotalAmount()) / floatval($i);
            $instalmentAmount = MoneyUtils::formatTurkishLira($instalmentAmount);
            $vposConfig = $this->prepareVposConfig($explodedArr[1]);
            $installment = new Installment((string)$i,$instalmentAmount,"",$installmentRequest->getTotalAmount(),$vposConfig);
            $out =  array('numberOfInstallment' => $installment->getNumberOfInstallment() , 'installmentAmount' => $installment->getInstallmentAmount() ,
                'totalAmount' => $installment->getTotalAmount() ,
                'vposConfig' => $vposConfig
            );
            array_push($installments,$out);
        }
        $binAndInstallments = new BinAndInstallments();
        $installmentResponse->setInstallments($installments);
        $installmentResponse->setStatus("ok");
        $installmentResponse->setBin($explodedArr[0]);
        $returnArray = array();
        $returnArray[$installmentResponse->getBin()] = $installmentResponse->getInstallments();
        $binAndInstallments->setInstallments($returnArray);
        return $binAndInstallments;
    }





    /**
     * @param NonceRequest $nonceRequest
     * @return MerchantNonceResponse
     */
    public function  callNonce(NonceRequest $nonceRequest){
        $miliSecondAsOperationTime  = $this->customData->operationTime;
        $secondOperationTime = (int) $miliSecondAsOperationTime / 1000;
        sleep($secondOperationTime);
        $merchantNonceResponse = new MerchantNonceResponse();
        $merchantService = new MerchantService($this->config);
        if(!$this->customData->shouldFail){
            if(EncryptionUtil::verifyBexSign($nonceRequest->getTicketId(),$nonceRequest->getSignature())){
                $merchantNonceResponse->setResult(true);
                $merchantNonceResponse->setNonce($nonceRequest->getToken());
                $merchantNonceResponse->setId($nonceRequest->getPath());
                $merchantService->sendNonceResponse($merchantNonceResponse,$this->connectionId,$nonceRequest->getPath(),$this->merchantToken,$nonceRequest->getToken());
            } else {
                $merchantNonceResponse->setResult(false);
                $merchantNonceResponse->setNonce($nonceRequest->getToken());
                $merchantNonceResponse->setId($nonceRequest->getPath());
                $merchantNonceResponse->setMessage("Signature verification failed");
                $merchantService->sendNonceResponse($merchantNonceResponse,$this->connectionId,$nonceRequest->getPath(),$this->merchantToken,$nonceRequest->getToken());
            }
        }
        else{
            $merchantNonceResponse->setResult(false);
            $merchantNonceResponse->setNonce($nonceRequest->getToken());
            $merchantNonceResponse->setId($nonceRequest->getPath());
            $merchantNonceResponse->setMessage("Out of stock for order id: ".$nonceRequest->getOrderId());
            $merchantService->sendNonceResponse($merchantNonceResponse,$this->connectionId,$nonceRequest->getPath(),$this->merchantToken,$nonceRequest->getToken());
        }
        return $merchantNonceResponse;
    }


    /**
     * @param $bankCode
     * @return string
     */
    private function prepareVposConfig($bankCode)
    {

        $vposConfig = new VposConfig();
        if (Banks::AKBANK == $bankCode) {

            $vposConfig->setVposUserId("akapi");
            $vposConfig->setVposPassword("TEST1234");
            $vposConfig->addExtra("ClientId", "100111222");
            $vposConfig->addExtra("storekey", "TEST1234");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/akbank");

        } else if(Banks::TEBBANK == $bankCode) {

            $vposConfig->setVposUserId("bkmapi");
            $vposConfig->setVposPassword("KUTU8520");
            $vposConfig->addExtra("ClientId", "401562930");
            $vposConfig->addExtra("storekey", "KUTU8520");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/teb");

        } else if(Banks::VAKIFBANK == $bankCode) {

            $vposConfig->setVposUserId("000000000011429");
            $vposConfig->setVposPassword("BKMexpress");
            $vposConfig->addExtra("posno", "vp000263");
            $vposConfig->addExtra("uyeno", "000000000011429");
            $vposConfig->addExtra("islemyeri", "I");
            $vposConfig->addExtra("uyeref", "917250515");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/vpos724v3/");

        } else if(Banks::ALBARAKA == $bankCode) {

            $vposConfig->setVposUserId("600218");
            $vposConfig->setVposPassword("123qweASD");
            $vposConfig->addExtra("terminalprovuserid", "PROVAUT");
            $vposConfig->addExtra("terminalmerchantid", "7000679");
            $vposConfig->addExtra("storekey", "12345678");
            $vposConfig->addExtra("terminalid", "30690168");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/VPServlet");

        } else if(Banks::BANKASYA == $bankCode) {

            $vposConfig->setVposUserId("");
            $vposConfig->setVposPassword("");
            $vposConfig->addExtra("MerchantId", "006100200140200");
            $vposConfig->addExtra("MerchantPassword", "12345678");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/iposnet/sposnet.aspx");

        } else if(Banks::DENIZBANK == $bankCode) {

            $vposConfig->setVposUserId("1");
            $vposConfig->setVposPassword("12345");
            $vposConfig->addExtra("ShopCode", "3123");
            $vposConfig->addExtra("UserCode", "InterTestApi");
            $vposConfig->addExtra("storeKey", "gDg1N");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/mpi/Default.aspx");

        } else if(Banks::FINANSBANK == $bankCode) {

            $vposConfig->setVposUserId("bkmapi");
            $vposConfig->setVposPassword("TEST1234");
            $vposConfig->addExtra("ClientId", "600000120");
            $vposConfig->addExtra("storekey", "TEST1234");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/finans");

        } else if(Banks::GARANTI == $bankCode) {

            $vposConfig->setVposUserId("600218");
            $vposConfig->setVposPassword("123qweASD");
            $vposConfig->addExtra("terminalprovuserid", "PROVAUT");
            $vposConfig->addExtra("terminalmerchantid", "7000679");
            $vposConfig->addExtra("storekey", "12345678");
            $vposConfig->addExtra("terminalid", "30690168");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/VPServlet");

        } else if(Banks::HALKBANK == $bankCode) {

            $vposConfig->setVposUserId("testapi");
            $vposConfig->setVposPassword("TEST1234");
            $vposConfig->addExtra("ClientId", "500020009");
            $vposConfig->addExtra("storekey", "Ab123456");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/halkbank");

        } else if(Banks::HSBC == $bankCode) {

            $vposConfig->setVposUserId("a");
            $vposConfig->setVposPassword("Test1234");
            $vposConfig->addExtra("ClientId", "0004220");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("https://vpostest.advantage.com.tr/servlet/cc5ApiServer");

        } else if(Banks::ING == $bankCode) {

            $vposConfig->setVposUserId("600218");
            $vposConfig->setVposPassword("123qweASD");
            $vposConfig->addExtra("terminalprovuserid", "PROVAUT");
            $vposConfig->addExtra("terminalmerchantid", "7000679");
            $vposConfig->addExtra("storekey", "12345678");
            $vposConfig->addExtra("terminalid", "30690168");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/VPServlet");

        } else if(Banks::ISBANK == $bankCode) {

            $vposConfig->setVposUserId("bkmapi");
            $vposConfig->setVposPassword("KUTU8900");
            $vposConfig->addExtra("ClientId", "700655047520");
            $vposConfig->addExtra("storekey", "TEST123456");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/isbank");

        } else if(Banks::KUVEYTTURK == $bankCode) {

            $vposConfig->setVposUserId("apiuser");
            $vposConfig->setVposPassword("Api123");
            $vposConfig->addExtra("MerchantId", "2");
            $vposConfig->addExtra("CustomerId", "8736633");
            $vposConfig->addExtra("orderId", "852507088");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("https://boatest.kuveytturk.com.tr/boa.virtualpos.services/Home/ThreeDModelGate");

        } else if(Banks::ODEABANK == $bankCode) {

            $vposConfig->setVposUserId("600218");
            $vposConfig->setVposPassword("123qweASD");
            $vposConfig->addExtra("terminalprovuserid", "PROVAUT");
            $vposConfig->addExtra("terminalmerchantid", "7000679");
            $vposConfig->addExtra("storekey", "12345678");
            $vposConfig->addExtra("terminalid", "30690168");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/VPServlet");

        } else if(Banks::SEKERBANK == $bankCode) {

            $vposConfig->setVposUserId("600218");
            $vposConfig->setVposPassword("123qweASD");
            $vposConfig->addExtra("terminalprovuserid", "PROVAUT");
            $vposConfig->addExtra("terminalmerchantid", "7000679");
            $vposConfig->addExtra("storekey", "12345678");
            $vposConfig->addExtra("terminalid", "30690168");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/VPServlet");

        } else if(Banks::TFKB == $bankCode) {

            $vposConfig->setVposUserId("");
            $vposConfig->setVposPassword("");
            $vposConfig->addExtra("orgNo", "006");
            $vposConfig->addExtra("firmNo", "9470335");
            $vposConfig->addExtra("termNo", "955434");
            $vposConfig->addExtra("merchantKey", "HngvXM22");
            $vposConfig->addExtra("orderId", "674451441");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("https://testserver1:15443/BKMExpressServices.asmx");

        } else if(Banks::ZIRAATBANK == $bankCode) {

            $vposConfig->setVposUserId("bkmtest");
            $vposConfig->setVposPassword("TEST1691");
            $vposConfig->addExtra("ClientId", "190001691");
            $vposConfig->addExtra("storekey", "TRPS1691");
            $vposConfig->addExtra("orderId", "9073194");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/ziraat");

        } else if(Banks::YKB == $bankCode) {

            $vposConfig->setVposUserId("bkm3d1");
            $vposConfig->setVposPassword("12345");
            $vposConfig->addExtra("mid", "6706598320");
            $vposConfig->addExtra("tid", "67245089");
            $vposConfig->addExtra("posnetID", "4280");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/PosnetWebService/XML");

        }
        $vps_jsn = array('vposUserId' => $vposConfig->getVposUserId() , 'vposPassword' => $vposConfig->getVposPassword() , 'extra' => $vposConfig->getExtra() , 'bankIndicator' => $vposConfig->getBankIndicator() , 'serviceUrl' => $vposConfig->getServiceUrl());
        return EncryptionUtil::encryptWithBex(json_encode($vps_jsn));

    }




    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
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
    public function getBaseJsUrl()
    {
        return $this->baseJsUrl;
    }

    /**
     * @param mixed $baseJsUrl
     */
    public function setBaseJsUrl($baseJsUrl)
    {
        $this->baseJsUrl = $baseJsUrl;
    }

    /**
     * @return mixed
     */
    public function getMerchantToken()
    {
        return $this->merchantToken;
    }

    /**
     * @param mixed $merchantToken
     */
    public function setMerchantToken($merchantToken)
    {
        $this->merchantToken = $merchantToken;
    }


    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
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
    public function getTicketPath()
    {
        return $this->ticketPath;
    }

    /**
     * @param mixed $ticketPath
     */
    public function setTicketPath($ticketPath)
    {
        $this->ticketPath = $ticketPath;
    }

    /**
     * @return mixed
     */
    public function getTicketToken()
    {
        return $this->ticketToken;
    }

    /**
     * @param mixed $ticketToken
     */
    public function setTicketToken($ticketToken)
    {
        $this->ticketToken = $ticketToken;
    }

    /**
     * @return mixed
     */
    public function getConnectionId()
    {
        return $this->connectionId;
    }

    /**
     * @param mixed $connectionId
     */
    public function setConnectionId($connectionId)
    {
        $this->connectionId = $connectionId;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param mixed $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return mixed
     */
    public function getCustomData()
    {
        return $this->customData;
    }

    /**
     * @param mixed $customData
     */
    public function setCustomData($customData)
    {
        $this->customData = $customData;
    }

    /**
     * @return mixed
     */
    public function getMerchantNonceResponseData()
    {
        return $this->merchantNonceResponseData;
    }

    /**
     * @param mixed $merchantNonceResponseData
     */
    public function setMerchantNonceResponseData($merchantNonceResponseData)
    {
        $this->merchantNonceResponseData = $merchantNonceResponseData;
    }











}
