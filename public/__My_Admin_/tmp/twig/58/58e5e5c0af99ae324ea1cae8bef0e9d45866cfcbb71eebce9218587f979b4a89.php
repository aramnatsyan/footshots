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

/* database/structure/index.twig */
class __TwigTemplate_f9a5e24d79d3f74981aca96ea7c3885dd99762ddb80dc8f30b835b6fb0718ab6 extends \Twig\Template
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
        if (($context["has_tables"] ?? null)) {
            // line 2
            echo "  <div id=\"tableslistcontainer\">
    ";
            // line 3
            echo ($context["list_navigator_html"] ?? null);
            echo "

    ";
            // line 5
            echo ($context["table_list_html"] ?? null);
            echo "

    ";
            // line 7
            echo ($context["list_navigator_html"] ?? null);
            echo "
  </div>
  <hr>
  <p class=\"print_ignore\">
    <a href=\"#\" id=\"printView\">
      ";
            // line 12
            echo PhpMyAdmin\Util::getIcon("b_print", _gettext("Print"), true);
            echo "
    </a>
    <a href=\"db_datadict.php";
            // line 14
            echo PhpMyAdmin\Url::getCommon(["db" => ($context["database"] ?? null), "goto" => "db_structure.php"]);
            echo "\" target=\"print_view\">
      ";
            // line 15
            echo PhpMyAdmin\Util::getIcon("b_tblanalyse", _gettext("Data dictionary"), true);
            echo "
    </a>
  </p>
";
        } else {
            // line 19
            echo "  ";
            echo call_user_func_array($this->env->getFilter('notice')->getCallable(), [_gettext("No tables found in database.")]);
            echo "
";
        }
        // line 21
        echo "
";
        // line 22
        if ( !($context["is_system_schema"] ?? null)) {
            // line 23
            echo "  ";
            echo ($context["create_table_html"] ?? null);
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "database/structure/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 23,  85 => 22,  82 => 21,  76 => 19,  69 => 15,  65 => 14,  60 => 12,  52 => 7,  47 => 5,  42 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "database/structure/index.twig", "/home/apollow/domains/fabso.apollow.com/public_html/public/__My_Admin/templates/database/structure/index.twig");
    }
}
