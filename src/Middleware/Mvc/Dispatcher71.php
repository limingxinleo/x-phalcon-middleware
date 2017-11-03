<?php

namespace Xin\Phalcon\Middleware\Mvc;

use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Xin\Phalcon\Middleware\Manager;

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
    public function callActionMethod($handler, $actionMethod, ?array $params = [])
    {
        /** @var DiInterface $dependencyInjector */
        $dependencyInjector = $this->_dependencyInjector;
        if ($dependencyInjector->has('middleware')) {
            $middlewareManager = $dependencyInjector->getShared('middleware');
            if ($middlewareManager instanceof Manager) {
                return $middlewareManager->handle($handler, $actionMethod, $params);
            }
        }
        return parent::callActionMethod($handler, $actionMethod, $params);
    }
}