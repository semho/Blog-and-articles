<?php

namespace App;

use App\Exception\ApplicationException;
use App\Exception\HttpException;
use App\View\Renderable;
use App\View\View;
use Illuminate\Database\Capsule\Manager as Capsule;

class Application
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->initialize();
    }

    private function initialize()
    {
        //инициализируем страрт сессии, если его не было
        if (!Session::isStarted()) {
            Session::init();
        }

        $config = new Config;
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $config->getConfig('db.host'),
            'database' => $config->getConfig('db.dbname'),
            'username' => $config->getConfig('db.username'),
            'password' => $config->getConfig('db.password'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function run(string $url, string $method)
    {
        try {
            $result = $this->router->dispatch($url, $method);
            if ($result instanceof Renderable) {
                $result->render();
            } else {
                echo $result;
            }
        } catch (ApplicationException $e) {
            $this->renderException($e);
        }
    }

    public function renderException(ApplicationException $e)
    {
        if ($e instanceof Renderable) {
            $e->render();
        } elseif ($e instanceof HttpException) {
            $code = $e->getCode() ? : 500;
            http_response_code($code);
            $view = new View('errors/error', ['code' => $code, 'message' => $e->getMessage()]);
            $view->render();
        } 
    }
}
