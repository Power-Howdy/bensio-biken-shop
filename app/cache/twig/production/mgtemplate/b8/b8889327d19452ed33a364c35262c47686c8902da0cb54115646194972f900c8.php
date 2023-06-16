<?php

/* __string_template__1a42e489ab0972a7c25009d5cca625ca5ac1b102ee18efe4d25c81e02548ca04 */
class __TwigTemplate_bc26ebfe979477f1874dfbead5be35741c7dbff2e9cba8385591f50eb720bd70 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__1a42e489ab0972a7c25009d5cca625ca5ac1b102ee18efe4d25c81e02548ca04", 22);
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
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 24
    public function block_main($context, array $blocks = array())
    {
        // line 25
        echo "<div id=\"contents\" class=\"main_only\">
    <div class=\"container-fluid inner no-padding\">
        <div id=\"main\">
            <h1 class=\"page-heading\">特定商取引法に基づく表記</h1>
            <div id=\"tradelaw_wrap\" class=\"container-fluid\">
                <div class=\"row\">
                    <div id=\"tradelaw_box\" class=\"col-md-10 col-md-offset-1\">
                        <div id=\"tradelaw__body\" class=\"dl_table\">

                            ";
        // line 34
        if ($this->getAttribute(($context["help"] ?? null), "law_company", array(), "any", true, true)) {
            // line 35
            echo "                            <dl id=\"tradelaw__law_company\">
                                <dt>販売業者</dt>
                                <dd>";
            // line 37
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_company", array()), "html", null, true);
            echo "</dd>
                            </dl>
                            ";
        }
        // line 40
        echo "
                            ";
        // line 41
        if ($this->getAttribute(($context["help"] ?? null), "law_manager", array(), "any", true, true)) {
            // line 42
            echo "                            <dl id=\"tradelaw__law_manager\">
                                <dt>運営責任者</dt>
                                <dd>";
            // line 44
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_manager", array()), "html", null, true);
            echo "</dd>
                            </dl>
                            ";
        }
        // line 47
        echo "
                            ";
        // line 48
        if ($this->getAttribute(($context["help"] ?? null), "law_zip01", array(), "any", true, true)) {
            // line 49
            echo "                            <dl id=\"tradelaw__zip\">
                                <dt>住所</dt>
                                <dd>〒";
            // line 51
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_zip01", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_zip02", array()), "html", null, true);
            echo "<br />
                                    ";
            // line 52
            echo twig_escape_filter($this->env, (($this->getAttribute(($context["help"] ?? null), "law_pref", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["help"] ?? null), "law_pref", array()), "")) : ("")), "html", null, true);
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_addr01", array()), "html", null, true);
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_addr02", array()), "html", null, true);
            echo "
                                </dd>
                            </dl>
                            ";
        }
        // line 56
        echo "
                            ";
        // line 57
        if ($this->getAttribute(($context["help"] ?? null), "law_tel01", array(), "any", true, true)) {
            // line 58
            echo "                            <dl id=\"tradelaw__tel\">
                                <dt>電話番号</dt>
                                <dd>";
            // line 60
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_tel01", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_tel02", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_tel03", array()), "html", null, true);
            echo "</dd>
                            </dl>
                            ";
        }
        // line 63
        echo "
                            ";
        // line 64
        if (($this->getAttribute(($context["help"] ?? null), "law_fax01", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute(($context["help"] ?? null), "law_fax01", array())))) {
            // line 65
            echo "                            <dl id=\"tradelaw__fax\">
                                <dt>FAX番号</dt>
                                <dd>";
            // line 67
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_fax01", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_fax02", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_fax03", array()), "html", null, true);
            echo "</dd>
                            </dl>
                            ";
        }
        // line 70
        echo "
                            ";
        // line 71
        if ($this->getAttribute(($context["help"] ?? null), "law_email", array(), "any", true, true)) {
            // line 72
            echo "                            <dl id=\"tradelaw__email\">
                                <dt>メールアドレス</dt>
                                <dd><a href=\"mailto:";
            // line 74
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_email", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_email", array()), "html", null, true);
            echo "</a></dd>
                            </dl>
                            ";
        }
        // line 77
        echo "
                            ";
        // line 78
        if ($this->getAttribute(($context["help"] ?? null), "law_url", array(), "any", true, true)) {
            // line 79
            echo "                            <dl id=\"tradelaw__law_url\">
                                <dt>URL</dt>
                                <dd><a href=\"";
            // line 81
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_url", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_url", array()), "html", null, true);
            echo "</a></dd>
                            </dl>
                            ";
        }
        // line 84
        echo "
                            ";
        // line 85
        if ($this->getAttribute(($context["help"] ?? null), "law_term01", array(), "any", true, true)) {
            // line 86
            echo "                            <dl id=\"tradelaw__law_term01\">
                                <dt>商品以外の必要代金</dt>
                                <dd>";
            // line 88
            echo nl2br(twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_term01", array()), "html", null, true));
            echo "</dd>
                            </dl>
                            ";
        }
        // line 91
        echo "
                            ";
        // line 92
        if ($this->getAttribute(($context["help"] ?? null), "law_term02", array(), "any", true, true)) {
            // line 93
            echo "                            <dl id=\"tradelaw__law_term02\">
                                <dt>注文方法</dt>
                                <dd>";
            // line 95
            echo nl2br(twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_term02", array()), "html", null, true));
            echo "</dd>
                            </dl>
                            ";
        }
        // line 98
        echo "
                            ";
        // line 99
        if ($this->getAttribute(($context["help"] ?? null), "law_term03", array(), "any", true, true)) {
            // line 100
            echo "                            <dl id=\"tradelaw__law_term03\">
                                <dt>支払方法</dt>
                                <dd>";
            // line 102
            echo nl2br(twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_term03", array()), "html", null, true));
            echo "</dd>
                            </dl>
                            ";
        }
        // line 105
        echo "
                            ";
        // line 106
        if ($this->getAttribute(($context["help"] ?? null), "law_term04", array(), "any", true, true)) {
            // line 107
            echo "                            <dl id=\"tradelaw__law_term04\">
                                <dt>支払期限</dt>
                                <dd>";
            // line 109
            echo nl2br(twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_term04", array()), "html", null, true));
            echo "</dd>
                            </dl>
                            ";
        }
        // line 112
        echo "
                            ";
        // line 113
        if ($this->getAttribute(($context["help"] ?? null), "law_term05", array(), "any", true, true)) {
            // line 114
            echo "                            <dl id=\"tradelaw__law_term05\">
                                <dt>引渡し時期</dt>
                                <dd>";
            // line 116
            echo nl2br(twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_term05", array()), "html", null, true));
            echo "</dd>
                            </dl>
                            ";
        }
        // line 119
        echo "
                            ";
        // line 120
        if ($this->getAttribute(($context["help"] ?? null), "law_term06", array(), "any", true, true)) {
            // line 121
            echo "                            <dl id=\"tradelaw__law_term06\">
                                <dt>返品・交換について</dt>
                                <dd>";
            // line 123
            echo nl2br(twig_escape_filter($this->env, $this->getAttribute(($context["help"] ?? null), "law_term06", array()), "html", null, true));
            echo "</dd>
                            </dl>
                            ";
        }
        // line 126
        echo "                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__1a42e489ab0972a7c25009d5cca625ca5ac1b102ee18efe4d25c81e02548ca04";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  255 => 126,  249 => 123,  245 => 121,  243 => 120,  240 => 119,  234 => 116,  230 => 114,  228 => 113,  225 => 112,  219 => 109,  215 => 107,  213 => 106,  210 => 105,  204 => 102,  200 => 100,  198 => 99,  195 => 98,  189 => 95,  185 => 93,  183 => 92,  180 => 91,  174 => 88,  170 => 86,  168 => 85,  165 => 84,  157 => 81,  153 => 79,  151 => 78,  148 => 77,  140 => 74,  136 => 72,  134 => 71,  131 => 70,  121 => 67,  117 => 65,  115 => 64,  112 => 63,  102 => 60,  98 => 58,  96 => 57,  93 => 56,  84 => 52,  78 => 51,  74 => 49,  72 => 48,  69 => 47,  63 => 44,  59 => 42,  57 => 41,  54 => 40,  48 => 37,  44 => 35,  42 => 34,  31 => 25,  28 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__1a42e489ab0972a7c25009d5cca625ca5ac1b102ee18efe4d25c81e02548ca04", "");
    }
}
