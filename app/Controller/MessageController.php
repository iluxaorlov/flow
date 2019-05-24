<?php

namespace Controller;

use Model\Messages;

class MessageController extends AbstractController
{
    /**
     * send a message from client
     * if there's no post request then throw exception
     */
    public function send()
    {
        if (!$_POST) {
            throw new \Exceptions\NotFoundException();
        }

        $user = $this->authorizedUser;
        $text = $_POST['text'];
        $message = Messages::send($user, $text);
    }

    /**
     * count number of all messages in database and then compare with number of messages in database that client have
     * while numbers are equal count number of all messages in database
     * once numbers aren't equal then count difference beetwen numbers and find last insert messages
     * if client haven't number of messages in database then find last 128 messages
     * send messages and new number of all messages in database to client
     * if there's no post request then throw exception
     */
    public function pull()
    {
        if (!$_POST) {
            throw new \Exceptions\NotFoundException();
        }
        
        $client = (integer)$_POST['countPull'];

        do {
            $server = (integer)Messages::countPull();
        } while ($server === $client);

        $limit = $server - $client ?? 128;
        $messages = Messages::pull($limit);

        if (!$messages) {
            return;
        }
        
        $response = $this->view->response('message' . DIRECTORY_SEPARATOR . 'message.php', [
            'messages' => $messages
        ]);

        echo json_encode(['server' => $server, 'response' => $response]);
    }

    /**
     * limit is a number of messages that will be loaded from database
     * offset is a number of messages on the page
     * if there's no post request then throw exception
     */
    public function load()
    {
        if (!$_POST) {
            throw new \Exceptions\NotFoundException();
        }

        $limit = 64;
        $offset = (integer)$_POST['offset'];
        $messages = Messages::load($limit, $offset);

        if (!$messages) {
            return;
        }

        $response = $this->view->response('message' . DIRECTORY_SEPARATOR . 'message.php', [
            'messages' => $messages
        ]);

        echo $response;
    }
}