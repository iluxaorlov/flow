<?php

namespace Controller;

use Model\Message;

class ChatController extends AbstractController
{
    public function chat()
    {
        $this->view->render('chat' . DIRECTORY_SEPARATOR . 'chat.php', [
            'title' => 'Flux'
        ]);
    }
}