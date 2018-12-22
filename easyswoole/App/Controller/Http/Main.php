<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/21
 * Time: 23:25
 */

namespace App\Controller\Http;


use App\Controller\Http;

class Main extends Http
{

    public function index()
    {
        $this->response()->write(file_get_contents(EASYSWOOLE_ROOT . '/App/Views/Index/index.html'));
    }
}