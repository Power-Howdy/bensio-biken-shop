<?php

/* error.twig */
class __TwigTemplate_7e4f8b34619326215142dc6912f5dcb6f6ce561ee47fa23f7121969a1ad68193 extends Twig_Template
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
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel=\"icon\" href=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/common/favicon.ico\">
    <link rel=\"stylesheet\" href=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/css/style.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/css/default.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"><!-- for original theme CSS -->

</head>
<body>
<div id=\"wrapper\" class=\"error_page\">
    <div id=\"contents\" class=\"theme_main_only\">
        <div class=\"container-fluid inner\">
            <div id=\"main\">
                <div id=\"default_error_wrap\" class=\"container-fluid\">
                    <div id=\"default_error_box\" class=\"message_box\">
                        <div id=\"default_error_box__body\" class=\"row no-padding\">
                            <div id=\"default_error__message\" class=\"col-sm-6 col-sm-offset-3\">
                                <div class=\"icon\"><svg class=\"cb cb-warning\"><use xlink:href=\"#cb-warning\" /></svg></div>
                                <h1>";
        // line 44
        echo twig_escape_filter($this->env, ($context["error_title"] ?? null), "html", null, true);
        echo "</h1>
                                <p>";
        // line 45
        echo twig_escape_filter($this->env, ($context["error_message"] ?? null), "html", null, true);
        echo "</p>
                            </div>
                        </div>
                        <div id=\"default_error__footer\" class=\"row\">
                            <div id=\"default_error__top_button\" class=\"btn_group col-sm-offset-4 col-sm-4\">
                                <a href=\"";
        // line 50
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("homepage");
        echo "\"><p><button type=\"button\" class=\"btn btn-info btn-block\">トップページへ</button></p></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
<script>window.jQuery || document.write('<script src=\"";
        // line 61
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/js/vendor/jquery-1.11.3.min.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"><\\/script>')</script>
<script src=\"";
        // line 62
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/js/function.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script>
    \$(function () {
        \$.ajax({
            url: '";
        // line 66
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/common/svg.html',
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
        return "error.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  102 => 66,  93 => 62,  87 => 61,  73 => 50,  65 => 45,  61 => 44,  43 => 31,  37 => 30,  33 => 29,  28 => 27,  22 => 23,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "error.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/error.twig");
    }
}
