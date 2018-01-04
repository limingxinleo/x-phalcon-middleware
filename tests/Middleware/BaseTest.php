<?php
// +----------------------------------------------------------------------
// | BaseTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Middleware;

use Phalcon\Http\Response;
use Tests\TestCase;

class BaseTest extends TestCase
{
    public function testBase()
    {
        $this->dispatcher->setControllerName('Index');
        $this->dispatcher->setActionName('index');

        $this->assertEquals('Tests\App\Controllers\IndexController', $this->dispatcher->getHandlerClass());
        $this->assertEquals('indexAction', $this->dispatcher->getActionName() . $this->dispatcher->getActionSuffix());
    }

    public function testNoMiddleware()
    {
        $this->dispatcher->setControllerName('Index');
        $this->dispatcher->setActionName('index');

        $obj = $this->dispatcher->dispatch();
        /** @var Response $response */
        $response = $obj->dispatcher->getReturnedValue();
        $json = $response->getContent();
        $result = json_decode($json, true);
        $this->assertTrue($result['success']);
    }

    public function testMiddlewareDeny()
    {
        $this->dispatcher->setControllerName('Index');
        $this->dispatcher->setActionName('test');

        $obj = $this->dispatcher->dispatch();
        /** @var Response $response */
        $response = $obj->dispatcher->getReturnedValue();
        $json = $response->getContent();
        $result = json_decode($json, true);
        $this->assertFalse($result['success']);
    }

    public function testMiddlewarePass()
    {
        $this->dispatcher->setControllerName('Index');
        $this->dispatcher->setActionName('test2');
        $this->dispatcher->setParam('pass', true);

        $obj = $this->dispatcher->dispatch();
        /** @var Response $response */
        $response = $obj->dispatcher->getReturnedValue();
        $json = $response->getContent();
        $result = json_decode($json, true);
        $this->assertTrue($result['success']);
    }
}
