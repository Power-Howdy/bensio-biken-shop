<?php

/* __string_template__79361fe5ce2cb56b829f7c49ea308f7f425049742a061e3b6cfc3f65c79c74a9 */
class __TwigTemplate_7c8b8119eec3143a55d31e2d40ff067a85f9ee0252b4a21928624d57ce062185 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__79361fe5ce2cb56b829f7c49ea308f7f425049742a061e3b6cfc3f65c79c74a9", 22);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'sub_title' => array($this, 'block_sub_title'),
            'javascript' => array($this, 'block_javascript'),
            'main' => array($this, 'block_main'),
            '__internal_d76746e7ea9cb80f1e9a0384785669e2c70c425dd6fe9f41f5fbe69b26f621d2' => array($this, 'block___internal_d76746e7ea9cb80f1e9a0384785669e2c70c425dd6fe9f41f5fbe69b26f621d2'),
            '__internal_0810ba0e70a39e972382fa172c0238844db57e4dd9545a4836da96b1eca18333' => array($this, 'block___internal_0810ba0e70a39e972382fa172c0238844db57e4dd9545a4836da96b1eca18333'),
            'modal' => array($this, 'block_modal'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 24
        $context["menus"] = array(0 => "order", 1 => "order_edit");
        // line 29
        $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme(($context["form"] ?? null), array(0 => "Form/bootstrap_3_horizontal_layout.html.twig"));
        // line 30
        $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme(($context["searchCustomerModalForm"] ?? null), array(0 => "Form/bootstrap_3_horizontal_layout.html.twig"));
        // line 31
        $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme(($context["searchProductModalForm"] ?? null), array(0 => "Form/bootstrap_3_horizontal_layout.html.twig"));
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    public function block_title($context, array $blocks = array())
    {
        echo "受注管理";
    }

    // line 27
    public function block_sub_title($context, array $blocks = array())
    {
        echo "受注登録・編集";
    }

    // line 33
    public function block_javascript($context, array $blocks = array())
    {
        // line 34
        echo "<script src=\"//ajaxzip3.github.io/ajaxzip3.js\" charset=\"UTF-8\"></script>
<script>
\$(function() {
    \$('#zip-search').click(function() {
        AjaxZip3.zip2addr('order[zip][zip01]', 'order[zip][zip02]', 'order[address][pref]', 'order[address][addr01]');
    });

    // 注文者情報をコピー
    \$('.copyCustomerToShippingButton').on('click', function() {
        var data = \$(this).data();
        var idx = data.idx;
        \$('#order_Shippings_' + idx + '_name_name01').val(\$('#order_name_name01').val());
        \$('#order_Shippings_' + idx + '_name_name02').val(\$('#order_name_name02').val());
        \$('#order_Shippings_' + idx + '_kana_kana01').val(\$('#order_kana_kana01').val());
        \$('#order_Shippings_' + idx + '_kana_kana02').val(\$('#order_kana_kana02').val());
        \$('#order_Shippings_' + idx + '_zip_zip01').val(\$('#order_zip_zip01').val());
        \$('#order_Shippings_' + idx + '_zip_zip02').val(\$('#order_zip_zip02').val());
        \$('#order_Shippings_' + idx + '_address_pref').val(\$('#order_address_pref').val());
        \$('#order_Shippings_' + idx + '_address_addr01').val(\$('#order_address_addr01').val());
        \$('#order_Shippings_' + idx + '_address_addr02').val(\$('#order_address_addr02').val());
        \$('#order_Shippings_' + idx + '_email').val(\$('#order_email').val());
        \$('#order_Shippings_' + idx + '_tel_tel01').val(\$('#order_tel_tel01').val());
        \$('#order_Shippings_' + idx + '_tel_tel02').val(\$('#order_tel_tel02').val());
        \$('#order_Shippings_' + idx + '_tel_tel03').val(\$('#order_tel_tel03').val());
        \$('#order_Shippings_' + idx + '_fax_fax01').val(\$('#order_fax_fax01').val());
        \$('#order_Shippings_' + idx + '_fax_fax02').val(\$('#order_fax_fax02').val());
        \$('#order_Shippings_' + idx + '_fax_fax03').val(\$('#order_fax_fax03').val());
        \$('#order_Shippings_' + idx + '_company_name').val(\$('#order_company_name').val());
    });
    // 会員検索
    \$('#searchCustomerModalButton').on('click', function() {
        var list = \$('#searchCustomerModalList');
        list.children().remove();

        \$.ajax({
            type: 'POST',
            dataType: 'html',
            data: { 'search_word' : \$('#admin_search_customer_multi').val() },
            url: '";
        // line 72
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_order_search_customer_html");
        echo "',
            success: function(data) {
                // モーダルに結果を書き出し.
                \$('#searchCustomerModalList').html(data);
            },
            error: function() {
                alert('search customer failed.');
            }
        });
    });
    \$('#searchProductModal').on('show.bs.modal', function (event) {
        var button = \$(event.relatedTarget);
        var idx = button.data('idx');
        var modal = \$(this);
        modal.find('#searchProductModalButton').attr('data-idx', idx);
    });


    // 商品検索
    \$('#searchProductModalButton').on('click', function() {
        var list = \$('#searchProductModalList');
        list.children().remove();

        var data = \$(this).data();
        shipment_idx = data.idx;

        shipmentItem_idx = 0;
        for(i = 0; i < shipping_details_count.length; i++) { 
            if (shipping_details_count[i].idx == shipment_idx) {
                shipmentItem_idx = shipping_details_count[i].cnt;
            }
        }
        
        \$.ajax({
            type: 'POST',
            dataType: 'html',
            data: {
                'id' : \$('#admin_search_product_id').val(),
                'category_id' : \$('#admin_search_product_category_id').val()
            },
            url: '";
        // line 112
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_order_search_product");
        echo "',
            success: function(data) {
                // モーダルに結果を書き出し.
                \$('#searchProductModalList').html(data);
            },
            error: function() {
                alert('search product failed.');
            }
        });
    });

    // 受注明細行の行数カウンタ.
    // 受注登録・編集画面上でグローバルな変数.
    // search_product.twig/order_detail_prototype.twigで利用しています.
    ";
        // line 126
        if (twig_test_empty($this->getAttribute(($context["form"] ?? null), "OrderDetails", array()))) {
            // line 127
            echo "        ";
            $context["maxIndex"] = 0;
            // line 128
            echo "    ";
        } else {
            // line 129
            echo "        ";
            $context["maxIndex"] = (max(twig_get_array_keys_filter($this->getAttribute(($context["form"] ?? null), "OrderDetails", array()))) + 1);
            // line 130
            echo "    ";
        }
        // line 131
        echo "    order_details_count = '";
        echo twig_escape_filter($this->env, ($context["maxIndex"] ?? null), "html", null, true);
        echo "';
    
    var shipping_details_count = [];
    ";
        // line 134
        if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
            // line 135
            echo "        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "Shippings", array()));
            foreach ($context['_seq'] as $context["shippingKey"] => $context["shippingForm"]) {
                // line 136
                echo "            ";
                if (twig_test_empty($this->getAttribute($context["shippingForm"], "ShipmentItems", array()))) {
                    // line 137
                    echo "                shipping_details_count.push({idx:";
                    echo twig_escape_filter($this->env, $context["shippingKey"], "html", null, true);
                    echo ", cnt:0});
            ";
                } else {
                    // line 139
                    echo "                shipping_details_count.push({idx:";
                    echo twig_escape_filter($this->env, $context["shippingKey"], "html", null, true);
                    echo ", cnt:";
                    echo twig_escape_filter($this->env, (max(twig_get_array_keys_filter($this->getAttribute($context["shippingForm"], "ShipmentItems", array()))) + 1), "html", null, true);
                    echo " });
            ";
                }
                // line 141
                echo "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['shippingKey'], $context['shippingForm'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 142
            echo "    ";
        }
        // line 143
        echo "
    // 項目数が多く、入力している項目によってEnter押下時に期待する動作が変わるので、いったん禁止
    \$(\"input\").on(\"keydown\", function(e) {
        if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
            return false;
        } else {
            return true;
        }
    });

    \$(\".delete-item\").on(\"click\", function(){
        \$(this).parents(\".item_box\").remove();

        onChangeOrderDetailCount(order_details_count);
    });
    
    \$(\".delete_delivery\").on(\"click\", function(){
       var data = \$(this).data();
       \$(\"#shipping_info_box--\" + data.idx ).remove();
       document.form1.modal.value = \"calc\";
       document.form1.submit();
    });
    
    \$(\".delete_shipping_product\").on(\"click\", function(){
       var data = \$(this).data();
       var idKey = \"order_Shippings_\"+ data.idx.replace(\"--\",\"_ShipmentItems_\") +\"_quantity\";
       \$(\"#\" + idKey ).val(0);
       document.form1.modal.value = \"calc\";
       document.form1.submit();
    });

    var onChangeOrderDetailCount = function(order_details_count) {
        if (order_details_count == 1) {
            \$(\".delete-item\").attr(\"disabled\", \"disabled\");
        } else {
            \$(\".delete-item\").removeAttr(\"disabled\");
        }
    };

    onChangeOrderDetailCount();


    // 配送業者選択時にお届け時間を設定
    var times = ";
        // line 186
        echo ($context["shippingDeliveryTimes"] ?? null);
        echo ";

    \$('.shipping-delivery').change(function(){
        var data = \$(this).data();
        setShippingDeliveryTime(\$(this).val(), data.idx);
    });

    function setShippingDeliveryTime(val, idx){
        var \$shippingDeliveryTime = \$('.shipping-delivery-time[data-idx=\"' + idx + '\"]');
        \$shippingDeliveryTime.find('option').remove();
        \$shippingDeliveryTime.append(\$('<option></option>').val('').text('指定なし'));

        if (typeof(times[val]) !== 'undefined') {
            for (var key in times[val]){
                text = times[val][key];
                \$shippingDeliveryTime.append(\$('<option></option>')
                    .val(key)
                    .text(text));
            }
        }
    }

});
var setModeAndSubmit = function(mode, keyname, keyid) {
    document.form1.modal.value = mode;
    if(keyname !== undefined && keyname !== \"\" && keyid !== undefined && keyid !== \"\") {
        document.form1[keyname].value = keyid;
    }
    document.form1.submit();
};

</script>
";
    }

    // line 220
    public function block_main($context, array $blocks = array())
    {
        echo "<script>
    \$(function(){
        \$('#payment_status_box__payment_method').appendTo(\$('#payment_info_box__body'));
    });
</script>

<div style=\"display: none;\">
    <dl id=\"payment_status_box__payment_method\" class=\"dl-horizontal\">
        <dt>イプシロン決済ステータス</dt>
        <dd class=\"form-group form-inline\">
            ";
        // line 230
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "PaymentStatus", array()), 'widget');
        echo "
            ";
        // line 231
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "PaymentStatus", array()), 'errors');
        echo "
        </dd>
    </dl>
