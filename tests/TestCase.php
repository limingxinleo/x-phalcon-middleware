<?php
// +----------------------------------------------------------------------
// | TestCase.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests;

use Phalcon\Di\FactoryDefault;
use PHPUnit\Framework\TestCase as UnitTestCase;
use Phalcon\Config;
use Xin\Phalcon\Middleware\Manager;
use Xin\Phalcon\Mvc\Dispatcher;

class TestCase extends UnitTestCase
{
    public $di;

    public function setUp()
    {
        $di = new FactoryDefault();
        $di->setShared('middlewareManager', function () {
            $middlewareManager = new Manager();
            //注册中间件
            $middlewareManager->add('test', \Tests\App\Middleware\Test1Middleware::class);

            return $middlewareManager;
        });
        //替换默认的dispatcher
        $di->setShared('dispatcher', \Xin\Dispatcher::class);
    }
}