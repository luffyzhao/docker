<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/22
 * Time: 14:35
 */

namespace App\Redis;

use App\Consts\RedisConst;
use App\Consts\UserConst;
use App\Utility\UserAuth\Parse;
use EasySwoole\Component\Pool\PoolObjectInterface;

class WebSocketRedis extends Redis implements PoolObjectInterface
{

    /**
     * @param Parse $parse
     * @return bool
     */
    public function verifyUser(Parse $parse): bool
    {
        return $this->hGet(RedisConst::USER_AUTH_HASH, $parse->getUid()) === $parse->getAuthKey();
    }

    /**
     * 用户绑定fd
     * @param int $fd
     * @param int $userId
     * @param string $identifying
     * @throws \Exception
     */
    public function bind(int $fd, int $userId, string $identifying)
    {
        $this->eval(
            $this->getLua('bind.lua'),
            [
                $fd,
                $userId,
                RedisConst::WEBSOCKET_FD_USER,
                RedisConst::WEBSOCKET_USER_FD,
                RedisConst::WEBSOCKET_FD_IDENTIFYING,
                $identifying,
            ]
        );
    }

    /**
     * 解绑fd
     * @param int $fd
     * @throws \Exception
     * @throws \Exception
     */
    public function unBind(int $fd)
    {
        $this->eval(
            $this->getLua('un_bind.lua'),
            [
                $fd,
                RedisConst::WEBSOCKET_FD_USER,
                RedisConst::WEBSOCKET_USER_FD,
                RedisConst::WEBSOCKET_FD_IDENTIFYING,
            ]
        );
    }


}