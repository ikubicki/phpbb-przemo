<?php

namespace PHPBB\Przemo\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Board
{
    /**
     * @var Config
     */
    public $config;
    
    /**
     * @var User
     */
    public $user;
    
    /**
     * @var View
     */
    public $view;
    
    /**
     * @var Request
     */
    public $request;
    
    /**
     * @var Response
     */
    public $response;
    
    
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
    
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    
    public function setView(View $view)
    {
        $this->view = $view;
    }
    
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
    
    public function createResponse($content = '', int $status = 200, array $headers = [])
    {
        $response = new Response($content, $status, $headers);
        $this->setResponse($response);
        return $response;
    }
    
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}