<?php

/* __string_template__b65291cf111b71d1a4902e7a57cb8db0aac1c61b700afe16618b36cd88c5f354 */
class __TwigTemplate_a238e809c62e4d11a77206ae986da85e29194c795d9deacf48eecdc42064af32 extends Twig_Template
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
        echo "<div id=\"cart_area\">
    <p class=\"clearfix cart-trigger\"><a href=\"#cart\">
            <svg class=\"cb cb-shopping-cart\">
                <use xlink:href=\"#cb-shopping-cart\"/>
            </svg>
            <span class=\"badge\">";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Cart"] ?? null), "total_quantity", array()), "html", null, true);
        echo "</span>
            <svg class=\"cb cb-close\">
                <use xlink:href=\"#cb-close\"/>
            </svg>
        </a>
        <span class=\"cart_price pc\">合計 <span class=\"price\">";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Cart"] ?? null), "total_price", array())), "html", null, true);
        echo "</span></span></p>
    <div id=\"cart\" class=\"cart\">
        <div class=\"inner\">
            ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashbag", array()), "get", array(0 => "eccube.front.cart.error"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
            // line 36
            echo "                <div class=\"message\">
                    <p class=\"errormsg bg-danger\">
                        <svg class=\"cb cb-warning\"><use xlink:href=\"#cb-warning\" /></svg>";
            // line 38
            echo nl2br(twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["error"]), "html", null, true));
            echo "
                    </p>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        echo "            ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["Cart"] ?? null), "CartItems", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["CartItem"]) {
            // line 43
            echo "                ";
            $context["ProductClass"] = $this->getAttribute($context["CartItem"], "Object", array());
            // line 44
            echo "                ";
            $context["Product"] = $this->getAttribute(($context["ProductClass"] ?? null), "Product", array());
            // line 45
            echo "                <div class=\"item_box clearfix\">
                    <div class=\"item_photo\"><img
                                src=\"";
            // line 47
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getNoImageProduct($this->getAttribute(($context["Product"] ?? null), "MainListImage", array())), "html", null, true);
            echo "\"
                                alt=\"";
            // line 48
            echo twig_escape_filter($this->env, $this->getAttribute(($context["Product"] ?? null), "name", array()), "html", null, true);
            echo "\"></div>
                    <dl class=\"item_detail\">
                        <dt class=\"item_name\">";
            // line 50
            echo twig_escape_filter($this->env, $this->getAttribute(($context["Product"] ?? null), "name", array()), "html", null, true);
            echo "</dt>
                        <dd class=\"item_pattern small\">";
            // line 52
            if ($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory1", array())) {
                // line 53
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory1", array()), "ClassName", array()), "html", null, true);
                echo "：";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory1", array()), "html", null, true);
                // line 54
                if ($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory2", array())) {
                    // line 55
                    echo "<br>";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory2", array()), "ClassName", array()), "html", null, true);
                    echo "：";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory2", array()), "html", null, true);
                }
            }
            // line 58
            echo "</dd>
                        <dd class=\"item_price\">";
            // line 59
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($context["CartItem"], "price", array())), "html", null, true);
            echo "<span class=\"small\">税込</span></dd>
                        <dd class=\"item_quantity form-group form-inline\">数量：";
            // line 60
            echo twig_escape_filter($this->env, $this->getAttribute($context["CartItem"], "quantity", array()), "html", null, true);
            echo "</dd>
                    </dl>
                </div><!--/item_box-->
                <p class=\"cart_price sp\">合計 <span class=\"price\">";
            // line 63
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Cart"] ?? null), "total_price", array())), "html", null, true);
            echo "</span></p>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['CartItem'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 65
        echo "            ";
        if ((twig_length_filter($this->env, $this->getAttribute(($context["Cart"] ?? null), "CartItems", array())) > 0)) {
            // line 66
            echo "
                <div class=\"btn_area\">
                    <ul>
                        <li>
                            <a href=\"";
            // line 70
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("cart");
            echo "\" class=\"btn btn-primary\">カートへ進む</a>
                        </li>
                        <li>
                            <button type=\"button\" class=\"btn btn-default btn-sm cart-trigger\">キャンセル</button>
                        </li>
                    </ul>
                </div>
            ";
        } else {
            // line 78
            echo "                <div class=\"btn_area\">
                    <div class=\"message\">
                        <p class=\"errormsg bg-danger\" style=\"margin-bottom: 20px;\">
                            現在カート内に<br>商品はございません。
                        </p>
                    </div>
                </div>
            ";
        }
        // line 86
        echo "        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "__string_template__b65291cf111b71d1a4902e7a57cb8db0aac1c61b700afe16618b36cd88c5f354";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  154 => 86,  144 => 78,  133 => 70,  127 => 66,  124 => 65,  116 => 63,  110 => 60,  106 => 59,  103 => 58,  96 => 55,  94 => 54,  90 => 53,  88 => 52,  84 => 50,  79 => 48,  73 => 47,  69 => 45,  66 => 44,  63 => 43,  58 => 42,  48 => 38,  44 => 36,  40 => 35,  34 => 32,  26 => 27,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__b65291cf111b71d1a4902e7a57cb8db0aac1c61b700afe16618b36cd88c5f354", "");
    }
}
