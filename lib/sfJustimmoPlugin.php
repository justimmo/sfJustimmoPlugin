<?php

use Justimmo\Api\JustimmoApi;
use Psr\Log\NullLogger;
use Justimmo\Model\RealtyQuery;
use Justimmo\Cache\NullCache;
use Justimmo\Model\Wrapper\V1\RealtyWrapper;
use Justimmo\Model\Mapper\V1\RealtyMapper;

class sfJustimmoPlugin
{
    protected static $query;

    protected static $username;
    protected static $password;

    protected $debug = false;
    protected $log = null;

    public static function getQueryInstance()
    {
        if (!isset(self::$query)) {
            $api = new JustimmoApi(
                self::$username,
                self::$password,
                new NullLogger(),
                new NullCache()
            );

            $mapper      = new RealtyMapper();
            $wrapper     = new RealtyWrapper($mapper);
            self::$query = new RealtyQuery($api, $wrapper, $mapper);
        }

        return self::$query;
    }

    function __construct()
    {
        self::$username = sfConfig::get('app_justimmoapi_username');
        self::$password = sfConfig::get('app_justimmoapi_password');
    }

    function setDebug($state = true)
    {
        $this->debug = $state;
    }
}
