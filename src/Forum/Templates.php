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
    protected $components = [];

    public function __construct($directory, array $options = [])
    {
        if (!isset($options['cache'])) {
            $options['cache'] = sys_get_temp_dir() . '/twig';
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

    public function component($name, $filename)
    {
        $this->components[$name] = $this->render($filename);
        $this->var('components', $this->components);
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

    public function defaults($variables)
    {
        foreach($variables as $variable => $subvalue) {
            $this->default($variable, $subvalue);
        }
    }

    public function default($variable, $value)
    {
        if (empty($this->variables[$variable])) {
            $this->variables[$variable] = $value;
        }
    }

    protected $blockPointers = [];

    /**
     * phpbb2 compatibility
     */
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
    }

    /**
     * phpbb2 compatibility
     */
    public function set_filenames($filenames)
    {
        foreach($filenames as $filename) {
            $this->twig->load($filename);
        }
    }

    /**
     * phpbb2 compatibility
     */
    public function pparse($name)
    {

    }
}
