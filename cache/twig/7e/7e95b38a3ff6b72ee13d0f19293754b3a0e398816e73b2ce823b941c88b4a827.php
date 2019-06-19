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

/* forms/password.html */
class __TwigTemplate_e5805e86a9bfec6d72d2dad85c25be457d4082523e5f711c049a780b3ed7ef37 extends \Twig\Template
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
<input type=\"password\" name=\"";
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
        return "forms/password.html";
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
        return new Source("", "forms/password.html", "/var/www/app/htdocs/assets/html/forms/password.html");
    }
}
