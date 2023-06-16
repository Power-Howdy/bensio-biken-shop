<?php

/* Mail/order.twig */
class __TwigTemplate_cf2cbd004745242f5e595660f95a95aa4d665e3677192204d9a1d56dcd26cf9e extends Twig_Template
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
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "name01", array()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "name02", array()), "html", null, true);
        echo " 様

";
        // line 24
        echo twig_escape_filter($this->env, ($context["header"] ?? null), "html", null, true);
        echo "

************************************************
　ご請求金額
************************************************

ご注文番号：";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "id", array()), "html", null, true);
        echo "
お支払い合計：";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "payment_total", array())), "html", null, true);
        echo "
お支払い方法：";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "payment_method", array()), "html", null, true);
        echo "
メッセージ：";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "message", array()), "html", null, true);
        echo "


************************************************
　ご注文商品明細
************************************************

";
        // line 40
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["Order"] ?? null), "OrderDetails", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["OrderDetail"]) {
            // line 41
            echo "商品コード: ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "product_code", array()), "html", null, true);
            echo "
商品名: ";
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "product_name", array()), "html", null, true);
            echo "  ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "classcategory_name1", array()), "html", null, true);
            echo "  ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "classcategory_name2", array()), "html", null, true);
            echo "
単価： ";
            // line 43
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCalcIncTax($this->getAttribute($context["OrderDetail"], "price", array()), $this->getAttribute($context["OrderDetail"], "tax_rate", array()), $this->getAttribute($context["OrderDetail"], "tax_rule", array()))), "html", null, true);
            echo "
数量： ";
            // line 44
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["OrderDetail"], "quantity", array())), "html", null, true);
            echo "

";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['OrderDetail'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "
-------------------------------------------------
小　計 ";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "subtotal", array())), "html", null, true);
        if (($this->getAttribute(($context["Order"] ?? null), "tax", array()) > 0)) {
            echo "(うち消費税 ";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "tax", array())), "html", null, true);
            echo ")";
        }
        // line 50
        echo "
手数料 ";
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "charge", array())), "html", null, true);
        echo "
送　料 ";
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "delivery_fee_total", array())), "html", null, true);
        echo "
";
        // line 53
        if (($this->getAttribute(($context["Order"] ?? null), "discount", array()) > 0)) {
            // line 54
            echo "値引き ";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter((0 - $this->getAttribute(($context["Order"] ?? null), "discount", array()))), "html", null, true);
            echo "
";
        }
        // line 56
        echo "============================================
合　計 ";
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "payment_total", array())), "html", null, true);
        echo "

************************************************
　ご注文者情報
************************************************
お名前　：";
        // line 62
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "name01", array()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "name02", array()), "html", null, true);
        echo " 様
フリガナ：";
        // line 63
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "kana01", array()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "kana02", array()), "html", null, true);
        echo " 様
";
        // line 64
        if ($this->getAttribute(($context["Order"] ?? null), "company_name", array())) {
            // line 65
            echo "会社名　：";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "company_name", array()), "html", null, true);
            echo "
";
        }
        // line 67
        if ($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "form_country_enable", array())) {
            // line 68
            echo "国　　　：";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "Country", array()), "html", null, true);
            echo "
ZIPCODE ：";
            // line 69
            echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "zip_code", array()), "html", null, true);
            echo "
";
        }
        // line 71
        echo "郵便番号：〒";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "zip01", array()), "html", null, true);
        echo "-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "zip02", array()), "html", null, true);
        echo "
住所　　：";
        // line 72
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["Order"] ?? null), "Pref", array()), "name", array()), "html", null, true);
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "addr01", array()), "html", null, true);
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "addr02", array()), "html", null, true);
        echo "
電話番号：";
        // line 73
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "tel01", array()), "html", null, true);
        echo "-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "tel02", array()), "html", null, true);
        echo "-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "tel03", array()), "html", null, true);
        echo "
FAX番号 ：";
        // line 74
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "fax01", array()), "html", null, true);
        echo "-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "fax02", array()), "html", null, true);
        echo "-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "fax03", array()), "html", null, true);
        echo "

メールアドレス：";
        // line 76
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "email", array()), "html", null, true);
        echo "

