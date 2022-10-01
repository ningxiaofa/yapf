<?php

namespace app\controllers;

use app\models\Test;
use GuzzleHttp\Client;
use Exception;
use League\Csv\Reader;

class TestController extends BaseController
{
    public function index()
    {
        p('it is index action of testController !');
    }

    public function all()
    {
        $test = new Test();
        $ret = $test->all();
        dump($ret);
    }
}
