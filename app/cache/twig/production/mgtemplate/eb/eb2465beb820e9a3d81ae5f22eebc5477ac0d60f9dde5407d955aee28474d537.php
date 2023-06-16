<?php

/* __string_template__0f955e0a8c36415197cf9e0ede5f4c9357a391bb2e60afcb15deab32183be72c */
class __TwigTemplate_588cd7a1ed8b6365b1ff5ccce2fa30ab4715cc8089c678227289896d7e9a3bbe extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__0f955e0a8c36415197cf9e0ede5f4c9357a391bb2e60afcb15deab32183be72c", 22);
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
        $context["body_class"] = "registration_page";
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    public function block_javascript($context, array $blocks = array())
    {
        // line 27
        echo "<script src=\"//ajaxzip3.github.io/ajaxzip3.js\" charset=\"UTF-8\"></script>
<script>
    \$(function() {
        \$('#zip-search').click(function() {
            AjaxZip3.zip2addr('entry[zip][zip01]', 'entry[zip][zip02]', 'entry[address][pref]', 'entry[address][addr01]');
        });
    });
</script>
";
    }

    // line 37
    public function block_main($context, array $blocks = array())
    {
        // line 38
        echo "<h1 class=\"page-heading\">新規SHOP会員登録</h1>
<div id=\"top_wrap\" class=\"container-fluid\">
    <div id=\"top_box\" class=\"row\">
        <div id=\"top_box__body\" class=\"col-md-10 col-md-offset-1\">
            <form method=\"post\" action=\"";
        // line 42
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("entry");
        echo "\">
                ";
        // line 43
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", array()), 'widget');
        echo "
                <div id=\"top_box__body_inner\" class=\"dl_table\">
                    <dl id=\"top_box__name\">
                        <dt>";
        // line 46
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "name", array()), 'label');
        echo "</dt>
                        <dd class=\"form-group input_name\">
                            ";
        // line 48
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name01", array()), 'widget');
        echo "
                            ";
        // line 49
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name02", array()), 'widget');
        echo "
                            ";
        // line 50
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name01", array()), 'errors');
        echo "
                            ";
        // line 51
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name02", array()), 'errors');
        echo "
                        </dd>
                    </dl>
                    <dl id=\"top_box__kana\">
                        <dt>";
        // line 55
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "kana", array()), 'label');
        echo "</dt>
                        <dd class=\"form-group input_name\">
                            ";
        // line 57
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana01", array()), 'widget');
        echo "
                            ";
        // line 58
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana02", array()), 'widget');
        echo "
                            ";
        // line 59
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana01", array()), 'errors');
        echo "
                            ";
        // line 60
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana02", array()), 'errors');
        echo "
                        </dd>
                    </dl>
                    <dl id=\"top_box__company_name\">
                        <dt>";
        // line 64
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'label');
        echo "</dt>
                        <dd class=\"form-group input_name\">
                            ";
        // line 66
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'widget');
        echo "
                            ";
        // line 67
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'errors');
        echo "
                        </dd>
                    </dl>
                    <dl id=\"top_box__address_detail\">
                        <dt>";
        // line 71
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "address", array()), 'label');
        echo "</dt>
                        <dd>
                            <div id=\"top_box__zip\" class=\"form-group form-inline input_zip ";
        // line 73
        if (( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip01", array()), "vars", array()), "errors", array())) ||  !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip02", array()), "vars", array()), "errors", array())))) {
            echo "has-error";
        }
        echo "\">";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "zip", array()), 'widget');
        echo "</div>
                            <div id=\"top_box__address\" class=\"";
        // line 74
        if ((( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "pref", array()), "vars", array()), "errors", array())) ||  !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr01", array()), "vars", array()), "errors", array()))) ||  !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr02", array()), "vars", array()), "errors", array())))) {
            echo "has-error";
        }
        echo "\">
                                ";
        // line 75
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "address", array()), 'widget');
        echo "
                                ";
        // line 76
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "address", array()), 'errors');
        echo "
                            </div>
                        </dd>
                    </dl>
                    <dl id=\"top_box__tel\">
                        <dt>";
        // line 81
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "tel", array()), 'label');
        echo "</dt>
                        <dd>
                            <div class=\"form-inline form-group input_tel\">
                                ";
        // line 84
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "tel", array()), 'widget', array("attr" => array("class" => "short")));
        echo "
                                ";
        // line 85
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "tel", array()), 'errors');
        echo "
                            </div>
                        </dd>
                    </dl>
                    <dl id=\"top_box__fax\">
                        <dt>";
        // line 90
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "fax", array()), 'label');
        echo "</dt>
                        <dd>
                            <div class=\"form-inline form-group input_tel\">
                                ";
        // line 93
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "fax", array()), 'widget', array("attr" => array("class" => "short")));
        echo "
                                ";
        // line 94
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "fax", array()), 'errors');
        echo "
                            </div>
                        </dd>
                    </dl>
                    <dl id=\"top_box__lineid\">
                        <dt>";
        // line 99
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "lineid", array()), 'label');
        echo "</dt>
                        <dd class=\"form-group input_name\">
                            ";
        // line 101
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "lineid", array()), 'widget');
        echo "
                            ";
        // line 102
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "lineid", array()), 'errors');
        echo "
                        </dd>
                    </dl>
                    <dl id=\"top_box__email\">
                        <dt>";
        // line 106
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "email", array()), 'label');
        echo "</dt>
                        <dd>
                            ";
        // line 108
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "email", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["emailField"]) {
            // line 109
            echo "                            <div class=\"form-group ";
            if ( !twig_test_empty($this->getAttribute($this->getAttribute($context["emailField"], "vars", array()), "errors", array()))) {
                echo "has-error";
            }
            echo "\">
                                ";
            // line 110
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["emailField"], 'widget');
            echo "
                                ";
            // line 111
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["emailField"], 'errors');
            echo "
                            </div>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['emailField'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 114
        echo "                        </dd>
                    </dl>
                    <dl id=\"top_box__password\">
                        <dt>";
        // line 117
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "password", array()), 'label');
        echo "</dt>
                        <dd>
                            ";
        // line 119
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "password", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["passwordField"]) {
            // line 120
            echo "                            <div class=\"form-group ";
            if ( !twig_test_empty($this->getAttribute($this->getAttribute($context["passwordField"], "vars", array()), "errors", array()))) {
                echo "has-error";
            }
            echo "\">
                                ";
            // line 121
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["passwordField"], 'widget', array("type" => "password"));
            echo "
                                ";
            // line 122
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["passwordField"], 'errors');
            echo "
                            </div>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['passwordField'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 125
        echo "                        </dd>
                    </dl>
                    <dl id=\"top_box__job\" style=\"display:none;\">
                        <dt>";
        // line 128
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "job", array()), 'label');
        echo "</dt>
                        <dd>
                            <div class=\"form-group form-inline\">
                                ";
        // line 131
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "job", array()), 'widget');
        echo "
                                ";
        // line 132
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "job", array()), 'errors');
        echo "
                            </div>
                        </dd>
                    </dl>";
        // line 156
        echo "<dl>
