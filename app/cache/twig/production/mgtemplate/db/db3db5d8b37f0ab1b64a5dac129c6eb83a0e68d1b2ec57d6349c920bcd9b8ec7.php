<?php

/* __string_template__3e81e3e1f19122830e121d0a3aa77b95bd59bbf84f9956f0deefe3e9df04d2d3 */
class __TwigTemplate_74eb459c72bbcf8f182235955064c3e2263c6f2536ff9515d2b71572d01988d6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__3e81e3e1f19122830e121d0a3aa77b95bd59bbf84f9956f0deefe3e9df04d2d3", 22);
        $this->blocks = array(
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
        $context["body_class"] = "product_page";
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    public function block_javascript($context, array $blocks = array())
    {
        // line 27
        echo "    <script>
        // 並び順を変更
        function fnChangeOrderBy(orderby) {
            eccube.setValue('orderby', orderby);
            eccube.setValue('pageno', 1);
            eccube.submitForm();
        }

        // 表示件数を変更
        function fnChangeDispNumber(dispNumber) {
            eccube.setValue('disp_number', dispNumber);
            eccube.setValue('pageno', 1);
            eccube.submitForm();
        }
        // 商品表示BOXの高さを揃える
        \$(window).load(function() {
            \$('.product_item').matchHeight();
        });
    </script>
";
    }

    // line 48
    public function block_main($context, array $blocks = array())
    {
        // line 49
        echo "    ";
        if ((twig_length_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["search_form"] ?? null), "category_id", array()), "vars", array()), "errors", array())) == 0)) {
            // line 50
            echo "    <form name=\"form1\" id=\"form1\" method=\"get\" action=\"?\">
        ";
            // line 51
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["search_form"] ?? null), 'widget');
            echo "
    </form>
    <!-- ▼topicpath▼ -->
    <div id=\"topicpath\" class=\"row\">
        <ol id=\"list_header_menu\">
            <li><a href=\"";
            // line 56
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("product_list");
            echo "\">全商品</a></li>
            ";
            // line 57
            if ( !(null === ($context["Category"] ?? null))) {
                // line 58
                echo "                ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["Category"] ?? null), "path", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["Path"]) {
                    // line 59
                    echo "                    <li><a href=\"";
                    echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("product_list");
                    echo "?category_id=";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Path"], "id", array()), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Path"], "name", array()), "html", null, true);
                    echo "</a></li>
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Path'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 61
                echo "            ";
            }
            // line 62
            echo "            ";
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["search_form"] ?? null), "vars", array()), "value", array()), "name", array())) {
                // line 63
                echo "            <li>「";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["search_form"] ?? null), "vars", array()), "value", array()), "name", array()), "html", null, true);
                echo "」の検索結果</li>
            ";
            }
            // line 65
            echo "        </ol>
    </div>
    <!-- ▲topicpath▲ -->
    <div id=\"result_info_box\" class=\"row\">
        <form name=\"page_navi_top\" id=\"page_navi_top\" action=\"?\">
            ";
            // line 70
            if (($this->getAttribute(($context["pagination"] ?? null), "totalItemCount", array()) > 0)) {
                // line 71
                echo "                <p id=\"result_info_box__item_count\" class=\"intro col-sm-6\"><strong><span id=\"productscount\">";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["pagination"] ?? null), "totalItemCount", array()), "html", null, true);
                echo "</span>件</strong>の商品がみつかりました。
                </p>

                <div id=\"result_info_box__menu_box\" class=\"col-sm-6 no-padding\">
                    <ul id=\"result_info_box__menu\" class=\"pagenumberarea clearfix\">
                        <li id=\"result_info_box__disp_menu\">
                            ";
                // line 77
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["disp_number_form"] ?? null), 'widget', array("id" => "", "attr" => array("onchange" => "javascript:fnChangeDispNumber(this.value);")));
                echo "
                        </li>
                        <li id=\"result_info_box__order_menu\">
                            ";
                // line 80
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["order_by_form"] ?? null), 'widget', array("id" => "", "attr" => array("onchange" => "javascript:fnChangeOrderBy(this.value);")));
                echo "
                        </li>
                    </ul>
                </div>

                ";
                // line 85
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["disp_number_form"] ?? null), "getIterator", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                    // line 86
                    echo "                    ";
                    if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                        // line 87
                        echo "                        ";
                        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'label');
                        echo "
                        ";
                        // line 88
                        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'widget');
                        echo "
                        ";
                        // line 89
                        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'errors');
                        echo "
                    ";
                    }
                    // line 91
                    echo "                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 92
                echo "
                ";
                // line 93
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["order_by_form"] ?? null), "getIterator", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                    // line 94
                    echo "                    ";
                    if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                        // line 95
                        echo "                        ";
                        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'label');
                        echo "
                        ";
                        // line 96
                        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'widget');
                        echo "
                        ";
                        // line 97
                        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'errors');
                        echo "
                    ";
                    }
                    // line 99
                    echo "                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 100
                echo "            ";
            } else {
                // line 101
                echo "                <p id=\"result_info_box__item_count\" class=\"intro col-sm-6\"><strong style=\"display: none;\"><span id=\"productscount\">";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["pagination"] ?? null), "totalItemCount", array()), "html", null, true);
                echo "</span>件</strong>お探しの商品は見つかりませんでした。</p>
            ";
            }
            // line 103
            echo "        </form>
    </div>

    <!-- ▼item_list▼ -->
    <div id=\"item_list\">
        <div class=\"row no-padding\">
            ";
            // line 109
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["pagination"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["Product"]) {
                // line 110
                echo "                <div id=\"result_list_box--";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                echo "\" class=\"col-sm-3 col-xs-6\">
                    <div id=\"result_list__item--";
                // line 111
                echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                echo "\" class=\"product_item\">
                        <a href=\"";
                // line 112
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("product_detail", array("id" => $this->getAttribute($context["Product"], "id", array()))), "html", null, true);
                echo "\">
                            <div id=\"result_list__image--";
                // line 113
                echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                echo "\" class=\"item_photo\">
                                <img src=\"";
                // line 114
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
                echo "/";
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getNoImageProduct($this->getAttribute($context["Product"], "main_list_image", array())), "html", null, true);
                echo "\">
                            </div>
                            <dl id=\"result_list__detail--";
                // line 116
                echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                echo "\">
                                <dt id=\"result_list__name--";
                // line 117
                echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                echo "\" class=\"item_name\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "name", array()), "html", null, true);
                echo "</dt>
                                ";
                // line 118
                if ($this->getAttribute($context["Product"], "description_list", array())) {
                    // line 119
                    echo "                                    <dd id=\"result_list__description_list--";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                    echo "\" class=\"item_comment\">";
                    echo nl2br($this->getAttribute($context["Product"], "description_list", array()));
                    echo "</dd>
                                ";
                }
                // line 121
                echo "                                ";
                if ($this->getAttribute($context["Product"], "hasProductClass", array())) {
                    // line 122
                    echo "                                    ";
                    if (($this->getAttribute($context["Product"], "getPrice02Min", array()) == $this->getAttribute($context["Product"], "getPrice02Max", array()))) {
                        // line 123
                        echo "                                    <dd id=\"result_list__price02_inc_tax--";
                        echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                        echo "\" class=\"item_price\">
                                        ";
                        // line 124
                        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($context["Product"], "getPrice02IncTaxMin", array())), "html", null, true);
                        echo "
                                    </dd>
                                    ";
                    } else {
                        // line 127
                        echo "                                    <dd id=\"result_list__price02_inc_tax--";
                        echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                        echo "\" class=\"item_price\">
                                        ";
                        // line 128
                        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($context["Product"], "getPrice02IncTaxMin", array())), "html", null, true);
                        echo " ～ ";
                        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($context["Product"], "getPrice02IncTaxMax", array())), "html", null, true);
                        echo "
                                    </dd>
                                    ";
                    }
                    // line 131
                    echo "                                ";
                } else {
                    // line 132
                    echo "                                    <dd id=\"result_list__price02_inc_tax--";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Product"], "id", array()), "html", null, true);
                    echo "\" class=\"item_price\">";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($context["Product"], "getPrice02IncTaxMin", array())), "html", null, true);
                    echo "</dd>
                                ";
                }
                // line 134
                echo "                            </dl>
                        </a>
                    </div>
                </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Product'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 139
            echo "        </div>

    </div>
    <!-- ▲item_list▲ -->
    ";
            // line 143
            if (($this->getAttribute(($context["pagination"] ?? null), "totalItemCount", array()) > 0)) {
                // line 144
                echo "        ";
                $this->loadTemplate("pagination.twig", "__string_template__3e81e3e1f19122830e121d0a3aa77b95bd59bbf84f9956f0deefe3e9df04d2d3", 144)->display(array_merge($context, array("pages" => $this->getAttribute(($context["pagination"] ?? null), "paginationData", array()))));
                // line 145
                echo "    ";
            }
            // line 146
            echo "    ";
        } else {
            // line 147
            echo "        <p class=\"errormsg text-danger\">ご指定のカテゴリは存在しません。</p>
    ";
        }
    }

    public function getTemplateName()
    {
        return "__string_template__3e81e3e1f19122830e121d0a3aa77b95bd59bbf84f9956f0deefe3e9df04d2d3";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  334 => 147,  331 => 146,  328 => 145,  325 => 144,  323 => 143,  317 => 139,  307 => 134,  299 => 132,  296 => 131,  288 => 128,  283 => 127,  277 => 124,  272 => 123,  269 => 122,  266 => 121,  258 => 119,  256 => 118,  250 => 117,  246 => 116,  239 => 114,  235 => 113,  231 => 112,  227 => 111,  222 => 110,  218 => 109,  210 => 103,  204 => 101,  201 => 100,  195 => 99,  190 => 97,  186 => 96,  181 => 95,  178 => 94,  174 => 93,  171 => 92,  165 => 91,  160 => 89,  156 => 88,  151 => 87,  148 => 86,  144 => 85,  136 => 80,  130 => 77,  120 => 71,  118 => 70,  111 => 65,  105 => 63,  102 => 62,  99 => 61,  86 => 59,  81 => 58,  79 => 57,  75 => 56,  67 => 51,  64 => 50,  61 => 49,  58 => 48,  35 => 27,  32 => 26,  28 => 22,  26 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__3e81e3e1f19122830e121d0a3aa77b95bd59bbf84f9956f0deefe3e9df04d2d3", "");
    }
}
