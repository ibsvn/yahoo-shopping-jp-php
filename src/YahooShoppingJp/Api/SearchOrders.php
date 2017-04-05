<?php

namespace Shippinno\YahooShoppingJp\Api;

use ErrorException;
use Shippinno\YahooShoppingJp\Exception\DistillationException;
use Shippinno\YahooShoppingJp\HttpMethod;

class SearchOrders extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function httpMethod(): HttpMethod
    {
        return HttpMethod::POST();
    }

    /**
     * {@inheritdoc}
     */
    public function path(): string
    {
        return 'orderList';
    }

    /**
     * @param array $response
     * @return array
     */
    public function distillResponse(array $response): array
    {
//        if ($response['Status'] !== 'OK') {
//            if (isset($response['Error'])) {
//                throw new DistillationException($response['Error']['Message'], $response['Error']['Code']);
//            } else {
//                throw new ErrorException('予期しないエラー');
//            }
//        }

        if(! isset($response['Search']['OrderInfo'])) {
            return [];
        }

        return $response['Search']['OrderInfo'];
    }
}