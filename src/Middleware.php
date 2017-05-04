<?php

namespace Myph;

use Phalcon\Di\Injectable;

abstract class Middleware extends Injectable
{
    abstract public function handle($request, \Closure $next);
}