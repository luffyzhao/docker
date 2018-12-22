<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/22
 * Time: 15:26
 */

namespace App\Controller\Http;


use EasySwoole\Http\AbstractInterface\AbstractRouter;
use FastRoute\RouteCollector;
use Swoole\Http\Request;
use Swoole\Http\Response;

class Router extends AbstractRouter
{

    function initialize(RouteCollector $routeCollector)
    {
        $routeCollector->get('/','Main/index');

        $this->setMethodNotAllowCallBack(function (Request $request,Response $response){
            $response->write('未找到处理方法');
        });
        $this->setRouterNotFoundCallBack(function (Request $request,Response $response){
            $response->write('未找到路由匹配');
        });
    }
}