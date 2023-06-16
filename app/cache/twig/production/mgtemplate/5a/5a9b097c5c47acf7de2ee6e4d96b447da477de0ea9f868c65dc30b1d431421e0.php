<?php

/* pagination.twig */
class __TwigTemplate_76d5ee1b62d8eb6679ab5ec5eb1544acbfe39a4e8d48f22affab2865371c7856 extends Twig_Template
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
        // line 22
        if ($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array(), "any", false, true), "pageinrange", array(), "any", true, true)) {
            // line 23
            echo "    ";
            $context["pageinrange"] = $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "pageinrange", array());
        } else {
            // line 25
            echo "    ";
            $context["pageinrange"] = false;
        }
        // line 27
        echo "
";
        // line 28
        if (($this->getAttribute(($context["pages"] ?? null), "pageCount", array()) > 1)) {
            // line 29
            echo "<div id=\"pagination_wrap\" class=\"pagination\">
    <ul>

        ";
            // line 32
            if ((($context["pageinrange"] ?? null) && ($this->getAttribute(($context["pages"] ?? null), "firstPageInRange", array()) != 1))) {
                // line 33
                echo "            ";
                // line 34
                echo "            <li class=\"pagenation__item-first\">
                <a href=\"";
                // line 35
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "attributes", array()), "get", array(0 => "_route"), "method"), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("pageno" => $this->getAttribute(($context["pages"] ?? null), "first", array())))), "html", null, true);
                echo "\"
                   aria-label=\"First\"><span aria-hidden=\"true\">最初へ</span></a>
            </li>
        ";
            }
            // line 39
            echo "
        ";
            // line 40
            if ($this->getAttribute(($context["pages"] ?? null), "previous", array(), "any", true, true)) {
                // line 41
                echo "            <li class=\"pagenation__item-previous\">
                <a href=\"";
                // line 42
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "attributes", array()), "get", array(0 => "_route"), "method"), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("pageno" => $this->getAttribute(($context["pages"] ?? null), "previous", array())))), "html", null, true);
                echo "\"
                   aria-label=\"Previous\"><span aria-hidden=\"true\">前へ</span></a>
            </li>
        ";
            }
            // line 46
            echo "
        ";
            // line 47
            if ((($context["pageinrange"] ?? null) && ($this->getAttribute(($context["pages"] ?? null), "firstPageInRange", array()) != 1))) {
                // line 48
                echo "            ";
                // line 49
                echo "            <li>...</li>
        ";
            }
            // line 51
            echo "
        ";
            // line 52
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["pages"] ?? null), "pagesInRange", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
                // line 53
                echo "            ";
                if (($context["page"] == $this->getAttribute(($context["pages"] ?? null), "current", array()))) {
                    // line 54
                    echo "                <li class=\"pagenation__item active\"><a href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "attributes", array()), "get", array(0 => "_route"), "method"), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("pageno" => $context["page"]))), "html", null, true);
                    echo "\"> ";
                    echo twig_escape_filter($this->env, $context["page"], "html", null, true);
                    echo " </a></li>
            ";
                } else {
                    // line 56
                    echo "                <li class=\"pagenation__item\"><a href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "attributes", array()), "get", array(0 => "_route"), "method"), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("pageno" => $context["page"]))), "html", null, true);
                    echo "\"> ";
                    echo twig_escape_filter($this->env, $context["page"], "html", null, true);
                    echo " </a></li>
            ";
                }
                // line 58
                echo "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 59
            echo "
        ";
            // line 60
            if ((($context["pageinrange"] ?? null) && ($this->getAttribute(($context["pages"] ?? null), "last", array()) != $this->getAttribute(($context["pages"] ?? null), "lastPageInRange", array())))) {
                // line 61
                echo "            ";
                // line 62
                echo "            <li>...</li>
        ";
            }
            // line 64
            echo "
        ";
            // line 65
            if ($this->getAttribute(($context["pages"] ?? null), "next", array(), "any", true, true)) {
                // line 66
                echo "            <li class=\"pagenation__item-next\">
                <a href=\"";
                // line 67
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "attributes", array()), "get", array(0 => "_route"), "method"), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("pageno" => $this->getAttribute(($context["pages"] ?? null), "next", array())))), "html", null, true);
                echo "\"
                   aria-label=\"Next\"><span aria-hidden=\"true\">次へ</span></a>
            </li>
        ";
            }
            // line 71
            echo "
        ";
            // line 72
            if ((($context["pageinrange"] ?? null) && ($this->getAttribute(($context["pages"] ?? null), "last", array()) != $this->getAttribute(($context["pages"] ?? null), "lastPageInRange", array())))) {
                // line 73
                echo "            ";
                // line 74
                echo "            <li class=\"pagenation__item-last\">
                <a href=\"";
                // line 75
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "attributes", array()), "get", array(0 => "_route"), "method"), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("pageno" => $this->getAttribute(($context["pages"] ?? null), "last", array())))), "html", null, true);
                echo "\"
                   aria-label=\"Last\"><span aria-hidden=\"true\">最後へ</span></a>
            </li>
        ";
            }
            // line 79
            echo "    </ul>
</div>
";
        }
    }

    public function getTemplateName()
    {
        return "pagination.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  154 => 79,  147 => 75,  144 => 74,  142 => 73,  140 => 72,  137 => 71,  130 => 67,  127 => 66,  125 => 65,  122 => 64,  118 => 62,  116 => 61,  114 => 60,  111 => 59,  105 => 58,  97 => 56,  89 => 54,  86 => 53,  82 => 52,  79 => 51,  75 => 49,  73 => 48,  71 => 47,  68 => 46,  61 => 42,  58 => 41,  56 => 40,  53 => 39,  46 => 35,  43 => 34,  41 => 33,  39 => 32,  34 => 29,  32 => 28,  29 => 27,  25 => 25,  21 => 23,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pagination.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/pagination.twig");
    }
}
