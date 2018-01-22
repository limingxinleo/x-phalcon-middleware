<?php
// +----------------------------------------------------------------------
// | SortClient.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\App;

class SortClient
{
    public static $_instance;

    public $sortMiddlewareArray = [];

    public static function getInstance()
    {
        if (isset(static::$_instance)) {
            return static::$_instance;
        }
        return static::$_instance = new static();
    }

    public function start($middle)
    {
        $this->sortMiddlewareArray[] = $middle . '.start';
    }

    public function end($middle)
    {
        $this->sortMiddlewareArray[] = $middle . '.end';
    }

    public function flush()
    {
        $this->sortMiddlewareArray = [];
    }

}