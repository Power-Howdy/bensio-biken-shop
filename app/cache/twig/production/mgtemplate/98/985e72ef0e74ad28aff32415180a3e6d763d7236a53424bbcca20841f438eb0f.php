<?php

/* Block/plg_shiro8_gallary_block.twig */
class __TwigTemplate_50e77695827423d4db1430a0b7ecaf35528c283b6833f6b90c62c622660d3816 extends Twig_Template
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
        echo "<h3>おすすめ商品</h3>
<!-- ▼おすすめ商品▼ -->
<p style=\"clear:both;\"></p>
<div class=\"item_gallary\">
    <ul id=\"osusume\" class=\"d-f fxw-w\">
    ";
        // line 6
        if ((twig_length_filter($this->env, ($context["Products"] ?? null)) > 0)) {
            // line 7
            echo "    \t";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["Products"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["Product"]) {
                // line 8
                echo "    \t\t<li>
    \t\t\t<a href=\"";
                // line 9
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("product_detail", array("id" => $this->getAttribute($context["Product"], "id", array()))), "html", null, true);
                echo "\" class=\"item_photo\">
    \t\t\t\t<img src=\"";
                // line 10
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getNoImageProduct($this->getAttribute($context["Product"], "main_list_image", array())), "html", null, true);
                echo "\"></a>
    \t\t</li>
    \t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Product'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 13
            echo "    ";
        }
        // line 14
        echo "    </ul>
</div>
<!-- ▲おすすめ商品▲ -->";
    }

    public function getTemplateName()
    {
        return "Block/plg_shiro8_gallary_block.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 14,  51 => 13,  40 => 10,  36 => 9,  33 => 8,  28 => 7,  26 => 6,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Block/plg_shiro8_gallary_block.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/Block/plg_shiro8_gallary_block.twig");
    }
}
