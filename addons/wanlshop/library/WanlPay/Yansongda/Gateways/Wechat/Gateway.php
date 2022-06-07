<?php

namespace WanlPay\Yansongda\Gateways\Wechat;

use WanlPay\Yansongda\Contracts\GatewayInterface;
use WanlPay\Yansongda\Events;
use WanlPay\Yansongda\Exceptions\GatewayException;
use WanlPay\Yansongda\Exceptions\InvalidArgumentException;
use WanlPay\Yansongda\Exceptions\InvalidSignException;
use WanlPay\Supports\Collection;

abstract class Gateway implements GatewayInterface
{
    /**
     * Mode.
     *
     * @var string
     */
    protected $mode;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $this->mode = Support::getInstance()->mode;
    }

    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     *
     * @return Collection
     */
    abstract public function pay($endpoint, array $payload);

    /**
     * Find.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|array $order
     */
    public function find($order): array
    {
        return [
            'endpoint' => 'pay/orderquery',
            'order' => is_array($order) ? $order : ['out_trade_no' => $order],
            'cert' => false,
        ];
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    abstract protected function getTradeType();

    /**
     * Schedule an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $payload
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    protected function preOrder($payload): Collection
    {
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\MethodCalled('Wechat', 'PreOrder', '', $payload));

        return Support::requestApi('pay/unifiedorder', $payload);
    }
}