</div>
<script>
    \$(function(){
        ";
        // line 237
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "Shippings", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["shippingForm"]) {
            // line 238
            echo "        ";
            $context["shippingIndex"] = $this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "name", array());
            // line 239
            echo "        \$('#shipment_item_detail__tracking_number--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "').appendTo(\$('#shipment_item_detail--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "'));
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['shippingForm'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 241
        echo "    });
</script>

<div style=\"display: none;\" id=\"asdasdasdasdas\">
    ";
        // line 245
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "Shippings", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["shippingForm"]) {
            // line 246
            echo "    ";
            $context["shippingIndex"] = $this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "name", array());
            // line 247
            echo "    <div id=\"shipment_item_detail__tracking_number--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
        ";
            // line 248
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "tracking_number", array()), 'label');
            echo "
        <div class=\"col-sm-9 col-lg-10\">
            ";
            // line 250
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "tracking_number", array()), 'widget', array("attr" => array("style" => "width:auto")));
            echo "
            ";
            // line 251
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "tracking_number", array()), 'errors');
            echo "
        </div>
    </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['shippingForm'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 255
        echo "</div>

<div class=\"row\" id=\"aside_wrap\">
    <form name=\"form1\" method=\"post\" action=\"?\">
    <input type=\"hidden\" name=\"modal\" value=\"\">
    ";
        // line 260
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", array()), 'widget');
        echo "
        <div id=\"detail_wrap\" class=\"col-md-12\">
            <div class=\"col_inner\">
                <div id=\"number_info_box\" class=\"box no-header\">
                    <div id=\"number_info_box__body\" class=\"box-body\">
                        <div class=\"row\">
                            <div id=\"number_info_box__order_status\" class=\"col-sm-4\">
                                <h4>注文番号 <span class=\"number\">";
        // line 267
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "id", array()), "html", null, true);
        echo "</span></h4>
                                <div class=\"form-group\">
                                    ";
        // line 269
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "OrderStatus", array()), 'widget');
        echo "
                                    ";
        // line 270
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "OrderStatus", array()), 'errors');
        echo "
                                </div>
                                <div id=\"number_info_box__order_status_info\" class=\"small text-danger\">キャンセルの場合は在庫数を手動で戻してください</div><div id=\"number_info_box__order_point_info\" class=\"small text-danger\">キャンセルの場合はポイントを手動で戻してください</div>

                            </div>
                            <div class=\"col-sm-6 col-sm-offset-2\">
                                <p id=\"number_info_box__order_date\"><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>受注日：";
        // line 276
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["Order"] ?? null), "order_date", array())) ? (twig_date_format_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "order_date", array()), "Y/m/d H:i:s")) : ("")), "html", null, true);
        echo "</p>
                                <p id=\"number_info_box__payment_date\"><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>入金日：";
        // line 277
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["Order"] ?? null), "payment_date", array())) ? (twig_date_format_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "payment_date", array()), "Y/m/d H:i:s")) : ("")), "html", null, true);
        echo "</p>
                                <p id=\"number_info_box__commit_date\"><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>発送日：";
        // line 278
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["Order"] ?? null), "commit_date", array())) ? (twig_date_format_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "commit_date", array()), "Y/m/d H:i:s")) : ("")), "html", null, true);
        echo "</p>
                                <p id=\"number_info_box__update_date\"><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>更新日：";
        // line 279
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["Order"] ?? null), "update_date", array())) ? (twig_date_format_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "update_date", array()), "Y/m/d H:i:s")) : ("")), "html", null, true);
        echo "</p>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div id=\"customer_info_box\"  class=\"box accordion\">
                <div id=\"customer_info_box__toggle\" class=\"box-header toggle active\">
                    <h3 class=\"box-title\">注文者情報<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                </div><!-- /.box-header -->
                <div id=\"customer_info_box__body\" class=\"box-body accpanel\" style=\"display: block;\">
                    <div id=\"customer_info_list\" class=\"order_list form-horizontal\">
                        ";
        // line 291
        if (twig_test_empty($this->getAttribute(($context["Order"] ?? null), "id", array()))) {
            // line 292
            echo "                        <div id=\"customer_info_list__button_search\" class=\"btn_area\">
                            <ul>
                                <li><a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#searchCustomerModal\">会員検索</a></li>
                            </ul>
                        </div>
                        ";
        }
        // line 298
        echo "                        <div id=\"customer_info_list__customer\" class=\"form-group\">
                            <div class=\"col-sm-3 col-lg-2\">会員ID</div>
                            <div class=\"col-sm-9 col-lg-10\">
                                <p id=\"order_CustomerId\">";
        // line 301
        echo twig_escape_filter($this->env, ((twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "Customer", array()), "vars", array()), "value", array()))) ? ("非会員") : ($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "Customer", array()), "vars", array()), "value", array()))), "html", null, true);
        echo "</p>
                                ";
        // line 302
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Customer", array()), 'widget');
        echo "
                                ";
        // line 303
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Customer", array()), 'errors');
        echo "
                            </div>

                        </div>
                        <div id=\"customer_info_list__name\" class=\"form-group\">
                            ";
        // line 308
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "name", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10 input_name form-inline\">
                                ";
        // line 310
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name01", array()), 'widget', array("attr" => array("placeholder" => "姓")));
        echo "
                                ";
        // line 311
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name02", array()), 'widget', array("attr" => array("placeholder" => "名")));
        echo "
                                ";
        // line 312
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name01", array()), 'errors');
        echo "
                                ";
        // line 313
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name02", array()), 'errors');
        echo "
                            </div>
                        </div>
                        <div id=\"customer_info_list__kana\" class=\"form-group\">
                            ";
        // line 317
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "kana", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10 input_name form-inline\">
                                ";
        // line 319
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana01", array()), 'widget', array("attr" => array("placeholder" => "セイ")));
        echo "
                                ";
        // line 320
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana02", array()), 'widget', array("attr" => array("placeholder" => "メイ")));
        echo "
                                ";
        // line 321
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana01", array()), 'errors');
        echo "
                                ";
        // line 322
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana02", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 326
        echo "                        <div id=\"customer_info_list__address\" class=\"form-group\">
                            ";
        // line 327
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "address", array()), 'label');
        echo "
                            <div id=\"customer_info_list__zip\" class=\"col-sm-9 col-lg-10 input_zip form-inline\">
                                〒";
        // line 329
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip01", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip02", array()), 'widget');
        echo "
                                ";
        // line 330
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip01", array()), 'errors');
        echo "
                                ";
        // line 331
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip02", array()), 'errors');
        echo "
                                <span><button type=\"button\" id=\"zip-search\" class=\"btn btn-default btn-sm\">郵便番号から自動入力</button></span>
                            </div>
                        </div>
                        ";
        // line 336
        echo "                        <div class=\"form-group\">
                            <div id=\"customer_info_list__pref\" class=\"col-sm-offset-2 col-sm-9 col-lg-10 form-inline\">
                                ";
        // line 338
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "pref", array()), 'widget');
        echo "
                                ";
        // line 339
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "pref", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 343
        echo "                        <div class=\"form-group\">
                            <div id=\"customer_info_list__addr01\" class=\"col-sm-offset-2 col-sm-9 col-lg-10\">
                                ";
        // line 345
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr01", array()), 'widget', array("attr" => array("placeholder" => "市区町村名（例：千代田区神田神保町）")));
        echo "
                                ";
        // line 346
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr01", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 350
        echo "                        <div class=\"form-group\">
                            <div id=\"customer_info_list__addr02\" class=\"col-sm-offset-2 col-sm-9 col-lg-10\">
                                ";
        // line 352
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr02", array()), 'widget', array("attr" => array("placeholder" => "番地・ビル名（例：1-3-5）")));
        echo "
                                ";
        // line 353
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr02", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 357
        echo "                        <div id=\"customer_info_list__email\" class=\"form-group\">
                            ";
        // line 358
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "email", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10\">
                                ";
        // line 360
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "email", array()), 'widget');
        echo "
                                ";
        // line 361
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "email", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 365
        echo "                        <div id=\"customer_info_list__tel\" class=\"form-group\">
                            ";
        // line 366
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "tel", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10 input_tel form-inline\">
                                ";
        // line 368
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel01", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel02", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel03", array()), 'widget');
        echo "
                                ";
        // line 369
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel01", array()), 'errors');
        echo "
                                ";
        // line 370
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel02", array()), 'errors');
        echo "
                                ";
        // line 371
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel03", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 375
        echo "                        <div id=\"customer_info_list__fax\" class=\"form-group\">
                            ";
        // line 376
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "fax", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10 input_tel form-inline\">
                                ";
        // line 378
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "fax", array()), "fax01", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "fax", array()), "fax02", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "fax", array()), "fax03", array()), 'widget');
        echo "
                                ";
        // line 379
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "fax", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 383
        echo "                        <div id=\"customer_info_list__company_name\" class=\"form-group\">
                            ";
        // line 384
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10\">
                                ";
        // line 386
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'widget');
        echo "
                                ";
        // line 387
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 391
        echo "                        <div id=\"customer_info_list__message\" class=\"form-group\">
                            ";
        // line 392
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "message", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10\">
                                ";
        // line 394
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "message", array()), 'widget', array("attr" => array("placeholder" => "3000文字まで入力可能")));
        echo "
                                ";
        // line 395
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "message", array()), 'errors');
        echo "
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <div id=\"point_info_box\"  class=\"box\">
    <div class=\"box-header\">
        <h3 class=\"box-title\">ポイント情報</h3>
    </div><!-- /.box-header -->
    <div class=\"box-body\">
        <div  class=\"form-group\">
            <div class=\"col-sm-3 col-lg-2\">保有ポイント</div>
            <div class=\"col-sm-9 col-lg-10\">
                <p>";
        // line 410
        echo twig_escape_filter($this->env, ($context["currentPoint"] ?? null), "html", null, true);
        echo " Pt</p>
            </div>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box --><div id=\"product_info_box\" class=\"box accordion\">
                <div id=\"product_info_box__toggle\" class=\"box-header toggle active\">
                    <h3 class=\"box-title\">受注商品情報<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                </div><!-- /.box-header -->
                <div id=\"product_info_box__body\" class=\"box-body accpanel\" style=\"display: block;\">
                    <div id=\"product_info_list\" class=\"order_list\">
                        <div class=\"btn_area\">
                            <ul id=\"product_info_list__search_menu\">
                                ";
        // line 422
        if (($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array()) != 1)) {
            // line 423
            echo "                                <li><a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#searchProductModal\">商品の追加</a></li>
                                ";
        }
        // line 425
        echo "                                <li><button type=\"submit\" class=\"btn btn-default\" name=\"mode\" value=\"calc\">計算結果の更新</button></li>
                            </ul>
                        </div>
                        <div class=\"tableish\"
                             id=\"order_detail_list\"
                             data-prototype=\"
                                ";
        // line 431
        echo twig_escape_filter($this->env,         $this->renderBlock("__internal_d76746e7ea9cb80f1e9a0384785669e2c70c425dd6fe9f41f5fbe69b26f621d2", $context, $blocks));
        // line 433
        echo "\">

                            ";
        // line 435
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "OrderDetails", array()));
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
        foreach ($context['_seq'] as $context["_key"] => $context["orderDetailForm"]) {
            // line 436
            echo "                                <div id=\"product_info_list__item--";
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_box\">
                                    ";
            // line 437
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "Product", array()), 'widget');
            echo "
                                    ";
            // line 438
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "ProductClass", array()), 'widget');
            echo "
                                    ";
            // line 439
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "product_name", array()), 'widget');
            echo "
                                    ";
            // line 440
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "product_code", array()), 'widget');
            echo "
                                    ";
            // line 441
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "class_name1", array()), 'widget');
            echo "
                                    ";
            // line 442
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "class_name2", array()), 'widget');
            echo "
                                    ";
            // line 443
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "class_category_name1", array()), 'widget');
            echo "
                                    ";
            // line 444
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "class_category_name2", array()), 'widget');
            echo "
                                    ";
            // line 445
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "tax_rule", array()), 'widget');
            echo "
                                    <div id=\"product_info_list__item_detail--";
            // line 446
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_detail\">
                                        <div id=\"product_info_list__detail_name--";
            // line 447
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_name_area\">
                                            <strong id=\"product_info_list__product_name--";
            // line 448
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_name\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "product_name", array()), "html", null, true);
            echo "</strong><br>
                                            <span id=\"product_info_list__product_code--";
            // line 449
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_id small\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "product_code", array()), "html", null, true);
            echo "</span>
                                            <span id=\"product_info_list__class_category_name--";
            // line 450
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_pattern small\">
                                                ";
            // line 451
            if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_category_name1", array()))) {
                // line 452
                echo "                                                / (
                                                    ";
                // line 453
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_name1", array()), "html", null, true);
                echo "：
                                                    ";
                // line 454
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_category_name1", array()), "html", null, true);
                echo "
                                                    ";
                // line 455
                if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_category_name2", array()))) {
                    // line 456
                    echo "                                                        /
                                                        ";
                    // line 457
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_name2", array()), "html", null, true);
                    echo "：
                                                        ";
                    // line 458
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_category_name2", array()), "html", null, true);
                    echo "
                                                    ";
                }
                // line 460
                echo "                                                    )
                                                ";
            }
            // line 462
            echo "                                            </span>
                                        </div>
                                        <div class=\"row\">
                                            <div id=\"product_info_list__price--";
            // line 465
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                                <span class=\"input-group item_price col-xs-8 col-sm-6 col-md-12\">
                                                    ";
            // line 467
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "price", array()), 'widget');
            echo "
                                                    ";
            // line 468
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "price", array()), 'errors');
            echo "
                                                </span>
                                            </div>
                                            <div class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                                <span id=\"product_info_list__quantity--";
            // line 472
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_quantity\">
                                                    ";
            // line 473
            $context["detail_id"] = $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "id", array());
            // line 474
            echo "                                                    ";
            if ($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "OrderDetails", array(), "any", false, true), ($context["detail_id"] ?? null), array(), "array", true, true)) {
                // line 475
                echo "                                                        ";
                $context["prev_quantity"] = ($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "OrderDetails", array()), ($context["detail_id"] ?? null), array(), "array"), "quantity", array()) . " ");
                // line 476
                echo "                                                    ";
            } else {
                // line 477
                echo "                                                        ";
                $context["prev_quantity"] = "";
                // line 478
                echo "                                                    ";
            }
            // line 479
            echo "                                                    ";
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
                // line 480
                echo "                                                        数量：";
                echo twig_escape_filter($this->env, ($context["prev_quantity"] ?? null), "html", null, true);
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "quantity", array()), 'widget', array("read_only" => "readonly"));
                echo "
                                                    ";
            } else {
                // line 482
                echo "                                                        数量：";
                echo twig_escape_filter($this->env, ($context["prev_quantity"] ?? null), "html", null, true);
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "quantity", array()), 'widget');
                echo "
                                                    ";
            }
            // line 484
            echo "                                                    ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "quantity", array()), 'errors');
            echo "
                                                </span>
                                            </div>
                                            <div class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                                <span id=\"product_info_list__tax_rate--";
            // line 488
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_tax\">
                                                    税率：
                                                    <span class=\"input-group\">
                                                    ";
            // line 491
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "tax_rate", array()), 'widget');
            echo "
                                                    ";
            // line 492
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "tax_rate", array()), 'errors');
            echo "
                                                    <span class=\"input-group-addon\">%</span>
                                                    </span>
                                                </span>
                                            </div>
                                            <div id=\"product_info_list__total_price--";
            // line 497
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"col-md-12 col-lg-3 item_subtotal text-right\">
                                                <span>小計：</span> ";
            // line 498
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "total_price", array())), "html", null, true);
            echo "
                                            </div>
                                        </div>

                                    </div>
                                    ";
            // line 503
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
                // line 504
                echo "                                    ";
            } else {
                // line 505
                echo "                                    <div id=\"product_info_list__button_multiple_shipping_delete--";
                echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                echo "\" class=\"icon_edit\">
                                        <button type=\"button\" class=\"btn btn-default btn-sm delete-item\">削除</button>
                                    </div>
                                    ";
            }
            // line 509
            echo "                                </div><!-- /.item_box -->
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['orderDetailForm'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 511
        echo "                        </div>

                        <div id=\"product_info_result_box__sub_price\" class=\"row with-border2 no-margin text-right\">
                            <div class=\"col-lg-7 col-lg-offset-5\">
                                <dl id=\"product_info_result_box__body_sub_price\" class=\"dl-horizontal\">
                                    <dt id=\"product_info_result_box__subtotal\">小計：</dt>
                                    <dd>";
        // line 517
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "subtotal", array())), "html", null, true);
        echo "</dd>
                                    <dt id=\"product_info_result_box__discount\">値引き：</dt>
                                    <dd class=\"form-group form-inline\">
                                        ";
        // line 520
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "discount", array()), 'widget');
        echo "
                                        ";
        // line 521
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "discount", array()), 'errors');
        echo "
                                    </dd>
                                    <dt id=\"product_info_result_box__delivery_fee_total\">送料：</dt>
                                    <dd class=\"form-group form-inline\">
                                        ";
        // line 525
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "delivery_fee_total", array()), 'widget');
        echo "
                                        ";
        // line 526
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "delivery_fee_total", array()), 'errors');
        echo "
                                    </dd>
                                    <dt id=\"product_info_result_box__charge\">手数料：</dt>
                                    <dd class=\"form-group form-inline\">
                                        ";
        // line 530
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "charge", array()), 'widget');
        echo "
                                        ";
        // line 531
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "charge", array()), 'errors');
        echo "
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div id=\"product_info_result_box__summary\" class=\"row with-border2 no-margin text-right  ta\">
                            <div class=\"col-lg-7 col-lg-offset-5\">
                                <p class=\"alignL text-danger small\">※値引きや明細変更時のポイント計算は、自動では行われません。</p>
