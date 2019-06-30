<?php

namespace App\Controller;

use App\Model\Messages;

class MessageController extends AbstractController
{
    public function send()
    {
        if (!$_POST) {
            throw new \App\Exceptions\NotFoundException();
        }

        $user = $this->authorizedUser;
        $text = $_POST['text'];
        // save message to database
        $message = Messages::send($user, $text);
    }

    public function pull()
    {
        if (!$_POST) {
            throw new \App\Exceptions\NotFoundException();
        }
        
        // number of messages that saved on client
        $client = (integer)$_POST['count'];

        do {
            // count number of messages in database
            $server = (integer)Messages::count();
        } while ($server === $client);

        if ($client === 0) {
            $limit = 128;
        } else {
            $limit = $server - $client;
        }

        // get messages from database
        $messages = Messages::pull($limit);

        if (!$messages) {
            return;
        }
        
        $response = $this->view->response('message/message.php', [
            'messages' => $messages
        ]);

        echo json_encode([
            'server' => $server,
            'response' => $response
        ]);
    }

    public function load()
    {
        if (!$_POST) {
            throw new \App\Exceptions\NotFoundException();
        }

        // number of messages that will be loaded from database
        $limit = 64;
        // number of messages on the page
        $offset = (integer)$_POST['offset'];
        // get messages from database
        $messages = Messages::load($limit, $offset);

        if (!$messages) {
            return http_response_code(204);
        }

        $response = $this->view->response('message/message.php', [
            'messages' => $messages
        ]);

        echo $response;
    }
}