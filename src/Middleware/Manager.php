<?php

namespace Xin\Phalcon\Middleware;

use Xin\Phalcon\Middleware;
use Phalcon\Di\Injectable;

class Manager extends Injectable
{

    protected $middlewares = [];

    protected $middlewareGroup = [];

    protected $activeMiddleware = [];

    protected $useAnnotations = true;

    public function add($alias, $handle)
    {
        $this->middlewares[$alias] = $handle;
    }

    public function get($alias = null)
    {
        if (empty($alias)) {
            return $this->middlewares;
        } else {
            return $this->middlewares[$alias] ?: false;
        }
    }

    public function has($alias)
    {
        return isset($this->middlewares[$alias]);
    }

    public function set($aliases, $options = [])
    {
        if (!is_array($aliases) && !is_string($aliases)) {
            throw new Exception('aliases must a string or array!');
            return;
        }
        if (!empty($options)) {
            $action = $this->dispatcher->getActionName();
            $append = true;
            if (isset($options['only'])) {
                if (!in_array($action, $options['only'])) {
                    $append = false;
                }
            }
            if (isset($options['except'])) {
                if (in_array($action, $options['except'])) {
                    $append = false;
                }
            }
            if (!$append) {
                return;
            }
        }
        if (is_string($aliases)) {
            $aliases = [$aliases];
        }
        foreach ($aliases as $alias) {
            if (array_key_exists($alias, $this->activeMiddleware)) {
                continue;
            }
            if (array_key_exists($alias, $this->middlewares)) {
                $this->activeMiddleware[$alias] = $this->middlewares[$alias];
            }
        }
    }

    public function useAnnotations($status)
    {
        $this->useAnnotations = $status;
    }

    public function getMiddlewareAnnotations($handler, $actionMethod)
    {
        $aliases = [];
        $annotataionsService = $this->annotations;
        $controllerName = get_class($handler);
        $controllerAnnotations = $annotataionsService->get($controllerName)->getClassAnnotations();
        if ($controllerAnnotations->has('Middleware')) {
            $aliases = $controllerAnnotations->get('Middleware')->getArguments() ?: [];
        }
        $methodAnnotations = $annotataionsService->getMethod($controllerName, $actionMethod);
        if ($methodAnnotations->has('Middleware')) {
            $aliases = array_merge($aliases, ($methodAnnotations->get('Middleware')->getArguments() ?: []));
        }
        if (!empty($aliases)) {
            $this->set($aliases);
        }
    }

    public function handle($handler, $actionMethod, $params)
    {
        if ($this->useAnnotations) {
            $this->getMiddlewareAnnotations($handler, $actionMethod);
        }
        $callback = function () use ($handler, $actionMethod, $params) {
            return call_user_func_array([$handler, $actionMethod], $params);
        };
        if (!empty($this->activeMiddleware)) {
            while ($middleware = array_shift($this->activeMiddleware)) {
                $middleware = new $middleware();
                if (!($middleware instanceof Middleware)) {
                    throw new Exception('Invalid a Middleware Handle!');
                }
                $callback = function () use ($middleware, $callback) {
                    return call_user_func_array([$middleware, 'handle'], [$middleware, $callback]);
                };
            }
        }
        return $callback();
    }
}