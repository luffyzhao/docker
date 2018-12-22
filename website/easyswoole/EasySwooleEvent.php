<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use App\Events\WebSocketEvents;
use App\Pool\RedisPool;
use App\Process\HotReload;
use EasySwoole\Component\Di;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use Swoole\Server;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        date_default_timezone_set('Asia/Shanghai');
        // 定义http路径
        Di::getInstance()->set(SysConst::HTTP_CONTROLLER_NAMESPACE,'App\\Controller\\Http\\');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // 注册websocket回调事件
        WebSocketEvents::register($register);
        PoolManager::getInstance()->register(RedisPool::class,10);
        ServerManager::getInstance()->getSwooleServer()->addProcess((new HotReload('HotReload', ['disableInotify' => false]))->getProcess());
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return bool
     */
    public static function onRequest(Request $request, Response $response): bool
    {
        return true;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public static function afterRequest(Request $request, Response $response): void
    {
    }

    /**
     * @param Server $server
     * @param int $fd
     * @param int $reactor_id
     * @param string $data
     */
    public static function onReceive(Server $server, int $fd, int $reactor_id, string $data):void
    {

    }

}