<?php

/* Order/shipment_item_prototype.twig */
class __TwigTemplate_eb9fceb7c15834a06bcdb1d091f9eae0b40b36e0f4ff39c68caba840d3470b5f extends Twig_Template
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
        echo "<div style=\"display: none\">
    ";
        // line 2
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["shipmentItemForm"] ?? null), "new", array()), 'widget');
        echo "
    ";
        // line 3
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["shipmentItemForm"] ?? null), "Product", array()), 'widget');
        echo "
    ";
        // line 4
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["shipmentItemForm"] ?? null), "ProductClass", array()), 'widget');
        echo "
    ";
        // line 5
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["shipmentItemForm"] ?? null), "price", array()), 'widget', array("type" => "hidden"));
        echo "
    ";
        // line 6
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["shipmentItemForm"] ?? null), "quantity", array()), 'widget', array("type" => "hidden"));
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "Order/shipment_item_prototype.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  34 => 5,  30 => 4,  26 => 3,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Order/shipment_item_prototype.twig", "/home/wp614605/biken-shop-mall.com/public_html/src/Eccube/Resource/template/admin/Order/shipment_item_prototype.twig");
    }
}
