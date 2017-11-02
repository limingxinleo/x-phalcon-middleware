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
use Xin\Phalcon\Middleware\Middleware;

class Test3Middleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        $pass = $this->dispatcher->getParam('pass');
        if ($pass) {
            return $next($request);
        }

        return $this->response->setJsonContent([
            'success' => false,
        ]);
    }

}