<?php
// +----------------------------------------------------------------------
// | BaseController.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\App\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Class BaseController
 * @package Tests\App\Controllers
 * @Milldeware('abs')
 */
abstract class BaseController extends Controller
{
    public function initialize()
    {
        $this->middleware->set([
            'abs'
        ]);
    }
}