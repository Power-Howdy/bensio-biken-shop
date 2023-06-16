<?php

/* __string_template__53a9b4f1d858fc891105acedf69a7f3b59e943c238ae16c5cfc83567ef539b6a */
class __TwigTemplate_41e96700a8b59d28c9539146a276b6a1916cf60f27a7bf83965c6c8e2941b9a3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__53a9b4f1d858fc891105acedf69a7f3b59e943c238ae16c5cfc83567ef539b6a", 22);
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
        $context["body_class"] = "cart_page";
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    public function block_main($context, array $blocks = array())
    {
        // line 27
        echo "    <h1 class=\"page-heading\">ショッピングカート</h1>
    <div id=\"cart\" class=\"container-fluid\">
        <div id=\"cart_box\" class=\"row\">
            <div id=\"cart_box__body\" class=\"col-md-10 col-md-offset-1\">
                ";
        // line 31
        if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\SecurityExtension')->isGranted("ROLE_USER")) {
            // line 32
            echo "                <div id=\"cart_box__flow_state\" class=\"flowline step3\">
                ";
        } else {
            // line 34
            echo "                <div id=\"cart_box__flow_state\" class=\"flowline step4\">
                ";
        }
        // line 36
        echo "                    <ul id=\"cart_box__flow_state_list\" class=\"clearfix\">
                        <li class=\"active\"><span class=\"flow_number\">1</span><br>カートの商品</li>
                    ";
        // line 38
        if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\SecurityExtension')->isGranted("ROLE_USER")) {
            // line 39
            echo "                        <li><span class=\"flow_number\">2</span><br>ご注文内容確認</li>
                        <li><span class=\"flow_number\">3</span><br>完了</li>
                    ";
        } else {
            // line 42
            echo "                        <li><span class=\"flow_number\">2</span><br>お客様情報</li>
                        <li><span class=\"flow_number\">3</span><br>ご注文内容確認</li>
                        <li><span class=\"flow_number\">4</span><br>完了</li>
                    ";
        }
        // line 46
        echo "                    </ul>
                </div>

                ";
        // line 49
        $context["productStr"] = $this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashbag", array()), "get", array(0 => "eccube.front.request.product"), "method");
        // line 50
        echo "                ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashbag", array()), "get", array(0 => "eccube.front.request.error"), "method"));
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
        foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
            // line 51
            echo "                    ";
            $context["idx"] = $this->getAttribute($context["loop"], "index0", array());
            // line 52
            echo "                    ";
            if ($this->getAttribute(($context["productStr"] ?? null), ($context["idx"] ?? null), array(), "array", true, true)) {
                // line 53
                echo "                    <div id=\"cart_box__message--";
                echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                echo "\" class=\"message\">
                        <p class=\"errormsg bg-danger\">
                            <svg class=\"cb cb-warning\"><use xlink:href=\"#cb-warning\" /></svg>
                            ";
                // line 56
                echo nl2br(twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["error"], array("%product%" => $this->getAttribute(($context["productStr"] ?? null), ($context["idx"] ?? null), array(), "array"))), "html", null, true));
                echo "
                        </p>
                    </div>
                    ";
            } else {
                // line 60
                echo "                    <div id=\"cart_box__message--";
                echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                echo "\" class=\"message\">
                        <p class=\"errormsg bg-danger\">
                            <svg class=\"cb cb-warning\"><use xlink:href=\"#cb-warning\" /></svg>";
                // line 62
                echo nl2br(twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["error"]), "html", null, true));
                echo "
                        </p>
                    </div>
                    ";
            }
            // line 66
            echo "                ";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 67
        echo "                ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashbag", array()), "get", array(0 => "eccube.front.cart.error"), "method"));
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
        foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
            // line 68
            echo "                    <div id=\"cart_box__message_error--";
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"message\">
                        <p class=\"errormsg bg-danger\">
                            <svg class=\"cb cb-warning\"><use xlink:href=\"#cb-warning\" /></svg>";
            // line 70
            echo nl2br(twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["error"]), "html", null, true));
            echo "
                        </p>
                    </div>
                ";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 74
        echo "
                ";
        // line 75
        if ((twig_length_filter($this->env, $this->getAttribute(($context["Cart"] ?? null), "CartItems", array())) > 0)) {
            // line 76
            echo "                <form name=\"form\" id=\"form_cart\" method=\"post\" action=\"";
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("cart");
            echo "\">
                    <p id=\"cart_item__info\" class=\"message\">
                        商品の合計金額は「<strong>";
            // line 78
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Cart"] ?? null), "total_price", array())), "html", null, true);
            echo "</strong>」です。
                        ";
            // line 79
            if (($this->getAttribute(($context["BaseInfo"] ?? null), "delivery_free_amount", array()) && $this->getAttribute(($context["BaseInfo"] ?? null), "delivery_free_quantity", array()))) {
                // line 80
                echo "                            <br />
                            ";
                // line 81
                if (($context["is_delivery_free"] ?? null)) {
                    // line 82
                    echo "                                現在送料無料です。
                            ";
                } else {
                    // line 84
                    echo "                                あと「<strong>";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter(($context["least"] ?? null)), "html", null, true);
                    echo "</strong>」または「<strong>";
                    echo twig_escape_filter($this->env, twig_number_format_filter($this->env, ($context["quantity"] ?? null)), "html", null, true);
                    echo "個</strong>」のお買い上げで<strong class=\"text-primary\">送料無料</strong>になります。
                            ";
                }
                // line 86
                echo "                        ";
            } elseif ($this->getAttribute(($context["BaseInfo"] ?? null), "delivery_free_amount", array())) {
                // line 87
                echo "                            <br />
                            ";
                // line 88
                if (($context["is_delivery_free"] ?? null)) {
                    // line 89
                    echo "                                現在送料無料です。
                            ";
                } else {
                    // line 91
                    echo "                                あと「<strong>";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter(($context["least"] ?? null)), "html", null, true);
                    echo "</strong>」のお買い上げで<strong class=\"text-primary\">送料無料</strong>になります。
                            ";
                }
                // line 93
                echo "                        ";
            } elseif ($this->getAttribute(($context["BaseInfo"] ?? null), "delivery_free_quantity", array())) {
                // line 94
                echo "                            <br />
                            ";
                // line 95
                if (($context["is_delivery_free"] ?? null)) {
                    // line 96
                    echo "                                現在送料無料です。
                            ";
                } else {
                    // line 98
                    echo "                                あと「<strong>";
                    echo twig_escape_filter($this->env, twig_number_format_filter($this->env, ($context["quantity"] ?? null)), "html", null, true);
                    echo "個</strong>」のお買い上げで<strong class=\"text-primary\">送料無料</strong>になります。
                            ";
                }
                // line 100
                echo "                        ";
            }
            // line 101
            echo "                    </p>
                    <p id=\"cart_item__point_info\" class=\"message\">
    ポイント制度をご利用になられる場合は、会員登録後ログインしてくださいますようお願い致します。<br/>
    ポイントは商品購入時に1pt＝<strong class=\"text-primary\">¥ 1</strong>として利用することができます。
