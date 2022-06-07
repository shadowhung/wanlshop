<?php

namespace WanlPay\Yansongda\Gateways\Wechat;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WanlPay\Yansongda\Events;
use WanlPay\Yansongda\Exceptions\GatewayException;
use WanlPay\Yansongda\Exceptions\InvalidArgumentException;
use WanlPay\Yansongda\Exceptions\InvalidSignException;
use WanlPay\Yansongda\Gateways\Wechat;
use WanlPay\Supports\Str;

class AppGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     * @throws Exception
     */
    public function pay($endpoint, array $payload): Response
    {
        $payload['appid'] = Support::getInstance()->appid;
        $payload['trade_type'] = $this->getTradeType();

        if (Wechat::MODE_SERVICE === $this->mode) {
            $payload['sub_appid'] = Support::getInstance()->sub_appid;
        }

        $pay_request = [
            'appid' => Wechat::MODE_SERVICE === $this->mode ? $payload['sub_appid'] : $payload['appid'],
            'partnerid' => Wechat::MODE_SERVICE === $this->mode ? $payload['sub_mch_id'] : $payload['mch_id'],
            'prepayid' => $this->preOrder($payload)->get('prepay_id'),
            'timestamp' => strval(time()),
            'noncestr' => Str::random(),
            'package' => 'Sign=WXPay',
        ];
        $pay_request['sign'] = Support::generateSign($pay_request);

        Events::dispatch(new Events\PayStarted('Wechat', 'App', $endpoint, $pay_request));

        return new JsonResponse($pay_request);
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     */
    protected function getTradeType(): string
    {
        return 'APP';
    }
}
