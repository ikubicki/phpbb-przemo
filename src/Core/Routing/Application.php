<?php

namespace PHPBB\Przemo\Core\Routing;

use PHPBB\Przemo\Core\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application
{

    protected $name;
    
    /**
     * 
     * @author ikubicki
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $module
     * @param array $parameters
     * @return Route
     */
    public function getRoute($module, array $parameters = [])
    {
        return new Route($this->name, $module, $parameters);
    }
    
    /**
     * 
     * @author ikubicki
     * @return Controller
     */
    public function getController()
    {
        return new Controller;
    }
    
    /**
     * 
     * @author ikubicki
     * @param Request $request
     * @return Route
     */
    public function findRoute(Request $request)
    {
        $module = 'index';
        $parameters = $request->query->all();
        if (!empty($parameters['module'])) {
            $module = $parameters['module'];
            unset($parameters['module']);
        }
        return $this->getRoute($module, $parameters);
    }
    
    /**
     * 
     * @author ikubicki
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request)
    {
        $route = $this->findRoute($request);
        return $this->getController()->dispatch($route, $request);
    }
}