************************************************
　配送情報
************************************************

";
        // line 82
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["Order"] ?? null), "Shippings", array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["Shipping"]) {
            // line 83
            echo "◎お届け先";
            if ($this->getAttribute(($context["Order"] ?? null), "multiple", array())) {
                echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            }
            // line 84
            echo "
お名前　：";
            // line 85
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "name01", array()), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "name02", array()), "html", null, true);
            echo " 様
フリガナ：";
            // line 86
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "kana01", array()), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "kana02", array()), "html", null, true);
            echo " 様
";
            // line 87
            if ($this->getAttribute($context["Shipping"], "company_name", array())) {
                // line 88
                echo "会社名　：";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "company_name", array()), "html", null, true);
                echo "
";
            }
            // line 90
            if ($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "form_country_enable", array())) {
                // line 91
                echo "    　国　　　：";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["Shipping"], "Country", array()), "name", array()), "html", null, true);
                echo "
    　ZIPCODE ：";
                // line 92
                echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "zip_code", array()), "html", null, true);
                echo "
";
            }
            // line 94
            echo "郵便番号：〒";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "zip01", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "zip02", array()), "html", null, true);
            echo "
住所　　：";
            // line 95
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["Shipping"], "Pref", array()), "name", array()), "html", null, true);
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "addr01", array()), "html", null, true);
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "addr02", array()), "html", null, true);
            echo "
電話番号：";
            // line 96
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "tel01", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "tel02", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "tel03", array()), "html", null, true);
            echo "
FAX番号 ：";
            // line 97
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "fax01", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "fax02", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Shipping"], "fax03", array()), "html", null, true);
            echo "

お届け日：";
            // line 99
            echo twig_escape_filter($this->env, ((twig_test_empty($this->getAttribute($context["Shipping"], "shipping_delivery_date", array()))) ? ("指定なし") : ($this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getDateFormatFilter($this->getAttribute($context["Shipping"], "shipping_delivery_date", array())))), "html", null, true);
            echo "
お届け時間：";
            // line 100
            echo twig_escape_filter($this->env, (($this->getAttribute($context["Shipping"], "shipping_delivery_time", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["Shipping"], "shipping_delivery_time", array()), "指定なし")) : ("指定なし")), "html", null, true);
            echo "

";
            // line 102
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["Shipping"], "ShipmentItems", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["ShipmentItem"]) {
                // line 103
                echo "商品コード: ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["ShipmentItem"], "product_code", array()), "html", null, true);
                echo "
商品名: ";
                // line 104
                echo twig_escape_filter($this->env, $this->getAttribute($context["ShipmentItem"], "product_name", array()), "html", null, true);
                echo "  ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["ShipmentItem"], "classcategory_name1", array()), "html", null, true);
                echo "  ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["ShipmentItem"], "classcategory_name2", array()), "html", null, true);
                echo "
数量：";
                // line 105
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["ShipmentItem"], "quantity", array())), "html", null, true);
                echo "

";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ShipmentItem'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Shipping'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 109
        echo "
";
        // line 110
        echo twig_escape_filter($this->env, ($context["footer"] ?? null), "html", null, true);
    }

    public function getTemplateName()
    {
        return "Mail/order.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  336 => 110,  333 => 109,  312 => 105,  304 => 104,  299 => 103,  295 => 102,  290 => 100,  286 => 99,  277 => 97,  269 => 96,  263 => 95,  256 => 94,  251 => 92,  246 => 91,  244 => 90,  238 => 88,  236 => 87,  230 => 86,  224 => 85,  221 => 84,  216 => 83,  199 => 82,  190 => 76,  181 => 74,  173 => 73,  167 => 72,  160 => 71,  155 => 69,  150 => 68,  148 => 67,  142 => 65,  140 => 64,  134 => 63,  128 => 62,  120 => 57,  117 => 56,  111 => 54,  109 => 53,  105 => 52,  101 => 51,  98 => 50,  91 => 49,  87 => 47,  78 => 44,  74 => 43,  66 => 42,  61 => 41,  57 => 40,  47 => 33,  43 => 32,  39 => 31,  35 => 30,  26 => 24,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Mail/order.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/Mail/order.twig");
    }
}
