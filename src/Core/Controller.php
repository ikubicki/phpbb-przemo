<?php

namespace PHPBB\Przemo\Core;

use PHPBB\Przemo\Core\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    
    /**
     * @var string
     */
    const FAILURE_NO_MODULE = 'Module not found';
    
    /**
     * @var string
     */
    const FAILURE_NO_ACTION = 'Action not found';
    
    /**
     * @var string
     */
    public $application;
    
    /**
     * @var string
     */
    public $module;
    
    /**
     * @var Registry
     */
    protected $parameters;
    
    /**
     * @var Request
     */
    protected $request;
    
    /**
     * @var Response
     */
    protected $response;
    
    /**
     * 
     * @author ikubicki
     */
    public function __construct()
    {
        $this->parameters = new Registry;
        $this->response = new Response;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $parameter
     * @param mixed $value
     */
    public function __set($parameter, $value)
    {
        $this->parameters->set($parameter, $value);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $parameter
     * @return mixed
     */
    public function __get($parameter)
    {
        return $this->parameters->get($parameter);
    }
    
    /**
     * 
     * @author ikubicki
     * @param Route $route
     * @param Request $request
     * @return Response
     */
    public function dispatch(Route $route, Request $request)
    {
        $application = ucfirst($route->application);
        $module = ucfirst($route->module);
        $classname = "\\PHPBB\\Applications\\{$application}\\{$module}";
        if (!class_exists($classname)) {
            return $this->handleFailure(self::FAILURE_NO_MODULE, $route, $request);
        }
        $controller = new $classname;
        $controller->application = $route->application;
        $controller->module = $route->module;
        $controller->request = $request;
        return $controller->handle($route, $request);
    }
    
    /**
     *
     * @author ikubicki
     * @param string $action
     * @param string $module
     * @param array $parameters
     * @param string $method
     * @return Response
     */
    public function go($action, $module = null, array $parameters = [], $method = null)
    {
        if ($method) {
            $this->request->setMethod($method);
        }
        $parameters['action'] = $action;
        if (!$module) {
            $route = new Route($this->application, $this->module, $parameters);
            return $this->handle($route, $this->request);
        }
        
        $route = new Route($this->application, $module, $parameters);
        $response = $this->dispatch($route, $this->request);
        return $this->response = $response;
    }
    
    /**
     * 
     * @author ikubicki
     * @param Route $route
     * @param Request $request
     */
    protected function handle(Route $route, Request $request)
    {
        $action = $route->getAction($request->get('action', 'index'));
        $method = $this->getAction($request->getMethod(), $action);
        if (!method_exists($this, $method)) {
            return $this->handleFailure(self::FAILURE_NO_ACTION, $route, $request);
        }
        call_user_func_array([$this, $method], [$request, $route]);
        return $this->response;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $method
     * @param string $action
     * @return string
     */
    protected function getAction($method, $action)
    {
        return strtolower($method) . ucfirst($action); 
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $failureType
     * @param Route $route
     * @param Request $request
     */
    protected function handleFailure($failureType, Route $route, Request $request)
    {
        throw new \Exception($failureType . ' for ' . $request->getMethod() . ' '  . json_encode($route));
    }
    
    /**
     *
     * @author ikubicki
     * @param string $action
     * @param array $parameters
     * @return Route
     */
    protected function getModuleRoute($action, array $parameters = [])
    {
        $parameters['action'] = $action;
        return new Route($this->application, $this->module, $parameters);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $module
     * @param string $action
     * @param array $parameters
     * @return Route
     */
    protected function getApplicationRoute($module, $action, array $parameters = [])
    {
        $parameters['action'] = $action;
        return new Route($this->application, $module, $parameters);
    }
}