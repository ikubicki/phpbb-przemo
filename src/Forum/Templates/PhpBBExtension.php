<?php

namespace PhpBB\Forum\Templates;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use PhpBB\Forum\Url;
use PhpBB\Core\Context;

class PhpBBExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('add', [$this, 'add']),
            new TwigFunction('addjs', [$this, 'addJs']),
            new TwigFunction('addcss', [$this, 'addCss']),
            new TwigFunction('getjs', [$this, 'getJs']),
            new TwigFunction('getcss', [$this, 'getCss']),
            new TwigFunction('js', [$this, 'getJsPath']),
            new TwigFunction('css', [$this, 'getCssPath']),
            new TwigFunction('module_js', [$this, 'getModuleJsPath']),
            new TwigFunction('module_css', [$this, 'getModuleCssPath']),
        ];
    }

    public function getModuleJsPath($module)
    {
        return (new Url("modules/$module/index.js"))->url;
    }

    public function getJsPath($path)
    {
        if (substr($path, -3) != '.js') {
            $path .= '.js';
        }
        return (new Url("js/$path"))->url;
    }

    public function getModuleCssPath($module)
    {
        return (new Url("modules/$module/style.css"))->url;
    }

    public function getCssPath($path)
    {
        $theme = Context::getService('templates')->getVar('theme', 'default');
        if (substr($path, -3) != '.css') {
            $path .= '.css';
        }
        return (new Url("themes/$theme/$path"))->url;
    }

    public function add()
    {
        $paths = func_get_args();
        foreach($paths as $path) {
            switch(substr($path, -3)) {
                case '.js': $this->addJs($path); break;
                case 'css': $this->addCss($path); break;
            }
        }
    }

    public function addJs($js)
    {
        $templates = Context::getService('templates');
        $jss = $templates->getVar('_jss', []);
        $jss[$js] = $js;
        $templates->var('_jss', $jss);
    }

    public function addCss($css)
    {
        $templates = Context::getService('templates');
        $csss = $templates->getVar('_csss', []);
        $csss[$css] = $css;
        $templates->var('_csss', $csss);
    }

    public function getJs()
    {
        $templates = Context::getService('templates');
        return $templates->getVar('_jss', []);
    }

    public function getCss()
    {
        $templates = Context::getService('templates');
        return $templates->getVar('_csss', []);
    }
}