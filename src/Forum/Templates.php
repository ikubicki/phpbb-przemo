<?php

namespace PhpBB\Forum;

use Twig\Loader\FilesystemLoader as TwigLoader;
use Twig\Extension\DebugExtension as TwigDebugExt;
use Twig\Environment as TwigEnvironment;

class Templates
{

    protected $twig;
    protected $variables = [];

    public function __construct($directory, array $options = [])
    {
        if (!isset($options['cache'])) {
            $options['cache'] = '/tmp/twig';
        }
        $this->twig = new TwigEnvironment(new TwigLoader($directory), $options);
        if (isset($options['debug'])) {
            $this->twig->addExtension(new TwigDebugExt());
        }
    }

    public function render($filename)
    {
        $template = $this->twig->load($filename);
        return $template->render($this->variables);
    }

    public function display($filename)
    {
        echo $this->render($filename);
    }

    public function vars($variable, $value)
    {
        if ($variable === null) {
            foreach($value as $variable => $subvalue) {
                $this->vars($variable, $subvalue);
            }
            return;
        }
        $this->variables[$variable] = $value;
    }

    public function block($block, array $variables = [])
    {
        $chunks = explode('.', $block);
        $block = array_shift($chunks);
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
        $container[] = $variables;
    }
}
