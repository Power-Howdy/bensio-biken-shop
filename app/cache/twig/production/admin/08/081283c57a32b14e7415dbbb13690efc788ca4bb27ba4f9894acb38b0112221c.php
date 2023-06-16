<?php

/* __string_template__49813e665a044aff1f01657c0ee5a3ff86b4ff6636e29981c5189556ecc50d66 */
class __TwigTemplate_c030c47437eb5d5b6e989da73f891b0d2324044914fe7c592850ccfbb5ad2141 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 17
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__49813e665a044aff1f01657c0ee5a3ff86b4ff6636e29981c5189556ecc50d66", 17);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'sub_title' => array($this, 'block_sub_title'),
            'stylesheet' => array($this, 'block_stylesheet'),
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
        // line 19
        $context["menus"] = array(0 => "product", 1 => "product_edit");
        // line 24
        $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme(($context["form"] ?? null), array(0 => "Form/bootstrap_3_horizontal_layout.html.twig"));
        // line 17
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 21
    public function block_title($context, array $blocks = array())
    {
        echo "商品管理";
    }

    // line 22
    public function block_sub_title($context, array $blocks = array())
    {
        echo "商品登録";
    }

    // line 26
    public function block_stylesheet($context, array $blocks = array())
    {
        // line 27
        echo "<link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/css/fileupload/jquery.fileupload.css\">
<link rel=\"stylesheet\" href=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/css/fileupload/jquery.fileupload-ui.css\">
<link rel=\"stylesheet\" href=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css\">
<style>
    .ui-state-highlight {
        height: 148px;
        border: dashed 1px #ccc;
        background: #fff;
    }
</style>
";
    }

    // line 39
    public function block_javascript($context, array $blocks = array())
    {
        // line 40
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/fileupload/vendor/jquery.ui.widget.js\"></script>
<script src=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/fileupload/jquery.iframe-transport.js\"></script>
<script src=\"";
        // line 42
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/fileupload/jquery.fileupload.js\"></script>
<script src=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/fileupload/jquery.fileupload-process.js\"></script>
<script src=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/js/vendor/fileupload/jquery.fileupload-validate.js\"></script>
<script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js\"></script>
<script>
\$(function() {
    \$(\"#thumb\").sortable({
        cursor: 'move',
        opacity: 0.7,
        placeholder: 'ui-state-highlight',
        update: function (event, ui) {
            updateRank();
        }
    });
    ";
        // line 56
        if ((($context["has_class"] ?? null) == false)) {
            // line 57
            echo "    if (\$(\"#";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock_unlimited", array()), "vars", array()), "id", array()), "html", null, true);
            echo "\").prop(\"checked\")) {
        \$(\"#";
            // line 58
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock", array()), "vars", array()), "id", array()), "html", null, true);
            echo "\").attr(\"disabled\", \"disabled\").val('');
    } else {
        \$(\"#";
            // line 60
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock", array()), "vars", array()), "id", array()), "html", null, true);
            echo "\").removeAttr(\"disabled\");
    }
    \$(\"#";
            // line 62
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock_unlimited", array()), "vars", array()), "id", array()), "html", null, true);
            echo "\").on(\"click change\", function () {
        if (\$(this).prop(\"checked\")) {
            \$(\"#";
            // line 64
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock", array()), "vars", array()), "id", array()), "html", null, true);
            echo "\").attr(\"disabled\", \"disabled\").val('');
        } else {
            \$(\"#";
            // line 66
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock", array()), "vars", array()), "id", array()), "html", null, true);
            echo "\").removeAttr(\"disabled\");
        }
    });
    ";
        }
        // line 70
        echo "    var proto_img = ''
            + '<li class=\"ui-state-default\">'
            + '<img src=\"__path__\" />'
            + '<a class=\"delete-image\">'
            + '<svg class=\"cb cb-close\">'
            + '<use xmlns:xlink=\"http://www.w3.org/1999/xlink\" xlink:href=\"#cb-close\"></use>'
            + '</svg>'
            + '</a>'
            + '</li>';
    var proto_add = '";
        // line 79
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "add_images", array()), "vars", array()), "prototype", array()), 'widget');
        echo "';
    var proto_del = '";
        // line 80
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "delete_images", array()), "vars", array()), "prototype", array()), 'widget');
        echo "';
    ";
        // line 81
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "images", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
            // line 82
            echo "    var \$img = \$(proto_img.replace(/__path__/g, '";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["image"], "vars", array()), "value", array()), "html", null, true);
            echo "'));
    var \$widget = \$('";
            // line 83
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["image"], 'widget');
            echo "');
    \$widget.val('";
            // line 84
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["image"], "vars", array()), "value", array()), "html", null, true);
            echo "');
    \$(\"#thumb\").append(\$img.append(\$widget));
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['image'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 87
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "add_images", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["add_image"]) {
            // line 88
            echo "    var \$img = \$(proto_img.replace(/__path__/g, '";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_temp_urlpath", array()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["add_image"], "vars", array()), "value", array()), "html", null, true);
            echo "'));
    var \$widget = \$('";
            // line 89
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["add_image"], 'widget');
            echo "');
    \$widget.val('";
            // line 90
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["add_image"], "vars", array()), "value", array()), "html", null, true);
            echo "');
    \$(\"#thumb\").append(\$img.append(\$widget));
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['add_image'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 93
        echo "    ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "delete_images", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["delete_image"]) {
            // line 94
            echo "    \$(\"#thumb\").append('";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["delete_image"], 'widget');
            echo "');
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['delete_image'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 96
        echo "    var hideSvg = function () {
        if (\$(\"#thumb li\").length > 0) {
            \$(\"#icon_no_image\").css(\"display\", \"none\");
        } else {
            \$(\"#icon_no_image\").css(\"display\", \"\");
        }
    };
    var updateRank = function () {
        \$(\"#thumb li\").each(function (index) {
            \$(this).find(\".rank_images\").remove();
            filename = \$(this).find(\"input[type='hidden']\").val();
            \$rank = \$('<input type=\"hidden\" class=\"rank_images\" name=\"rank_images[]\" />');
            \$rank.val(filename + '//' + parseInt(index + 1));
            \$(this).append(\$rank);
        });
    }
    hideSvg();
    updateRank();
    // 画像削除時
    var count_del = 0;
    \$(\"#thumb\").on(\"click\", \".delete-image\", function () {
        var \$new_delete_image = \$(proto_del.replace(/__name__/g, count_del));
        var src = \$(this).prev().attr('src')
                .replace('";
        // line 119
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_temp_urlpath", array()), "html", null, true);
        echo "/', '')
                .replace('";
        // line 120
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_save_urlpath", array()), "html", null, true);
        echo "/', '');
        \$new_delete_image.val(src);
        \$(\"#thumb\").append(\$new_delete_image);
        \$(this).parent(\"li\").remove();
        hideSvg();
        updateRank();
        count_del++;
    });
    var count_add = ";
        // line 128
        echo twig_escape_filter($this->env, _twig_default_filter(twig_length_filter($this->env, $this->getAttribute(($context["form"] ?? null), "add_images", array())), 0), "html", null, true);
        echo ";
    \$('#";
        // line 129
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "product_image", array()), "vars", array()), "id", array()), "html", null, true);
        echo "').fileupload({
        url: \"";
        // line 130
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_product_image_add");
        echo "\",
        type: \"post\",
        sequentialUploads: true,
        dataType: 'json',
        done: function (e, data) {
            \$('#progress').hide();
            \$.each(data.result.files, function (index, file) {
                var path = '";
        // line 137
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "image_temp_urlpath", array()), "html", null, true);
        echo "/' + file;
                var \$img = \$(proto_img.replace(/__path__/g, path));
                var \$new_img = \$(proto_add.replace(/__name__/g, count_add));
                \$new_img.val(file);
                \$child = \$img.append(\$new_img);
                \$('#thumb').append(\$child);
                count_add++;
            });
            hideSvg();
            updateRank();
        },
        fail: function (e, data) {
            alert('アップロードに失敗しました。');
        },
        always: function (e, data) {
            \$('#progress').hide();
            \$('#progress .progress-bar').width('0%');
        },
        start: function (e, data) {
            \$('#progress').show();
        },
        acceptFileTypes: /(\\.|\\/)(gif|jpe?g|png)\$/i,
        maxFileSize: 10000000,
        maxNumberOfFiles: 10,
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            \$('#progress .progress-bar').css(
                    'width',
                    progress + '%'
            );
        },
        processalways: function (e, data) {
            if (data.files.error) {
                alert(\"画像ファイルサイズが大きいか画像ファイルではありません。\");
            }
        }
    });
    // 画像アップロード
    \$('#file_upload').on('click', function () {
        \$('#";
        // line 176
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "product_image", array()), "vars", array()), "id", array()), "html", null, true);
        echo "').click();
    });
});

