<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/21
 * Time: 22:49
 */

namespace App\Pool;


use EasySwoole\Component\Pool\AbstractPool;
use EasySwoole\EasySwoole\Config;
use App\Redis\WebSocketRedis;

class RedisPool extends AbstractPool
{

    /**
     * @return Redis
     */
    protected function createObject()
    {
        $redis = new WebSocketRedis();
        $conf = Config::getInstance()->getConf('REDIS');
        $redis->connect($conf['HOST'], $conf['PORT']);
        $redis->setOption(WebSocketRedis::OPT_SERIALIZER, WebSocketRedis::SERIALIZER_PHP);
        if (!empty($conf['AUTH'])) {
            $redis->auth($conf['AUTH']);
        }

        return $redis;
    }
}