<?php

namespace App\View;

class View
{
    private $templatesFolder;
    private $authorizedUser = [];

    public function __construct(string $templatesFolder)
    {
        $this->templatesFolder = $templatesFolder;
    }

    public function setUser($authorizedUser)
    {
        $this->authorizedUser['authorizedUser'] = $authorizedUser;
    }

    public function render(string $template, array $variables = [], int $responseCode = 200)
    {
        ob_start();
        http_response_code($responseCode);
        extract($variables);
        extract($this->authorizedUser);
        require_once $this->templatesFolder . '/' . $template;
        $response = ob_get_contents();
        ob_end_clean();
        echo $response;
    }

    public function response(string $template, array $variables = [])
    {
        ob_start();
        extract($variables);
        extract($this->authorizedUser);
        require_once $this->templatesFolder . '/' . $template;
        $response = ob_get_contents();
        ob_end_clean();
        return $response;
    }
}