<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\AbstractLogger;

class JustimmoLogger extends AbstractLogger
{
    protected $_logger = null;

    public function __construct($name)
    {
        $this->_logger = new Logger($name);
        $this->_logger->pushHandler(new StreamHandler(__DIR__ . '/justimmo_plugin.log', Logger::DEBUG));
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $this->_logger->log($level, $message, $context);
    }
}
