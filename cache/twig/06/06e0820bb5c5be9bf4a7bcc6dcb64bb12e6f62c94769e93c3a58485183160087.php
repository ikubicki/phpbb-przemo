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

/* install/config_error.html */
class __TwigTemplate_b1d65c9a3b28eb78106e68631c9f1da7842842f9558bc84a9febb321daae49a9 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("install/layout.html", "install/config_error.html", 1);
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
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["l10n"] ?? null), "Unwriteable_config", [], "any", false, false, false, 5), "html", null, true);
        echo "</p>
<p>";
        // line 6
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["l10n"] ?? null), "Install_db_error", [], "any", false, false, false, 6), "html", null, true);
        echo "</p>

<form action=\"";
        // line 8
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "action", [], "any", false, false, false, 8), "html", null, true);
        echo "\" method=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "method", [], "any", false, false, false, 8), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "name", [], "any", false, false, false, 8), "html", null, true);
        echo "\">
";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "hidden_fields", [], "any", false, false, false, 9));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["name"] => $context["value"]) {
            // line 10
            echo "\t";
            $this->loadTemplate("forms/hidden.html", "install/config_error.html", 10)->display(twig_array_merge($context, ["name" => $context["name"], "value" => $context["value"]]));
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['name'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        echo "\t<div class=\"section\">
\t\t<div class=\"submit row\">
\t\t\t ";
        // line 14
        $this->loadTemplate("forms/submit.html", "install/config_error.html", 14)->display(twig_array_merge($context, ["value" => twig_get_attribute($this->env, $this->source, ($context["l10n"] ?? null), "Download_config", [], "any", false, false, false, 14)]));
        // line 15
        echo "\t\t</div>
\t\t<p>";
        // line 16
        echo twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "File_download_trouble", [], "any", false, false, false, 16);
        echo "</p>
\t\t<div class=\"row\">
\t\t\t <textarea>";
        // line 18
        echo twig_escape_filter($this->env, ($context["dump"] ?? null), "html", null, true);
        echo "</textarea>
\t\t</div>
\t\t<div class=\"submit\">
\t\t\t <a href=\"";
        // line 21
        echo twig_escape_filter($this->env, ($context["forum_url"] ?? null), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Go_to_forum", [], "any", false, false, false, 21), "html", null, true);
        echo "</a>
\t\t</div>
\t</div>
</form>
";
    }

    public function getTemplateName()
    {
        return "install/config_error.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  122 => 21,  116 => 18,  111 => 16,  108 => 15,  106 => 14,  102 => 12,  87 => 10,  70 => 9,  62 => 8,  57 => 6,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"install/layout.html\" %}

{% block content %}

<p>{{ l10n.Unwriteable_config }}</p>
<p>{{ l10n.Install_db_error }}</p>

<form action=\"{{ form.action }}\" method=\"{{ form.method }}\" name=\"{{ form.name }}\">
{% for name, value in form.hidden_fields %}
\t{% include 'forms/hidden.html' with {'name': name, 'value': value} %}
{% endfor %}
\t<div class=\"section\">
\t\t<div class=\"submit row\">
\t\t\t {% include 'forms/submit.html' with {'value': l10n.Download_config} %}
\t\t</div>
\t\t<p>{{ messages.File_download_trouble|raw }}</p>
\t\t<div class=\"row\">
\t\t\t <textarea>{{ dump }}</textarea>
\t\t</div>
\t\t<div class=\"submit\">
\t\t\t <a href=\"{{ forum_url }}\">{{ messages.Go_to_forum }}</a>
\t\t</div>
\t</div>
</form>
{% endblock %}", "install/config_error.html", "/var/www/app/htdocs/assets/default/html/install/config_error.html");
    }
}
