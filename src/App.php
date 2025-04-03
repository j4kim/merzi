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
            if (!Auth::check()) {
                header('Location: /login');
                return;
            }
            echo $this->templates->render('home');
        });

        $this->router->get('/login', function () {
            echo $this->templates->render(Auth::check() ? 'logout' : 'login');
        });

        $this->router->post('/login', function () {
            if (Auth::login($_POST['passphrase'])) {
                header('Location: /');
                return;
            }
            echo $this->templates->render('login', ['error' => '😭 Mauvais mot de passe...']);
        });

        $this->router->post('/logout', function () {
            Auth::logout();
            header('Location: /login');
        });

        $this->router->get('/api/events', function () {
            $calendars = Config::calendars();
            foreach ($calendars as $cal) {
                $cal->ics = file_get_contents($cal->url);
            }
            echo json_encode($calendars);
        });
    }
}
