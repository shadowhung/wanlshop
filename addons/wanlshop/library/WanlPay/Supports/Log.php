<?php

namespace WanlPay\Supports;

/**
 * @method static void emergency($message, array $context = array())
 * @method static void alert($message, array $context = array())
 * @method static void critical($message, array $context = array())
 * @method static void error($message, array $context = array())
 * @method static void warning($message, array $context = array())
 * @method static void notice($message, array $context = array())
 * @method static void info($message, array $context = array())
 * @method static void debug($message, array $context = array())
 * @method static void log($message, array $context = array())
 */
class Log extends Logger
{
    /**
     * instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    private static $instance;

    /**
     * Bootstrap.
     */
    private function __construct()
    {
    }

    /**
     * __call.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $method
     * @param array  $args
     *
     * @throws \Exception
     */
    public function __call($method, $args): void
    {
        call_user_func_array([self::getInstance(), $method], $args);
    }

    /**
     * __callStatic.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $method
     * @param array  $args
     *
     * @throws \Exception
     */
    public static function __callStatic($method, $args): void
    {
        forward_static_call_array([self::getInstance(), $method], $args);
    }

    /**
     * getInstance.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return \WanlPay\Supports\Logger
     */
    public static function getInstance(): Logger
    {
        if (is_null(self::$instance)) {
            self::$instance = new Logger();
        }

        return self::$instance;
    }

    /**
     * setInstance.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param \WanlPay\Supports\Logger $logger
     *
     * @throws \Exception
     */
    public static function setInstance(Logger $logger): void
    {
        self::$instance = $logger;
    }
}
