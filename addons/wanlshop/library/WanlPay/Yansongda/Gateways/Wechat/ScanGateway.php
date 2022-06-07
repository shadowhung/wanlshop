<?php

namespace WanlPay\Yansongda\Gateways\Wechat;

use Symfony\Component\HttpFoundation\Request;
use WanlPay\Yansongda\Events;
use WanlPay\Yansongda\Exceptions\GatewayException;
use WanlPay\Yansongda\Exceptions\InvalidArgumentException;
use WanlPay\Yansongda\Exceptions\InvalidSignException;
use WanlPay\Supports\Collection;

class ScanGateway extends Gateway
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
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['spbill_create_ip'] = Request::createFromGlobals()->server->get('SERVER_ADDR');
        $payload['trade_type'] = $this->getTradeType();

        Events::dispatch(new Events\PayStarted('Wechat', 'Scan', $endpoint, $payload));

        return $this->preOrder($payload);
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     */
    protected function getTradeType(): string
    {
        return 'NATIVE';
    }
}
