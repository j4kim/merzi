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
            Auth::checkAndRedirect();
            echo $this->templates->render('home');
        });

        $this->router->get('/settings', function () {
            Auth::checkAndRedirect();
            echo $this->templates->render('settings');
        });

        $this->router->post('/settings', function () {
            Auth::checkAndRedirect();
            $calendars = [];
            foreach ($_POST['name'] as $index => $name) {
                $calendars[] = [
                    'name' => $name,
                    'url' => $_POST['url'][$index],
                    'enabled' => in_array($index, $_POST['enabled']),
                ];
            }
            Config::store([
                'calendars' => $calendars,
                'showIndividualCalendars' => isset($_POST['showIndividualCalendars'])
            ]);
            header('Location: /');
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

        $this->router->get('/api/calendars', function () {
            echo json_encode([
                'calendars' => Calendar::getCalendars(),
                'showIndividualCalendars' => Config::showIndividualCalendars(),
            ]);
        });
    }
}