<dl id=\"product_info_result_box__point_summary\" class=\"dl-horizontal\">
    <dt id=\"product_info_result_box__point_use\">利用ポイント&nbsp;:</dt>
    <dd>";
        // line 542
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "use_point", array()), 'widget');
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "use_point", array()), 'errors');
        echo "</dd>
    <dt id=\"product_info_result_box__point_add\">加算ポイント&nbsp;:</dt>
    <dd>";
        // line 544
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "add_point", array()), 'widget');
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "add_point", array()), 'errors');
        echo "</dd>
</dl>
<dl id=\"product_info_result_box__body_summary\" class=\"dl-horizontal\">
                                    <dt id=\"product_info_result_box__total\">合計：</dt>
                                    <dd>";
        // line 548
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "total", array())), "html", null, true);
        echo "</dd>
                                    <dt id=\"product_info_result_box__payment_total\">お支払合計：</dt>
                                    <dd>";
        // line 550
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "payment_total", array())), "html", null, true);
        echo "</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            ";
        // line 559
        echo "            <div id=\"payment_info_box\" class=\"box accordion\">
                <div id=\"payment_info_box__toggle\" class=\"box-header toggle active\">
                    <h3 class=\"box-title\">お支払情報<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                </div><!-- /.box-header -->
                <div id=\"payment_info_box__body\" class=\"box-body accpanel\" style=\"display: block;\">
                    <dl id=\"payment_info_box__payment_method\" class=\"dl-horizontal\">
                        <dt>お支払方法</dt>
                        <dd class=\"form-group form-inline\">
                            ";
        // line 567
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "value", array()), "payment_method", array()), "html", null, true);
        echo "<br/>
                            ";
        // line 568
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Payment", array()), 'widget');
        echo "
                            ";
        // line 569
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Payment", array()), 'errors');
        echo "
                            <p class=\"small\">お支払方法の変更に伴う手数料の変更は手動にてお願いします。</p>
                        </dd>
                    </dl>
                </div>
            </div>

            ";
        // line 577
        echo "            ";
        if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
            // line 578
            echo "            <div id=\"shipping_info__button_new\"><button type=\"submit\" class=\"btn btn-default\" name=\"mode\" value=\"add_delivery\">お届け先を新規追加</button></div>
            ";
        }
        // line 580
        echo "            ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "Shippings", array()));
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
        foreach ($context['_seq'] as $context["_key"] => $context["shippingForm"]) {
            // line 581
            echo "            ";
            $context["shippingIndex"] = $this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "name", array());
            // line 582
            echo "            <div id=\"shipping_info_box--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"box accordion\">
                <div id=\"shipping_info_box__toggle--";
            // line 583
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"box-header toggle active\">
                    <h3 class=\"box-title\">お届け先情報";
            // line 584
            if ((twig_length_filter($this->env, $this->getAttribute(($context["form"] ?? null), "Shippings", array())) > 1)) {
                echo "(";
                echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                echo ")";
            }
            echo "<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                </div><!-- /.box-header -->
                    <div id=\"shipping_info_box__body--";
            // line 586
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"box-body accpanel\" style=\"display: block;\">
                    <div id=\"shipping_info_list--";
            // line 587
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"order_list\">
                        <div class=\"btn_area\">
                            <ul id=\"shipping_info_list__menu--";
            // line 589
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\">
                                <li><a class=\"btn btn-default copyCustomerToShippingButton\" data-idx=\"";
            // line 590
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\">注文者情報をコピー</a></li>
                                ";
            // line 591
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
                // line 592
                echo "                                <li><a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#searchProductModal\" data-idx=\"";
                echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                echo "\">商品の追加</a></li>
                                ";
                // line 593
                if ((twig_length_filter($this->env, $this->getAttribute(($context["form"] ?? null), "Shippings", array())) > 1)) {
                    // line 594
                    echo "                                    <li><button type=\"button\" class=\"btn btn-default delete_delivery\" data-idx=\"";
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "\">お届け先情報を削除</button></li>
                                ";
                }
                // line 596
                echo "                                ";
            }
            // line 597
            echo "                            </ul>
                        </div>

                        ";
            // line 600
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
                // line 601
                echo "                        <div class=\"tableish\"
                             id=\"shipment_item_list";
                // line 602
                echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                echo "\"
                             data-prototype=\"
                             ";
                // line 604
                echo twig_escape_filter($this->env,                 $this->renderBlock("__internal_0810ba0e70a39e972382fa172c0238844db57e4dd9545a4836da96b1eca18333", $context, $blocks));
                // line 606
                echo "\">

                        ";
                // line 608
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["shippingForm"], "ShipmentItems", array()));
                foreach ($context['_seq'] as $context["shippingItemkey"] => $context["shipmentItemForm"]) {
                    // line 609
                    echo "                            <div id=\"shipment_item__id--";
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_box shipment_item_idx";
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "\">
                                ";
                    // line 610
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "Product", array()), 'widget');
                    echo "
                                ";
                    // line 611
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "ProductClass", array()), 'widget');
                    echo "
                                ";
                    // line 612
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "Product", array()), 'widget');
                    echo "
                                ";
                    // line 613
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "ProductClass", array()), 'widget');
                    echo "
                                ";
                    // line 614
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "product_name", array()), 'widget');
                    echo "
                                ";
                    // line 615
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "product_code", array()), 'widget');
                    echo "
                                ";
                    // line 616
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "class_name1", array()), 'widget');
                    echo "
                                ";
                    // line 617
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "class_name2", array()), 'widget');
                    echo "
                                ";
                    // line 618
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "class_category_name1", array()), 'widget');
                    echo "
                                ";
                    // line 619
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "class_category_name2", array()), 'widget');
                    echo "
                                <div id=\"shipment_item__detail--";
                    // line 620
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_detail\">
                                    <div id=\"shipment_item__name_detail--";
                    // line 621
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_name_area\">
                                        <strong id=\"shipment_item__product_name--";
                    // line 622
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_name\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "product_name", array()), "html", null, true);
                    echo "</strong><br>
                                        <span id=\"shipment_item__product_code--";
                    // line 623
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_id small\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "product_code", array()), "html", null, true);
                    echo "</span>
                                            <span id=\"shipment_item__class_category_name--";
                    // line 624
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_pattern small\">
                                                ";
                    // line 625
                    if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_category_name1", array()))) {
                        // line 626
                        echo "                                                    / (
                                                    ";
                        // line 627
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_name1", array()), "html", null, true);
                        echo "：
                                                    ";
                        // line 628
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_category_name1", array()), "html", null, true);
                        echo "
                                                    ";
                        // line 629
                        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_category_name2", array()))) {
                            // line 630
                            echo "                                                        /
                                                        ";
                            // line 631
                            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_name2", array()), "html", null, true);
                            echo "：
                                                        ";
                            // line 632
                            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_category_name2", array()), "html", null, true);
                            echo "
                                                    ";
                        }
                        // line 634
                        echo "                                                    )
                                                ";
                    }
                    // line 636
                    echo "                                            </span>
                                    </div>
                                    <div id=\"shipment_item__info_item--";
                    // line 638
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"row\">
                                        <div id=\"shipment_item__price--";
                    // line 639
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                            ";
                    // line 640
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "price", array()), 'widget', array("read_only" => "readonly"));
                    echo "
                                        </div>
                                        <div id=\"shipment_item__quantity--";
                    // line 642
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                            <span class=\"item_quantity\">
                                                ";
                    // line 644
                    $context["item_id"] = $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "id", array());
                    // line 645
                    echo "                                                ";
                    if ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array(), "any", false, true), ($context["shippingIndex"] ?? null), array(), "array", false, true), "ShipmentItems", array(), "any", false, true), ($context["item_id"] ?? null), array(), "array", true, true)) {
                        // line 646
                        echo "                                                    ";
                        $context["prev_quantity"] = ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array()), ($context["shippingIndex"] ?? null), array(), "array"), "ShipmentItems", array()), ($context["item_id"] ?? null), array(), "array"), "quantity", array()) . " ");
                        // line 647
                        echo "                                                ";
                    } else {
                        // line 648
                        echo "                                                    ";
                        $context["prev_quantity"] = "";
                        // line 649
                        echo "                                                ";
                    }
                    // line 650
                    echo "                                                数量：";
                    echo twig_escape_filter($this->env, ($context["prev_quantity"] ?? null), "html", null, true);
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "quantity", array()), 'widget', array("attr" => array("class" => "shipment_quantity")));
                    echo "
                                                ";
                    // line 651
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "quantity", array()), 'errors');
                    echo "
                                            </span>
                                        </div>
                                            <div id=\"shipment_item__delete--";
                    // line 654
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                                <button type=\"button\" class=\"btn btn-default delete_shipping_product\" data-idx=\"";
                    // line 655
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\">削除</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.item_box -->
                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['shippingItemkey'], $context['shipmentItemForm'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 661
                echo "                            </div>
                        ";
            }
            // line 663
            echo "
                        <hr>
                        <div id=\"shipment_item_detail--";
            // line 665
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-horizontal\">
                            <div id=\"shipment_item_detail__name--";
            // line 666
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 667
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "name", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10 input_name form-inline\">
                                    ";
            // line 669
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "name", array()), "name01", array()), 'widget', array("attr" => array("placeholder" => "姓")));
            echo "
                                    ";
            // line 670
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "name", array()), "name02", array()), 'widget', array("attr" => array("placeholder" => "名")));
            echo "
                                    ";
            // line 671
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "name", array()), "name01", array()), 'errors');
            echo "
                                    ";
            // line 672
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "name", array()), "name02", array()), 'errors');
            echo "
                                </div>
                            </div>
                            <div id=\"shipment_item_detail__kana--";
            // line 675
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 676
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "kana", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10 input_name form-inline\">
                                    ";
            // line 678
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "kana", array()), "kana01", array()), 'widget', array("attr" => array("placeholder" => "セイ")));
            echo "
                                    ";
            // line 679
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "kana", array()), "kana02", array()), 'widget', array("attr" => array("placeholder" => "メイ")));
            echo "
                                    ";
            // line 680
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "kana", array()), "kana01", array()), 'errors');
            echo "
                                    ";
            // line 681
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "kana", array()), "kana02", array()), 'errors');
            echo "
                                </div>
                            </div>
                            <div id=\"shipment_item_detail__company_name--";
            // line 684
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 685
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "company_name", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    ";
            // line 687
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "company_name", array()), 'widget');
            echo "
                                    ";
            // line 688
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "company_name", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 692
            echo "                            <div id=\"shipment_item_detail__address--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 693
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "address", array()), 'label');
            echo "
                                <div id=\"shipment_item_detail__zip--";
            // line 694
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-9 col-lg-10 input_zip form-inline\">
                                    〒";
            // line 695
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "zip", array()), "zip01", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "zip", array()), "zip02", array()), 'widget');
            echo "
                                    ";
            // line 696
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "zip", array()), "zip01", array()), 'errors');
            echo "
                                    ";
            // line 697
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "zip", array()), "zip02", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 701
            echo "                            <div class=\"form-group\">
                                <div id=\"shipment_item_detail__pref--";
            // line 702
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-offset-2 col-sm-9 col-lg-10 form-inline\">
                                    ";
            // line 703
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "pref", array()), 'widget');
            echo "
                                    ";
            // line 704
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "pref", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 708
            echo "                            <div class=\"form-group\">
                                <div id=\"shipment_item_detail__addr01--";
            // line 709
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-offset-2 col-sm-9 col-lg-10\">
                                    ";
            // line 710
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "addr01", array()), 'widget', array("attr" => array("placeholder" => "市区町村名（例：千代田区神田神保町）")));
            echo "
                                    ";
            // line 711
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "addr01", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 715
            echo "                            <div class=\"form-group\">
                                <div id=\"shipment_item_detail__addr02--";
            // line 716
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-offset-2 col-sm-9 col-lg-10\">
                                    ";
            // line 717
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "addr02", array()), 'widget', array("attr" => array("placeholder" => "番地・ビル名（例：1-3-5）")));
            echo "
                                    ";
            // line 718
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "addr02", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 722
            echo "                            <div id=\"shipment_item_detail__tel--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 723
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "tel", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10 input_tel form-inline\">
                                    ";
            // line 725
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel01", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel02", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel03", array()), 'widget');
            echo "
                                    ";
            // line 726
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel01", array()), 'errors');
            echo "
                                    ";
            // line 727
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel02", array()), 'errors');
            echo "
                                    ";
            // line 728
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel03", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 732
            echo "                            <div id=\"shipment_item_detail__fax--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 733
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "fax", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10 input_tel form-inline\">
                                    ";
            // line 735
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "fax", array()), "fax01", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "fax", array()), "fax02", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "fax", array()), "fax03", array()), 'widget');
            echo "
                                    ";
            // line 736
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "fax", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 740
            echo "                            <div id=\"shipment_item_detail__delivery--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 741
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "Delivery", array()), 'label');
            echo "
                                <div id=\"shipment_item_detail__delivery_name--";
            // line 742
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-9 col-lg-10\">
                                    ";
            // line 743
            if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "value", array()), "shipping_delivery_name", array()))) {
                // line 744
                echo "                                    ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "value", array()), "shipping_delivery_name", array()), "html", null, true);
                echo "<br/>
                                    ";
            }
            // line 746
            echo "                                    ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "Delivery", array()), 'widget', array("attr" => array("style" => "width:auto", "class" => "shipping-delivery", "data-idx" => ($context["shippingIndex"] ?? null))));
            echo "
                                    ";
            // line 747
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "Delivery", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 751
            echo "                            <div id=\"shipment_item_detail__delivery_time--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 752
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "DeliveryTime", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    ";
            // line 754
            if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "value", array()), "shipping_delivery_time", array()))) {
                // line 755
                echo "                                    ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "value", array()), "shipping_delivery_time", array()), "html", null, true);
                echo "<br/>
                                    ";
            } else {
                // line 757
                echo "                                        指定なし
                                    ";
            }
            // line 759
            echo "                                    ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "DeliveryTime", array()), 'widget', array("attr" => array("style" => "width:auto", "class" => "shipping-delivery-time", "data-idx" => ($context["shippingIndex"] ?? null))));
            echo "
                                    ";
            // line 760
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "DeliveryTime", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 764
            echo "                            <div id=\"shipment_item_detail__shipping_delivery_date--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 765
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "shipping_delivery_date", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    ";
            // line 767
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array(), "any", false, true), ($context["shippingIndex"] ?? null), array(), "array", false, true), "shipping_delivery_date", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array()), ($context["shippingIndex"] ?? null), array(), "array"), "shipping_delivery_date", array())))) {
                // line 768
                echo "                                        ";
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array()), ($context["shippingIndex"] ?? null), array(), "array"), "shipping_delivery_date", array()), "Y-m-d"), "html", null, true);
                echo "<br/>
                                    ";
            } else {
                // line 770
                echo "                                        指定なし
                                    ";
            }
            // line 772
            echo "                                    ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "shipping_delivery_date", array()), 'widget');
            echo "
                                    ";
            // line 773
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "shipping_delivery_date", array()), 'errors');
            echo "
                                </div>
                            </div>
                            <div class=\"extra-form\">
                                ";
            // line 777
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "getIterator", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                // line 778
                echo "                                    ";
                if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                    // line 779
                    echo "                                        ";
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'row');
                    echo "
                                    ";
                }
                // line 781
                echo "                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 782
            echo "                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['shippingForm'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 788
        echo "
            <div id=\"shop_info_box\" class=\"box\">
                <div id=\"shop_info_box__header\" class=\"box-header\">
                    <h3 class=\"box-title\">ショップ用メモ欄</h3>
                </div><!-- /.box-header -->
                <div id=\"shop_info_box__note\" class=\"box-body\">";
        // line 793
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "note", array()), 'widget');
        echo "</div>
            </div><!-- /.box -->

            <div id=\"detail__insert_button\" class=\"row btn_area\">
                <p class=\"col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 text-center\">
                    <button type=\"submit\" class=\"btn btn-primary btn-block btn-lg\" name=\"mode\" value=\"register\">受注情報を登録</button>
                </p>
                <!-- /.col -->
            </div>

            <div id=\"detail__back_button\" class=\"row hidden-xs hidden-sm\">
                <div class=\"col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 text-center btn_area\">
                    ";
        // line 805
        if ( !(null === ($context["id"] ?? null))) {
            // line 806
            echo "                        <p><a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_order_page", array("page_no" => (($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array(), "any", false, true), "get", array(0 => "eccube.admin.order.search.page_no"), "method", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array(), "any", false, true), "get", array(0 => "eccube.admin.order.search.page_no"), "method"), "1")) : ("1")))), "html", null, true);
            echo "?resume=1\">戻る</a></p>
                    ";
        }
        // line 808
        echo "                </div>
            </div>

        </div><!-- /.col -->

    </form>
