<?php

/* __string_template__2d013be3a9e1a1c2dcd5dc687e1b6f2ea9a14ad6eb076f912920528b82a0bfcd */
class __TwigTemplate_923375a1880be50c837d8b475c7eefc7988fee31990e82a2bd2cfde794539ed5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__2d013be3a9e1a1c2dcd5dc687e1b6f2ea9a14ad6eb076f912920528b82a0bfcd", 22);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'javascript' => array($this, 'block_javascript'),
            'main' => array($this, 'block_main'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 24
    public function block_title($context, array $blocks = array())
    {
        echo "ホーム";
    }

    // line 26
    public function block_javascript($context, array $blocks = array())
    {
        // line 27
        echo "<script>
\$(function(){
    \$('.order-summary-detail').click(function() {
        \$('#admin_search_order_status').val(\$(this).attr('data-order-status'));
        \$('#order-state').submit();
        return false;
    });
    \$('.shop-stock-detail').click(function() {
        \$('#shop-state-stock').submit();
        return false;
    });
    \$('.shop-member-detail').click(function() {
        \$('#shop-state-member').submit();
        return false;
    });
});
</script>
";
    }

    // line 46
    public function block_main($context, array $blocks = array())
    {
        // line 47
        echo "    ";
        if (($context["is_danger_admin_url"] ?? null)) {
            // line 48
            echo "        <div class=\"row\">
            <div class=\"alert alert-warning alert-dismissable alert-section\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span class=\"alert-close\" aria-hidden=\"true\">×</span></button>
                <svg class=\"cb cb-info-circle\"> <use xlink:href=\"#cb-info-circle\"></use></svg> 管理画面URLは、セキュリティのため推測されにくいものを設定してください。「<a href=\"";
            // line 51
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_setting_system_security");
            echo "\">セキュリティ管理</a>」から設定できます。
            </div>
        </div>
    ";
        }
        // line 55
        echo "        <div class=\"row\">
            <div class=\"col-md-6\">
                <form id=\"order-state\" name=\"form1\" action=\"";
        // line 57
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_order");
        echo "\" method=\"post\">
                ";
        // line 58
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchOrderForm"] ?? null), "_token", array()), 'widget');
        echo "
                <input type=\"hidden\" id=\"admin_search_order_status\" name=\"admin_search_order[multi_status]\" value=\"\">
                <div class=\"box\" id=\"order_info\">
                    <div class=\"box-header\">
                        <h3 class=\"box-title\">受注状況<a href=\"";
        // line 62
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_order");
        echo "\" class=\"icon_wrap\"><svg class=\"cb cb-angle-right\"> <use xlink:href=\"#cb-angle-right\" /></svg></a></h3>
                    </div><!-- /.box-header -->
                    <div class=\"box-body no-padding no-border\">
                        <div class=\"link_list\">
                            <div class=\"tableish\">
                                ";
        // line 67
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["OrderStatuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["OrderStatus"]) {
            // line 68
            echo "                                <a href=\"\" class=\"item_box tr order-summary-detail\" data-order-status=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["OrderStatus"], "id", array()), "html", null, true);
            echo "\">
                                    <div class=\"td\">";
            // line 69
            echo twig_escape_filter($this->env, $this->getAttribute($context["OrderStatus"], "name", array()), "html", null, true);
            echo "</div>
                                    <div class=\"item_number text-right td\">";
            // line 70
            echo twig_escape_filter($this->env, ((( !twig_test_empty(($context["Orders"] ?? null)) && $this->getAttribute(($context["Orders"] ?? null), $this->getAttribute($context["OrderStatus"], "id", array()), array(), "array", true, true))) ? ($this->getAttribute(($context["Orders"] ?? null), $this->getAttribute($context["OrderStatus"], "id", array()), array(), "array")) : (0)), "html", null, true);
            echo "</div>
                                    <div class=\"icon_link td\">
                                        <svg class=\"cb cb-angle-right\"> <use xlink:href=\"#cb-angle-right\" /></svg>
                                    </div>
                                </a><!-- /.item_box -->
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['OrderStatus'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 76
        echo "                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                </form>
            </div><!-- /.col -->

            <div class=\"col-md-6\">
                <div class=\"box\" id=\"cube_news\">
                    <div class=\"box-header\">
                        <h3 class=\"box-title\">お知らせ</h3>
                    </div><!-- /.box-header -->
                    <div class=\"box-body no-padding no-border\">
                        <iframe name=\"information\" class=\"link_list_wrap\" src=\"";
        // line 89
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "eccube_info_url", array()), "html", null, true);
        echo "\"></iframe>
                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>

        <div class=\"row\">
            <div class=\"col-md-8\">
                <div class=\"box\" id=\"sale_info\">
                    <div class=\"box-header\">
                        <h3 class=\"box-title\">売り上げ状況</h3>
                    </div><!-- /.box-header -->
                    <div class=\"box-body no-padding no-border\">
                        <div class=\"sale_box clearfix\">
                            <div class=\"monthly_sale\">
                                <div class=\"item_number\">
                                    ";
        // line 106
        echo twig_escape_filter($this->env, ((twig_test_empty(($context["salesThisMonth"] ?? null))) ? ("¥ 0") : ($this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["salesThisMonth"] ?? null), "order_amount", array())))), "html", null, true);
        echo " / ";
        echo twig_escape_filter($this->env, ((twig_test_empty(($context["salesThisMonth"] ?? null))) ? (0) : (twig_number_format_filter($this->env, $this->getAttribute(($context["salesThisMonth"] ?? null), "order_count", array())))), "html", null, true);
        echo " <span>件</span>
                                    <div class=\"small\">今月の売上高 / 売上件数</div>
                                </div>
                            </div>
                            <div class=\"yesterday_sale\">
                                <div class=\"item_number\">
                                    ";
        // line 112
        echo twig_escape_filter($this->env, ((twig_test_empty(($context["salesYesterday"] ?? null))) ? ("¥ 0") : ($this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["salesYesterday"] ?? null), "order_amount", array())))), "html", null, true);
        echo " / ";
        echo twig_escape_filter($this->env, ((twig_test_empty(($context["salesYesterday"] ?? null))) ? (0) : (twig_number_format_filter($this->env, $this->getAttribute(($context["salesYesterday"] ?? null), "order_count", array())))), "html", null, true);
        echo " <span>件</span>
                                    <div class=\"small\">昨日の売上高 / 売上件数</div>
                                </div>
                            </div>
                            <div class=\"today_sale\">
                                <div class=\"item_number\">
                                    ";
        // line 118
        echo twig_escape_filter($this->env, ((twig_test_empty(($context["salesToday"] ?? null))) ? ("¥ 0") : ($this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["salesToday"] ?? null), "order_amount", array())))), "html", null, true);
        echo " / ";
        echo twig_escape_filter($this->env, ((twig_test_empty(($context["salesToday"] ?? null))) ? (0) : (twig_number_format_filter($this->env, $this->getAttribute(($context["salesToday"] ?? null), "order_count", array())))), "html", null, true);
        echo "  <span>件</span>
                                    <div class=\"small\">今日の売上高 / 売上件数</div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class=\"col-md-4\">
                <div class=\"box\" id=\"shop_info\">
                    <div class=\"box-header\">
                        <h3 class=\"box-title\">ショップ状況</h3>
                    </div><!-- /.box-header -->
                    <div class=\"box-body no-padding no-border\">
                        <form id=\"shop-state-stock\" name=\"form2\" action=\"";
        // line 132
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_homepage_nonstock");
        echo "\" method=\"post\">
                            ";
        // line 133
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchProductForm"] ?? null), "_token", array()), 'widget');
        echo "
                        </form>
                        <form id=\"shop-state-member\" name=\"form3\" action=\"";
        // line 135
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_customer");
        echo "\" method=\"post\">
                            ";
        // line 136
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchCustomerForm"] ?? null), "_token", array()), 'widget');
        echo "
                            <input type=\"hidden\" id=\"admin_search_customer_status_1\" name=\"admin_search_customer[customer_status]\" value=\"2\">
                        </form>
                        <div class=\"link_list\">
                            <div class=\"tableish\">
                                <a href=\"\" class=\"item_box tr shop-stock-detail\">
                                    <div class=\"icon td\"><svg class=\"cb cb-tag-slash\"><use xlink:href=\"#cb-tag-slash\" /></svg></div>
                                    <div class=\"item_number td\">";
        // line 143
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, ($context["countNonStockProducts"] ?? null)), "html", null, true);
        echo "<div class=\"small\">在庫切れ商品</div></div>
                                    <div class=\"icon_link td\">
                                        <svg class=\"cb cb-angle-right\"> <use xlink:href=\"#cb-angle-right\" /></svg>
                                    </div>
                                </a><!-- /.item_box -->
                                <a href=\"\" class=\"item_box tr shop-member-detail\">
                                    <div class=\"icon td\"><svg class=\"cb cb-users\"><use xlink:href=\"#cb-users\" /></svg></div>
                                    <div class=\"item_number text-left td\">";
        // line 150
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, ($context["countCustomers"] ?? null)), "html", null, true);
        echo "<div class=\"small\">会員数</div></div>
                                    <div class=\"icon_link td\">
                                        <svg class=\"cb cb-angle-right\"> <use xlink:href=\"#cb-angle-right\" /></svg>
                                    </div>
                                </a><!-- /.item_box -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__2d013be3a9e1a1c2dcd5dc687e1b6f2ea9a14ad6eb076f912920528b82a0bfcd";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  235 => 150,  225 => 143,  215 => 136,  211 => 135,  206 => 133,  202 => 132,  183 => 118,  172 => 112,  161 => 106,  141 => 89,  126 => 76,  114 => 70,  110 => 69,  105 => 68,  101 => 67,  93 => 62,  86 => 58,  82 => 57,  78 => 55,  71 => 51,  66 => 48,  63 => 47,  60 => 46,  39 => 27,  36 => 26,  30 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__2d013be3a9e1a1c2dcd5dc687e1b6f2ea9a14ad6eb076f912920528b82a0bfcd", "");
    }
}
