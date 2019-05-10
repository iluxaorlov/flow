<?php

return [
    '/^$/' => [Controller\ChatController::class, 'chat'],
    '/^login$/' => [Controller\UserController::class, 'login'],
    '/^register$/' => [Controller\UserController::class, 'register'],
    '/^send$/' => [Controller\MessageController::class, 'send'],
    '/^pull$/' => [Controller\MessageController::class, 'pull'],
    '/^load$/' => [Controller\MessageController::class, 'load']
];