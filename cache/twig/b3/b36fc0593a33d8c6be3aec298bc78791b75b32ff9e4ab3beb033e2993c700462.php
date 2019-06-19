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

/* install/layout.html */
class __TwigTemplate_e57d885ad8ade3b01c51aab6b4632d9fda6486f790607e4d15353289d2e9399b extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE HTML>
<html>
\t<head>
\t\t<link rel=\"stylesheet\" href=\"assets/default/css/main.css\" type=\"text/css\" />
\t\t<link rel=\"stylesheet\" href=\"assets/default/css/install.css\" type=\"text/css\" />
\t\t<title>";
        // line 6
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["l10n"] ?? null), "Welcome_install", [], "any", false, false, false, 6), "html", null, true);
        echo "</title>
\t</head>
\t<body>
\t\t<div class=\"header\">
\t\t\t<p>";
        // line 10
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "header", [], "any", false, false, false, 10), "html", null, true);
        echo "</p>
\t\t</div>

";
        // line 13
        if (        $this->hasBlock("errors", $context, $blocks)) {
            // line 14
            $context["block_errors"] =             $this->renderBlock("errors", $context, $blocks);
            // line 15
            if ( !twig_test_empty(($context["block_errors"] ?? null))) {
                // line 16
                echo "\t\t<div class=\"errors\">
   \t\t\t";
                // line 17
                echo ($context["block_errors"] ?? null);
                echo "
   \t\t</div>
";
            }
        }
        // line 21
        echo "\t\t<div class=\"content\">
\t\t\t";
        // line 22
        $this->displayBlock('content', $context, $blocks);
        // line 23
        echo "\t\t</div>
\t\t<div class=\"footer\">phpbb by przemo v2.0.132
\t\t</div>
\t</body>
</html>";
    }

    // line 22
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "install/layout.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 22,  79 => 23,  77 => 22,  74 => 21,  67 => 17,  64 => 16,  62 => 15,  60 => 14,  58 => 13,  52 => 10,  45 => 6,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE HTML>
<html>
\t<head>
\t\t<link rel=\"stylesheet\" href=\"assets/default/css/main.css\" type=\"text/css\" />
\t\t<link rel=\"stylesheet\" href=\"assets/default/css/install.css\" type=\"text/css\" />
\t\t<title>{{ l10n.Welcome_install }}</title>
\t</head>
\t<body>
\t\t<div class=\"header\">
\t\t\t<p>{{ messages.header }}</p>
\t\t</div>

{% if block('errors') is defined %}
{% set block_errors = block('errors') %}
{% if block_errors is not empty %}
\t\t<div class=\"errors\">
   \t\t\t{{ block_errors|raw }}
   \t\t</div>
{% endif %}
{% endif %}
\t\t<div class=\"content\">
\t\t\t{% block content %}{% endblock %}
\t\t</div>
\t\t<div class=\"footer\">phpbb by przemo v2.0.132
\t\t</div>
\t</body>
</html>", "install/layout.html", "/var/www/app/htdocs/assets/default/html/install/layout.html");
    }
}
