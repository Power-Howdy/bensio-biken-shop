<?php

/* __string_template__4ea8a87d4ce39e75118239a97eff7c1ba77a9aa94ee6f11bc745263aebba6547 */
class __TwigTemplate_8be8877d4e84192b0aef2591edebd072adbb7ee3ca769ddba3288e5e1bfca4c1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__4ea8a87d4ce39e75118239a97eff7c1ba77a9aa94ee6f11bc745263aebba6547", 22);
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
        $context["menus"] = array(0 => "product", 1 => "product_csv_import");
        // line 29
        $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme(($context["form"] ?? null), array(0 => "Form/bootstrap_3_horizontal_layout.html.twig"));
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    public function block_title($context, array $blocks = array())
    {
        echo "商品管理";
    }

    // line 27
    public function block_sub_title($context, array $blocks = array())
    {
        echo "商品登録CSVアップロード";
    }

    // line 31
    public function block_javascript($context, array $blocks = array())
    {
        // line 32
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/spin.min.js\"></script>
<script>
\$(function() {

    var opts = {
        lines: 13,
        length: 30,
        width: 2,
        radius: 12,
        corners: 1,
        rotate: 0,
        direction: 1,
        color: '#BBB',
        speed: 1,
        trail: 67,
        shadow: true,
        hwaccel: false,
        className: 'spinner',
        zIndex: 2e9,
        top: top
    };

    ImageSpinner = new Spinner(opts).spin(document.getElementById('spinner'));
    ImageSpinner.stop();

    \$('#upload-form').submit(function() {
        \$('#upload-button').attr('disabled', 'disabled');
        \$('#download-button').attr('disabled', 'disabled');
        ImageSpinner.spin(document.getElementById('spinner'));
    });
});
</script>
";
    }

    // line 66
    public function block_main($context, array $blocks = array())
    {
        // line 67
        echo "<div id=\"upload_wrap\" class=\"row\">
    <div id=\"upload_file_box\" class=\"col-md-12\">
        <form id=\"upload-form\" class=\"form-inline\" method=\"post\" action=\"";
        // line 69
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_product_csv_import");
        echo "\" ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'enctype');
        echo ">
            ";
        // line 70
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", array()), 'widget');
        echo "
            <div id=\"upload_file_box__body\" class=\"box\">
                <div id=\"upload_file_box__header\" class=\"box-header\">
                    <h3 class=\"box-title\">商品登録CSV</h3>
                </div><!-- /.box-header -->
                <div id=\"upload_file_box__body_inner\" class=\"box-body\">
                    <div id=\"upload_file_box__upload_box\" class=\"form-group\">
                        <label class=\"col-sm-5 control-label\">CSVファイル選択</label>
                        <div id=\"upload_file_box__import_file\" class=\"col-sm-7\">
                            ";
        // line 79
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "import_file", array()), 'widget', array("attr" => array("accept" => "text/csv,text/tsv")));
        echo "
                            ";
        // line 80
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "import_file", array()), 'errors');
        echo "
                        </div>
                        ";
        // line 82
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
            // line 83
            echo "                            <div id=\"upload_file_box__upload_error\" class=\"text-danger\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["error"], "message", array()), "html", null, true);
            echo "</div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 85
        echo "                    </div>
                    <div id=\"spinner\"></div>
                </div><!-- /.box-body -->
                <div id=\"button_box__upload_button\" class=\"box-footer text-center\">
                    <button id=\"upload-button\" type=\"submit\" class=\"btn btn-primary btn-sm\">CSVファイルのアップロード</button>
                </div><!-- /.box-footer -->
            </div><!-- /.box -->
        </form>
    </div><!-- /.col -->
</div>

