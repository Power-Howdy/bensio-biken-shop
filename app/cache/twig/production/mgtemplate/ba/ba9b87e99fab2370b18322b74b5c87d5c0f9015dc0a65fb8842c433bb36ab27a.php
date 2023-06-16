<?php

/* __string_template__db17bc2b6ed8474cd26ab7989723811a7e8cccc23c2c1e8c5fc608bee8982270 */
class __TwigTemplate_9be12c5b76fd03d1e5e396ed259a45bf121abd710b8e5e1ea6cd1ce8872e6aac extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__db17bc2b6ed8474cd26ab7989723811a7e8cccc23c2c1e8c5fc608bee8982270", 22);
        $this->blocks = array(
            'main' => array($this, 'block_main'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 24
        $context["mypageno"] = "index";
        // line 26
        $context["body_class"] = "mypage";
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 28
    public function block_main($context, array $blocks = array())
    {
        // line 29
        echo "    <h1 class=\"page-heading\">マイページ/ご注文履歴</h1>
    <div id=\"history_wrap\" class=\"container-fluid\">

        ";
        // line 32
        $this->loadTemplate("Mypage/navi.twig", "__string_template__db17bc2b6ed8474cd26ab7989723811a7e8cccc23c2c1e8c5fc608bee8982270", 32)->display($context);
        // line 33
        echo "
        <p class=\"txt_center\">
    現在の保有ポイントは「<span class=\"text-primary\">960 pt</span>」です。<br/>
        ※1pt＝<span class=\"text-primary\">¥ 1</span>でご利用いただけます。
</p>

<div id=\"history_list\" class=\"row\">
            <div id=\"history_list__body\" class=\"col-md-12\">

                ";
        // line 42
        if (($this->getAttribute(($context["pagination"] ?? null), "totalItemCount", array()) > 0)) {
            // line 43
            echo "                    <p id=\"history_list__total_count\" class=\"intro\"><strong>";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["pagination"] ?? null), "totalItemCount", array()), "html", null, true);
            echo "件</strong>の履歴があります。</p>

                    ";
            // line 45
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["pagination"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["Order"]) {
                // line 46
                echo "                        <div id=\"history_list__item--";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "\" class=\"historylist_column row\">
                            <div id=\"history_list__item_info--";
                // line 47
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "\" class=\"col-sm-4\">
                                <h3 id=\"history_list__order_date--";
                // line 48
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "\" class=\"order_date\">";
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["Order"], "order_date", array()), "Y/m/d H:i:s"), "html", null, true);
                echo "</h3>
                                <dl id=\"history_list__order_detail--";
                // line 49
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "\" class=\"order_detail\">
                                    <dt id=\"history_list__header_order_id--";
                // line 50
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "\">ご注文番号：</dt>
                                    <dd id=\"history_list__order_id--";
                // line 51
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "</dd>
                                    ";
                // line 52
                if ($this->getAttribute(($context["BaseInfo"] ?? null), "option_mypage_order_status_display", array())) {
                    // line 53
                    echo "                                        <dt id=\"history_list__header_order_status--";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "\">ご注文状況：</dt>
                                        <dd id=\"history_list__order_status--";
                    // line 54
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "CustomerOrderStatus", array()), "html", null, true);
                    echo "</dd>
                                    ";
                }
                // line 56
                echo "                                </dl>
<div style=\"display: flex; flex-direction: row;\">
                                <p id=\"history_list__detail_button--";
                // line 58
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "\"><a class=\"btn btn-default btn-sm\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("mypage_history", array("id" => $this->getAttribute($context["Order"], "id", array()))), "html", null, true);
                echo "\">詳細を見る</a></p>
\t\t\t\t\t\t\t\t";
                // line 59
                if (($this->getAttribute($context["Order"], "CustomerOrderStatus", array()) != "キャンセル")) {
                    // line 60
                    echo "                                <p id=\"history_list__detail_button--";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "\" style=\"margin-left:5px;\"><a class=\"btn btn-default btn-sm\" href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("mypage_export_receipt", array("id" => $this->getAttribute($context["Order"], "id", array()))), "html", null, true);
                    echo "\">領収書ダウンロード</a></p>
\t\t\t\t\t\t\t\t";
                }
                // line 62
                echo "</div>
                            </div>
                            <div id=\"history_detail_list--";
                // line 64
                echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                echo "\" class=\"col-sm-8\">
                                ";
                // line 65
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["Order"], "OrderDetails", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["OrderDetail"]) {
                    // line 66
                    echo "                                    <div id=\"history_detail_list__body--";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"item_box table\">
                                        <div id=\"history_detail_list__body_inner--";
                    // line 67
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"tbody\">
                                            <div id=\"history_detail_list__item--";
                    // line 68
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"tr\">
                                                <div id=\"history_detail_list__image--";
                    // line 69
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"item_photo td\">
                                                    ";
                    // line 70
                    if ((null === $this->getAttribute($context["OrderDetail"], "Product", array()))) {
                        // line 71
                        echo "                                                        <img src=\"";
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
                        echo "/";
                        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getNoImageProduct(""), "html", null, true);
                        echo "\" />
                                                    ";
                    } else {
                        // line 73
                        echo "                                                        ";
                        if ($this->getAttribute($context["OrderDetail"], "enable", array())) {
                            // line 74
                            echo "                                                            <img src=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
                            echo "/";
                            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getNoImageProduct($this->getAttribute($this->getAttribute($context["OrderDetail"], "product", array()), "MainListImage", array())), "html", null, true);
                            echo "\">
                                                        ";
                        } else {
                            // line 76
                            echo "                                                            <img src=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
                            echo "/";
                            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getNoImageProduct(""), "html", null, true);
                            echo "\" />
                                                        ";
                        }
                        // line 78
                        echo "                                                    ";
                    }
                    // line 79
                    echo "                                                </div>
                                                <dl id=\"history_detail_list__item_info--";
                    // line 80
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"item_detail td\">
                                                    <dt id=\"history_detail_list__product_name--";
                    // line 81
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"item_name\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "product_name", array()), "html", null, true);
                    echo "</dt>
                                                    <dd id=\"history_detail_list__category_name--";
                    // line 82
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"item_pattern small\">
                                                        ";
                    // line 83
                    if ( !twig_test_empty($this->getAttribute($context["OrderDetail"], "class_category_name1", array()))) {
                        // line 84
                        echo "                                                            ";
                        echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "class_category_name1", array()), "html", null, true);
                        echo "
                                                        ";
                    }
                    // line 86
                    echo "                                                        ";
                    if ( !twig_test_empty($this->getAttribute($context["OrderDetail"], "class_category_name1", array()))) {
                        // line 87
                        echo "                                                            / ";
                        echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "class_category_name2", array()), "html", null, true);
                        echo "
                                                        ";
                    }
                    // line 89
                    echo "                                                    </dd>
                                                    <dd id=\"history_detail_list__price--";
                    // line 90
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"item_price\">";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($context["OrderDetail"], "price_inc_tax", array())), "html", null, true);
                    echo " ×";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "quantity", array()), "html", null, true);
                    echo "</dd>
                                                </dl>
