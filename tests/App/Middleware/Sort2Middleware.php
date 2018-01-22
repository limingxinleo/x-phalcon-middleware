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
use Tests\App\SortClient;
use Xin\Phalcon\Middleware\Middleware;

class Sort2Middleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        SortClient::getInstance()->start('sort2');
        $result = $next($request);
        SortClient::getInstance()->end('sort2');
        return $result;
    }
}
