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

/* forms/select.html */
class __TwigTemplate_e09a050814c7c0e0731a5ccdf2b236086dba47f7a35e6e8665cc05287cffb35b extends \Twig\Template
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
<select name=\"";
        // line 2
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "name", [], "any", false, false, false, 2), "html", null, true);
        echo "\" class=\"";
        if (twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "error", [], "any", false, false, false, 2)) {
            echo "error";
        }
        echo "\">
";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "options", [], "any", false, false, false, 3));
        foreach ($context['_seq'] as $context["key"] => $context["label"]) {
            echo " 
\t<option value=\"";
            // line 4
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\" ";
            if ((twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "value", [], "any", false, false, false, 4) == $context["key"])) {
                echo "selected=\"selected\"";
            }
            echo ">";
            echo twig_escape_filter($this->env, $context["label"], "html", null, true);
            echo "</option>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['label'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 6
        echo "</select>
";
        // line 7
        if (twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "error", [], "any", false, false, false, 7)) {
            echo "<span class=\"error\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["field"] ?? null), "error", [], "any", false, false, false, 7), "html", null, true);
            echo "</span>";
        }
    }

    public function getTemplateName()
    {
        return "forms/select.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 7,  70 => 6,  56 => 4,  50 => 3,  42 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<span class=\"label\">{{ label }}</span>
<select name=\"{{ field.name }}\" class=\"{% if field.error %}error{% endif %}\">
{% for key, label in field.options %} 
\t<option value=\"{{ key }}\" {% if field.value == key %}selected=\"selected\"{% endif %}>{{ label }}</option>
{% endfor %}
</select>
{% if field.error %}<span class=\"error\">{{ field.error }}</span>{% endif %}", "forms/select.html", "/var/www/app/htdocs/assets/html/forms/select.html");
    }
}
