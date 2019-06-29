<?php

namespace App\Controller;

use App\View\View;

abstract class AbstractController
{
    protected $authorizedUser;
    protected $view;

    public function __construct()
    {
        // find user by token from cookie
        $this->authorizedUser = UserController::findUserByToken();
        $this->view = new View(__DIR__ . '/../../templates');
        $this->view->setUser($this->authorizedUser);
    }
}