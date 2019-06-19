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
class __TwigTemplate_508a2eb31367c61a00d9b70cb053b4d0b0c4c7011cbdbab56b75296f108b2210 extends \Twig\Template
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
        return new Source("", "forms/text.html", "/var/www/app/htdocs/assets/html/forms/text.html");
    }
}