<div id=\"file_format\" class=\"row\">
    <div id=\"file_format_box\" class=\"col-md-12\">
        <div id=\"file_format_box__body\" class=\"box\">
            <div id=\"file_format_box__head\" class=\"box-header\">
                <a href=\"";
        // line 100
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_product_csv_template", array("type" => "product"));
        echo "\" id=\"download-button\" class=\"btn btn-default pull-right btn-xs\">雛形ファイルダウンロード</a>
                <h3 class=\"box-title\">商品登録CSVファイルフォーマット</h3>
            </div><!-- /.box-header -->
            <div id=\"file_format_box__body_inner\" class=\"box-body no-padding\">
                <div id=\"file_format_box__list_box\" class=\"table_list\">
                    <div id=\"file_format_box__list_box_body\" class=\"table-responsive no-border table-menu table-responsive-overflow\">
                        <table class=\"table table-striped\">
                            <thead>
                                <tr id=\"file_format_box__header\" class=\"text-nowrap\">
                                    ";
        // line 109
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_array_keys_filter(($context["headers"] ?? null)));
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
        foreach ($context['_seq'] as $context["_key"] => $context["header"]) {
            // line 110
            echo "                                        <th id=\"file_format_box__header--";
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["header"], "html", null, true);
            echo "</th>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['header'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 112
        echo "                                </tr>
                            </thead>
                            <tbody>
                                <tr id=\"file_format_box__list\" class=\"text-nowrap\">
                                    <td id=\"file_format_box__id\">新規登録時は未設定<br>既存商品の更新は商品IDを設定</td>
                                    <td id=\"file_format_box__status\">必須</td>
                                    <td id=\"file_format_box__name\">必須</td>
                                    <td id=\"file_format_box__shop_memo\"></td>
                                    <td id=\"file_format_box__info\"></td>
                                    <td id=\"file_format_box__detail\"></td>
                                    <td id=\"file_format_box__search_word\"></td>
                                    <td id=\"file_format_box__free\"></td>
                                    <td id=\"file_format_box__delete_flg\">設定されていない場合<br>0を登録</td>
                                    <td id=\"file_format_box__image\">複数画像の場合<br>画像ファイル名をカンマ区切りで<br>「\"」で囲んで設定</td>
                                    <td id=\"file_format_box__category\">複数カテゴリの場合<br>商品カテゴリIDをカンマ区切りで<br>「\"」で囲んで設定</td>
                                    <td id=\"file_format_box__tag\">複数タグの場合<br>タグIDをカンマ区切りで<br>「\"」で囲んで設定</td>
                                    <td id=\"file_format_box__type_id\">必須</td>
                                    <td id=\"file_format_box__class_1\"></td>
                                    <td id=\"file_format_box__class_2\"></td>
                                    <td id=\"file_format_box__date\"></td>
                                    <td id=\"file_format_box__code\"></td>
                                    <td id=\"file_format_box__stock\">在庫数無制限フラグが0の場合<br>0以上の数値を設定</td>
                                    <td id=\"file_format_box__stock_nolimit_flg\">必須</td>
                                    <td id=\"file_format_box__limit\">0以上の数値を設定</td>
                                    <td id=\"file_format_box__price_2\">0以上の数値を設定</td>
                                    <td id=\"file_format_box__price_1\">必須<br>0以上の数値を設定</td>
                                    <td id=\"file_format_box__delivery_fee\">商品ごとの送料設定が有効の場合<br>0以上の数値を設定</td>
                                    <td id=\"file_format_box__category_delete_flg\">設定されていない場合<br>0を登録</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div>

";
    }

    public function getTemplateName()
    {
        return "__string_template__4ea8a87d4ce39e75118239a97eff7c1ba77a9aa94ee6f11bc745263aebba6547";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  201 => 112,  182 => 110,  165 => 109,  153 => 100,  136 => 85,  127 => 83,  123 => 82,  118 => 80,  114 => 79,  102 => 70,  96 => 69,  92 => 67,  89 => 66,  51 => 32,  48 => 31,  42 => 27,  36 => 26,  32 => 22,  30 => 29,  28 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__4ea8a87d4ce39e75118239a97eff7c1ba77a9aa94ee6f11bc745263aebba6547", "");
    }
}
