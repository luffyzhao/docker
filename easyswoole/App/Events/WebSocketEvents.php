<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/21
 * Time: 22:55
 */

namespace App\Events;

use App\Consts\UserConst;
use App\Parser\WebSocketParser;
use App\Pool\RedisPool;
use App\Redis\WebSocketRedis;
use App\Utility\UserAuth;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\Socket\Config;
use EasySwoole\Socket\Dispatcher;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class WebSocketEvents
{
    protected static $dispatch = null;

    /**
     * @param EventRegister $register
     * @throws \Exception
     */
    public static function register(EventRegister $register)
    {
        // websocket dispatch 保存在内存里不要每次都 new
        self::getDispatch();
        // 收到客户端消息时的处理
        $register->set(EventRegister::onMessage, [self::class, 'onMessage']);
        // 握手
        $register->set(EventRegister::onHandShake, [self::class, 'onHandShake']);
        // 链接打开
        $register->set(EventRegister::onOpen, [self::class, 'onOpen']);
        // 链接关闭时的处理
        $register->set(EventRegister::onClose, [self::class, 'onClose']);
        // 启动时清理 在线用户列表直接清空
        $register->add(EventRegister::onWorkerStart, [self::class, 'onWorkerStart']);
    }


    /**
     * 握手检查 用户验证
     * @param Request $request
     * @return bool
     */
    public static function onWebSocketHandCheck(Request $request): bool
    {
        try {
            $auth = new UserAuth();
            $parse = $auth->decrypt($request->get['auth'] ?? '');
            $parse->verify();

            $redisPool = PoolManager::getInstance()->getPool(RedisPool::class);
            $redis = $redisPool->getObj();
            if ($redis instanceof WebSocketRedis) {
                if (!$redis->verifyUser($parse)) {
                    $redisPool->recycleObj($redis);

                    return false;
                }
                $redisPool->recycleObj($redis);
            } else {
                throw new \Exception('redis pool is empty');
            }
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return bool
     * @throws \Exception
     */
    public static function onHandShake(Request $request, Response $response): bool
    {
        if (!self::onWebSocketHandCheck($request)) {
            $response->end();

            return false;
        }

        // websocket握手连接算法验证
        $secWebSocketKey = $request->header['sec-websocket-key'];
        $patten = '#^[+/0-9A-Za-z]{21}[AQgw]==$#';
        if (0 === preg_match($patten, $secWebSocketKey) || 16 !== strlen(base64_decode($secWebSocketKey))) {
            $response->end();

            return false;
        }
        $key = base64_encode(
            sha1(
                $request->header['sec-websocket-key'].'258EAFA5-E914-47DA-95CA-C5AB0DC85B11',
                true
            )
        );

        $headers = [
            'Upgrade' => 'websocket',
            'Connection' => 'Upgrade',
            'Sec-WebSocket-Accept' => $key,
            'Sec-WebSocket-Version' => '13',
        ];

        if (isset($request->header['sec-websocket-protocol'])) {
            $headers['Sec-WebSocket-Protocol'] = $request->header['sec-websocket-protocol'];
        }

        foreach ($headers as $key => $val) {
            $response->header($key, $val);
        }

        $response->status(101);
        $response->end();

        ServerManager::getInstance()->getSwooleServer()->defer(
            function () use ($request) {
                go(
                    function () use ($request) {
                        self::onOpen(ServerManager::getInstance()->getSwooleServer(), $request);
                    }
                );
            }
        );

        return true;

    }

    /**
     * 链接打开时保存fd
     * @param Server $server
     * @param Request $request
     * @throws \Exception
     */
    public static function onOpen(Server $server, Request $request)
    {
        $redisPool = PoolManager::getInstance()->getPool(RedisPool::class);
        $redis = $redisPool->getObj();
        if ($redis instanceof WebSocketRedis) {
            $auth = new UserAuth();
            $parse = $auth->decrypt($request->get['auth'] ?? '');

            $redis->bind($request->fd, $parse->getUid(), $parse->getType());


            $redisPool->recycleObj($redis);
        } else {
            throw new \Exception('redis pool is empty');
        }
    }

    /**
     * 链接关闭时 将用户的删除fd
     * @param Server $server
     * @param int $fd
     * @param int $reactorId 来自那个reactor线程
     * @throws \Exception
     */
    public static function onClose(Server $server, int $fd, int $reactorId)
    {
        $redisPool = PoolManager::getInstance()->getPool(RedisPool::class);
        $redis = $redisPool->getObj();
        if ($redis instanceof WebSocketRedis) {
            $redis->unBind($fd);
            $redisPool->recycleObj($redis);
        } else {
            throw new \Exception('redis pool is empty');
        }
    }

    /**
     * 接收到客户端消息时回调函数
     * @param Server $server
     * @param Frame $frame
     * @throws \Exception
     */
    public static function onMessage(Server $server, Frame $frame)
    {
        self::getDispatch()->dispatch($server, $frame->data, $frame);
    }

    /**
     * worker 进程启动时回调函数
     * @param Server $server
     * @param $workerId
     */
    public static function onWorkerStart(Server $server, $workerId)
    {
        // 启动时清空所有的用户
        if ($workerId === 0) {
            self::cleanOnlineUser();
        }
    }

    /**
     * 清空所有用户
     */
    public static function cleanOnlineUser()
    {
        echo "清空所有用户";
    }

    /**
     * 获取 dispatcher
     * @return Dispatcher
     * @throws \Exception
     */
    public static function getDispatch(): Dispatcher
    {
        if (self::$dispatch === null) {
            echo "创建getDispatch\n";
            $conf = new Config();
            $conf->setType(Config::WEB_SOCKET);
            $conf->setParser(new WebSocketParser);
            self::$dispatch = new Dispatcher($conf);
        }

        return self::$dispatch;
    }
}