</div>
";
    }

    // line 431
    public function block___internal_d76746e7ea9cb80f1e9a0384785669e2c70c425dd6fe9f41f5fbe69b26f621d2($context, array $blocks = array())
    {
        // line 432
        echo "                                     ";
        echo twig_include($this->env, $context, "Order/order_detail_prototype.twig", array("orderDetailForm" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "OrderDetails", array()), "vars", array()), "prototype", array())));
        echo "
                                ";
    }

    // line 604
    public function block___internal_0810ba0e70a39e972382fa172c0238844db57e4dd9545a4836da96b1eca18333($context, array $blocks = array())
    {
        // line 605
        echo "                                     ";
        echo twig_include($this->env, $context, "Order/shipment_item_prototype.twig", array("shipmentItemForm" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["shippingForm"] ?? null), "ShipmentItems", array()), "vars", array()), "prototype", array())));
        echo "
                             ";
    }

    // line 817
    public function block_modal($context, array $blocks = array())
    {
        // line 818
        echo "
";
        // line 820
        echo "<div class=\"modal fade\" id=\"searchCustomerModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\">
        <div id=\"search_customer_modal_box\" class=\"modal-content\">
            <div id=\"search_customer_modal_box__header\" class=\"modal-header\">
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span class=\"modal-close\" aria-hidden=\"true\">&times;</span></button>
                <h4 class=\"modal-title\" id=\"myModalLabel\">会員検索</h4>
            </div>
            <div id=\"search_customer_modal_box__body\" class=\"modal-body\">
                <div class=\"form-group\">
                    ";
        // line 829
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchCustomerModalForm"] ?? null), "multi", array()), 'widget', array("attr" => array("placeholder" => "会員ID・メールアドレス・お名前")));
        echo "
                </div>
                <div class=\"extra-form form-group\">
                    ";
        // line 832
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["searchCustomerModalForm"] ?? null), "getIterator", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
            // line 833
            echo "                        ";
            if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                // line 834
                echo "                            ";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'label');
                echo "
                            ";
                // line 835
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'widget');
                echo "
                            ";
                // line 836
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'errors');
                echo "
                        ";
            }
            // line 838
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 839
        echo "                </div>
                <div id=\"search_customer_modal_box__button_search\" class=\"form-group\">
                    <button type=\"button\" id=\"searchCustomerModalButton\" class=\"btn btn-primary\" >検索</button>
                </div>
                <div class=\"form-group\" id=\"searchCustomerModalList\">
                </div>
            </div>
        </div>
    </div>
