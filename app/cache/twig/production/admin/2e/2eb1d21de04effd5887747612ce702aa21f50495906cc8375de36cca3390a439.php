<?php

/* __string_template__8ba2dc10320a5bdd304e0c3f5bb506d96cb2bdc0b001e9c0bec4c0366cdd4d6a */
class __TwigTemplate_ab084bc915b85bb6fe6211366c11cfbea78e3b6507d507e130706d679d77cbde extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 11
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__8ba2dc10320a5bdd304e0c3f5bb506d96cb2bdc0b001e9c0bec4c0366cdd4d6a", 11);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'sub_title' => array($this, 'block_sub_title'),
            'main' => array($this, 'block_main'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 13
        $context["menus"] = array(0 => "order", 1 => "plugin_coupon");
        // line 11
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 15
    public function block_title($context, array $blocks = array())
    {
        echo "クーポン管理";
    }

    // line 16
    public function block_sub_title($context, array $blocks = array())
    {
        echo "クーポン内容設定";
    }

    // line 18
    public function block_main($context, array $blocks = array())
    {
        // line 19
        echo "<form name=\"search_form\" id=\"search_form\" method=\"post\" action=\"\">
    ";
        // line 20
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchForm"] ?? null), "_token", array()), 'widget');
        echo "
    <div class=\"row\">
        <div class=\"col-md-12\">
            <div class=\"box\">
                <div class=\"box-header with-arrow\">
                    <h3 class=\"box-title\"><span class=\"normal\"><strong>";
        // line 25
        echo twig_escape_filter($this->env, ($context["totalItemCount"] ?? null), "html", null, true);
        echo " 件</strong> が該当しました</span></h3>
                </div><!-- /.box-header -->
                <div class=\"box-body\">
                    <div class=\"table_list\">
                        <div class=\"table-responsive with-border\">
                            <table class=\"table table-hover\">
                                <thead>
                                <tr>
                                    <th>クーポンID</th>
                                    <th>クーポンコード</th>
                                    <th>クーポン名</th>
                                    <th>種別</th>
                                    <th>会員のみ</th>
                                    <th>値引き</th>
                                    <th>残発行枚数</th>
                                    <th>下限金額</th>
                                    <th>有効期間</th>
                                    <th>編集</th>
                                    <th>状態</th>
                                    <th>削除</th>
                                </tr>
                                </thead>
                                <tbody>
                                ";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["pagination"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["Coupon"]) {
            // line 49
            echo "                                <tr class=\"";
            if (($this->getAttribute($context["Coupon"], "enable_flag", array()) == 0)) {
                echo "active";
            }
            echo "\">
                                    <td class=\"coupon_id\">";
            // line 50
            echo twig_escape_filter($this->env, $this->getAttribute($context["Coupon"], "id", array()), "html", null, true);
            echo "</td>
                                    <td class=\"coupon_cd\">";
            // line 51
            echo twig_escape_filter($this->env, $this->getAttribute($context["Coupon"], "coupon_cd", array()), "html", null, true);
            echo "</td>
                                    <td class=\"coupon_name\">";
            // line 52
            echo twig_escape_filter($this->env, $this->getAttribute($context["Coupon"], "coupon_name", array()), "html", null, true);
            echo "</td>

                                    ";
            // line 54
            if (($this->getAttribute($context["Coupon"], "coupon_type", array()) == 1)) {
                // line 55
                echo "                                        <td class=\"coupon_type\">商品</td>
                                    ";
            } elseif (($this->getAttribute(            // line 56
$context["Coupon"], "coupon_type", array()) == 2)) {
                // line 57
                echo "                                        <td class=\"coupon_type\">カテゴリ</td>
                                    ";
            } elseif (($this->getAttribute(            // line 58
$context["Coupon"], "coupon_type", array()) == 3)) {
                // line 59
                echo "                                        <td class=\"coupon_type\">全商品</td>
                                    ";
            } else {
                // line 61
                echo "                                        <td class=\"coupon_type\"></td>
                                    ";
            }
            // line 63
            echo "
                                    ";
            // line 64
            if (($this->getAttribute($context["Coupon"], "coupon_member", array()) == 1)) {
                // line 65
                echo "                                        <td class=\"coupon_member\">YES</td>
                                    ";
            } else {
                // line 67
                echo "                                        <td class=\"coupon_member\">NO</td>
                                    ";
            }
            // line 69
            echo "
                                    ";
            // line 70
            if (($this->getAttribute($context["Coupon"], "discount_type", array()) == 1)) {
                // line 71
                echo "                                        <td class=\"coupon_discount\">";
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($context["Coupon"], "discount_price", array())), "html", null, true);
                echo "</td>
                                    ";
            } elseif (($this->getAttribute(            // line 72
$context["Coupon"], "discount_type", array()) == 2)) {
                // line 73
                echo "                                        <td class=\"coupon_discount\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Coupon"], "discount_rate", array()), "html", null, true);
                echo " %</td>
                                    ";
            } else {
                // line 75
                echo "                                        <td class=\"coupon_discount\"></td>
                                    ";
            }
            // line 77
            echo "
                                    <td>";
            // line 78
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["Coupon"], "coupon_use_time", array())), "html", null, true);
            echo " / ";
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["Coupon"], "coupon_release", array())), "html", null, true);
            echo "</td>
                                    <td>";
            // line 79
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($context["Coupon"], "coupon_lower_limit", array())), "html", null, true);
            echo "</td>
                                    <td>";
            // line 80
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getDateFormatFilter($this->getAttribute($context["Coupon"], "available_from_date", array())), "html", null, true);
            echo " ～ ";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getDateFormatFilter($this->getAttribute($context["Coupon"], "available_to_date", array())), "html", null, true);
            echo "</td>

                                    <td><a href=\"";
            // line 82
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("plugin_coupon_edit", array("id" => $this->getAttribute($context["Coupon"], "id", array()))), "html", null, true);
            echo "\">編集</a></td>
                                    <td>
                                        <a href=\"";
            // line 84
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("plugin_coupon_enable", array("id" => $this->getAttribute($context["Coupon"], "id", array()))), "html", null, true);
            echo "\">
                                        ";
            // line 85
            if (($this->getAttribute($context["Coupon"], "enable_flag", array()) == 1)) {
                // line 86
                echo "                                            有効
                                        ";
            } else {
                // line 88
                echo "                                            無効
                                        ";
            }
            // line 90
            echo "                                        </a>
                                    </td>
                                    <td>
                                        <a href=\"";
            // line 93
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("plugin_coupon_delete", array("id" => $this->getAttribute($context["Coupon"], "id", array()))), "html", null, true);
            echo "\" ";
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
            echo " data-method=\"delete\" data-message=\"このクーポンを削除しても宜しいですか？\">削除</a>
                                    </td>
                                </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Coupon'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 97
        echo "                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
