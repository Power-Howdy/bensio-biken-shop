<?php

/* EccubePaymentLite3/Twig/mypage/mypage_navi_add.twig */
class __TwigTemplate_6d67e9f8b3f39f50d1680e669156f8fad2e08357835013d8cdbd33ebaa62c360 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'main' => array($this, 'block_main'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('main', $context, $blocks);
    }

    public function block_main($context, array $blocks = array())
    {
        // line 2
        echo "    <li class=\"";
        if ((((array_key_exists("mypageno", $context)) ? (_twig_default_filter(($context["mypageno"] ?? null), "")) : ("")) == "card")) {
            echo "active";
        }
        echo "\"><a";
        if ((((array_key_exists("mypageno", $context)) ? (_twig_default_filter(($context["mypageno"] ?? null), "")) : ("")) != "card")) {
            echo " href=\"";
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("paylite_mypage_credit_card_index");
            echo "\"";
        }
        echo ">カード編集</a></li>
";
    }

    public function getTemplateName()
    {
        return "EccubePaymentLite3/Twig/mypage/mypage_navi_add.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "EccubePaymentLite3/Twig/mypage/mypage_navi_add.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/Plugin/EccubePaymentLite3/Twig/mypage/mypage_navi_add.twig");
    }
}