</div>

";
        // line 851
        echo "<div class=\"modal fade\" id=\"searchProductModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\">
        <div id=\"search_product_modal_box\" class=\"modal-content\">
            <div id=\"search_product_modal_box__header\" class=\"modal-header\">
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span class=\"modal-close\" aria-hidden=\"true\">&times;</span></button>
                <h4 class=\"modal-title\" id=\"myModalLabel\">商品検索</h4>
            </div>
            <div id=\"search_product_modal_box__body\" class=\"modal-body\">
                <div id=\"search_product_modal_box__id\" class=\"form-group\">
                    ";
        // line 860
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchProductModalForm"] ?? null), "id", array()), 'widget', array("attr" => array("placeholder" => "商品名・ID・コード")));
        echo "
                </div>
                <div id=\"search_product_modal_box__category_id\" class=\"form-group\">
                    ";
        // line 863
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchProductModalForm"] ?? null), "category_id", array()), 'widget');
        echo "
                </div>
                <div class=\"extra-form form-group\">
                    ";
        // line 866
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["searchProductModalForm"] ?? null), "getIterator", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
            // line 867
            echo "                        ";
            if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                // line 868
                echo "                            ";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'label');
                echo "
                            ";
                // line 869
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'widget');
                echo "
                            ";
                // line 870
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'errors');
                echo "
                        ";
            }
            // line 872
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 873
        echo "                </div>
                <div id=\"search_product_modal_box__button_search\" class=\"form-group\">
                    <button type=\"button\" id=\"searchProductModalButton\" class=\"btn btn-primary\">検索</button>
                </div>
                <div class=\"form-group\" id=\"searchProductModalList\">
                </div>
            </div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__79361fe5ce2cb56b829f7c49ea308f7f425049742a061e3b6cfc3f65c79c74a9";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1915 => 873,  1909 => 872,  1904 => 870,  1900 => 869,  1895 => 868,  1892 => 867,  1888 => 866,  1882 => 863,  1876 => 860,  1865 => 851,  1852 => 839,  1846 => 838,  1841 => 836,  1837 => 835,  1832 => 834,  1829 => 833,  1825 => 832,  1819 => 829,  1808 => 820,  1805 => 818,  1802 => 817,  1795 => 605,  1792 => 604,  1785 => 432,  1782 => 431,  1771 => 808,  1765 => 806,  1763 => 805,  1748 => 793,  1741 => 788,  1722 => 782,  1716 => 781,  1710 => 779,  1707 => 778,  1703 => 777,  1696 => 773,  1691 => 772,  1687 => 770,  1681 => 768,  1679 => 767,  1674 => 765,  1669 => 764,  1663 => 760,  1658 => 759,  1654 => 757,  1648 => 755,  1646 => 754,  1641 => 752,  1636 => 751,  1630 => 747,  1625 => 746,  1619 => 744,  1617 => 743,  1613 => 742,  1609 => 741,  1604 => 740,  1598 => 736,  1590 => 735,  1585 => 733,  1580 => 732,  1574 => 728,  1570 => 727,  1566 => 726,  1558 => 725,  1553 => 723,  1548 => 722,  1542 => 718,  1538 => 717,  1534 => 716,  1531 => 715,  1525 => 711,  1521 => 710,  1517 => 709,  1514 => 708,  1508 => 704,  1504 => 703,  1500 => 702,  1497 => 701,  1491 => 697,  1487 => 696,  1481 => 695,  1477 => 694,  1473 => 693,  1468 => 692,  1462 => 688,  1458 => 687,  1453 => 685,  1449 => 684,  1443 => 681,  1439 => 680,  1435 => 679,  1431 => 678,  1426 => 676,  1422 => 675,  1416 => 672,  1412 => 671,  1408 => 670,  1404 => 669,  1399 => 667,  1395 => 666,  1391 => 665,  1387 => 663,  1383 => 661,  1369 => 655,  1363 => 654,  1357 => 651,  1351 => 650,  1348 => 649,  1345 => 648,  1342 => 647,  1339 => 646,  1336 => 645,  1334 => 644,  1327 => 642,  1322 => 640,  1316 => 639,  1310 => 638,  1306 => 636,  1302 => 634,  1297 => 632,  1293 => 631,  1290 => 630,  1288 => 629,  1284 => 628,  1280 => 627,  1277 => 626,  1275 => 625,  1269 => 624,  1261 => 623,  1253 => 622,  1247 => 621,  1241 => 620,  1237 => 619,  1233 => 618,  1229 => 617,  1225 => 616,  1221 => 615,  1217 => 614,  1213 => 613,  1209 => 612,  1205 => 611,  1201 => 610,  1192 => 609,  1188 => 608,  1184 => 606,  1182 => 604,  1177 => 602,  1174 => 601,  1172 => 600,  1167 => 597,  1164 => 596,  1158 => 594,  1156 => 593,  1151 => 592,  1149 => 591,  1145 => 590,  1141 => 589,  1136 => 587,  1132 => 586,  1123 => 584,  1119 => 583,  1114 => 582,  1111 => 581,  1093 => 580,  1089 => 578,  1086 => 577,  1076 => 569,  1072 => 568,  1068 => 567,  1058 => 559,  1047 => 550,  1042 => 548,  1034 => 544,  1028 => 542,  1014 => 531,  1010 => 530,  1003 => 526,  999 => 525,  992 => 521,  988 => 520,  982 => 517,  974 => 511,  959 => 509,  951 => 505,  948 => 504,  946 => 503,  938 => 498,  934 => 497,  926 => 492,  922 => 491,  916 => 488,  908 => 484,  901 => 482,  894 => 480,  891 => 479,  888 => 478,  885 => 477,  882 => 476,  879 => 475,  876 => 474,  874 => 473,  870 => 472,  863 => 468,  859 => 467,  854 => 465,  849 => 462,  845 => 460,  840 => 458,  836 => 457,  833 => 456,  831 => 455,  827 => 454,  823 => 453,  820 => 452,  818 => 451,  814 => 450,  808 => 449,  802 => 448,  798 => 447,  794 => 446,  790 => 445,  786 => 444,  782 => 443,  778 => 442,  774 => 441,  770 => 440,  766 => 439,  762 => 438,  758 => 437,  753 => 436,  736 => 435,  732 => 433,  730 => 431,  722 => 425,  718 => 423,  716 => 422,  701 => 410,  683 => 395,  679 => 394,  674 => 392,  671 => 391,  665 => 387,  661 => 386,  656 => 384,  653 => 383,  647 => 379,  639 => 378,  634 => 376,  631 => 375,  625 => 371,  621 => 370,  617 => 369,  609 => 368,  604 => 366,  601 => 365,  595 => 361,  591 => 360,  586 => 358,  583 => 357,  577 => 353,  573 => 352,  569 => 350,  563 => 346,  559 => 345,  555 => 343,  549 => 339,  545 => 338,  541 => 336,  534 => 331,  530 => 330,  524 => 329,  519 => 327,  516 => 326,  510 => 322,  506 => 321,  502 => 320,  498 => 319,  493 => 317,  486 => 313,  482 => 312,  478 => 311,  474 => 310,  469 => 308,  461 => 303,  457 => 302,  453 => 301,  448 => 298,  440 => 292,  438 => 291,  423 => 279,  419 => 278,  415 => 277,  411 => 276,  402 => 270,  398 => 269,  393 => 267,  383 => 260,  376 => 255,  366 => 251,  362 => 250,  357 => 248,  352 => 247,  349 => 246,  345 => 245,  339 => 241,  328 => 239,  325 => 238,  321 => 237,  312 => 231,  308 => 230,  294 => 220,  257 => 186,  212 => 143,  209 => 142,  203 => 141,  195 => 139,  189 => 137,  186 => 136,  181 => 135,  179 => 134,  172 => 131,  169 => 130,  166 => 129,  163 => 128,  160 => 127,  158 => 126,  141 => 112,  98 => 72,  58 => 34,  55 => 33,  49 => 27,  43 => 26,  39 => 22,  37 => 31,  35 => 30,  33 => 29,  31 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__79361fe5ce2cb56b829f7c49ea308f7f425049742a061e3b6cfc3f65c79c74a9", "");
    }
}