<div class=\"row\">
    <div class=\"col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 text-center btn_area\">
        <a href=\"";
        // line 107
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("plugin_coupon_new");
        echo "\" class=\"btn btn-primary btn-block btn-lg\">クーポンを新規登録</a>
    </div>
</div>
</form>
";
    }

    public function getTemplateName()
    {
        return "__string_template__8ba2dc10320a5bdd304e0c3f5bb506d96cb2bdc0b001e9c0bec4c0366cdd4d6a";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  232 => 107,  220 => 97,  208 => 93,  203 => 90,  199 => 88,  195 => 86,  193 => 85,  189 => 84,  184 => 82,  177 => 80,  173 => 79,  167 => 78,  164 => 77,  160 => 75,  154 => 73,  152 => 72,  147 => 71,  145 => 70,  142 => 69,  138 => 67,  134 => 65,  132 => 64,  129 => 63,  125 => 61,  121 => 59,  119 => 58,  116 => 57,  114 => 56,  111 => 55,  109 => 54,  104 => 52,  100 => 51,  96 => 50,  89 => 49,  85 => 48,  59 => 25,  51 => 20,  48 => 19,  45 => 18,  39 => 16,  33 => 15,  29 => 11,  27 => 13,  11 => 11,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__8ba2dc10320a5bdd304e0c3f5bb506d96cb2bdc0b001e9c0bec4c0366cdd4d6a", "");
    }
}
