# x-phalcon-middleware
a phalcon middleware component

[![Build Status](https://travis-ci.org/limingxinleo/x-phalcon-middleware.svg?branch=master)](https://travis-ci.org/limingxinleo/x-phalcon-middleware)

## 感谢
[https://github.com/shouhuyou/phalcon-midddleware.git](https://github.com/shouhuyou/phalcon-midddleware.git)

## 安装
`composer require limingxinleo/x-phalcon-middleware`

## 配置
添加服务
~~~php
<?php
 
use Xin\Phalcon\Middleware\Mvc\Dispatcher as MvcDispatcher;
use Xin\Phalcon\Middleware\Mvc\Dispatcher71 as MvcDispatcher71;

$di->setShared('middlewareManager', function () {
    $middlewareManager = new Manager();
    //注册中间件
    $middlewareManager->add('test', \Tests\App\Middleware\Test1Middleware::class);
    $middlewareManager->add('test2', \Tests\App\Middleware\Test2Middleware::class);
    $middlewareManager->add('test3', \Tests\App\Middleware\Test3Middleware::class);

    return $middlewareManager;
});

//替换默认的dispatcher
$di->setShared('dispatcher', function () {

    if (version_compare(PHP_VERSION, '7.1', '>')) {
        $dispatcher = new MvcDispatcher71();
    } else {
        $dispatcher = new MvcDispatcher();
    }
    $dispatcher->setDefaultNamespace('Tests\App\Controllers');

    return $dispatcher;
});
~~~

## 使用
* 创建中间件
~~~php
<?php

namespace App\Middleware;

use Xin\Phalcon\Middleware\Middleware;

class Aaa extends Middleware
{
 public function handle($request ,\Closure $next)
 {
     //在中间件中使用service
     if($this->request->isAjax()){
         return $this->response->redirect('/login');
      }
      //前置操作
      echo __METHOD__.'<hr>';
      $response = $next($request);
     //后置操作
      echo __METHOD__.'<hr>';
    
     return $response;
  }
}
~~~

* 控制器中使用中间件
~~~php
<?php
namespace Tests\App\Controllers;
class Controller extends \Phalcon\Mvc\Controller
{
    public function onConstruct()
    {
        /**
         * 过滤掉登陆页面的中间件
         *
         */
        $this->middleware->set([
            'adminAuth'
        ],[
            'except' => [
                'admin.auth.index',
                'admin.auth.login'
            ]
        ]);
    }
}


<?php
namespace Tests\App\Controllers;
class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->response->setJsonContent([
            'success' => true,
            'data' => ['action' => 'index']
        ]);
    }

    /**
     * @desc
     * @author limx
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @Middleware('test')
     */
    public function testAction()
    {
        return $this->response->setJsonContent([
            'success' => true,
            'data' => ['action' => 'test']
        ]);
    }

    /**
     * @desc
     * @author limx
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @Middleware('test2')
     */
    public function test2Action()
    {
        return $this->response->setJsonContent([
            'success' => true,
            'data' => ['action' => 'test2']
        ]);
    }

    /**
     * @desc
     * @author limx
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @Middleware('test2')
     * @Middleware('test3')
     */
    public function test3Action()
    {
        return $this->response->setJsonContent([
            'success' => true,
            'data' => ['action' => 'test2']
        ]);
    }
}
~~~

## 中间件执行顺序
中间件定义
~~~
class OneMiddleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        echo 'One1' . PHP_EOL;
        $response = $next($request);
        echo 'One2' . PHP_EOL;
        return $response;
    }
}

class TwoMiddleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        echo 'Two1' . PHP_EOL;
        $response = $next($request);
        echo 'Two2' . PHP_EOL;
        return $response;
    }
}

class ThreeMiddleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        echo 'Three1' . PHP_EOL;
        $response = $next($request);
        echo 'Three2' . PHP_EOL;
        return $response;
    }
}

class FourMiddleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        echo 'Four1' . PHP_EOL;
        $response = $next($request);
        echo 'Four2' . PHP_EOL;
        return $response;
    }
}
~~~

使用如下
~~~
/**
 * Class IndexController
 * @package Tests\App\Controllers
 * @Middleware('sort1')
 */
class IndexController extends Controller
{
    public function initialize()
    {
        $this->middleware->set([
            'abs',
            'test3'
        ]);
    }
    
    /**
     * @Middleware('sort2')
     * @Middleware('sort3')
     */
    public function indexAction()
    {
        return $this->response->setJsonContent([
            'success' => true,
            'data' => ['action' => 'index']
        ]);
    }
}
~~~

结果
~~~
'abs.start',
'test3.start',
'sort1.start',
'sort2.start',
'sort3.start',
'sort3.end',
'sort2.end',
'sort1.end',
'test3.end',
'abs.end',
~~~
