<?php

/* __string_template__b59b552ba6751b159e65ae50b7d192e5f592833ab56d599f0c8526df39f4b834 */
class __TwigTemplate_8f8b551660c8fbce8c6aa6d42ed7093eb07a246fe03f653395a5439dfa1e3c39 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
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
        echo twig_escape_filter($this->env, ($context["error_title"] ?? null), "html", null, true);
        echo " - EC-CUBE管理画面</title>
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"robots\" content=\"noindex,nofollow\" />
    <link rel=\"icon\" href=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/img/favicon.ico\">
    <link rel=\"stylesheet\" href=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/css/bootstrap.min.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/css/dashboard.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
    <!--[if lt IE 9]>
    <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
    <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->

</head>
<body>

    <!-- ▼ #main ▼ -->
    <div id=\"main\">
        <div class=\"container-fluid\">
            <div class=\"message_box\">
                <div class=\"row no-padding\">
                    <div class=\"col-sm-6 col-sm-offset-3\">
                        <div class=\"icon\"><svg class=\"cb cb-warning\"><use xlink:href=\"#cb-warning\" /></svg></div>
                        <h1>";
        // line 50
        echo twig_escape_filter($this->env, ($context["error_title"] ?? null), "html", null, true);
        echo "</h1>
                        <p>";
        // line 51
        echo twig_escape_filter($this->env, ($context["error_message"] ?? null), "html", null, true);
        echo "</p>
                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"btn_group col-sm-offset-4 col-sm-4\">
                        <a href=\"";
        // line 56
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_homepage");
        echo "\"><p><button type=\"button\" class=\"btn btn-info btn-block\">ログインページへ</button></p></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ▲ #main ▲ -->


<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
<script>window.jQuery || document.write('<script src=\"";
        // line 66
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/jquery-1.11.3.min.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"><\\/script>')</script>
<script src=\"";
        // line 67
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/function.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script>
    \$(function () {
        \$.ajax({
            url: '";
        // line 71
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

</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "__string_template__b59b552ba6751b159e65ae50b7d192e5f592833ab56d599f0c8526df39f4b834";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 71,  98 => 67,  92 => 66,  79 => 56,  71 => 51,  67 => 50,  46 => 34,  40 => 33,  36 => 32,  28 => 27,  22 => 23,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__b59b552ba6751b159e65ae50b7d192e5f592833ab56d599f0c8526df39f4b834", "");
    }
}
