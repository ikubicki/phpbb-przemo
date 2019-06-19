<?php

namespace PHPBB\Przemo\Core;

use Twig\Loader\LoaderInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    
    /**
     * @var string
     */
    protected static $templatesDirectory;
    
    /**
     * @var string
     */
    protected static $cacheDirectory;
    
    /**
     * @var string
     */
    protected static $theme;
    
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
     * @param string $templatesDirectory
     */
    public function setTemplatesDirectory($templatesDirectory)
    {
        self::$templatesDirectory = $templatesDirectory;
    }
    
    /**
     *
     * @author ikubicki
     * @param string $cacheDirectory
     */
    public function setCacheDirectory($cacheDirectory)
    {
        self::$cacheDirectory = $cacheDirectory;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $theme
     */
    public function setTheme($theme)
    {
        self::$theme = $theme;
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
            $this->twigLoader = new FilesystemLoader(sprintf(self::$templatesDirectory, self::$theme));
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
            'cache' => self::$cacheDirectory,
            'debug' => ini_get('display_errors') > 0,
            'strict_variables ' => ini_get('display_errors') > 0,
        ];
    }
}