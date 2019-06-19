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

/* install/step2.html */
class __TwigTemplate_05cc13f23da01f9927058d59f1d4b41fc53760d82adff2ee69c06ab5850c8acc extends \Twig\Template
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
        $this->parent = $this->loadTemplate("install/layout.html", "install/step2.html", 1);
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

<form action=\"";
        // line 7
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "action", [], "any", false, false, false, 7), "html", null, true);
        echo "\" method=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "method", [], "any", false, false, false, 7), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "name", [], "any", false, false, false, 7), "html", null, true);
        echo "\">
<div class=\"section\">
\t<div class=\"submit\">
\t\t ";
        // line 10
        $this->loadTemplate("forms/submit.html", "install/step2.html", 10)->display(twig_array_merge($context, ["value" => twig_get_attribute($this->env, $this->source, ($context["l10n"] ?? null), "Finish_Install", [], "any", false, false, false, 10)]));
        // line 11
        echo "\t</div>
</div>
</form>
";
    }

    public function getTemplateName()
    {
        return "install/step2.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 11,  68 => 10,  58 => 7,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"install/layout.html\" %}

{% block content %}

<p>{{ messages.content|raw }}</p>

<form action=\"{{ form.action }}\" method=\"{{ form.method }}\" name=\"{{ form.name }}\">
<div class=\"section\">
\t<div class=\"submit\">
\t\t {% include 'forms/submit.html' with {'value': l10n.Finish_Install} %}
\t</div>
</div>
</form>
{% endblock %}", "install/step2.html", "/var/www/app/htdocs/assets/html/install/step2.html");
    }
}