function fnClass(action) {
    document.form1.action = action;
    document.form1.submit();
    return false;
}

</script>
";
    }

    // line 189
    public function block_main($context, array $blocks = array())
    {
        echo "<script>
    \$(function(){
        \$('#free_box').after(\$('#free_description_box'));
    });
</script>
<script>
    // 初期表示
    \$(function() {
        disableFreeDescriptionInfo();
        // 販売種別変更時に、定期サイクルフォームの使用可、不可を設定
        \$(\"#admin_product_class_product_type\").change(function(){
            var selectedSaleTypeId = \$(this).val();
            console.log(selectedSaleTypeId);
            // 定期サイクルフォームを表示非表示にする
            if (selectedSaleTypeId != ";
        // line 203
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "product_type_normal", array()), "html", null, true);
        echo "
                && selectedSaleTypeId != ";
        // line 204
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "product_type_download", array()), "html", null, true);
        echo ") {
                // 表示可能
                \$(\"#free_description_box\").show();
                \$(\"#free_description_box\").show();
            } else {
                // データクリアかつ表示不可
                \$(\"#admin_product_free_description_quantity\").val('');
                \$(\"#admin_product_free_description_selling_price\").val('');
                \$(\"#admin_product_free_description_payment_delivery\").val('');
                \$(\"#free_description_box\").hide();
                \$(\"#free_description_box\").hide();
            }
        });
    });


    function disableFreeDescriptionInfo() {
        var isRegularProduct = '";
        // line 221
        echo twig_escape_filter($this->env, ($context["regular_product_type"] ?? null), "html", null, true);
        echo "';
        // 定期サイクルフォームを表示非表示にする
        if (isRegularProduct) {
            // 表示可能
            \$(\"#free_description_box\").show();
            \$(\"#free_description_box\").show();
        } else {
            // データクリアかつ表示不可
            \$(\"#admin_product_free_description_quantity\").val('');
            \$(\"#admin_product_free_description_selling_price\").val('');
            \$(\"#admin_product_free_description_payment_delivery\").val('');
            \$(\"#free_description_box\").val('').hide();
            \$(\"#free_description_box\").val('').hide();
        }
    }
</script>

<div style=\"display: none;\">
    <div id=\"free_description_box\" class=\"box accordion form-horizontal\">
        <div  id=\"free_description_box__toggle\" class=\"box-header toggle\">
            <h3 class=\"box-title\">特定商法取引に関する項目 <svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
        </div><!-- /.box-header -->
        <div id=\"free_description_box__body\" class=\"box-body accpanel\">
            <div id=\"free_description_list__quantity\" class=\"form-group\">
                ";
        // line 245
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_quantity", array()), 'label');
        echo "
                <div class=\"col-sm-9 col-lg-10\">
                    ";
        // line 247
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_quantity", array()), 'widget', array("attr" => array("placeholder" => "入力例）購入者が定期購入を解除した場合、または商品販売が終了するまで自動継続")));
        echo "
                    ";
        // line 248
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_quantity", array()), 'errors');
        echo "
                </div>
            </div>
            <div id=\"free_description_list__price\" class=\"form-group\">
                ";
        // line 252
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_selling_price", array()), 'label');
        echo "
                <div class=\"col-sm-9 col-lg-10\">
                    ";
        // line 254
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_selling_price", array()), 'widget', array("attr" => array("placeholder" => "入力例）購入者が定期購入を解除した場合、または商品販売が終了するまで自動継続")));
        echo "
                    ";
        // line 255
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_selling_price", array()), 'errors');
        echo "
                </div>
            </div>
            <div id=\"free_description_list__payment_delivery\" class=\"form-group\">
                ";
        // line 259
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_payment_delivery", array()), 'label');
        echo "
                <div class=\"col-sm-9 col-lg-10\">
                    ";
        // line 261
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_payment_delivery", array()), 'widget', array("attr" => array("placeholder" => "入力例）購入者が定期購入を解除した場合、または商品販売が終了するまで自動継続
お支払い日から●日以内にお届けします")));
        echo "
                    ";
        // line 262
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_description_payment_delivery", array()), 'errors');
        echo "
                </div>
            </div>
        </div>
    </div>
</div>

        <div class=\"row\" id=\"aside_wrap\">
            <form role=\"form\" name=\"form1\" id=\"form1\" method=\"post\" action=\"\" novalidate enctype=\"multipart/form-data\">
            ";
        // line 271
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", array()), 'widget');
        echo "
                <div id=\"detail_wrap\" class=\"col-md-9\">
                    <div id=\"detail_box\" class=\"box form-horizontal\">
                        <div id=\"detail_box__header\" class=\"box-header\">
                            <h3 class=\"box-title\">基本情報</h3>
                        </div><!-- /.box-header -->
                        <div id=\"detail_box__body\" class=\"box-body\">

                            ";
        // line 280
        echo "                            ";
        if ($this->getAttribute(($context["Product"] ?? null), "id", array())) {
            // line 281
            echo "                                <div id=\"detail_box__id\" class=\"form-group\">
                                    <label class=\"col-sm-3 col-lg-2 control-label\">商品ID</label>
                                    <div class=\"col-sm-9 col-lg-10 padT07\">";
            // line 283
            echo twig_escape_filter($this->env, $this->getAttribute(($context["Product"] ?? null), "id", array()), "html", null, true);
            echo "</div>
                                </div>
                            ";
        }
        // line 286
        echo "

                            ";
        // line 288
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "name", array()), 'row');
        echo "
                            ";
        // line 289
        if ((($context["has_class"] ?? null) == false)) {
            // line 290
            echo "                                ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "product_type", array()), 'row', array("attr" => array("class" => "form-inline  padT07")));
            echo "
                            ";
        }
        // line 292
        echo "
                            <div id=\"detail_box__image\" class=\"form-group\">
                                <label class=\"col-sm-2 control-label\" for=\"admin_product_product_image\">
                                    ";
        // line 295
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "product_image", array()), "vars", array()), "label", array()), "html", null, true);
        echo "<br>
                                    <span class=\"small\">620px以上推奨</span>
                                </label>
                                <div id=\"detail_files_box\" class=\"col-sm-9 col-lg-10\">
                                    <div class=\"photo_files\" id=\"drag-drop-area\">
                                        <svg id=\"icon_no_image\" class=\"cb cb-photo no-image\"> <use xmlns:xlink=\"http://www.w3.org/1999/xlink\" xlink:href=\"#cb-photo\"></use></svg>
                                        <ul id=\"thumb\" class=\"clearfix\"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group marB30\">
                                <div id=\"detail_box__file_upload\" class=\"col-sm-offset-2 col-sm-9 col-lg-10 \">

                                    <div id=\"progress\" class=\"progress progress-striped active\" style=\"display:none;\">
                                        <div class=\"progress-bar progress-bar-info\"></div>
                                    </div>

                                    ";
        // line 312
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "product_image", array()), 'widget', array("attr" => array("accept" => "image/*", "style" => "display:none;")));
        echo "
                                    ";
        // line 313
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "product_image", array()), 'errors');
        echo "
                                    <a id=\"file_upload\" class=\"with-icon\">
                                        <svg class=\"cb cb-plus\"> <use xlink:href=\"#cb-plus\" /></svg>ファイルをアップロード
                                    </a>

                                </div>
                            </div>

                            <div id=\"detail_description_box\" class=\"form-group\">
                                ";
        // line 322
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "description_detail", array()), 'label');
        echo "
                                <div id=\"detail_description_box__detail\" class=\"col-sm-9 col-lg-10\">
                                    ";
        // line 324
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "description_detail", array()), 'widget');
        echo "
                                    ";
        // line 325
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "description_detail", array()), 'errors');
        echo "
                                    <div id=\"detail_description_box__list\" class=\"accordion marT15 marB20\"><a id=\"detail_description_box__list_toggle\" class=\"toggle with-icon\"><svg class=\"cb cb-plus icon_plus\"> <use xlink:href=\"#cb-plus\" /></svg>一覧コメントを追加</a>
                                        <div class=\"accpanel padT08\">
                                            ";
        // line 328
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "description_list", array()), 'widget');
        echo "
                                            ";
        // line 329
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "description_list", array()), 'errors');
        echo "
                                        </div>
                                    </div>
                                </div>
                            </div>

                            ";
        // line 335
        if ((($context["has_class"] ?? null) == false)) {
            // line 336
            echo "                            <div id=\"detail_box__price\" class=\"form-group\">
                                ";
            // line 337
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "price02", array()), 'label');
            echo "
                                <div id=\"detail_box__price02\" class=\"col-sm-3 col-lg-3\">
                                    ";
            // line 339
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "price02", array()), 'widget');
            echo "
                                    ";
            // line 340
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "price02", array()), 'errors');
            echo "
                                    <div id=\"detail_box__price01\" class=\"accordion marT15 marB20\"><a class=\"toggle with-icon\"><svg class=\"cb cb-plus icon_plus\"> <use xlink:href=\"#cb-plus\" /></svg>通常価格を追加</a>
                                        <div class=\"accpanel padT08\">
                                            ";
            // line 343
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "price01", array()), 'widget');
            echo "
                                            ";
            // line 344
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "price01", array()), 'errors');
            echo "
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id=\"detail_box__stock\" class=\"form-group\">
                                ";
            // line 351
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    <div class=\"row\">
                                        <div id=\"detail_box__unlimited\" class=\"col-xs-12 form-inline\">
                                            ";
            // line 355
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock", array()), 'widget');
            echo "
                                            ";
            // line 356
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock", array()), 'errors');
            echo "
                                            ";
            // line 357
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock_unlimited", array()), 'widget');
            echo "
                                            ";
            // line 358
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "stock_unlimited", array()), 'errors');
            echo "
                                        </div>
                                    </div>

                                </div>
                            </div>
                            ";
        }
        // line 365
        echo "
                            <div id=\"detail_category_box\" class=\"form-group\">
                                ";
        // line 367
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Category", array()), 'label');
        echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    <div class=\"accordion marT05\">
                                        <a id=\"detail_category_box__toggle\" class=\"toggle with-icon\"><svg class=\"cb cb-plus icon_plus\"> <use xlink:href=\"#cb-plus\" /></svg>カテゴリを選択</a>
                                        <div id=\"detail_category_box__list\" class=\"accpanel padT08";
        // line 371
        if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "Category", array()), "vars", array()), "valid", array()) == false)) {
            echo " has-error";
        }
        echo "\">
                                            ";
        // line 372
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Category", array()), 'widget');
        echo "
                                            ";
        // line 373
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Category", array()), 'errors');
        echo "
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id=\"detail_tag_box\" class=\"form-group\">
                                ";
        // line 380
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Tag", array()), 'label');
        echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    <div class=\"accordion marT05\">
                                        <a id=\"detail_tags_box__toggle\" class=\"toggle with-icon\"><svg class=\"cb cb-plus icon_plus\"> <use xlink:href=\"#cb-plus\" /></svg>";
        // line 383
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Tag"), "html", null, true);
        echo "を選択</a>
                                        <div id=\"detail_tags_box__list\" class=\"accpanel padT08\">
                                            ";
        // line 385
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Tag", array()), 'widget');
        echo "
                                            ";
        // line 386
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Tag", array()), 'errors');
        echo "
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=\"extra-form\">
                                ";
        // line 393
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "getIterator", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
            // line 394
            echo "                                    ";
            if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                // line 395
                echo "                                        ";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'row');
                echo "
                                    ";
            }
            // line 397
            echo "                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 398
        echo "                            </div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <div id=\"sub_detail_box\" class=\"box accordion form-horizontal\">
                        <div  id=\"sub_detail_box__toggle\" class=\"box-header toggle\">
                            <h3 class=\"box-title\">詳細な設定<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                        </div><!-- /.box-header -->
                        <div id=\"sub_detail_box__body\" class=\"box-body accpanel\">

                            ";
        // line 409
        if ((($context["has_class"] ?? null) == false)) {
            // line 410
            echo "                                ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "code", array()), 'row');
            echo "
                                ";
            // line 411
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "sale_limit", array()), 'row');
            echo "
                            ";
        }
        // line 413
        echo "
                            ";
        // line 414
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "search_word", array()), 'row');
        echo "
                            ";
        // line 415
        if ((($context["has_class"] ?? null) == false)) {
            // line 416
            echo "                                ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "delivery_date", array()), 'row');
            echo "
                                ";
            // line 417
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "option_product_delivery_fee", array())) {
                // line 418
                echo "                                <div id=\"sub_detail_box__delivery_fee\" class=\"form-group\">
                                    ";
                // line 419
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "delivery_fee", array()), 'label');
                echo "
                                    <div class=\"col-sm-3 col-lg-3\">
                                        ";
                // line 421
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "delivery_fee", array()), 'widget');
                echo "
                                        ";
                // line 422
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "delivery_fee", array()), 'errors');
                echo "
                                    </div>
                                </div>
                                ";
            }
            // line 426
            echo "                                ";
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "option_product_tax_rule", array())) {
                // line 427
                echo "                                <div id=\"sub_detail_box__tax_rate\" class=\"form-group\">
                                    ";
                // line 428
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "tax_rate", array()), 'label');
                echo "
                                    <div class=\"col-sm-3 col-lg-3\">
                                        ";
                // line 430
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "tax_rate", array()), 'widget');
                echo "
                                        ";
                // line 431
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "class", array()), "tax_rate", array()), 'errors');
                echo "
                                    </div>
                                </div>
                                ";
            }
            // line 435
            echo "                            ";
        }
        // line 436
        echo "
                        </div>
                    </div>

                    <div id=\"free_box\" class=\"box accordion\">
                        <div id=\"free_box__body_toggle\" class=\"box-header toggle\">
                            <h3 class=\"box-title\">フリーエリア<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                        </div><!-- /.box-header -->
                        <div id=\"free_box__body\" class=\"box-body accpanel\">
                            ";
        // line 445
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_area", array()), 'widget', array("id" => "wysiwyg-area"));
        echo "
                            ";
        // line 446
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "free_area", array()), 'errors');
        echo "
                        </div>
                    </div>

                    <div id=\"video_box\" class=\"box accordion form-horizontal\">
                        <div id=\"video_box__body_toggle\" class=\"box-header toggle\">
                            <h3 class=\"box-title\">動画<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                        </div><!-- /.box-header -->
                        <div id=\"video_box__body\" class=\"box-body accpanel\">
