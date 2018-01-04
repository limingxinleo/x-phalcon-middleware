<?php
// +----------------------------------------------------------------------
// | TestController.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\App\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Class IndexController
 * @package Tests\App\Controllers
 * @Middleware('test3')
 */
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
