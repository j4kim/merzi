<?php

namespace J4kim\Merzi;

use Bramus\Router\Router;
use League\Plates\Engine;

class App
{
    private Router $router;
    private Engine $templates;

    public function __construct()
    {
        session_start();
        $this->router = new Router();
        $this->templates = new Engine('../views');;
        $this->registerRoutes();
        $this->router->run();
    }

    private function registerRoutes()
    {
        $this->router->get('/', function () {
            echo $this->templates->render('home');
        });
        $this->router->get('/login', function () {
            echo $this->templates->render('login');
        });
    }
}
