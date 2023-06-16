<?php

/* Point/Resource/template/default/Event/ShoppingConfirm/point_summary.twig */
class __TwigTemplate_3b9ba6d5f2be1015903ee7ad130e5562706934c8520c079fba66832bc56550cd extends Twig_Template
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
        echo "<br/>
<dl id=\"summary_box__customer_point\">
    <dt>利用ポイント</dt>
    <dd class=\"text-primary\">";
        // line 4
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute(($context["point"] ?? null), "use", array())), "html", null, true);
        echo " pt</dd>
</dl>
<dl id=\"summary_box__customer_point\">
    <dt>加算ポイント</dt>
    <dd>";
        // line 8
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute(($context["point"] ?? null), "add", array())), "html", null, true);
        echo " pt</dd>
</dl>

";
    }

    public function getTemplateName()
    {
        return "Point/Resource/template/default/Event/ShoppingConfirm/point_summary.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 8,  24 => 4,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Point/Resource/template/default/Event/ShoppingConfirm/point_summary.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/Plugin/Point/Resource/template/default/Event/ShoppingConfirm/point_summary.twig");
    }
}
