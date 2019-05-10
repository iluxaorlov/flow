<?php

namespace Controller;

use View\View;

abstract class AbstractController
{
    protected $authorizedUser;
    protected $view;

    public function __construct()
    {
        $this->authorizedUser = UserController::findUserByToken();
        $this->view = new View(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'templates');
        $this->view->setUser($this->authorizedUser);
    }
}