\t\t\t\t\t\t\t";
        // line 455
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_comment", array()), 'row');
        echo "
\t\t\t\t\t\t\t";
        // line 456
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_file", array()), 'row');
        echo "
\t\t\t\t\t\t\t<div style=\"margin:-10px 0 10px 0;width:80%;float:right;\">
\t\t\t\t\t\t\t\tビデオテキスト：コンテンツ管理＞ファイル管理 [videotext]フォルダの[表示]をクリックしてファイルをアップロードし、アップロードしたファイル名を入力する。
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div style=\"clear:both;\"></div>
\t\t\t\t\t\t\t";
        // line 461
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_userid", array()), 'row');
        echo "
\t\t\t\t\t\t\t";
        // line 462
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_userpass", array()), 'row');
        echo "
\t\t\t\t\t\t\t<div style=\"margin:20px 0 10px 0;clear:both;\">
\t\t\t\t\t\t\t\t動画のID：https://player.vimeo.com/video/<font color=\"#FF0000\">*********</font>　<span style=\"color: #909;\">入力例)&nbsp;&nbsp;136554876</span><br />
\t\t\t\t\t\t\t</div>
                            ";
        // line 466
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url1", array()), 'row');
        echo "
                            ";
        // line 467
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title1", array()), 'row');
        echo "
                            ";
        // line 468
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text1", array()), 'row');
        echo "
                            ";
        // line 469
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url2", array()), 'row');
        echo "
                            ";
        // line 470
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title2", array()), 'row');
        echo "
                            ";
        // line 471
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text2", array()), 'row');
        echo "
                            ";
        // line 472
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url3", array()), 'row');
        echo "
                            ";
        // line 473
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title3", array()), 'row');
        echo "
                            ";
        // line 474
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text3", array()), 'row');
        echo "
                            ";
        // line 475
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url4", array()), 'row');
        echo "
                            ";
        // line 476
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title4", array()), 'row');
        echo "
                            ";
        // line 477
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text4", array()), 'row');
        echo "
                            ";
        // line 478
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url5", array()), 'row');
        echo "
                            ";
        // line 479
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title5", array()), 'row');
        echo "
                            ";
        // line 480
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text5", array()), 'row');
        echo "
                            ";
        // line 481
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url6", array()), 'row');
        echo "
                            ";
        // line 482
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title6", array()), 'row');
        echo "
                            ";
        // line 483
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text6", array()), 'row');
        echo "
                            ";
        // line 484
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url7", array()), 'row');
        echo "
                            ";
        // line 485
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title7", array()), 'row');
        echo "
                            ";
        // line 486
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text7", array()), 'row');
        echo "
                            ";
        // line 487
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url8", array()), 'row');
        echo "
                            ";
        // line 488
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title8", array()), 'row');
        echo "
                            ";
        // line 489
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text8", array()), 'row');
        echo "
                            ";
        // line 490
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url9", array()), 'row');
        echo "
                            ";
        // line 491
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title9", array()), 'row');
        echo "
                            ";
        // line 492
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text9", array()), 'row');
        echo "
                            ";
        // line 493
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url10", array()), 'row');
        echo "
                            ";
        // line 494
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title10", array()), 'row');
        echo "
                            ";
        // line 495
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text10", array()), 'row');
        echo "
                            ";
        // line 496
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url11", array()), 'row');
        echo "
                            ";
        // line 497
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title11", array()), 'row');
        echo "
                            ";
        // line 498
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text11", array()), 'row');
        echo "
                            ";
        // line 499
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url12", array()), 'row');
        echo "
                            ";
        // line 500
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title12", array()), 'row');
        echo "
                            ";
        // line 501
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text12", array()), 'row');
        echo "
                            ";
        // line 502
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url13", array()), 'row');
        echo "
                            ";
        // line 503
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title13", array()), 'row');
        echo "
                            ";
        // line 504
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text13", array()), 'row');
        echo "
                            ";
        // line 505
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url14", array()), 'row');
        echo "
                            ";
        // line 506
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title14", array()), 'row');
        echo "
                            ";
        // line 507
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text14", array()), 'row');
        echo "
                            ";
        // line 508
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url15", array()), 'row');
        echo "
                            ";
        // line 509
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title15", array()), 'row');
        echo "
                            ";
        // line 510
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text15", array()), 'row');
        echo "
                            ";
        // line 511
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url16", array()), 'row');
        echo "
                            ";
        // line 512
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title16", array()), 'row');
        echo "
                            ";
        // line 513
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text16", array()), 'row');
        echo "
                            ";
        // line 514
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url17", array()), 'row');
        echo "
                            ";
        // line 515
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title17", array()), 'row');
        echo "
                            ";
        // line 516
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text17", array()), 'row');
        echo "
                            ";
        // line 517
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url18", array()), 'row');
        echo "
                            ";
        // line 518
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title18", array()), 'row');
        echo "
                            ";
        // line 519
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text18", array()), 'row');
        echo "
                            ";
        // line 520
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url19", array()), 'row');
        echo "
                            ";
        // line 521
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title19", array()), 'row');
        echo "
                            ";
        // line 522
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text19", array()), 'row');
        echo "
                            ";
        // line 523
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_url20", array()), 'row');
        echo "
                            ";
        // line 524
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_title20", array()), 'row');
        echo "
                            ";
        // line 525
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "video_text20", array()), 'row');
        echo "
                        </div>
                    </div>

                    <div id=\"detail_box__footer\" class=\"row hidden-xs hidden-sm\">
                        <div class=\"col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 text-center btn_area\">
                            <p><a href=\"";
        // line 531
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_product_page", array("page_no" => (($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array(), "any", false, true), "get", array(0 => "eccube.admin.product.search.page_no"), "method", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array(), "any", false, true), "get", array(0 => "eccube.admin.product.search.page_no"), "method"), "1")) : ("1")))), "html", null, true);
        echo "?resume=1\">検索画面に戻る</a></p>
                        </div>
                    </div>

                </div><!-- /.col -->

                <div class=\"col-md-3\" id=\"aside_column\">
                    <div id=\"common_box\" class=\"col_inner\">
                        <div id=\"common_button_box\" class=\"box no-header\">
                            <div id=\"common_button_box__body\" class=\"box-body\">
                                <div id=\"common_button_box__status\" class=\"row\">
                                    <div class=\"col-xs-12\">
                                        <div class=\"form-group\">
                                            ";
        // line 544
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Status", array()), 'widget');
        echo "
                                            ";
        // line 545
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Status", array()), 'errors');
        echo "
                                        </div>
                                    </div>
                                </div>
                                <div id=\"common_button_box__insert_button\" class=\"row text-center\">
                                    <div class=\"col-sm-6 col-sm-offset-3 col-md-12 col-md-offset-0\">
                                        <button type=\"submit\" class=\"btn btn-primary btn-block btn-lg prevention-btn prevention-mask\" >商品を登録</button>
                                    </div>
                                </div>
                                <div id=\"common_button_box__class_set_button\" class=\"row text-center with-border\">
                                    <div class=\"col-sm-6 col-sm-offset-3 col-md-12 col-md-offset-0\">
                                        ";
        // line 556
        if ((null === ($context["id"] ?? null))) {
            // line 557
            echo "                                            <button class=\"btn btn-default btn-block btn-sm\" disabled>
                                                規格設定
                                            </button>
                                        ";
        } else {
            // line 561
            echo "                                            <button class=\"btn btn-default btn-block btn-sm\" onclick=\"fnClass('";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_product_product_class", array("id" => ($context["id"] ?? null))), "html", null, true);
            echo "');return false;\">
                                                規格設定
                                            </button>
                                        ";
        }
        // line 565
        echo "                                    </div>
                                </div>
                                <div id=\"common_button_box__operation_button\" class=\"row text-center with-border\">
                                    <div class=\"col-sm-6 col-sm-offset-3 col-md-12 col-md-offset-0\">
                                        <ul class=\"col-3\">
                                            ";
        // line 570
        if ((null === ($context["id"] ?? null))) {
            // line 571
            echo "                                                <li>
                                                    <button class=\"btn btn-default btn-block btn-sm\" disabled>
                                                        確認
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class=\"btn btn-default btn-block btn-sm\" disabled>
                                                        複製
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class=\"btn btn-default btn-block btn-sm\" disabled>
                                                        削除
                                                    </button>
                                                </li>
                                            ";
        } else {
            // line 587
            echo "                                                <li>
                                                    <a class=\"btn btn-default btn-block btn-sm\" href=\"";
            // line 588
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_product_product_display", array("id" => ($context["id"] ?? null))), "html", null, true);
            echo "\" target=\"_blank\">
                                                        確認
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class=\"btn btn-default btn-block btn-sm\" href=\"";
            // line 593
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_product_product_copy", array("id" => $this->getAttribute(($context["Product"] ?? null), "id", array()))), "html", null, true);
            echo "\"  ";
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
            echo " data-method=\"post\" data-message=\"この商品情報を複製してもよろしいですか？\">
                                                        複製
                                                    </a>
                                                </li>
                                                <li>
                                                     <a class=\"btn btn-default btn-block btn-sm\" href=\"";
            // line 598
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_product_product_delete", array("id" => $this->getAttribute(($context["Product"] ?? null), "id", array()))), "html", null, true);
            echo "\" ";
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
            echo " data-method=\"delete\" data-message=\"この商品情報を削除してもよろしいですか？\">
                                                        削除
                                                    </a>
                                                </li>
                                            ";
        }
        // line 603
        echo "                                        </ul>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                        <div id=\"common_date_info_box\" class=\"box no-header\">
                            <div id=\"common_date_info_box__body\" class=\"box-body update-area\">
                                <p><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>登録日：";
        // line 611
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getDateFormatFilter($this->getAttribute(($context["Product"] ?? null), "create_date", array())), "html", null, true);
        echo "</p>
                                <p><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>更新日：";
        // line 612
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getDateFormatFilter($this->getAttribute(($context["Product"] ?? null), "update_date", array())), "html", null, true);
        echo "</p>
                            </div>
                        </div><!-- /.box -->

                        <div id=\"common_shop_note_box\" class=\"box\">
                            <div id=\"common_shop_note_box__header\" class=\"box-header\">
                                <h3 class=\"box-title\">ショップ用メモ欄</h3>
                            </div><!-- /.box-header -->
                            <div id=\"common_shop_note_box__body\" class=\"box-body\">
                                ";
        // line 621
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "note", array()), 'widget');
        echo "
                                ";
        // line 622
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "note", array()), 'errors');
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
        return "__string_template__49813e665a044aff1f01657c0ee5a3ff86b4ff6636e29981c5189556ecc50d66";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1226 => 622,  1222 => 621,  1210 => 612,  1206 => 611,  1196 => 603,  1186 => 598,  1176 => 593,  1168 => 588,  1165 => 587,  1147 => 571,  1145 => 570,  1138 => 565,  1130 => 561,  1124 => 557,  1122 => 556,  1108 => 545,  1104 => 544,  1088 => 531,  1079 => 525,  1075 => 524,  1071 => 523,  1067 => 522,  1063 => 521,  1059 => 520,  1055 => 519,  1051 => 518,  1047 => 517,  1043 => 516,  1039 => 515,  1035 => 514,  1031 => 513,  1027 => 512,  1023 => 511,  1019 => 510,  1015 => 509,  1011 => 508,  1007 => 507,  1003 => 506,  999 => 505,  995 => 504,  991 => 503,  987 => 502,  983 => 501,  979 => 500,  975 => 499,  971 => 498,  967 => 497,  963 => 496,  959 => 495,  955 => 494,  951 => 493,  947 => 492,  943 => 491,  939 => 490,  935 => 489,  931 => 488,  927 => 487,  923 => 486,  919 => 485,  915 => 484,  911 => 483,  907 => 482,  903 => 481,  899 => 480,  895 => 479,  891 => 478,  887 => 477,  883 => 476,  879 => 475,  875 => 474,  871 => 473,  867 => 472,  863 => 471,  859 => 470,  855 => 469,  851 => 468,  847 => 467,  843 => 466,  836 => 462,  832 => 461,  824 => 456,  820 => 455,  808 => 446,  804 => 445,  793 => 436,  790 => 435,  783 => 431,  779 => 430,  774 => 428,  771 => 427,  768 => 426,  761 => 422,  757 => 421,  752 => 419,  749 => 418,  747 => 417,  742 => 416,  740 => 415,  736 => 414,  733 => 413,  728 => 411,  723 => 410,  721 => 409,  708 => 398,  702 => 397,  696 => 395,  693 => 394,  689 => 393,  679 => 386,  675 => 385,  670 => 383,  664 => 380,  654 => 373,  650 => 372,  644 => 371,  637 => 367,  633 => 365,  623 => 358,  619 => 357,  615 => 356,  611 => 355,  604 => 351,  594 => 344,  590 => 343,  584 => 340,  580 => 339,  575 => 337,  572 => 336,  570 => 335,  561 => 329,  557 => 328,  551 => 325,  547 => 324,  542 => 322,  530 => 313,  526 => 312,  506 => 295,  501 => 292,  495 => 290,  493 => 289,  489 => 288,  485 => 286,  479 => 283,  475 => 281,  472 => 280,  461 => 271,  449 => 262,  444 => 261,  439 => 259,  432 => 255,  428 => 254,  423 => 252,  416 => 248,  412 => 247,  407 => 245,  380 => 221,  360 => 204,  356 => 203,  338 => 189,  322 => 176,  280 => 137,  270 => 130,  266 => 129,  262 => 128,  251 => 120,  247 => 119,  222 => 96,  213 => 94,  208 => 93,  199 => 90,  195 => 89,  188 => 88,  183 => 87,  174 => 84,  170 => 83,  163 => 82,  159 => 81,  155 => 80,  151 => 79,  140 => 70,  133 => 66,  128 => 64,  123 => 62,  118 => 60,  113 => 58,  108 => 57,  106 => 56,  91 => 44,  87 => 43,  83 => 42,  79 => 41,  74 => 40,  71 => 39,  57 => 28,  52 => 27,  49 => 26,  43 => 22,  37 => 21,  33 => 17,  31 => 24,  29 => 19,  11 => 17,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__49813e665a044aff1f01657c0ee5a3ff86b4ff6636e29981c5189556ecc50d66", "");
    }
}
