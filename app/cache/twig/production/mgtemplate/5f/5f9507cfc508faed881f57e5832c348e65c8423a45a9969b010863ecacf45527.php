<?php

/* __string_template__5971d987020eeadc517fcaade66ea24907b724ffef0e5c9481855b465406ff18 */
class __TwigTemplate_9c2a9db2c1004f87081948a8d1b4ac183f3dbfc625efa986398fe7504d3926d3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__5971d987020eeadc517fcaade66ea24907b724ffef0e5c9481855b465406ff18", 22);
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
        echo "    <h1 class=\"page-heading\">購入エラー</h1>
    <div id=\"error_wrap\" class=\"container-fluid\">
        <div id=\"error_box\" class=\"row\">
            <div id=\"error_box__body\" class=\"col-sm-10 col-sm-offset-1\">
                ";
        // line 31
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashbag", array()), "get", array(0 => "eccube.front.error"), "method"));
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
            // line 32
            echo "                <div id=\"error_box__error_message-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"message\">
                    ";
            // line 33
            echo nl2br(twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["error"]), "html", null, true));
            echo "
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
        // line 36
        echo "                <div id=\"error_box__footer\" class=\"row no-padding\">
                    <div id=\"error_box__button_menu\" class=\"btn_group col-sm-offset-4 col-sm-4\">
                        <p id=\"error_box__top_button\">
                            <a href=\"";
        // line 39
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("homepage");
        echo "\" class=\"btn btn-info btn-block\">トップページへ</a>
                        </p>
                        <p id=\"error_box__back_button\">
                            <a href=\"";
        // line 42
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("cart");
        echo "\" class=\"btn btn-info btn-block\">カートに戻る</a>
                        </p>
                    </div>
                </div>

            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__5971d987020eeadc517fcaade66ea24907b724ffef0e5c9481855b465406ff18";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 42,  84 => 39,  79 => 36,  62 => 33,  57 => 32,  40 => 31,  34 => 27,  31 => 26,  27 => 22,  25 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__5971d987020eeadc517fcaade66ea24907b724ffef0e5c9481855b465406ff18", "");
    }
}
