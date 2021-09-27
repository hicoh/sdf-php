<?php

namespace Functions\Shopify\GetOrder;

use App\Request\ContextRequest;
use PHPShopify\ShopifySDK;

class Main
{
    public static function run(ContextRequest $contextRequest): array
    {
        $config = array(
            'ShopUrl' => 'simple-street-supplies.myshopify.com',
            'ApiKey' => '2acbf9b07aaddcd26f99a57a08928a87',
            'Password' => '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',
            'Curl' => array(
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true
            )
        );

        $shopifySDK = ShopifySDK::config($config);
        return $shopifySDK->Order->get();
    }
}
