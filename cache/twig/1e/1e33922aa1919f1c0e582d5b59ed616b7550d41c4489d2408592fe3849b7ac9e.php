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

/* install/step1.html */
class __TwigTemplate_59901b51dfa50d7eb759ef0ec18567c543453de26e36ad4aa7f968056685be5e extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'errors' => [$this, 'block_errors'],
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
        $this->parent = $this->loadTemplate("install/layout.html", "install/step1.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_errors($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        if ((twig_length_filter($this->env, ($context["errors"] ?? null)) > 0)) {
            // line 5
            echo "<ul>
";
            // line 6
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 7
                echo "\t<li>";
                echo twig_escape_filter($this->env, $context["error"], "html", null, true);
                echo "</li>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 9
            echo "</ul>
";
        }
    }

    // line 13
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 14
        echo "
<p>";
        // line 15
        echo twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Inst_Step_0", [], "any", false, false, false, 15);
        echo "</p>

<form action=\"";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "action", [], "any", false, false, false, 17), "html", null, true);
        echo "\" method=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "method", [], "any", false, false, false, 17), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "name", [], "any", false, false, false, 17), "html", null, true);
        echo "\">

";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "hidden_fields", [], "any", false, false, false, 19));
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
            // line 20
            echo "\t\t";
            $this->loadTemplate("forms/hidden.html", "install/step1.html", 20)->display(twig_array_merge($context, ["name" => $context["name"], "value" => $context["value"]]));
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
        // line 22
        echo "
<div class=\"section\">
\t<div class=\"head\">";
        // line 24
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Initial_config", [], "any", false, false, false, 24), "html", null, true);
        echo "</div>
\t<div class=\"row\">
\t\t ";
        // line 26
        $this->loadTemplate("forms/select.html", "install/step1.html", 26)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Default_lang", [], "any", false, false, false, 26), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "lang", [], "any", false, false, false, 26)]));
        // line 27
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 29
        $this->loadTemplate("forms/text.html", "install/step1.html", 29)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Server_name", [], "any", false, false, false, 29), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "server_name", [], "any", false, false, false, 29)]));
        // line 30
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 32
        $this->loadTemplate("forms/text.html", "install/step1.html", 32)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Server_port", [], "any", false, false, false, 32), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "server_port", [], "any", false, false, false, 32)]));
        // line 33
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 35
        $this->loadTemplate("forms/text.html", "install/step1.html", 35)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Script_path", [], "any", false, false, false, 35), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "script_path", [], "any", false, false, false, 35)]));
        // line 36
        echo "\t</div>
</div>
<div class=\"section\">
\t<div class=\"head\">";
        // line 39
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "DB_config", [], "any", false, false, false, 39), "html", null, true);
        echo "</div>
\t<div class=\"row\">
\t\t ";
        // line 41
        $this->loadTemplate("forms/select.html", "install/step1.html", 41)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "dbms", [], "any", false, false, false, 41), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "dbms", [], "any", false, false, false, 41)]));
        // line 42
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 44
        $this->loadTemplate("forms/text.html", "install/step1.html", 44)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "DB_Host", [], "any", false, false, false, 44), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "dbhost", [], "any", false, false, false, 44)]));
        // line 45
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 47
        $this->loadTemplate("forms/text.html", "install/step1.html", 47)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "DB_Name", [], "any", false, false, false, 47), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "dbname", [], "any", false, false, false, 47)]));
        // line 48
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 50
        $this->loadTemplate("forms/text.html", "install/step1.html", 50)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "DB_Username", [], "any", false, false, false, 50), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "dbuser", [], "any", false, false, false, 50)]));
        // line 51
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 53
        $this->loadTemplate("forms/password.html", "install/step1.html", 53)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "DB_Password", [], "any", false, false, false, 53), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "dbpasswd", [], "any", false, false, false, 53)]));
        // line 54
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 56
        $this->loadTemplate("forms/text.html", "install/step1.html", 56)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Table_Prefix", [], "any", false, false, false, 56), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "prefix", [], "any", false, false, false, 56)]));
        // line 57
        echo "\t</div>
</div>
<div class=\"section\">
\t<div class=\"head\">";
        // line 60
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Admin_config", [], "any", false, false, false, 60), "html", null, true);
        echo " <span>";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Admin_config_e", [], "any", false, false, false, 60), "html", null, true);
        echo "</span></div>
\t<div class=\"row\">
\t\t ";
        // line 62
        $this->loadTemplate("forms/text.html", "install/step1.html", 62)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Admin_email", [], "any", false, false, false, 62), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "board_email", [], "any", false, false, false, 62)]));
        // line 63
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 65
        $this->loadTemplate("forms/text.html", "install/step1.html", 65)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Admin_Username", [], "any", false, false, false, 65), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "admin_name", [], "any", false, false, false, 65)]));
        // line 66
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 68
        $this->loadTemplate("forms/password.html", "install/step1.html", 68)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Admin_Password", [], "any", false, false, false, 68), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "admin_pass1", [], "any", false, false, false, 68)]));
        // line 69
        echo "\t</div>
\t<div class=\"row\">
\t\t ";
        // line 71
        $this->loadTemplate("forms/password.html", "install/step1.html", 71)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Admin_Password_confirm", [], "any", false, false, false, 71), "field" => twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "admin_pass2", [], "any", false, false, false, 71)]));
        // line 72
        echo "\t</div>
\t<div class=\"submit\">
\t\t ";
        // line 74
        $this->loadTemplate("forms/submit.html", "install/step1.html", 74)->display(twig_array_merge($context, ["label" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Admin_Password_confirm", [], "any", false, false, false, 74), "value" => twig_get_attribute($this->env, $this->source, ($context["messages"] ?? null), "Start_Install", [], "any", false, false, false, 74)]));
        // line 75
        echo "\t</div>
</div>
</form>
";
    }

    public function getTemplateName()
    {
        return "install/step1.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  237 => 75,  235 => 74,  231 => 72,  229 => 71,  225 => 69,  223 => 68,  219 => 66,  217 => 65,  213 => 63,  211 => 62,  204 => 60,  199 => 57,  197 => 56,  193 => 54,  191 => 53,  187 => 51,  185 => 50,  181 => 48,  179 => 47,  175 => 45,  173 => 44,  169 => 42,  167 => 41,  162 => 39,  157 => 36,  155 => 35,  151 => 33,  149 => 32,  145 => 30,  143 => 29,  139 => 27,  137 => 26,  132 => 24,  128 => 22,  113 => 20,  96 => 19,  87 => 17,  82 => 15,  79 => 14,  75 => 13,  69 => 9,  60 => 7,  56 => 6,  53 => 5,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "install/step1.html", "/var/www/app/htdocs/assets/html/install/step1.html");
    }
}
