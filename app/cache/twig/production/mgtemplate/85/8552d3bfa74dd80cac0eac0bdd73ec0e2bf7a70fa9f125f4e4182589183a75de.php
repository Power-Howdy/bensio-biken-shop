<?php

/* Block/free.twig */
class __TwigTemplate_ebfdb6eb4c13f853d2c816976fe592a8c1a519164b1088afe51026b4649fc06d extends Twig_Template
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
        echo "<nav id=\"category\" class=\"drawer_block pc\">
    <ul class=\"category-nav\">
                <li>
        <a href=\"https://biken-shop-mall.com/\">
            ホーム
        </a>
            </li>

                <li>
        <a href=\"https://biken-shop-mall.com/products/list?category_id=&name=\">
            商品一覧
        </a>
            </li>

        </ul> <!-- nav -->
</nav>";
    }

    public function getTemplateName()
    {
        return "Block/free.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Block/free.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/Block/free.twig");
    }
}
