<?php
// +----------------------------------------------------------------------
// | TestController.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\App\Controllers;

/**
 * Class IndexController
 * @package Tests\App\Controllers
 * @Middleware('sort1')
 */
class SortController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * @desc
     * @author limx
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
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