</p>

<div id=\"cart_item_list\" class=\"cart_item table\">
                        <div class=\"thead\">
                            <ol id=\"cart_item_list__header\">
                                <li id=\"cart_item_list__header_cart_remove\">削除</li>
                                <li id=\"cart_item_list__header_product_detail\">商品内容</li>
                                <li id=\"cart_item_list__header_total\">数量</li>
                                <li id=\"cart_item_list__header_sub_total\">小計</li>
                            </ol>
                        </div>
                        <div id=\"cart_item_list__body\" class=\"tbody\">

                            ";
            // line 118
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["Cart"] ?? null), "CartItems", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["CartItem"]) {
                // line 119
                echo "                                ";
                $context["ProductClass"] = $this->getAttribute($context["CartItem"], "Object", array());
                // line 120
                echo "                                ";
                $context["Product"] = $this->getAttribute(($context["ProductClass"] ?? null), "Product", array());
                // line 121
                echo "
                                <div id=\"cart_item_list__item\" class=\"item_box tr\">
                                    <div id=\"cart_item_list__cart_remove\" class=\"icon_edit td\">
                                        <a href=\"";
                // line 124
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("cart_remove", array("productClassId" => $this->getAttribute(($context["ProductClass"] ?? null), "id", array()))), "html", null, true);
                echo "\" ";
                echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
                echo " data-method=\"put\" data-message=\"カートから商品を削除してもよろしいですか?\">
                                            <svg class=\"cb cb-close\"><use xlink:href=\"#cb-close\" /></svg>
                                        </a>
                                    </div>
                                    <div class=\"td table\">
                                        <div id=\"cart_item_list__product_image\" class=\"item_photo\">
                                            <a  target=\"_blank\" href=\"";
                // line 130
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("product_detail", array("id" => $this->getAttribute(($context["Product"] ?? null), "id", array()))), "html", null, true);
                echo "\">
                                                <img src=\"";
                // line 131
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getNoImageProduct($this->getAttribute(($context["Product"] ?? null), "MainListImage", array())), "html", null, true);
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["Product"] ?? null), "name", array()), "html", null, true);
                echo "\" />
                                            </a>
                                        </div>
                                        <dl class=\"item_detail\">
                                            <dt id=\"cart_item_list__product_detail\" class=\"item_name text-default\">
                                                <a target=\"_blank\" href=\"";
                // line 136
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("product_detail", array("id" => $this->getAttribute(($context["Product"] ?? null), "id", array()))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["Product"] ?? null), "name", array()), "html", null, true);
                echo "</a>
                                            </dt>
                                            <dd id=\"cart_item_list__class_category\" class=\"item_pattern small\">
                                                ";
                // line 139
                if (($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory1", array()) && $this->getAttribute($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory1", array()), "id", array()))) {
                    // line 140
                    echo "                                                    ";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory1", array()), "ClassName", array()), "html", null, true);
                    echo "：";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory1", array()), "html", null, true);
                    echo "
                                                ";
                }
                // line 142
                echo "                                                ";
                if (($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory2", array()) && $this->getAttribute($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory2", array()), "id", array()))) {
                    // line 143
                    echo "                                                    <br>";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory2", array()), "ClassName", array()), "html", null, true);
                    echo "：";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["ProductClass"] ?? null), "ClassCategory2", array()), "html", null, true);
                    echo "
                                                ";
                }
                // line 145
                echo "                                            </dd>
                                            <dd id=\"cart_item_list__item_price\" class=\"item_price\">￥";
                // line 146
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["CartItem"], "price", array())), "html", null, true);
                echo "</dd>
                                            <dd id=\"cart_item_list__item_subtotal\" class=\"item_subtotal\">小計：￥";
                // line 147
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["CartItem"], "total_price", array())), "html", null, true);
                echo "</dd>
                                        </dl>
                                    </div>
                                    <div id=\"cart_item_list__quantity\" class=\"item_quantity td\">
                                        ";
                // line 151
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["CartItem"], "quantity", array())), "html", null, true);
                echo "
                                        <ul id=\"cart_item_list__quantity_edit\">
                                            <li>
                                                ";
                // line 154
                if (($this->getAttribute($context["CartItem"], "quantity", array()) > 1)) {
                    // line 155
                    echo "                                                    <a id=\"cart_item_list__down\" href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("cart_down", array("productClassId" => $this->getAttribute(($context["ProductClass"] ?? null), "id", array()))), "html", null, true);
                    echo "\" ";
                    echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
                    echo " data-method=\"put\" data-confirm=\"false\"><svg class=\"cb cb-minus\"><use xlink:href=\"#cb-minus\" /></svg></a>
                                                ";
                } else {
                    // line 157
                    echo "                                                    <span><svg class=\"cb cb-minus\"><use xlink:href=\"#cb-minus\" /></svg></span>
                                                ";
                }
                // line 159
                echo "                                            </li>
                                            <li>
                                                <a id=\"cart_item_list__up\" href=\"";
                // line 161
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("cart_up", array("productClassId" => $this->getAttribute(($context["ProductClass"] ?? null), "id", array()))), "html", null, true);
                echo "\" ";
                echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
                echo " data-method=\"put\" data-confirm=\"false\"><svg class=\"cb cb-plus\"><use xlink:href=\"#cb-plus\" /></svg></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id=\"cart_item_list__subtotal\" class=\"item_subtotal td\">￥";
                // line 165
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["CartItem"], "total_price", array())), "html", null, true);
                echo "</div>
                                </div><!--/item_box-->
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['CartItem'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 168
            echo "
                        </div>
                    </div><!--/cart_item-->
                    <div class=\"total_box\">
                        <dl id=\"total_box__total_price\" class=\"total_price\">
                            <dt>合計：</dt>
                            <dd class=\"text-primary\">￥";
            // line 174
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute(($context["Cart"] ?? null), "total_price", array())), "html", null, true);
            echo "</dd>
                        </dl>
                        <div id=\"total_box__user_action_menu\" class=\"btn_group\">

                            <p id=\"total_box__next_button\" >
                                <a href=\"";
            // line 179
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath("cart_buystep");
            echo "\" class=\"btn btn-primary btn-block\">レジに進む</a>
                            </p>
                            <p id=\"total_box__top_button\">
                                <a  href=\"";
            // line 182
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("top");
            echo "\" class=\"btn btn-info btn-block\">お買い物を続ける</a>
                            </p>
                        </div>
                    </div>

                </form>
                ";
        } else {
            // line 189
            echo "                <div id=\"cart_box__message\" class=\"message\">
                    <p class=\"errormsg bg-danger\">
                        <svg class=\"cb cb-warning\"><use xlink:href=\"#cb-warning\" /></svg>現在カート内に商品はございません。
                    </p>
                </div>
                ";
        }
        // line 195
        echo "
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__53a9b4f1d858fc891105acedf69a7f3b59e943c238ae16c5cfc83567ef539b6a";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  440 => 195,  432 => 189,  422 => 182,  416 => 179,  408 => 174,  400 => 168,  391 => 165,  382 => 161,  378 => 159,  374 => 157,  366 => 155,  364 => 154,  358 => 151,  351 => 147,  347 => 146,  344 => 145,  336 => 143,  333 => 142,  325 => 140,  323 => 139,  315 => 136,  303 => 131,  299 => 130,  288 => 124,  283 => 121,  280 => 120,  277 => 119,  273 => 118,  254 => 101,  251 => 100,  245 => 98,  241 => 96,  239 => 95,  236 => 94,  233 => 93,  227 => 91,  223 => 89,  221 => 88,  218 => 87,  215 => 86,  207 => 84,  203 => 82,  201 => 81,  198 => 80,  196 => 79,  192 => 78,  186 => 76,  184 => 75,  181 => 74,  163 => 70,  157 => 68,  139 => 67,  125 => 66,  118 => 62,  112 => 60,  105 => 56,  98 => 53,  95 => 52,  92 => 51,  74 => 50,  72 => 49,  67 => 46,  61 => 42,  56 => 39,  54 => 38,  50 => 36,  46 => 34,  42 => 32,  40 => 31,  34 => 27,  31 => 26,  27 => 22,  25 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__53a9b4f1d858fc891105acedf69a7f3b59e943c238ae16c5cfc83567ef539b6a", "");
    }
}
