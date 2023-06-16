<?php

/* pager.twig */
class __TwigTemplate_c5db8f4266529ed9eb2bf69a2c6cf270a6f4afd78e7ec7dc7296dc93641a026f extends Twig_Template
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
        // line 23
        echo "<div id=\"";
        echo twig_escape_filter($this->env, ((array_key_exists("id", $context)) ? (_twig_default_filter(($context["id"] ?? null), "pagination_wrap")) : ("pagination_wrap")), "html", null, true);
        echo "\" class=\"box-footer\">
    <div class=\"text-center\">
        <ul class=\"pagination\">
            ";
        // line 26
        if ($this->getAttribute(($context["pages"] ?? null), "previous", array(), "any", true, true)) {
            // line 27
            echo "                <li class=\"pagenation__item-previous\"><a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath(($context["routes"] ?? null), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("page_no" => $this->getAttribute(($context["pages"] ?? null), "previous", array())))), "html", null, true);
            echo "\" aria-label=\"Previous\"><span aria-hidden=\"true\">前へ</span></a></li>
            ";
        }
        // line 29
        echo "            
            ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["pages"] ?? null), "pagesInRange", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 31
            echo "                <li";
            if (($context["page"] == $this->getAttribute(($context["pages"] ?? null), "current", array()))) {
                echo " class=\"pagenation__item active\"";
            }
            echo "><a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath(($context["routes"] ?? null), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("page_no" => $context["page"]))), "html", null, true);
            echo "\"><span>";
            echo twig_escape_filter($this->env, $context["page"], "html", null, true);
            echo "</span></a></li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "            
            ";
        // line 34
        if ($this->getAttribute(($context["pages"] ?? null), "next", array(), "any", true, true)) {
            // line 35
            echo "                <li class=\"pagenation__item-next\"><a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath(($context["routes"] ?? null), twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "query", array()), "all", array()), array("page_no" => $this->getAttribute(($context["pages"] ?? null), "next", array())))), "html", null, true);
            echo "\" aria-label=\"Next\"><span aria-hidden=\"true\">次へ</span></a></li>
            ";
        }
        // line 37
        echo "        </ul>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "pager.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 37,  61 => 35,  59 => 34,  56 => 33,  41 => 31,  37 => 30,  34 => 29,  28 => 27,  26 => 26,  19 => 23,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "pager.twig", "/home/wp614605/biken-shop-mall.com/public_html/src/Eccube/Resource/template/admin/pager.twig");
    }
}
