<?php

error_reporting(0);

try {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
    $route = $_GET['route'] ?? '';
    $routes = require_once __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Settings' . DIRECTORY_SEPARATOR . 'Routes.php';
    
    foreach ($routes as $pattern => $controllerAndAction) {
        if (preg_match($pattern, $route, $matches)) {
            break;
        }
    }
    
    if (!$matches) {
        throw new \Exceptions\NotFoundException();
    }

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];
    $controller = new $controllerName;
    $controller->$actionName($matches);

} catch (\Exceptions\NotFoundException $error) {
    header('Location: /');
}