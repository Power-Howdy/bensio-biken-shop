<?php

/* Block/new_product.twig */
class __TwigTemplate_ece279e6c544092927e3fbbe824279807564fb84b963a37b71f6eaa7f97175c7 extends Twig_Template
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
        echo "<h3>商品カテゴリー</h3>
<div id=\"contents_top\">
                  <div class=\"cat_photo\">
                    <a href=\"https://biken-shop-mall.com/products/detail/20\"><img src=\"https://biken-shop-mall.com/html/upload/temp_image/0506120348_6274901424520.png\"></a>
                  </div>

<ul id=\"cat-list\" class=\"d-f jc-sb sp-fxw-w\">
        <li>
                  <div class=\"cat_photo\">
                    <a href=\"https://biken-shop-mall.com/products/list?category_id=1\"><img src=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/top/cat01.png\"></a>
                  </div>

                  <ul>
                    <li class=\"cat_nav\"><a href=\"https://biken-shop-mall.com/products/list?category_id=9\"><span class=\"deco\">◆治療家（国家資格者）・治療院勤務の方（国家資格者以外含む）</span></a></li>
                    <li class=\"cat_nav\"><a href=\"https://biken-shop-mall.com/products/list?category_id=10\"><span class=\"deco\">◆セラピスト（整体・エステ・その他）</span></a></li>
                  </ul>
        </li>
        <li>
                <div class=\"cat_photo\">
                    <a href=\"https://biken-shop-mall.com/products/list?category_id=7\"><img src=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/top/cat02.png\"></a>
                </div>
                <ul>
                    <li class=\"cat_nav\"><a href=\"https://biken-shop-mall.com/products/list?category_id=12\"><span class=\"deco\">◆テキスト</span></a></li>
                    <li class=\"cat_nav\"><a href=\"https://biken-shop-mall.com/products/list?category_id=13\"><span class=\"deco\">◆動画</span></a></li>
                    <li class=\"cat_nav\"><a href=\"https://biken-shop-mall.com/products/list?category_id=14\"><span class=\"deco\">◆オンラインテスト</span></a></li>
                </ul>
        </li>    
</ul>
<ul id=\"cat-list\" class=\"d-f jc-sb sp-fxw-w\">
        <li>
                  <div class=\"cat_photo\">
                    <a href=\"https://biken-shop-mall.com/products/list?category_id=6\"><img src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/top/cat03.png\"></a>
                  </div>

                  <ul>
                    <li class=\"cat_nav\"><a href=\"https://biken-shop-mall.com/products/detail/9?admin=1\"><span class=\"deco\">92ブランドシリーズ（化粧品）</span></a></li>
                    <li class=\"cat_nav\"><a href=\"https://www.share28-co.com/aquabank-water-server01272002?fbclid=IwAR00QKpUEyzHLfYWB4Wh7bgQLbZfozm9PZ-ru7HL_7xNPHiNftqZ2_JKK5U\"><span class=\"deco\">アクアバンクウォーターサーバー（水素水）</span></a></li>
                    <li class=\"cat_nav\"><a href=\"#\"><span class=\"deco\">アクアバンクKENCOS（水素吸引機）</span></a></li>
                    <li class=\"cat_nav\"><a href=\"#\"><span class=\"deco\">アクアバンクマスク</span></a></li>
                    <li class=\"cat_nav\"><a href=\"#\"><span class=\"deco\">Air Design card（空気清浄・消臭カード）</span></a></li>
                    <li class=\"cat_nav\"><a href=\"#\"><span class=\"deco\">タケックス（アルコール製剤）</span></a></li>
                  </ul>
        </li>
        <li>
                <div class=\"cat_photo\">
                    <a href=\"https://biken-shop-mall.com/products/list?category_id=8\"><img src=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/top/cat04.png\"></a>
                </div>
                <ul>
                    <li class=\"cat_nav\"><a href=\"https://biken-shop-mall.com/products/list?category_id=15\"><span class=\"deco\">◆クーポン</span></a></li>
                </ul>
        </li>    
</ul>
</div>";
    }

    public function getTemplateName()
    {
        return "Block/new_product.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 46,  58 => 32,  43 => 20,  30 => 10,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Block/new_product.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/Block/new_product.twig");
    }
}
