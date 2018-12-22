<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/21
 * Time: 22:56
 */

namespace App\Parser;


use EasySwoole\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Socket\Bean\Caller;
use EasySwoole\Socket\Bean\Response;
use EasySwoole\Socket\Client\WebSocket as WebSocketClient;

class WebSocketParser implements ParserInterface
{

    /**
     * 解码上来的消息
     * @param string $raw 消息内容
     * @param WebSocketClient $client   当前客户端
     * @return Caller|null
     */
    public function decode($raw, $client): ?Caller
    {
        $caller = new Caller;
        if ($raw !== 'PING') {
            $payload = json_decode($raw, true);
            $class = isset($payload['controller']) ? $payload['controller'] : 'index';
            $action = isset($payload['action']) ? $payload['action'] : 'actionNotFound';
            $params = isset($payload['params']) ? (array)$payload['params'] : [];
            $controllerClass = "\\App\\Controller\\WebSocket\\".ucfirst($class) . 'WebSocket';
            if (!class_exists($controllerClass)) {
                $controllerClass = "\\App\\Controller\\WebSocket\\IndexWebSocket";
            }
            $caller->setClient($caller);
            $caller->setControllerClass($controllerClass);
            $caller->setAction($action);
            $caller->setArgs($params);
        } else {
            $caller->setControllerClass("\\App\\Controller\\WebSocket\\IndexWebSocket");
            $caller->setAction('heartbeat');
        }

        return $caller;
    }

    /**
     * 打包下发的消息
     * @param Response $response    控制器返回的响应
     * @param WebSocketClient $client   当前客户端
     * @return null|string
     */
    public function encode(Response $response, $client): ?string
    {
        return $response->getMessage();
    }
}