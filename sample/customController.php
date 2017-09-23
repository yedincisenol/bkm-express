<?php

header('Access-Control-Allow-Origin: *');
use Bex\exceptions\BexException;
use Bex\merchant\request\InstallmentRequest;
use Bex\merchant\request\NonceRequest;

require_once 'src/main/SampleSetup.php';

if (isset($_REQUEST['customStart'])) {
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    $customParams = new SampleSetup($data, 'custom');
    file_put_contents('customParams', serialize($customParams));
    if (isset($customParams)) {
        $ticketShortId = $customParams->getTicketId();
        $ticketPath = $customParams->getTicketPath();
        $ticketToken = $customParams->getTicketToken();
        exit(json_encode(['ticketShortId' => $ticketShortId, 'ticketPath'=>$ticketPath, 'ticketToken' => $ticketToken]));
    }
}

if (isset($_REQUEST['customResult'])) {
    $getData = $_GET['customResult'];
    $customParams = unserialize(file_get_contents('customParams'));

    $resultData = $customParams->callResult($getData);
    if ($resultData->getResult() == 'ok') {
        $installmentCount = $resultData->getInstallmentCount();
        $totalAmount = $resultData->getTotalAmount();
        $cardData = $resultData->getCardFirst6().'******'.$resultData->getCardLast4();
        $bkmTokenId = $resultData->getBkmTokenId();
        $posResult = $resultData->getPosResult();

        $orderId = $posResult->getOrderId();
        $authCode = $posResult->getAuthCode();
        $posResponse = $posResult->getPosResponse();
        $posResultCode = $posResult->getPosResultCode();
        $referenceNumber = $posResult->getReferenceNumber();
        $posTransactionId = $posResult->getPosTransactionId();
        $posBank = $posResult->getPosBank();
        exit(json_encode(['installmentCount' => $installmentCount, 'totalAmount' => $totalAmount, 'cardData' => $cardData, 'bkmTokenId' =>$bkmTokenId,
            'posResult'                      => ['orderId' => $orderId, 'authCode' =>$authCode, 'posResponse' =>$posResponse, 'posResultCode' => $posResultCode,
                'referenceNumber'                          => $referenceNumber, 'posTransactionId' => $posTransactionId, 'posBank' =>$posBank, ], ]));
    }
}

if (isset($_REQUEST['custom']) && $_REQUEST['custom'] == 'reinit') {
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    $params = new SampleSetup($data, 'custom');
    exit(json_encode(['id'=>$params->getTicketId(), 'path' => $params->getTicketPath(), 'token' => $params->getTicketToken()], JSON_PRETTY_PRINT));
}

if (isset($_REQUEST['installment']) && $_REQUEST['installment'] == 'custom') {
    header('Content-type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    if (!empty($data)) {
        $installmentRequest = new InstallmentRequest($data['bin'], $data['totalAmount'], $data['ticketId'], $data['signature']);
        $customParams = unserialize(file_get_contents('customParams'));
        $binAndInstallments = $customParams->getInstallmentResponseForCustom($installmentRequest);
        if (isset($binAndInstallments)) {
            exit(json_encode(['data' => $binAndInstallments, 'status' => 'ok', 'error' => '']));
        } else {
            exit(json_encode(['data' => null, 'status' => 'fail', 'error' => 'Can not get installments']));
        }
    } else {
        throw  new BexException('Request body can not get !');
    }
}

if (isset($_REQUEST['nonce']) && $_REQUEST['nonce'] == 'custom') {
    header('Content-type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    if (!empty($data)) {
        $customParams = unserialize(file_get_contents('customParams'));
        if ($customParams->getCustomData()->noResponse) {
            return;
        }
        $nonceRequest = new NonceRequest($data['id'], $data['path'], $data['issuer'], $data['approver'], $data['token'], $data['signature'], $data['reply']);
        ob_start();

        // Send your response.
        echo json_encode([
            'result' => 'ok',
            'data'   => 'ok',
        ]);
        // Get the size of the output.
        $size = ob_get_length();

        // Disable compression (in case content length is compressed).
        header('Content-Encoding: none');
        header($_SERVER['SERVER_PROTOCOL'].' 202 Accepted');
        header('Status: 202 Accepted');
        // Set the content length of the response.
        header("Content-Length: {$size}");

        // Close the connection.
        header('Connection: close');
        ignore_user_abort(true);
        set_time_limit(0);

        // Flush all output.
        ob_end_flush();
        ob_flush();
        flush();
        session_write_close(); // Added a line suggested in the comment
        //TODO in local development set fastcgi_finish_request as comment line
        fastcgi_finish_request();
        // Do processing here
        sleep(5);
        callBackAfterNonce($nonceRequest, $customParams);
    }
}

function callBackAfterNonce($nonceRequest, $customParams)
{
    if (!isset($customParams)) {
        throw new BexException('Custom Params cannot get from file');
    }
    $customParams->callNonce($nonceRequest);
}
