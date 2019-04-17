<?php
$workerNum = 1;
$pool = new Swoole\Process\Pool($workerNum);

$pool->on("WorkerStart", function ($pool, $workerId) {
    
});

$pool->on("WorkerStop", function ($pool, $workerId) {
    
});

$pool->start();