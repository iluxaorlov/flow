<?php

error_reporting(0);

try {
    require_once __DIR__ . '/../vendor/autoload.php';
    $route = $_GET['route'] ?? '';
    $routes = require_once __DIR__ . '/../app/Settings/Routes.php';
    
    foreach ($routes as $pattern => $controllerAndAction) {
        if (preg_match($pattern, $route, $matches)) {
            break;
        }
    }
    
    if (!$matches) {
        throw new \App\Exceptions\NotFoundException();
    }

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];
    $controller = new $controllerName;
    $controller->$actionName($matches);

} catch (\App\Exceptions\NotFoundException $error) {
    $view = new \App\View\View(__DIR__ . '/../templates');
    $view->render('error/404.php', [], 404);
}