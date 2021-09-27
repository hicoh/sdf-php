<?php

namespace Functions\Shopify\GetOrder;

use App\Request\ContextRequest;
use PHPShopify\ShopifySDK;

class Main
{
    public static function run(ContextRequest $contextRequest): array
    {
        $config = array(
            'ShopUrl' => $contextRequest->getFunctionConfiguration()->getKey()->getContentByKey('ShopUrl'),
            'ApiKey' => $contextRequest->getFunctionConfiguration()->getKey()->getContentByKey('ApiKey'),
            'Password' => $contextRequest->getFunctionConfiguration()->getKey()->getContentByKey('Password'),
            'Curl' => array(
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true
            )
        );

        $shopifySDK = ShopifySDK::config($config);
        return $shopifySDK->Order->get();
    }
}
