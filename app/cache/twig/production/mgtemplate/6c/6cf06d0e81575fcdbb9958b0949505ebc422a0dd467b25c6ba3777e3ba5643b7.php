<?php

/* Block/footer.twig */
class __TwigTemplate_c63128b295fc0ba60fad9a5f0589630627efede605c7469bb860831c99509ecb extends Twig_Template
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
        echo "<div class=\"container-fluid inner\">
    <ul>
        <li><a href=\"";
        // line 24
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("help_about");
        echo "\"><span class=\"deco\">当サイトについて</span></a></li>
        <li><a href=\"";
        // line 25
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("help_privacy");
        echo "\"><span class=\"deco\">プライバシーポリシー</span></a></li>
        <li><a href=\"";
        // line 26
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("help_tradelaw");
        echo "\"><span class=\"deco\">特定商取引法に基づく表記</span></a></li>
        <li><a href=\"";
        // line 27
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("contact");
        echo "\"><span class=\"deco\">お問い合わせ</span></a></li>
    </ul>
    <div class=\"footer_logo_area\">
        <p class=\"logo\"><a href=\"";
        // line 30
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("homepage");
        echo "\"><img src=\"/html/template/mgtemplate/img/ft_logo.png\" alt=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["BaseInfo"] ?? null), "shop_name", array()), "html", null, true);
        echo "\" /></a></p>
        <p class=\"copyright\">
            <small>copyright (c) ";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute(($context["BaseInfo"] ?? null), "shop_name", array()), "html", null, true);
        echo " all rights reserved.</small>
        </p>
    </div>
</div>

";
    }

    public function getTemplateName()
    {
        return "Block/footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 32,  41 => 30,  35 => 27,  31 => 26,  27 => 25,  23 => 24,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Block/footer.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/Block/footer.twig");
    }
}
