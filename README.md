# phalcon-midddleware
a phalcon middleware component
## 安装
`composer require myph/phalcon-middleware`
## 配置
在service.php中添加
```php
  $di->setShared('middlewareManager',function(){
    $middlewareManager = new \Myph\Middleware\Manager();
    //注册中间件
    $middlewareManager->add('middlewareAlias','middlewareHandle');
    // ...
    return $middleware
  });
  //替换默认的dispatcher
  $di->setShared('dispatcher',\Myph\Dispatcher::class);
```
## 使用
* 创建中间件

  中间件必须继承`Myph\Middleware`这个类,并实现`handle($request,\Closure $next)`方法
  
  example:
  ```php
  <?php

  namespace App\Middleware;

  use Myph\Middleware;

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
   ```
* 注册中间件
  ```php
    $middlewareManager->add('middlewareAlias1',App\Middleware\Aaa::class);
    $middlewareManager->add('middlewareAlias2','middlewareHandle2');
    $middlewareManager->add('middlewareAlias3','middlewareHandle3');
  ```
* 分配中间件
  * 全局中间件
  
  若希望每个请求都会经过的中间件,可以添加全局中间件
  
  添加全局中间件只需在middlewareManger服务中使用`set`方法
  
  example:
  ```
    $middlewareManager->set('aaa');
    //or
    $middlewareManger->set(['bbb','ccc']);
  ```
  * 在控制器中分配
    
  在控制器的`initialize()`方法中调用middlewareManger服务
  
  example:
  ```php
    public function initialize()
    {
       $this->middleware->set(
          ['csrf','auth'],
          [
            //这里可以使用only和except,对应的参数是方法名
            'except'=>['login','register']
          ]
       );
    }
  ```
  * 使用Annotations
  使用annotations可以直接在控制器类或者方法的注释中分配中间件
  example:
  ```php
    <?php

    namespace App\Controllers;

    /**
     * @Middleware('bbb');
     */
    class IndexController extends ControllerBase
    {
       /**
        * @Middleware('aaa','csrf','auth')
        */
        public function index()
        {
            echo __METHOD__.'<hr>';
        }
     }
  ```
    禁用annotationsMiddleware,可以在middlewareManager中使用`$middlewareManger->useAnnotations(false);`来禁用annotation
    
## 其他
  管理中间件可以单独使用一个文件来管理
  
  example:
  ```php
  $di->setShared('middlewareManager',function(){
      $middlewareManager = new \Myph\Middleware\Manger();
      require $this->get('config')->application->configDir.'middleware.php';
      return $middlewareManager;
   });
  ```
 为什么要重写dispatcher?

  这里实现Phalcon的middleware是使用Myph\Dispatcher继承Phalcon\Mvc\Dispatcher重写了里面的_dispatch方法的,这个Myph\Dispatcher依赖于middlewareManager服务.
        
  Phalcon原本的Phalcon\Mvc\Dispather是里面的Hooks是先是beforeExecuteRoute,后是调用控制器的initalize方法,执行handle后fire afterExecuteRoute的,这里如果不重写dispatcher的话,就不能实现initalize中分配中间件,只能使用annotations,而且,需要把Middleware中前置后置操作分开写.