<dt>メールマガジン送付について<span class=\"required\">必須</span></dt>
<dd>
    <div class=\"form-group form-inline\">
        ";
        // line 160
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "mailmaga_flg", array()), 'widget');
        echo "
        ";
        // line 161
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "mailmaga_flg", array()), 'errors');
        echo "
    </div>
</dd>
</dl>

                </div>
                <div id=\"top_box__birth\" class=\"dl_table not_required\" style=\"display:none;\">
                    <dl>
                        <dt>";
        // line 169
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "birth", array()), 'label');
        echo "</dt>
                        <dd>
                            <div class=\"form-group form-inline\">
                                ";
        // line 172
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "birth", array()), 'widget');
        echo "
                                ";
        // line 173
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "birth", array()), 'errors');
        echo "
                            </div>
                        </dd>
                    </dl>
                    <dl>
                        <dt id=\"top_box__sex\">";
        // line 178
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "sex", array()), 'label');
        echo "</dt>
                        <dd>
                            <div class=\"form-group form-inline\">
                                ";
        // line 181
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "sex", array()), 'widget');
        echo "
                                ";
        // line 182
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "sex", array()), 'errors');
        echo "
                            </div>
                        </dd>
                    </dl>
                </div>
                ";
        // line 187
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
            // line 188
            echo "                    ";
            if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                // line 189
                echo "                        <div class=\"extra-form dl_table\">
                            ";
                // line 190
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'row');
                echo "
                        </div>
                    ";
            }
            // line 193
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 194
        echo "                <input id=\"top_box__hidden_mode\" type=\"hidden\" name=\"mode\" value=\"confirm\">
                <p id=\"top_box__agreement\" class=\"form_terms_link\"><a href=\"";
        // line 195
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("help_agreement");
        echo "\" target=\"_blank\">利用規約</a>に同意してお進みください
                </p>

                <div id=\"top_box__footer\" class=\"row no-padding\">
                    <div id=\"top_box__button_menu\" class=\"btn_group col-sm-offset-4 col-sm-4\">
                        <p>
                            <button type=\"submit\" class=\"btn btn-primary btn-block\">同意する</button>
                        </p>
                        <p><a href=\"";
        // line 203
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("index");
        echo "\" class=\"btn btn-info btn-block\">同意しない</a></p>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__0f955e0a8c36415197cf9e0ede5f4c9357a391bb2e60afcb15deab32183be72c";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  390 => 203,  379 => 195,  376 => 194,  370 => 193,  364 => 190,  361 => 189,  358 => 188,  354 => 187,  346 => 182,  342 => 181,  336 => 178,  328 => 173,  324 => 172,  318 => 169,  307 => 161,  303 => 160,  297 => 156,  291 => 132,  287 => 131,  281 => 128,  276 => 125,  267 => 122,  263 => 121,  256 => 120,  252 => 119,  247 => 117,  242 => 114,  233 => 111,  229 => 110,  222 => 109,  218 => 108,  213 => 106,  206 => 102,  202 => 101,  197 => 99,  189 => 94,  185 => 93,  179 => 90,  171 => 85,  167 => 84,  161 => 81,  153 => 76,  149 => 75,  143 => 74,  135 => 73,  130 => 71,  123 => 67,  119 => 66,  114 => 64,  107 => 60,  103 => 59,  99 => 58,  95 => 57,  90 => 55,  83 => 51,  79 => 50,  75 => 49,  71 => 48,  66 => 46,  60 => 43,  56 => 42,  50 => 38,  47 => 37,  35 => 27,  32 => 26,  28 => 22,  26 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__0f955e0a8c36415197cf9e0ede5f4c9357a391bb2e60afcb15deab32183be72c", "");
    }
}
