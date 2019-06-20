<?php

namespace PHPBB\Przemo\Core;

use Twig\Loader\LoaderInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    
    /**
     * @var LoaderInterface
     */
    protected $twigLoader;
    
    /**
     * @var Environment
     */
    protected $twigInstance;
    
    /**
     * 
     * @author ikubicki
     * @param string $body
     * @param array $context
     * @return string
     */
    public function renderBody($template, array $context = [])
    {
        return $this->getTwig()->render($template, $context);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->getConfig()->get('view')->set('theme', $theme);
    }
    
    /**
     * 
     * @author ikubicki
     * @return \Twig\Environment
     */
    protected function getTwig()
    {
        if (!$this->twigInstance) {
            $this->twigInstance = new Environment($this->getTwigLoader(), $this->getTwigOptions());
        }
        return $this->twigInstance;
    }
    
    /**
     * 
     * @author ikubicki
     * @return \Twig\Loader\FilesystemLoader
     */
    protected function getTwigLoader()
    {
        if (!$this->twigLoader) {
            $this->twigLoader = new FilesystemLoader(sprintf(
                $this->getTemplatesDirectory(),
                $this->getTheme()
            ));
        }
        return $this->twigLoader;
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    protected function getTwigOptions()
    {
        return [
            'charset' => 'utf-8',
            'cache' => $this->getCacheDirectory(),
            'debug' => ini_get('display_errors') > 0,
            'strict_variables ' => ini_get('display_errors') > 0,
        ];
    }
    
    /**
     *
     * @author ikubicki
     * @return Config
     */
    protected function getConfig()
    {
        return StaticRegistry::get('configuration');
    }
    
    /**
     *
     * @author ikubicki
     * @return array
     */
    protected function getCacheDirectory()
    {
        return $this->getConfig()->view->cache->get('dir', '');
    }
    
    /**
     *
     * @author ikubicki
     * @return array
     */
    protected function getTemplatesDirectory()
    {
        return $this->getConfig()->view->templates->get('dir', '');
    }
    
    /**
     *
     * @author ikubicki
     * @return array
     */
    protected function getTheme()
    {
        return $this->getConfig()->view->get('theme', 'default');
    }
}