<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/21
 * Time: 22:50
 */

namespace App\Redis;


use EasySwoole\Component\Pool\PoolObjectInterface;

class Redis extends \Redis implements PoolObjectInterface
{
    /**
     * @param $filename
     * @return string
     * @throws \Exception
     */
    protected function getLua($filename): string
    {
        $filename = EASYSWOOLE_ROOT.'/lua/'.$filename;
        if (!file_exists($filename)) {
            throw new \Exception('lua exists!');
        }

        if (!is_readable($filename)) {
            throw new \Exception('lua not readable!');
        }

        return file_get_contents($filename);

    }

    function gc()
    {
        $this->close();
    }

    function objectRestore()
    {

    }

    function beforeUse(): bool
    {
        return true;
    }
}