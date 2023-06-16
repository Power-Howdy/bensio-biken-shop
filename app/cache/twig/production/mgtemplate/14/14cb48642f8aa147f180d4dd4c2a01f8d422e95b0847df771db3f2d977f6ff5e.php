<?php

/* default_frame.twig */
class __TwigTemplate_b5832f68c24e1712e997e22366544cef8bc29b3919cd33bc5970212d21aacfc4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'meta_tags' => array($this, 'block_meta_tags'),
            'stylesheet' => array($this, 'block_stylesheet'),
            'main' => array($this, 'block_main'),
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
        if ((array_key_exists("subtitle", $context) &&  !twig_test_empty(($context["subtitle"] ?? null)))) {
            echo " / ";
            echo twig_escape_filter($this->env, ($context["subtitle"] ?? null), "html", null, true);
        } elseif ((array_key_exists("title", $context) &&  !twig_test_empty(($context["title"] ?? null)))) {
            echo " / ";
            echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        }
        echo "</title>
";
        // line 28
        if ( !twig_test_empty($this->getAttribute(($context["PageLayout"] ?? null), "author", array()))) {
            // line 29
            echo "    <meta name=\"author\" content=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["PageLayout"] ?? null), "author", array()), "html", null, true);
            echo "\">
";
        }
        // line 31
        if ( !twig_test_empty($this->getAttribute(($context["PageLayout"] ?? null), "description", array()))) {
            // line 32
            echo "    <meta name=\"description\" content=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["PageLayout"] ?? null), "description", array()), "html", null, true);
            echo "\">
";
        }
        // line 34
        if ( !twig_test_empty($this->getAttribute(($context["PageLayout"] ?? null), "keyword", array()))) {
            // line 35
            echo "    <meta name=\"keywords\" content=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["PageLayout"] ?? null), "keyword", array()), "html", null, true);
            echo "\">
";
        }
        // line 37
        if ( !twig_test_empty($this->getAttribute(($context["PageLayout"] ?? null), "meta_robots", array()))) {
            // line 38
            echo "    <meta name=\"robots\" content=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["PageLayout"] ?? null), "meta_robots", array()), "html", null, true);
            echo "\">
";
        }
        // line 40
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
";
        // line 41
        if ( !twig_test_empty($this->getAttribute(($context["PageLayout"] ?? null), "meta_tags", array()))) {
            // line 42
            echo "    ";
            echo $this->getAttribute(($context["PageLayout"] ?? null), "meta_tags", array());
            echo "
";
        }
        // line 44
        $this->displayBlock('meta_tags', $context, $blocks);
        // line 45
        echo "<link rel=\"icon\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/common/favicon.ico\">
<link rel=\"stylesheet\" href=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/css/style.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
<link rel=\"stylesheet\" href=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/css/slick.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
<link rel=\"stylesheet\" href=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/css/default.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
<link rel=\"stylesheet\" href=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/css/custom.css?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\">
<!-- for original theme CSS -->
";
        // line 51
        $this->displayBlock('stylesheet', $context, $blocks);
        // line 52
        echo "
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
<script>window.jQuery || document.write('<script src=\"";
        // line 54
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/js/vendor/jquery-1.11.3.min.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"><\\/script>')</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-CMST9RCTTE\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CMST9RCTTE');
</script>
";
        // line 65
        if ($this->getAttribute(($context["PageLayout"] ?? null), "Head", array())) {
            // line 66
            echo "    ";
            // line 67
            echo "    ";
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "Head", array())));
            echo "
    ";
        }
        // line 71
        echo "
</head>
<body id=\"page_";
        // line 73
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "get", array(0 => "_route"), "method"), "html", null, true);
        echo "\" class=\"";
        echo twig_escape_filter($this->env, ((array_key_exists("body_class", $context)) ? (_twig_default_filter(($context["body_class"] ?? null), "other_page")) : ("other_page")), "html", null, true);
        echo "\">
