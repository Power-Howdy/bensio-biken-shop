<?php

/* __string_template__9d353c62a761be78df4077531c7fac344fb1d6de0e0d71e4ce2150223fc722bb */
class __TwigTemplate_e57bff5760b44d2a68eeb23a694c651dc5d4cfb65befc3fb4350cd5736e592b3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__9d353c62a761be78df4077531c7fac344fb1d6de0e0d71e4ce2150223fc722bb", 22);
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
        // line 29
        $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme(($context["form"] ?? null), array(0 => "Form/bootstrap_3_horizontal_layout.html.twig"));
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
        echo "配送先管理";
    }

    // line 31
    public function block_javascript($context, array $blocks = array())
    {
        // line 32
        echo "<script>
\$(function(){
    \$(\"#set_fee_all\").on(\"click\", function() {
        var fee = \$(\"#";
        // line 35
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "free_all", array()), "vars", array()), "id", array()), "html", null, true);
        echo "\").val();
        \$(\"input[name\$='[fee]']\").val(fee);
    });
});
</script>
";
    }

    // line 42
    public function block_main($context, array $blocks = array())
    {
        echo "<style>
    #delivery_DeliveryCompany > div.radio-inline {
        display: block;
        padding-left: 0;
    }
</style>
<script>
    \$(function(){
        let field = \$('#delivery_company_form_type').html();
        // Clear
        \$('#delivery_company_form_type').empty();
        // Append
        \$(field).appendTo(\$('#delivery_info_box__body'));
    });
</script>

<div style=\"display: none;\" id=\"delivery_company_form_type\">
    ";
        // line 59
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "DeliveryCompany", array()), 'row');
        echo "
