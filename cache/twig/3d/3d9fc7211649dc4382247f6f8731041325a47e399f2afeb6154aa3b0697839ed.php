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

/* forms/text.html */
class __TwigTemplate_bceac22fbd1fc487ee170d52f5b6cf97fb5b5aa10024923a3a26db397b36f3c8 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<span class=\"label\">";
        echo twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
        echo "</span>
<input type=\"text\" name=\"";
        // line 2
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "name", [], "any", false, false, false, 2), "html", null, true);
        echo "\" value=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "value", [], "any", false, false, false, 2), "html", null, true);
        echo "\" class=\"";
        if (twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "error", [], "any", false, false, false, 2)) {
            echo "error";
        }
        echo "\" />
";
        // line 3
        if (twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "error", [], "any", false, false, false, 3)) {
            echo "<span class=\"error\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "error", [], "any", false, false, false, 3), "html", null, true);
            echo "</span>";
        }
    }

    public function getTemplateName()
    {
        return "forms/text.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 3,  42 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<span class=\"label\">{{ label }}</span>
<input type=\"text\" name=\"{{ field.name }}\" value=\"{{ field.value }}\" class=\"{% if field.error %}error{% endif %}\" />
{% if field.error %}<span class=\"error\">{{ field.error }}</span>{% endif %}", "forms/text.html", "/var/www/app/htdocs/assets/default/html/forms/text.html");
    }
}
