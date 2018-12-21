<?php
/**
 * Created by PhpStorm.
 * User: Luffy Zhao
 * DateTime: 2018/12/21 15:27
 * Email: luffyzhao@vip.126.com
 */

namespace App\Crontab;


use EasySwoole\EasySwoole\Crontab\AbstractCronTask;

class TestCrontab extends AbstractCronTask
{

    public static function getRule(): string
    {
        return '*/1 * * * *';
    }

    public static function getTaskName(): string
    {
        return "测试定时任务";
    }

    static function run(\swoole_server $server, int $taskId, int $fromWorkerId)
    {
        var_dump('run once every two minutes');
    }
}