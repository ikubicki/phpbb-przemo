<?php

namespace PhpBB\Forum;

use Twig\Loader\FilesystemLoader as TwigLoader;
use Twig\Extension\DebugExtension as TwigDebugExt;
use Twig\Environment as TwigEnvironment;

class Templates
{
    protected $twig;
    protected $loader;
    protected $variables = [];

    public function __construct($directory, array $options = [])
    {
        if (!isset($options['cache'])) {
            $options['cache'] = '/tmp/twig';
        }
        $this->loader = new TwigLoader($directory);
        $this->twig = new TwigEnvironment($this->loader, $options);
        if (isset($options['debug'])) {
            $this->twig->addExtension(new TwigDebugExt());
        }
        $this->variables = (array) $options['vars'] ?? [];
    }

    public function addPath($path)
    {
        $this->loader->addPath($path);
    }

    public function render($filename)
    {
        $template = $this->twig->load($filename);
        return $template->render($this->variables);
    }

    public function display($filename)
    {
        //print '<pre>';
        //print_r($this->variables);
        //exit;
        echo $this->render($filename);
    }

    public function vars($variables)
    {
        foreach($variables as $variable => $subvalue) {
            $this->var($variable, $subvalue);
        }
    }

    public function var($variable, $value)
    {
        $this->variables[$variable] = $value;
    }
    /*
    /var1
    /var2
    /var3
    /tablehead[]
        /var1
        /var2
        /br[]
            /var
    /tablehead[]
        /var1
        /var2
        /br[]
            /var
    /tablehead[]
        /var1
        /var2
    /forumrow[]
        /var1
        /var2
        /forum_link_no[]
    /forumrow[]
        /var1
        /var2
        /forum_link_no[]
    */

    protected $blockPointers = [];

    public function block($block, array $variables = [])
    {
        // print $block . '<br />';
        $chunks = explode('.', $block);
        $block = array_pop($chunks);
        $blockPointerIndex = implode('.', $chunks);
        $blockPointer = &$this->variables;
        if ($blockPointerIndex) {
            $blockPointer = &$this->blockPointers[$blockPointerIndex];
        }
        if (!array_key_exists($block, $blockPointer)) {
            $blockPointer[$block] = [];
        }
        $index = count($blockPointer[$block]);
        $blockPointer[$block][$index] = &$variables;
        $this->blockPointers[$blockPointerIndex . ($blockPointerIndex ? '.' : '') . $block] = &$variables;
        //echo "-> $blockPointerIndex$block<br />";
        //var_dump($this->blockPointers[$blockPointerIndex . $block]);
/*
        if (!isset($this->variables[$block])) {
            $this->variables[$block] = [];
        }
        $container = &$this->variables[$block];
        foreach($chunks as $_block) {
            if (!isset($container[$_block])) {
                $container[$_block] = [];
            }
            $container = &$container[$_block];
        }
        if (!empty($variables)) {
            $container[] = $variables;
        }
*/
    }

    public function set_filenames($filenames)
    {
        foreach($filenames as $filename) {
            $this->twig->load($filename);
        }
    }

    public function pparse($name)
    {

    }
}
