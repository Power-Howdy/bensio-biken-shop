<?php

/* __string_template__b41e70a7f7b7d517373d076b2e3014975237483dfee791b607824b53fe57df99 */
class __TwigTemplate_1e212b99b7c9b653711a0d0f9125adff67718cd73592ef0cca8eb6967d1d8361 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 23
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__b41e70a7f7b7d517373d076b2e3014975237483dfee791b607824b53fe57df99", 23);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'sub_title' => array($this, 'block_sub_title'),
            'javascript' => array($this, 'block_javascript'),
            'main' => array($this, 'block_main'),
            'modal' => array($this, 'block_modal'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 25
        $context["menus"] = array(0 => "store", 1 => "plugin", 2 => "plugin_list");
        // line 23
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 27
    public function block_title($context, array $blocks = array())
    {
        echo "オーナーズストア";
    }

    // line 28
    public function block_sub_title($context, array $blocks = array())
    {
        echo "プラグイン一覧";
    }

    // line 30
    public function block_javascript($context, array $blocks = array())
    {
        // line 31
        echo "<script>
    function changeActionSubmit(action, form_name) {
        document.forms[form_name].action = action;
        document.forms[form_name].submit();
        return false;
    }
    \$(function(){
        \$('#readmeModal').on('show.bs.modal', function(event) {
            var target = \$(event.relatedTarget);
            var modal = \$(this)
            modal.find('#readmeModalLabel').text(target.data('name'));
            modal.find('#readmeContent').html(target.data('readme'));
        });
    });
</script>
";
    }

    // line 48
    public function block_main($context, array $blocks = array())
    {
        // line 49
        echo "    <div class=\"row\">
        <div class=\"col-md-12\">
            <div class=\"box\">
                <div class=\"box-header\">
                    <a href=\"";
        // line 53
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_store_plugin_owners_install");
        echo "\" class=\"btn btn-info btn-xs pull-right\">プラグインの新規追加はこちら</a>
                    <h3 class=\"box-title\">オーナーズストアプラグイン</h3>
                </div><!-- /.box-header -->
                <div class=\"box-body\">
                    ";
        // line 57
        echo twig_include($this->env, $context, "Store/plugin_table.twig", array("Plugins" => ($context["officialPlugins"] ?? null)));
        echo "
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <div class=\"box\">
                <div class=\"box-header\">
                    <a href=\"";
        // line 63
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_store_plugin_install");
        echo "\" class=\"btn btn-info btn-xs pull-right\">プラグインのアップロードはこちら</a>
                    <h3 class=\"box-title\">独自プラグイン</h3>
                </div><!-- /.box-header -->
                <div class=\"box-body\">
                    ";
        // line 67
        echo twig_include($this->env, $context, "Store/plugin_table.twig", array("Plugins" => ($context["unofficialPlugins"] ?? null)));
        echo "
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            ";
        // line 70
        if ( !twig_test_empty(($context["unregisterdPlugins"] ?? null))) {
            // line 71
            echo "            <div class=\"box\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">未登録プラグイン</h3>
                </div><!-- /.box-header -->
                <div class=\"box-body\">
                    ";
            // line 76
            echo twig_include($this->env, $context, "Store/unregisterd_plugin_table.twig", array("Plugins" => ($context["unregisterdPlugins"] ?? null)));
            echo "
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            ";
        }
        // line 80
        echo "        </div><!-- /.col -->
    </div>
";
    }

    // line 83
    public function block_modal($context, array $blocks = array())
    {
        // line 84
        echo "<div class=\"modal fade\" id=\"readmeModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"readmeModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><svg class=\"cb cb-close\" aria-hidden=\"true\"><use xlink:href=\"#cb-close\"></svg></button>
                <h4 class=\"modal-title\" id=\"readmeModalLabel\">";
        // line 89
        echo "</h4>
            </div>
            <div class=\"modal-body\">
                <div class=\"form-group\" id=\"readmeContent\">
                    ";
        // line 94
        echo "                </div>
            </div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__b41e70a7f7b7d517373d076b2e3014975237483dfee791b607824b53fe57df99";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  145 => 94,  139 => 89,  132 => 84,  129 => 83,  123 => 80,  116 => 76,  109 => 71,  107 => 70,  101 => 67,  94 => 63,  85 => 57,  78 => 53,  72 => 49,  69 => 48,  50 => 31,  47 => 30,  41 => 28,  35 => 27,  31 => 23,  29 => 25,  11 => 23,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__b41e70a7f7b7d517373d076b2e3014975237483dfee791b607824b53fe57df99", "");
    }
}
