<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/22
 * Time: 13:41
 */

namespace App\Consts;


class RedisConst
{
    // 用户当前登录的标识
    const USER_AUTH_HASH = 'User:auth:hash';
    
    // websocket fd和用户映射关系
    const WEBSOCKET_FD_USER = 'WebSocket:fd:user';

    // websocket 用户和fd映射关系
    const WEBSOCKET_USER_FD = 'WebSocket:user:fd';

    // fd和身份对应关系
    const WEBSOCKET_FD_IDENTIFYING = 'WebSocket:fd:identifying';

}