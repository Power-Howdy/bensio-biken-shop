<?php

/* default_frame.twig */
class __TwigTemplate_a9eeb3ab30f667219a324cff6a89c8a40b5a0f868dddc1fd72e15710c5972204 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'stylesheet' => array($this, 'block_stylesheet'),
            'main' => array($this, 'block_main'),
            'modal' => array($this, 'block_modal'),
            'javascript' => array($this, 'block_javascript'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
";
        // line 23
        echo "<html lang=\"ja\">
<head>
<meta charset=\"utf-8\">
<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
<title>";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute(($context["BaseInfo"] ?? null), "shop_name", array()), "html", null, true);
        echo " - EC-CUBE管理画面</title>
<meta name=\"description\" content=\"\">
<meta name=\"author\" content=\"\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<link rel=\"icon\" href=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/img/favicon.ico\">
<link rel=\"stylesheet\" href=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/css/bootstrap.min.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
<link rel=\"stylesheet\" href=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/css/dashboard.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
";
        // line 34
        $this->displayBlock('stylesheet', $context, $blocks);
        // line 35
        echo "<!--[if lt IE 9]>
<script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
<script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
<![endif]-->
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
<script>window.jQuery || document.write('<script src=\"";
        // line 40
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/jquery-1.11.3.min.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"><\\/script>')</script>
</head>
<body id=\"page_";
        // line 42
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "get", array(0 => "_route"), "method"), "html", null, true);
        echo "\">
<div id=\"wrapper\" class=\"sidebar-open\">
    <!-- ▼ #header ▼ -->
    <header id=\"header\" role=\"navigation\">
        <div class=\"navbar navbar-static-top\">
            <div class=\"logo\" href=\"./\"><img src=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/img/logo.png\" width=\"172\"></div>
            <!-- Sidebar toggle button-->

            <div class=\"bt_toggle\">
                <a role=\"button\" data-toggle=\"offcanvas\" class=\"bt_drawermenu\" href=\"#\"> <span class=\"sr-only\">Toggle navigation</span>
                    <svg class=\"cb cb-bars\">
                        <use xlink:href=\"#cb-bars\"/>
                    </svg>
                </a>
            </div>
            <a href=\"";
        // line 57
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("homepage");
        echo "\" id=\"sitename\" target=\"_blank\">";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["BaseInfo"] ?? null), "shop_name", array()), "html", null, true);
        echo "<span class=\"cb cb-external-link\"></span></a>
            <!-- Navbar Right Menu -->
            <div class=\"navbar-menu\">
                <dl class=\"dropdown\">
                    ";
        // line 61
        if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\SecurityExtension')->isGranted("ROLE_ADMIN")) {
            // line 62
            echo "                        <dt class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                            <svg class=\"cb cb-user-circle\">
                                <use xlink:href=\"#cb-user-circle\" />
                            </svg>
                            <span class=\"hidden-xs\">";
            // line 66
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "user", array()), "name", array()), "html", null, true);
            echo " 様</span>
                            <svg class=\"cb cb-angle-down icon_down\">
                                <use xlink:href=\"#cb-angle-down\" />
                            </svg>
                        </dt>
                        <dd class=\"dropdown-menu\">
                            最終ログイン<br>
                            ";
            // line 73
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "user", array(), "any", false, true), "login_date", array(), "any", false, true), "format", array(0 => "Y/m/d H:i"), "method", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "user", array(), "any", false, true), "login_date", array(), "any", false, true), "format", array(0 => "Y/m/d H:i"), "method"), "")) : ("")), "html", null, true);
            echo "
                            <a class=\"btn btn-primary btn-xs\" href=\"";
            // line 74
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_change_password");
            echo "\">パスワード変更</a>
                            <a class=\"btn btn-primary btn-xs\" href=\"";
            // line 75
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl(($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_route", array()) . "_logout"));
            echo "\">ログアウト</a>
                        </dd>
                    ";
        }
        // line 78
        echo "                </dl>
            </div>
        </div>
    </header>
    <!-- ▲ #header ▲ -->
    <!-- ▼ #side ▼ -->
    <aside id=\"side\">
        <ul class=\"nav nav-sidebar\">
            <li>
                <a href=\"";
        // line 87
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_homepage");
        echo "\">
                    <svg class=\"cb cb-home\"><use xlink:href=\"#cb-home\" /></svg>ホーム<svg class=\"cb cb-angle-down\"><use xlink:href=\"#cb-angle-down\" /></svg>
                </a>
            </li>
            ";
        // line 91
        echo twig_include($this->env, $context, "nav.twig");
        echo "
        </ul>
    </aside>
    <!-- ▲ #side ▲ -->
    <!-- ▼ #main ▼ -->
    <div id=\"main\">
        <h1 class=\"page-header\">";
        // line 97
        $this->displayBlock("title", $context, $blocks);
        echo "<span>";
        $this->displayBlock("sub_title", $context, $blocks);
        echo "</span></h1>

        <div class=\"container-fluid\">

            ";
        // line 101
        echo twig_include($this->env, $context, "alert.twig");
        echo "

            ";
        // line 103
        $this->displayBlock('main', $context, $blocks);
        // line 104
        echo "
        </div>
    </div>
    <!-- ▲ #main ▲ -->

    <!-- ▼ #modal ▼ -->
    ";
        // line 110
        $this->displayBlock('modal', $context, $blocks);
        // line 111
        echo "    <!-- ▲ #modal ▲ -->

</div>

<script src=\"";
        // line 115
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/bootstrap.min.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 116
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/ie10-viewport-bug-workaround.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 117
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/function.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script>
\$(function () {
    \$.ajax({
        url: '";
        // line 121
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/img/svg.html',
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        \$('body').prepend(data);
    }).fail(function(data){
    });
});
</script>
";
        // line 130
        $this->displayBlock('javascript', $context, $blocks);
        // line 131
        echo "</body>
</html>
";
    }

    // line 34
    public function block_stylesheet($context, array $blocks = array())
    {
    }

    // line 103
    public function block_main($context, array $blocks = array())
    {
    }

    // line 110
    public function block_modal($context, array $blocks = array())
    {
    }

    // line 130
    public function block_javascript($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "default_frame.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  248 => 130,  243 => 110,  238 => 103,  233 => 34,  227 => 131,  225 => 130,  213 => 121,  204 => 117,  198 => 116,  192 => 115,  186 => 111,  184 => 110,  176 => 104,  174 => 103,  169 => 101,  160 => 97,  151 => 91,  144 => 87,  133 => 78,  127 => 75,  123 => 74,  119 => 73,  109 => 66,  103 => 62,  101 => 61,  92 => 57,  79 => 47,  71 => 42,  64 => 40,  57 => 35,  55 => 34,  49 => 33,  43 => 32,  39 => 31,  32 => 27,  26 => 23,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "default_frame.twig", "/home/wp614605/biken-shop-mall.com/public_html/src/Eccube/Resource/template/admin/default_frame.twig");
    }
}