</div>
<div class=\"row\" id=\"aside_wrap\">
    <form role=\"form\" class=\"form-horizontal\" name=\"form1\" id=\"form1\" method=\"post\" action=\"\">
        ";
        // line 63
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", array()), 'widget');
        echo "
            <div id=\"detail_wrap\" class=\"col-md-9\">
                <div id=\"delivery_info_box\" class=\"box\">
                    <div id=\"delivery_info_box__header\" class=\"box-header\">
                        <h3 class=\"box-title\">基本情報</h3>
                    </div><!-- /.box-header -->
                    <div id=\"delivery_info_box__body\" class=\"box-body\">

                        ";
        // line 71
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "name", array()), 'row');
        echo "
                        ";
        // line 72
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "service_name", array()), 'row');
        echo "
                        ";
        // line 73
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "confirm_url", array()), 'row');
        echo "
                        ";
        // line 74
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "product_type", array()), 'row', array("attr" => array("class" => "form-inline")));
        echo "

                        <div class=\"extra-form\">
                            ";
        // line 77
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "getIterator", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
            // line 78
            echo "                                ";
            if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                // line 79
                echo "                                    ";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'row');
                echo "
                                ";
            }
            // line 81
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 82
        echo "                        </div>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div id=\"payments_box\" class=\"box\">
                    <div id=\"payments_box__header\" class=\"box-header\">
                        <h3 class=\"box-title\">支払方法設定</h3>
                    </div><!-- /.box-header -->
                    <div id=\"payments_box__body\" class=\"box-body\">
                        ";
        // line 92
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "payments", array()), 'widget');
        echo "
                        ";
        // line 93
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "payments", array()), 'errors');
        echo "
                    </div>
                </div>

                <div id=\"delivery_times_box\" class=\"box accordion clearfix\">
                    <div id=\"delivery_times_box__toggle\" class=\"box-header toggle\">
                        <h3 class=\"box-title\">お届け時間設定<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                    </div><!-- /.box-header -->
                    <div id=\"delivery_times_box__body\" class=\"box-body accpanel\">
                        ";
        // line 102
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "delivery_times", array()));
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
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 103
            echo "                            ";
            if ($this->getAttribute($context["loop"], "first", array())) {
                // line 104
                echo "                                <div id=\"delivery_times_box__body_inner\" class=\"form-group\">
                            ";
            }
            // line 106
            echo "
                            <label class=\"col-sm-2 control-label\">
                                お届け時間";
            // line 108
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "
                            </label>
                            <div id=\"delivery_times_box__delivery_times--";
            // line 110
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index0", array()), "html", null, true);
            echo "\" class=\"col-sm-4\">
                                ";
            // line 111
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget');
            echo "
                            </div>

                            ";
            // line 114
            if (($this->getAttribute($context["loop"], "last", array()) == true)) {
                // line 115
                echo "                                </div>
                            ";
            }
            // line 117
            echo "                        ";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 118
        echo "                    </div>
                </div>

                <div id=\"delivery_pref_box\" class=\"box accordion\">
                    <div id=\"delivery_pref_box__header\" class=\"box-header\">
                        <h3 class=\"box-title\">都道府県別送料設定</h3>
                    </div>
                    <div id=\"delivery_pref_box__body\" class=\"box-body\">
                        <div id=\"delivery_pref_box__free_all\" class=\"form-inline fees_area\">
                            全国一律送料&nbsp; ";
        // line 127
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_all", array()), 'widget');
        echo "
                            <a class=\"btn btn-normal btn-default btn-sm\" href=\"javascript:;\" id=\"set_fee_all\">各都道府県に反映</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div id=\"delivery_pref_box__body_toggle\" class=\"box-body toggle active\" style=\"position:relative;\">
                        <h3 class=\"box-title\">都道府県ごとに設定する<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                    </div>
                    <div id=\"delivery_pref_box__body_inner\" class=\"box-body accpanel\" style=\"display: block;\">
                        ";
        // line 135
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "delivery_fees", array()));
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
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 136
            echo "                            ";
            if ($this->getAttribute($context["loop"], "first", array())) {
                // line 137
                echo "                                <div id=\"delivery_pref_box__item\" class=\"form-group\">
                            ";
            }
            // line 139
            echo "
                                <label id=\"delivery_pref_box__header_delivery_fee--";
            // line 140
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["child"], "vars", array()), "name", array()), "html", null, true);
            echo "\" class=\"col-sm-2 control-label\">
                                    ";
            // line 141
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute($context["child"], "vars", array(), "any", false, true), "data", array(), "any", false, true), "pref", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute($context["child"], "vars", array(), "any", false, true), "data", array(), "any", false, true), "pref", array()), "")) : ("")), "html", null, true);
            echo "
                                </label>
                                <div id=\"delivery_pref_box__delivery_fee--";
            // line 143
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["child"], "vars", array()), "name", array()), "html", null, true);
            echo "\" class=\"col-sm-4 fees_area\">
                                    ";
            // line 144
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget');
            echo "
                                </div>

                            ";
            // line 147
            if (($this->getAttribute($context["loop"], "last", array()) == true)) {
                // line 148
                echo "                                </div>
                            ";
            }
            // line 150
            echo "                        ";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 151
        echo "                    </div>
                </div>

                <div id=\"detail__back_button\" class=\"row hidden-xs hidden-sm\">
                    <div class=\"col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 text-center btn_area\">
                        <p><a href=\"";
        // line 156
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_setting_shop_delivery");
        echo "\">一覧に戻る</a></p>
                    </div>
                </div>

            </div><!-- /.col -->
            <div class=\"col-md-3\" id=\"aside_column\">
                <div id=\"common_box\" class=\"col_inner\">
                    <div id=\"common_button_box\" class=\"box no-header\">
                        <div id=\"common_button_box__body\" class=\"box-body\">
                            <div id=\"common_button_box__insert_button\" class=\"row text-center\">
                                <div class=\"col-sm-6 col-sm-offset-3 col-md-12 col-md-offset-0\">
                                    <button class=\"btn btn-primary btn-block btn-lg\" type=\"submit\">登録</button>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <div id=\"common_shop_note_box\" class=\"box\">
                        <div id=\"common_shop_note_box__header\" class=\"box-header\">
                            <h3 class=\"box-title\">ショップ用メモ欄</h3>
                        </div><!-- /.box-header -->
                        <div id=\"common_shop_note_box__body\" class=\"box-body\">
                            ";
        // line 177
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "description", array()), 'widget');
        echo "
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
    </form>
</div>

";
    }

    public function getTemplateName()
    {
        return "__string_template__9d353c62a761be78df4077531c7fac344fb1d6de0e0d71e4ce2150223fc722bb";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  352 => 177,  328 => 156,  321 => 151,  307 => 150,  303 => 148,  301 => 147,  295 => 144,  291 => 143,  286 => 141,  282 => 140,  279 => 139,  275 => 137,  272 => 136,  255 => 135,  244 => 127,  233 => 118,  219 => 117,  215 => 115,  213 => 114,  207 => 111,  203 => 110,  198 => 108,  194 => 106,  190 => 104,  187 => 103,  170 => 102,  158 => 93,  154 => 92,  142 => 82,  136 => 81,  130 => 79,  127 => 78,  123 => 77,  117 => 74,  113 => 73,  109 => 72,  105 => 71,  94 => 63,  87 => 59,  66 => 42,  56 => 35,  51 => 32,  48 => 31,  42 => 27,  36 => 26,  32 => 22,  30 => 29,  28 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__9d353c62a761be78df4077531c7fac344fb1d6de0e0d71e4ce2150223fc722bb", "");
    }
}
