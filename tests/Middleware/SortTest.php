<?php
// +----------------------------------------------------------------------
// | MultiTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Middleware;

use Phalcon\Http\Response;
use Tests\App\SortClient;
use Tests\TestCase;

class SortTest extends TestCase
{
    public function testMiddlewarePassMulti()
    {
        $this->dispatcher->setControllerName('Sort');
        $this->dispatcher->setActionName('index');

        $obj = $this->dispatcher->dispatch();
        /** @var Response $response */
        $response = $obj->dispatcher->getReturnedValue();
        $json = $response->getContent();
        $result = json_decode($json, true);
        $this->assertTrue($result['success']);

        dd(SortClient::getInstance()->sortMiddlewareArray);
    }
}
