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

/* install/db_error.html */
class __TwigTemplate_9c1fa34f0bf69b8af71b1a2b3f43e959e3d09e44fc3f5030bb3dccb98f7a758d extends \Twig\Template
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
        $this->parent = $this->loadTemplate("install/layout.html", "install/db_error.html", 1);
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
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["l10n"] ?? null), "Install_db_error", [], "any", false, false, false, 5), "html", null, true);
        echo "</p>
<ul class=\"wrong-queries\">
";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
            // line 8
            echo "\t<li>
\t\t<span class=\"query\">";
            // line 9
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["error"], "query", [], "any", false, false, false, 9), "html", null, true);
            echo "</span>
\t\t<span class=\"error\">";
            // line 10
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["error"], "error", [], "any", false, false, false, 10), "html", null, true);
            echo "</span>
\t</li>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "</ul>
";
    }

    public function getTemplateName()
    {
        return "install/db_error.html";
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

<p>{{ l10n.Install_db_error }}</p>
<ul class=\"wrong-queries\">
{% for error in errors %}
\t<li>
\t\t<span class=\"query\">{{ error.query }}</span>
\t\t<span class=\"error\">{{ error.error }}</span>
\t</li>
{% endfor %}
</ul>
{% endblock %}", "install/db_error.html", "/var/www/app/htdocs/assets/html/install/db_error.html");
    }
}
