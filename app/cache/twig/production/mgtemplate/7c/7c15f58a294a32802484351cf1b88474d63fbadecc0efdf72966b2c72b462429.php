<?php

/* EccubePaymentLite3/Twig/shopping/next_cart_button.twig */
class __TwigTemplate_ccd8a11562f136ec49727b27deea0697116296d74d913087fb70210ba98e77a2 extends Twig_Template
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
        echo "
<button type=\"submit\" class=\"btn btn-primary btn-block\">注文する</button>
";
    }

    public function getTemplateName()
    {
        return "EccubePaymentLite3/Twig/shopping/next_cart_button.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "EccubePaymentLite3/Twig/shopping/next_cart_button.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/Plugin/EccubePaymentLite3/Twig/shopping/next_cart_button.twig");
    }
}