<div id=\"wrapper\">
    <header id=\"header\">
        <div class=\"container-fluid inner\">
            ";
        // line 78
        echo "            ";
        if ($this->getAttribute(($context["PageLayout"] ?? null), "Header", array())) {
            // line 79
            echo "                ";
            // line 80
            echo "                ";
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "Header", array())));
            echo "
                ";
            // line 82
            echo "            ";
        }
        // line 83
        echo "            ";
        // line 84
        echo "            <p id=\"btn_menu\"><a class=\"nav-trigger\" href=\"#nav\">Menu<span></span></a></p>
        </div>
    </header>

    <div id=\"contents\" class=\"";
        // line 88
        echo twig_escape_filter($this->env, $this->getAttribute(($context["PageLayout"] ?? null), "theme", array()), "html", null, true);
        echo "\">

        <div id=\"contents_top\">
            ";
        // line 92
        echo "            ";
        if ($this->getAttribute(($context["PageLayout"] ?? null), "ContentsTop", array())) {
            // line 93
            echo "                ";
            // line 94
            echo "                ";
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "ContentsTop", array())));
            echo "
                ";
            // line 96
            echo "            ";
        }
        // line 97
        echo "            ";
        // line 98
        echo "        </div>

        <div class=\"container-fluid inner\">
            ";
        // line 102
        echo "            ";
        if ($this->getAttribute(($context["PageLayout"] ?? null), "SideLeft", array())) {
            // line 103
            echo "                <div id=\"side_left\" class=\"side\">
                    ";
            // line 105
            echo "                    ";
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "SideLeft", array())));
            echo "
                    ";
            // line 107
            echo "                </div>
            ";
        }
        // line 109
        echo "            ";
        // line 110
        echo "
            <div id=\"main\">
                ";
        // line 113
        echo "                ";
        if ($this->getAttribute(($context["PageLayout"] ?? null), "MainTop", array())) {
            // line 114
            echo "                    <div id=\"main_top\">
                        ";
            // line 115
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "MainTop", array())));
            echo "
                    </div>
                ";
        }
        // line 118
        echo "                ";
        // line 119
        echo "
                <div id=\"main_middle\">
                    ";
        // line 121
        $this->displayBlock('main', $context, $blocks);
        // line 122
        echo "                </div>

                ";
        // line 125
        echo "                ";
        if ($this->getAttribute(($context["PageLayout"] ?? null), "MainBottom", array())) {
            // line 126
            echo "                    <div id=\"main_bottom\">
                        ";
            // line 127
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "MainBottom", array())));
            echo "
                    </div>
                ";
        }
        // line 130
        echo "                ";
        // line 131
        echo "            </div>

            ";
        // line 134
        echo "            ";
        if ($this->getAttribute(($context["PageLayout"] ?? null), "SideRight", array())) {
            // line 135
            echo "                <div id=\"side_right\" class=\"side\">
                    ";
            // line 137
            echo "                    ";
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "SideRight", array())));
            echo "
                    ";
            // line 139
            echo "                </div>
            ";
        }
        // line 141
        echo "            ";
        // line 142
        echo "
            ";
        // line 144
        echo "            ";
        if ($this->getAttribute(($context["PageLayout"] ?? null), "ContentsBottom", array())) {
            // line 145
            echo "                <div id=\"contents_bottom\">
                    ";
            // line 147
            echo "                    ";
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "ContentsBottom", array())));
            echo "
                    ";
            // line 149
            echo "                </div>
            ";
        }
        // line 151
        echo "            ";
        // line 152
        echo "
        </div>

        <footer id=\"footer\">
            ";
        // line 157
        echo "            ";
        if ($this->getAttribute(($context["PageLayout"] ?? null), "Footer", array())) {
            // line 158
            echo "                ";
            // line 159
            echo "                ";
            echo twig_include($this->env, $context, "block.twig", array("Blocks" => $this->getAttribute(($context["PageLayout"] ?? null), "Footer", array())));
            echo "
                ";
            // line 161
            echo "            ";
        }
        // line 162
        echo "            ";
        // line 163
        echo "
        </footer>

    </div>

    <div id=\"drawer\" class=\"drawer sp\">
    </div>

</div>

<div class=\"overlay\"></div>

<script src=\"";
        // line 175
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/js/vendor/bootstrap.custom.min.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 176
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/js/vendor/slick.min.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 177
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/js/function.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 178
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/js/eccube.js?v=";
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::VERSION"), "html", null, true);
        echo "\"></script>
<script>
\$(function () {
    \$('#drawer').append(\$('.drawer_block').clone(true).children());
    \$.ajax({
        url: '";
        // line 183
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
";
        // line 192
        $this->displayBlock('javascript', $context, $blocks);
        // line 193
        echo "</body>
</html>
";
    }

    // line 44
    public function block_meta_tags($context, array $blocks = array())
    {
    }

    // line 51
    public function block_stylesheet($context, array $blocks = array())
    {
    }

    // line 121
    public function block_main($context, array $blocks = array())
    {
    }

    // line 192
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
        return array (  407 => 192,  402 => 121,  397 => 51,  392 => 44,  386 => 193,  384 => 192,  372 => 183,  362 => 178,  356 => 177,  350 => 176,  344 => 175,  330 => 163,  328 => 162,  325 => 161,  320 => 159,  318 => 158,  315 => 157,  309 => 152,  307 => 151,  303 => 149,  298 => 147,  295 => 145,  292 => 144,  289 => 142,  287 => 141,  283 => 139,  278 => 137,  275 => 135,  272 => 134,  268 => 131,  266 => 130,  260 => 127,  257 => 126,  254 => 125,  250 => 122,  248 => 121,  244 => 119,  242 => 118,  236 => 115,  233 => 114,  230 => 113,  226 => 110,  224 => 109,  220 => 107,  215 => 105,  212 => 103,  209 => 102,  204 => 98,  202 => 97,  199 => 96,  194 => 94,  192 => 93,  189 => 92,  183 => 88,  177 => 84,  175 => 83,  172 => 82,  167 => 80,  165 => 79,  162 => 78,  153 => 73,  149 => 71,  143 => 67,  141 => 66,  139 => 65,  124 => 54,  120 => 52,  118 => 51,  111 => 49,  105 => 48,  99 => 47,  93 => 46,  88 => 45,  86 => 44,  80 => 42,  78 => 41,  75 => 40,  69 => 38,  67 => 37,  61 => 35,  59 => 34,  53 => 32,  51 => 31,  45 => 29,  43 => 28,  32 => 27,  26 => 23,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "default_frame.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/default_frame.twig");
    }
}
