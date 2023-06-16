<?php

/* __string_template__598d416b114dfdd194c6eb24c828a4f3a23191a9608e47525451dfb88774705c */
class __TwigTemplate_2abce5b47bdfe15eb0dbc2478ed96c48f9a429507e188fa7a54f3e259ec01d58 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__598d416b114dfdd194c6eb24c828a4f3a23191a9608e47525451dfb88774705c", 22);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'sub_title' => array($this, 'block_sub_title'),
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
        // line 24
        $context["menus"] = array(0 => "setting", 1 => "shop", 2 => "shop_delivery");
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    public function block_title($context, array $blocks = array())
    {
        echo "ショップ設定";
    }

    // line 27
    public function block_sub_title($context, array $blocks = array())
    {
        echo "配送方法管理";
    }

    // line 29
    public function block_javascript($context, array $blocks = array())
    {
        // line 30
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/jquery.ui/jquery.ui.core.min.js\"></script>
    <script src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/jquery.ui/jquery.ui.widget.min.js\"></script>
    <script src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/jquery.ui/jquery.ui.mouse.min.js\"></script>
    <script src=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/jquery.ui/jquery.ui.sortable.min.js\"></script>
    <script>
        \$(function() {
            var oldRanks = [];
            // 画面の中のrank一覧を保持
            \$(\"div.tableish > .item_box\").each(function() {
                oldRanks.push(this.dataset.rank);
            });
            // rsort
            oldRanks.sort(function(a,b){return a - b;}).reverse();

            \$(\"div.tableish\").sortable({
                items: '> .item_box',
                cursor: 'move',
                update: function(e, ui) {
                    \$(\"body\").append(\$('<div class=\"modal-backdrop in\"></div>'));
                    updateRank();
                }
            });

            var updateRank = function() {
                // 並び替え後にrankを更新
                var newRanks = {};
                var i = 0;
                \$(\"div.tableish > .item_box\").each(function() {
                    newRanks[this.dataset.deliveryId] = oldRanks[i];
                    i++;
                });

                \$.ajax({
                    url: '";
        // line 63
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_setting_shop_delivery_rank_move");
        echo "',
                    type: 'POST',
                    data: newRanks
                }).done(function() {
                    \$(\".modal-backdrop\").remove();
                }).fail(function() {
                    \$(\".modal-backdrop\").remove();
                });
            };
        });
    </script>
";
    }

    // line 76
    public function block_main($context, array $blocks = array())
    {
        // line 77
        echo "    <form name=\"form1\" method=\"post\">
    <div id=\"delivery_wrap\" class=\"row\">
        <div id=\"delivery_list_box\" class=\"col-md-12\">
            <div id=\"delivery_list__body\" class=\"box\">
                <div id=\"delivery_list__header\" class=\"box-header\">
                    <h3 class=\"box-title\">配送方法一覧</h3>
                </div>
                ";
        // line 84
        if ((twig_length_filter($this->env, ($context["Deliveries"] ?? null)) > 0)) {
            // line 85
            echo "                    <div id=\"delivery_list__body_inner\" class=\"box-body no-padding no-border\">
                        <div id=\"delivery_list__sortable_area\" class=\"sortable_list\">
                            <div class=\"tableish\">

                                ";
            // line 89
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["Deliveries"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["Delivery"]) {
                // line 90
                echo "
                                    <div id=\"delivery_list__item--";
                // line 91
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "id", array()), "html", null, true);
                echo "\" class=\"item_box tr\" data-delivery-id=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "id", array()), "html", null, true);
                echo "\" data-rank=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "rank", array()), "html", null, true);
                echo "\">
                                        <div class=\"icon_sortable td\">
                                            <svg class=\"cb cb-ellipsis-v\"> <use xlink:href=\"#cb-ellipsis-v\" /></svg>
                                        </div>
                                        <div id=\"delivery_list__name--";
                // line 95
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "id", array()), "html", null, true);
                echo "\" class=\"item_pattern td\">
                                            <a href=\"";
                // line 96
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_setting_shop_delivery_edit", array("id" => $this->getAttribute($context["Delivery"], "id", array()))), "html", null, true);
                echo "\">
                                                ";
                // line 97
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "name", array()), "html", null, true);
                echo " / ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "service_name", array()), "html", null, true);
                echo "
                                            </a>
                                        </div>
                                        <div id=\"delivery_list__menu_box--";
                // line 100
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "id", array()), "html", null, true);
                echo "\" class=\"icon_edit td\">
                                            <div id=\"delivery_list__menu_toggle--";
                // line 101
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "id", array()), "html", null, true);
                echo "\" class=\"dropdown\">
                                                <a class=\"dropdown-toggle\" data-toggle=\"dropdown\"><svg class=\"cb cb-ellipsis-h\"> <use xlink:href=\"#cb-ellipsis-h\" /></svg></a>
                                                <ul id=\"delivery_list__menu--";
                // line 103
                echo twig_escape_filter($this->env, $this->getAttribute($context["Delivery"], "id", array()), "html", null, true);
                echo "\" class=\"dropdown-menu dropdown-menu-right\">
                                                    <li><a href=\"";
                // line 104
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_setting_shop_delivery_edit", array("id" => $this->getAttribute($context["Delivery"], "id", array()))), "html", null, true);
                echo "\">編集</a></li>
                                                    <li><a href=\"";
                // line 105
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_setting_shop_delivery_delete", array("id" => $this->getAttribute($context["Delivery"], "Id", array()))), "html", null, true);
                echo "\" ";
                echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
                echo " data-method=\"delete\">削除</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- /.item_box -->
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Delivery'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 111
            echo "
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                ";
        } else {
            // line 116
            echo "                    <div id=\"delivery_list__body_inner\" class=\"box-body no-padding\">
                        <div class=\"data-empty\"><svg class=\"cb cb-inbox\"> <use xlink:href=\"#cb-inbox\" /></svg><p>データはありません</p></div>
                    </div><!-- /.box-body -->
                ";
        }
        // line 120
        echo "                <!-- ▲ データがある時 ▲ -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
    </form>

    <div id=\"delivery_list_footer\" class=\"row\">
        <div id=\"delivery_list_footer__button_area\" class=\"col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 text-center btn_area\">
            <a href=\"";
        // line 128
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_setting_shop_delivery_new");
        echo "\" class=\"btn btn-primary btn-block btn-lg\">配送方法";
        if ($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "input_deliv_fee", array())) {
            echo "・配送料";
        }
        echo "を新規入力</a>
        </div>
    </div>

";
    }

    public function getTemplateName()
    {
        return "__string_template__598d416b114dfdd194c6eb24c828a4f3a23191a9608e47525451dfb88774705c";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  219 => 128,  209 => 120,  203 => 116,  196 => 111,  182 => 105,  178 => 104,  174 => 103,  169 => 101,  165 => 100,  157 => 97,  153 => 96,  149 => 95,  138 => 91,  135 => 90,  131 => 89,  125 => 85,  123 => 84,  114 => 77,  111 => 76,  95 => 63,  62 => 33,  58 => 32,  54 => 31,  49 => 30,  46 => 29,  40 => 27,  34 => 26,  30 => 22,  28 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__598d416b114dfdd194c6eb24c828a4f3a23191a9608e47525451dfb88774705c", "");
    }
}
