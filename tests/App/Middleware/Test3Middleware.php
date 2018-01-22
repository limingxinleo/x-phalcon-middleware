<?php
// +----------------------------------------------------------------------
// | Test1Middleware.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\App\Middleware;

use Closure;
use Phalcon\Di\FactoryDefault;
use Tests\App\SortClient;
use Xin\Phalcon\Middleware\Middleware;

class Test3Middleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        SortClient::getInstance()->start('test3');
        $res = $next($request);
        SortClient::getInstance()->end('test3');
        return $res;
    }
}
