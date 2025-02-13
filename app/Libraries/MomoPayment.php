<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MomoPayment
{
    protected static $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';
    protected static $partnerCode = 'MOMOBKUN20180529';
    protected static $accessKey = 'klm05TvNBzhg7h7j';
    protected static $secretKey =  'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    public static function purchase(array $params)
    {
        $rawData = "accessKey=" . self::$accessKey .
            "&amount=" . $params['amount'] .
            "&extraData=" . $params['extraData'] .
            "&ipnUrl=" . $params['ipnUrl'] .
            "&orderId=" . $params['orderId'] .
            "&orderInfo=" . $params['orderInfo'] .
            "&partnerCode=" . self::$partnerCode .
            "&redirectUrl=" . $params['redirectUrl'] .
            "&requestId=" . $params['requestId'] .
            "&requestType=payWithATM";
        $signature = hash_hmac('sha256', $rawData, self::$secretKey);

        $response = Http::post(self::$endpoint, [
            'partnerCode' => self::$partnerCode,
            'accessKey' => self::$accessKey,
            'requestId' => $params['requestId'],
            'amount' => $params['amount'],
            'orderId' => $params['orderId'],
            'orderInfo' => $params['orderInfo'],
            'redirectUrl' => $params['redirectUrl'],
            'ipnUrl' => $params['ipnUrl'],
            'extraData' => $params['extraData'],
            'requestType' => 'payWithATM',
            'signature' => $signature,
        ]);

        return $response;
    }

    /**
     * Xác minh chữ ký từ MoMo
     */
    public static function validateSignature(array $data)
    {
        $rawData = "accessKey=" . self::$accessKey .
            "&amount=" . $data['amount'] .
            "&extraData=" . $data['extraData'] .
            "&message=" . $data['message'] .
            "&orderId=" . $data['orderId'] .
            "&orderInfo=" . $data['orderInfo'] .
            "&partnerCode=" . self::$partnerCode .
            "&payType=" . $data['payType'] .
            "&requestId=" . $data['requestId'] .
            "&responseTime=" . $data['responseTime'] .
            "&resultCode=" . $data['resultCode'];
        $signature = hash_hmac('sha256', $rawData, self::$secretKey);

        return $signature === $data['signature'];
    }
}

