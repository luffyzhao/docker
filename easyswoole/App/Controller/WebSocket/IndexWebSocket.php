<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/21
 * Time: 22:59
 */

namespace App\Controller\WebSocket;


use App\Controller\WebSocket;

class IndexWebSocket extends WebSocket
{
    /**
     * 心跳
     */
    public function heartbeat()
    {
        $this->response()->setMessage('PONG');
    }

    protected function onException(\Throwable $throwable): void
    {
        $this->response()->setMessage('error');
    }
}