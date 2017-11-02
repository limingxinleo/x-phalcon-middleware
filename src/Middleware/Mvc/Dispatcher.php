<?php

namespace Xin\Phalcon\Middleware\Mvc;

use Phalcon\Mvc\Dispatcher as MvcDispatcher;

class Dispatcher extends MvcDispatcher
{
    /**
     * @desc   重写 callActionMethod 方法
     * @author limx
     * @param mixed  $handler
     * @param string $actionMethod
     * @param array  $params
     * @return mixed
     */
    public function callActionMethod($handler, $actionMethod, array $params = array())
    {
        $dependencyInjector = $this->_dependencyInjector;
        $middlewareManager = $dependencyInjector->getShared('middlewareManager');
        return $middlewareManager->handle($handler, $actionMethod, $params);
    }
}