<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* install/checksum_warning.html */
class __TwigTemplate_42c715695fb0ada31618e49ebe3c92d9a7c842cf8bad2d75d2133b4fe01f7384 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "install/layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("install/layout.html", "install/checksum_warning.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "
<p>";
        // line 5
        echo twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "content", [], "any", false, false, false, 5);
        echo "</p>
<ul class=\"wrong-files\">
";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["files"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["file"]) {
            // line 8
            echo "\t<li>
\t\t<span class=\"filename\">";
            // line 9
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["file"], "name", [], "any", false, false, false, 9), "html", null, true);
            echo "</span>
\t\t<span class=\"summary\">";
            // line 10
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["file"], "summary", [], "any", false, false, false, 10), "html", null, true);
            echo "</span>
\t</li>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['file'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "</ul>
";
    }

    public function getTemplateName()
    {
        return "install/checksum_warning.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 13,  69 => 10,  65 => 9,  62 => 8,  58 => 7,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"install/layout.html\" %}

{% block content %}

<p>{{ messages.content|raw }}</p>
<ul class=\"wrong-files\">
{% for file in files %}
\t<li>
\t\t<span class=\"filename\">{{ file.name }}</span>
\t\t<span class=\"summary\">{{ file.summary }}</span>
\t</li>
{% endfor %}
</ul>
{% endblock %}", "install/checksum_warning.html", "/var/www/app/htdocs/assets/html/install/checksum_warning.html");
    }
}
