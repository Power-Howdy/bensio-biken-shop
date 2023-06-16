<?php

/* EccubePaymentLite3/Twig/admin/config.twig */
class __TwigTemplate_a62cc373e3f30162d3c10478da6f87d1da018229c78b70c7a2b1ef971da26656 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("default_frame.twig", "EccubePaymentLite3/Twig/admin/config.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'main' => array($this, 'block_main'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 5
        $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme(($context["form"] ?? null), array(0 => "Form/bootstrap_3_horizontal_layout.html.twig"));
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ($context["tpl_subtitle"] ?? null), "html", null, true);
    }

    // line 6
    public function block_main($context, array $blocks = array())
    {
        // line 7
        echo "
    <div class=\"row\" id=\"aside_wrap\">
        <form name=\"form1\" role=\"form\" novalidate class=\"form-horizontal\" id=\"point_form\" method=\"post\" action=\"\">
            ";
        // line 10
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", array()), 'widget');
        echo "
            <div class=\"col-md-9\">


                <div class=\"box\">
                    <div class=\"box-header\">
                        <h3 class=\"box-title\">設定</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class=\"box-body\">
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label required\">契約コード<span
                                        class=\"text-danger\"> *</span></label>
                            <div class=\"col-sm-10 ";
        // line 23
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "contract_code", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 24
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "contract_code", array()), 'widget');
        echo "
                                ";
        // line 25
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "contract_code", array()), 'errors');
        echo "
                            </div>
                        </div>
                        <div class=\"form-group\"
                             ";
        // line 29
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "environmental_setting", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label required\"> 環境設定<span class=\"text-danger\"> *</span></label>

                            <div class=\"col-sm-10 ";
        // line 32
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "environmental_setting", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 33
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "environmental_setting", array()), 'widget');
        echo "
                                ";
        // line 34
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "environmental_setting", array()), 'errors');
        echo "
                            </div>
                        </div>

                        <div class=\"form-group\"
                             ";
        // line 39
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "credit_payment_setting", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label required\"> 環境設定<span class=\"text-danger\"> *</span></label>

                            <div class=\"col-sm-10 ";
        // line 42
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "credit_payment_setting", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 43
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "credit_payment_setting", array()), 'widget');
        echo "
                                ";
        // line 44
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "credit_payment_setting", array()), 'errors');
        echo "
                            </div>
                        </div>
                        <div class=\"form-group\"
                             ";
        // line 48
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "use_payment", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label required\">利用決済方法<span class=\"text-danger\"> *</span></label>

                            <div class=\"col-sm-10 ";
        // line 51
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "use_payment", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 52
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "use_payment", array()), 'widget');
        echo "
                                ";
        // line 53
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "use_payment", array()), 'errors');
        echo "
                            </div>
                        </div>
                        <div class=\"form-group\"
                             ";
        // line 57
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "use_convenience", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label required\">利用コンビニ<span class=\"text-danger\"> *</span></label>

                            <div class=\"col-sm-10 ";
        // line 60
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "use_convenience", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 61
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "use_convenience", array()), 'widget');
        echo "
                                ";
        // line 62
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "use_convenience", array()), 'errors');
        echo "
                            </div>
                        </div>
                        <div class=\"form-group\"
                             ";
        // line 66
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "card_expiration_notification_days", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label required\">カード有効期限切れ通知日数<span class=\"text-danger\"> *</span></label>

                            <div class=\"col-sm-10 ";
        // line 69
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "card_expiration_notification_days", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 70
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "card_expiration_notification_days", array()), 'widget');
        echo "
                                ";
        // line 71
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "card_expiration_notification_days", array()), 'errors');
        echo "
                            </div>
                        </div>
                    </div>

                    <div class=\"box-header\">
                        <h3 class=\"box-title\">定期課金設定</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class=\"box-body\">
                        <div class=\"form-group\"
                             ";
        // line 82
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "regular", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label required\"> 定期課金機能<span class=\"text-danger\"> *</span></label>

                            <div class=\"col-sm-10 ";
        // line 85
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "regular", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 86
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "regular", array()), 'widget');
        echo "
                                ";
        // line 87
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "regular", array()), 'errors');
        echo "
                                <p class='small'>*定期課金機能を利用するにはクレジットカード決済が有効である必要があります。</p>
                            </div>
                        </div>
                    </div>

                    <div class=\"box-header\">
                        <h3 class=\"box-title\">不正アクセスブロック機能</h3>
                        <div style=\"margin-left: 10px;\">
                            <p>不正アクセスブロック機能は「クレジットカード決済」「登録済みのクレジットカードで決済」を対象とした機能です。</p>
                            <p>下記で設定したアクセス頻度の上限を超えた場合は設定したブロック時間分、クレジットカード情報入力ページへのアクセスをブロックします。</p>
                            <p>不正アクセス対象外としたいIPアドレスはホワイトリストにて設定が可能です。</p>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class=\"box-body\">
                        <div class=\"form-group\"
                             ";
        // line 104
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "block_mode", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label required\"> ブロックモード<span class=\"text-danger\"> *</span></label>

                            <div class=\"col-sm-10 ";
        // line 107
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "block_mode", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 108
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "block_mode", array()), 'widget');
        echo "
                                ";
        // line 109
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "block_mode", array()), 'errors');
        echo "
                            </div>
                        </div>

                        <div class=\"form-group\"
                             ";
        // line 114
        if (( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "access_frequency", array()), "vars", array()), "errors", array())) ||  !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "access_frequency_time", array()), "vars", array()), "errors", array())))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label\"> アクセス頻度</label>

                            <div>
                                <div class=\"col-sm-2 col-lg-2 ";
        // line 118
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "access_frequency_time", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                    ";
        // line 119
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "access_frequency_time", array()), 'widget');
        echo "
                                    ";
        // line 120
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "access_frequency_time", array()), 'errors');
        echo "
                                </div>
                                <div class=\"col-sm-2 col-lg-2\">
                                    秒間に
                                </div>

                                <div class=\"col-sm-2 col-lg-2 ";
        // line 126
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "access_frequency", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                    ";
        // line 127
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "access_frequency", array()), 'widget');
        echo "
                                    ";
        // line 128
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "access_frequency", array()), 'errors');
        echo "
                                </div>
                                <div class=\"col-sm-3 col-lg-3\">
                                    回アクセスされた場合ブロックする
                                </div>
                            </div>
                        </div>

                        <div class=\"form-group\"
                             ";
        // line 137
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "block_time", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label\"> ブロック時間</label>

                            <div class=\"col-sm-3 col-lg-3 ";
        // line 140
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "block_time", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 141
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "block_time", array()), 'widget');
        echo "
                                ";
        // line 142
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "block_time", array()), 'errors');
        echo "
                            </div>
                            <div class=\"col-sm-2 col-lg-2\">
                                秒
                            </div>
                        </div>

                        <div class=\"form-group\"
                             ";
        // line 150
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "white_list", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label\"> ホワイトリスト</label>

                            <div class=\"col-sm-9 col-lg-10 ";
        // line 153
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "white_list", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 154
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "white_list", array()), 'widget');
        echo "
                                ";
        // line 155
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "white_list", array()), 'errors');
        echo "
                                <span id=\"helpBlock\" class=\"help-block\">
                                    ※カンマ区切りで複数指定可
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class=\"box-header\">
                        <h3 class=\"box-title\">IPのブラックリスト機能</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class=\"box-body\">
                        <div class=\"form-group\"
                             ";
        // line 169
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "ip_black_lists", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo ">
                            <label class=\"col-sm-2 control-label\"> ブラックリスト</label>

                            <div class=\"col-sm-9 col-lg-10 ";
        // line 172
        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "ip_black_lists", array()), "vars", array()), "errors", array()))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 173
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "ip_black_lists", array()), 'widget');
        echo "
                                ";
        // line 174
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "ip_black_lists", array()), 'errors');
        echo "
                                <span id=\"helpBlock\" class=\"help-block\">
                                    ※カンマ区切りで複数指定可
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
\t\t\t</div>
            <div class=\"col-md-3\" id=\"aside_column\">
                <div class=\"col_inner\">
                    <div class=\"box no-header\">
                        <div class=\"box-body\">
                            <div class=\"row text-center\">
                                <div class=\"col-sm-6 col-sm-offset-3 col-md-12 col-md-offset-0\">
                                    <button class=\"btn btn-primary btn-block btn-lg\" onclick=\"document.form1.submit();\">
                                        この内容で登録する
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.col -->
        </form>
    </div>


";
    }

    public function getTemplateName()
    {
        return "EccubePaymentLite3/Twig/admin/config.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  408 => 174,  404 => 173,  398 => 172,  390 => 169,  373 => 155,  369 => 154,  363 => 153,  355 => 150,  344 => 142,  340 => 141,  334 => 140,  326 => 137,  314 => 128,  310 => 127,  304 => 126,  295 => 120,  291 => 119,  285 => 118,  276 => 114,  268 => 109,  264 => 108,  258 => 107,  250 => 104,  230 => 87,  226 => 86,  220 => 85,  212 => 82,  198 => 71,  194 => 70,  188 => 69,  180 => 66,  173 => 62,  169 => 61,  163 => 60,  155 => 57,  148 => 53,  144 => 52,  138 => 51,  130 => 48,  123 => 44,  119 => 43,  113 => 42,  105 => 39,  97 => 34,  93 => 33,  87 => 32,  79 => 29,  72 => 25,  68 => 24,  62 => 23,  46 => 10,  41 => 7,  38 => 6,  32 => 3,  28 => 1,  26 => 5,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "EccubePaymentLite3/Twig/admin/config.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/Plugin/EccubePaymentLite3/Twig/admin/config.twig");
    }
}