\t\t\t\t\t\t\t\t\t\t\t\t<div style=\"text-align:right;\" id=\"history_detail_list_video--";
                    // line 92
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Order"], "id", array()), "html", null, true);
                    echo "_";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "id", array()), "html", null, true);
                    echo "\" class=\"item_video td\">
                                                    ";
                    // line 93
                    if ( !(null === $this->getAttribute($context["OrderDetail"], "Product", array()))) {
                        // line 94
                        echo "\t\t\t\t\t\t\t\t\t\t\t\t\t\t";
                        if ($this->getAttribute($this->getAttribute($context["OrderDetail"], "Product", array()), "hasVideo", array())) {
                            // line 95
                            echo "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t";
                            if (($this->getAttribute($context["Order"], "CustomerOrderStatus", array()) == "入金済み")) {
                                // line 96
                                echo "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<a class=\"btn btn-danger\" href=\"";
                                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("mypage_video", array("id" => $this->getAttribute($context["Order"], "id", array()))), "html", null, true);
                                echo "?item=";
                                echo twig_escape_filter($this->env, $this->getAttribute($context["OrderDetail"], "productid", array()), "html", null, true);
                                echo "\">教材を見る</a>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t";
                            } elseif (($this->getAttribute(                            // line 97
$context["Order"], "CustomerOrderStatus", array()) != "入金済み")) {
                                // line 98
                                echo "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tご入金後に動画の視聴が可能になります。
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t";
                            }
                            // line 100
                            echo "\t\t\t\t\t\t\t\t\t\t\t\t\t\t";
                        }
                        // line 101
                        echo "\t\t\t\t\t\t\t\t\t\t\t\t\t";
                    }
                    // line 102
                    echo "\t\t\t\t\t\t\t\t\t\t\t\t</div>
                                            </div>
                                        </div>
                                    </div><!--/item_box-->
                                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['OrderDetail'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 107
                echo "                            </div>
                        </div><!--/historylist_column-->
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Order'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 110
            echo "
                    ";
            // line 111
            $this->loadTemplate("pagination.twig", "__string_template__db17bc2b6ed8474cd26ab7989723811a7e8cccc23c2c1e8c5fc608bee8982270", 111)->display(array_merge($context, array("pages" => $this->getAttribute(($context["pagination"] ?? null), "paginationData", array()))));
            // line 112
            echo "
                ";
        } else {
            // line 114
            echo "                    <p id=\"history_list__not_result_message\" class=\"intro\">ご注文履歴がありません。</p>
                ";
        }
        // line 116
        echo "
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__db17bc2b6ed8474cd26ab7989723811a7e8cccc23c2c1e8c5fc608bee8982270";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  316 => 116,  312 => 114,  308 => 112,  306 => 111,  303 => 110,  295 => 107,  285 => 102,  282 => 101,  279 => 100,  275 => 98,  273 => 97,  266 => 96,  263 => 95,  260 => 94,  258 => 93,  252 => 92,  241 => 90,  238 => 89,  232 => 87,  229 => 86,  223 => 84,  221 => 83,  215 => 82,  207 => 81,  201 => 80,  198 => 79,  195 => 78,  187 => 76,  179 => 74,  176 => 73,  168 => 71,  166 => 70,  160 => 69,  154 => 68,  148 => 67,  141 => 66,  137 => 65,  133 => 64,  129 => 62,  121 => 60,  119 => 59,  113 => 58,  109 => 56,  102 => 54,  97 => 53,  95 => 52,  89 => 51,  85 => 50,  81 => 49,  75 => 48,  71 => 47,  66 => 46,  62 => 45,  56 => 43,  54 => 42,  43 => 33,  41 => 32,  36 => 29,  33 => 28,  29 => 22,  27 => 26,  25 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__db17bc2b6ed8474cd26ab7989723811a7e8cccc23c2c1e8c5fc608bee8982270", "");
    }
}
