<?php

namespace PHPBB\Extra;

use PHPBB\Przemo\Core\Controller;
use PHPBB\Przemo\Core\Form;
use PHPBB\Przemo\Core\View;
use PHPBB\Przemo\Core\L10n;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPBB\Przemo\Core\StaticRegistry;
use PHPBB\Przemo\Core\Config;
use PHPBB\Przemo\Core\Store\SQL;

class RichController extends Controller
{
    
    /**
     * 
     * @author ikubicki
     * @return Form
     */
    protected function form()
    {
        return new Form($this->request);
    }
    
    /**
     *
     * @author ikubicki
     * @return L10n
     */
    protected function l10n()
    {
        if (!StaticRegistry::has('i10n')) {
            StaticRegistry::set('i10n', new L10n);
        }
        return StaticRegistry::get('i10n');
    }
    
    /**
     *
     * @author ikubicki
     * @return SQL
     */
    protected function sql()
    {
        if (!StaticRegistry::has('sql')) {
            StaticRegistry::set('sql', new SQL());
        }
        return StaticRegistry::get('sql');
    }
    
    /**
     * 
     * @author ikubicki
     * @return Config
     */
    protected function config()
    {
        return StaticRegistry::get('configuration');
    }
    
    /**
     *
     * @author ikubicki
     * @param steing $template
     * @param array $parameters
     */
    protected function html($template = null, array $parameters = null)
    {
        if (!$template) {
            $template = "{$this->application}/{$this->module}.html";
        }
        if ($parameters === null) {
            $parameters = $this->parameters->export();
        }
        $parameters['l10n'] = $this->l10n();
        $contents = $this->getView()->renderBody($template, $parameters);
        $this->response->setContent($contents);
    }
    
    /**
     *
     * @author ikubicki
     * @param array $parameters
     */
    protected function json(array $parameters = null)
    {
        if ($parameters === null) {
            $parameters = $this->parameters->export();
        }
        $this->response->setContent(json_encode($parameters));
    }
    
    /**
     *
     * @author ikubicki
     * @return View
     */
    protected function getView()
    {
        return new View;
    }
    
    /**
     *
     * @author ikubicki
     * @param string $action
     * @param string $module
     * @param array $parameters
     * @return Response
     */
    protected function get($action, $module = null, array $parameters = [])
    {
        return $this->go($action, $module, $parameters, Request::METHOD_GET);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $action
     * @param string $module
     * @param array $parameters
     * @return Response
     */
    protected function post($action, $module = null, array $parameters = [])
    {
        return $this->go($action, $module, $parameters, Request::METHOD_POST);
    }
}