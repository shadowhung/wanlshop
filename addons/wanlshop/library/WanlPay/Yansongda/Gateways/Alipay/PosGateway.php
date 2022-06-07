<?php

namespace WanlPay\Yansongda\Gateways\Alipay;

use WanlPay\Yansongda\Events;
use WanlPay\Yansongda\Exceptions\GatewayException;
use WanlPay\Yansongda\Exceptions\InvalidArgumentException;
use WanlPay\Yansongda\Exceptions\InvalidConfigException;
use WanlPay\Yansongda\Exceptions\InvalidSignException;
use WanlPay\Yansongda\Gateways\Alipay;
use WanlPay\Supports\Collection;

class PosGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     *
     * @throws InvalidArgumentException
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['method'] = 'alipay.trade.pay';
        $biz_array = json_decode($payload['biz_content'], true);
        if ((Alipay::MODE_SERVICE === $this->mode) && (!empty(Support::getInstance()->pid))) {
            $biz_array['extend_params'] = is_array($biz_array['extend_params']) ? array_merge(['sys_service_provider_id' => Support::getInstance()->pid], $biz_array['extend_params']) : ['sys_service_provider_id' => Support::getInstance()->pid];
        }
        $payload['biz_content'] = json_encode(array_merge(
            $biz_array,
            [
                'product_code' => 'FACE_TO_FACE_PAYMENT',
                'scene' => 'bar_code',
            ]
        ));
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Alipay', 'Pos', $endpoint, $payload));

        return Support::requestApi($payload);
    }
}
