<?php

/* EccubePaymentLite3/Twig/shopping/specified_commercial_transactions_other.twig */
class __TwigTemplate_5e717abf143520691db2374b609cad146cc73d961cda5cc675fe8ad357d41e8d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<script>
    \$(function (){
        \$('#contact_message').after(
            '<div id=\"ec_trans_other_payment_wrap\" class=\"row\">' +
                '<div id=\"ec_trans_other_payment_list_box\" class=\"col-md-12\">' +
                    '<div id=\"ec_trans_other_payment_list_box__body\" class=\"box\">' +
                        '<div id=\"ec_trans_other_payment_list_box__header\" class=\"box-header\">' +
                            '<h2 class=\"heading02\">お支払時期について</h2>' +
                        '</div>' +
                        '<div id=\"ec_trans_other_payment_detail_box\" class=\"column is-edit\">' +
                            '<div id=\"ec_trans_other_payment_box_detail_box__message\">詳細は<a href=\"";
        // line 11
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("help_tradelaw");
        echo "\" target=\"_blank\">こちらのページ</a>をご覧ください</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div id=\"ec_trans_other_cancel_wrap\" class=\"row\">' +
                '<div id=\"ec_trans_other_cancel_list_box\" class=\"col-md-12\">' +
                    '<div id=\"ec_trans_other_cancel_list_box__body\" class=\"box\">' +
                        '<div id=\"ec_trans_other_cancel_list_box__header\" class=\"box-header\">' +
                            '<h2 class=\"heading02\">キャンセル返品について</h2>' +
                        '</div>' +
                        '<div id=\"ec_trans_other_cancel_detail_box\" class=\"column is-edit\">' +
                            '<div id=\"ec_trans_other_cancel_box_detail_box__message\">詳細は<a href=\"";
        // line 23
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("help_tradelaw");
        echo "\" target=\"_blank\">こちらのページ</a>をご覧ください</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>'
        );
    });
</script>
";
    }

    public function getTemplateName()
    {
        return "EccubePaymentLite3/Twig/shopping/specified_commercial_transactions_other.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 23,  31 => 11,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "EccubePaymentLite3/Twig/shopping/specified_commercial_transactions_other.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/Plugin/EccubePaymentLite3/Twig/shopping/specified_commercial_transactions_other.twig");
    }
}
