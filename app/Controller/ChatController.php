<?php

namespace App\Controller;

class ChatController extends AbstractController
{
    public function chat()
    {
        $this->view->render('chat/chat.php', [
            'title' => 'Flux • Анонимный групповой чат'
        ]);
    }
}