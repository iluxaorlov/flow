<?php

return [
    '/^$/' => [\App\Controller\ChatController::class, 'chat'],
    '/^login$/' => [\App\Controller\UserController::class, 'login'],
    '/^register$/' => [\App\Controller\UserController::class, 'register'],
    '/^send$/' => [\App\Controller\MessageController::class, 'send'],
    '/^pull$/' => [\App\Controller\MessageController::class, 'pull'],
    '/^load$/' => [\App\Controller\MessageController::class, 'load']
];