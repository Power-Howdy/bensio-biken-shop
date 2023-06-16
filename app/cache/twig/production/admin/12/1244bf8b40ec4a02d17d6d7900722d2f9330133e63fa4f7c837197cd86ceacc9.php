<?php

/* __string_template__81d67888cd80b148ae56973117d57c7ec416c4136a0ee622a80937eb17fce674 */
class __TwigTemplate_c26c01d2c2792179802c56d0b1e7dcc0652314681bd577d5211e6934de08d734 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__81d67888cd80b148ae56973117d57c7ec416c4136a0ee622a80937eb17fce674", 22);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'sub_title' => array($this, 'block_sub_title'),
            'javascript' => array($this, 'block_javascript'),
            'main' => array($this, 'block_main'),
            '__internal_4c2075cada8eb3224ab5d4357125c456ec1ae1042b42ba9790e1fc6a8cd1ab0b' => array($this, 'block___internal_4c2075cada8eb3224ab5d4357125c456ec1ae1042b42ba9790e1fc6a8cd1ab0b'),
            '__internal_ab08adf125466b5efbc27c4188f928844f208beccaba58438f98b5f4aed794e7' => array($this, 'block___internal_ab08adf125466b5efbc27c4188f928844f208beccaba58438f98b5f4aed794e7'),
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
        \$('#complete_payment_box__payment_method').appendTo(\$('#payment_info_box__body'));

        \$('#register_gmo_epsilon_credit_card_btn').on('click', function() {
            location.href = '";
        // line 225
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("paylite_create_reg_credit_order", array("id" => $this->getAttribute(($context["Order"] ?? null), "id", array()))), "html", null, true);
        echo "';
        });
    });
</script>

<div style=\"display: none;\">
    <dl id=\"complete_payment_box__payment_method\" class=\"dl-horizontal\">
        <dt>登録済みクレジットカード決済登録</dt>
        <dd class=\"form-group form-inline\">
            <a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#completePaymentBtn\">決済を登録する</a>
        </dd>
    </dl>
</div>
<script>
    \$(function(){
        \$('#payment_status_box__payment_method').appendTo(\$('#payment_info_box__body'));
    });
</script>

<div style=\"display: none;\">
    <dl id=\"payment_status_box__payment_method\" class=\"dl-horizontal\">
        <dt>イプシロン決済ステータス</dt>
        <dd class=\"form-group form-inline\">
            ";
        // line 248
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "PaymentStatus", array()), 'widget');
        echo "
            ";
        // line 249
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "PaymentStatus", array()), 'errors');
        echo "
        </dd>
    </dl>
</div>
<script>
    \$(function(){
        ";
        // line 255
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "Shippings", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["shippingForm"]) {
            // line 256
            echo "        ";
            $context["shippingIndex"] = $this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "name", array());
            // line 257
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
        // line 259
        echo "    });
</script>

<div style=\"display: none;\" id=\"asdasdasdasdas\">
    ";
        // line 263
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "Shippings", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["shippingForm"]) {
            // line 264
            echo "    ";
            $context["shippingIndex"] = $this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "name", array());
            // line 265
            echo "    <div id=\"shipment_item_detail__tracking_number--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
        ";
            // line 266
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "tracking_number", array()), 'label');
            echo "
        <div class=\"col-sm-9 col-lg-10\">
            ";
            // line 268
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "tracking_number", array()), 'widget', array("attr" => array("style" => "width:auto")));
            echo "
            ";
            // line 269
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "tracking_number", array()), 'errors');
            echo "
        </div>
    </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['shippingForm'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 273
        echo "</div>

<div class=\"row\" id=\"aside_wrap\">
    <form name=\"form1\" method=\"post\" action=\"?\">
    <input type=\"hidden\" name=\"modal\" value=\"\">
    ";
        // line 278
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", array()), 'widget');
        echo "
        <div id=\"detail_wrap\" class=\"col-md-12\">
            <div class=\"col_inner\">
                <div id=\"number_info_box\" class=\"box no-header\">
                    <div id=\"number_info_box__body\" class=\"box-body\">
                        <div class=\"row\">
                            <div id=\"number_info_box__order_status\" class=\"col-sm-4\">
                                <h4>注文番号 <span class=\"number\">";
        // line 285
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "id", array()), "html", null, true);
        echo "</span></h4>
                                <div class=\"form-group\">
                                    ";
        // line 287
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "OrderStatus", array()), 'widget');
        echo "
                                    ";
        // line 288
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "OrderStatus", array()), 'errors');
        echo "
                                </div>
                                <div id=\"number_info_box__order_status_info\" class=\"small text-danger\">キャンセルの場合は在庫数を手動で戻してください</div><div id=\"number_info_box__order_point_info\" class=\"small text-danger\">キャンセルの場合はポイントを手動で戻してください</div>

                            </div>
                            <div class=\"col-sm-6 col-sm-offset-2\">
                                <p id=\"number_info_box__order_date\"><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>受注日：";
        // line 294
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["Order"] ?? null), "order_date", array())) ? (twig_date_format_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "order_date", array()), "Y/m/d H:i:s")) : ("")), "html", null, true);
        echo "</p>
                                <p id=\"number_info_box__payment_date\"><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>入金日：";
        // line 295
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["Order"] ?? null), "payment_date", array())) ? (twig_date_format_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "payment_date", array()), "Y/m/d H:i:s")) : ("")), "html", null, true);
        echo "</p>
                                <p id=\"number_info_box__commit_date\"><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>発送日：";
        // line 296
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["Order"] ?? null), "commit_date", array())) ? (twig_date_format_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "commit_date", array()), "Y/m/d H:i:s")) : ("")), "html", null, true);
        echo "</p>
                                <p id=\"number_info_box__update_date\"><svg class=\"cb cb-clock\"> <use xlink:href=\"#cb-clock\" /></svg>更新日：";
        // line 297
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
        // line 309
        if (twig_test_empty($this->getAttribute(($context["Order"] ?? null), "id", array()))) {
            // line 310
            echo "                        <div id=\"customer_info_list__button_search\" class=\"btn_area\">
                            <ul>
                                <li><a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#searchCustomerModal\">会員検索</a></li>
                            </ul>
                        </div>
                        ";
        }
        // line 316
        echo "                        <div id=\"customer_info_list__customer\" class=\"form-group\">
                            <div class=\"col-sm-3 col-lg-2\">会員ID</div>
                            <div class=\"col-sm-9 col-lg-10\">
                                <p id=\"order_CustomerId\">";
        // line 319
        echo twig_escape_filter($this->env, ((twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "Customer", array()), "vars", array()), "value", array()))) ? ("非会員") : ($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "Customer", array()), "vars", array()), "value", array()))), "html", null, true);
        echo "</p>
                                ";
        // line 320
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Customer", array()), 'widget');
        echo "
                                ";
        // line 321
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Customer", array()), 'errors');
        echo "
                            </div>

                        </div>
                        <div id=\"customer_info_list__name\" class=\"form-group\">
                            ";
        // line 326
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "name", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10 input_name form-inline\">
                                ";
        // line 328
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name01", array()), 'widget', array("attr" => array("placeholder" => "姓")));
        echo "
                                ";
        // line 329
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name02", array()), 'widget', array("attr" => array("placeholder" => "名")));
        echo "
                                ";
        // line 330
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name01", array()), 'errors');
        echo "
                                ";
        // line 331
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "name", array()), "name02", array()), 'errors');
        echo "
                            </div>
                        </div>
                        <div id=\"customer_info_list__kana\" class=\"form-group\">
                            ";
        // line 335
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "kana", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10 input_name form-inline\">
                                ";
        // line 337
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana01", array()), 'widget', array("attr" => array("placeholder" => "セイ")));
        echo "
                                ";
        // line 338
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana02", array()), 'widget', array("attr" => array("placeholder" => "メイ")));
        echo "
                                ";
        // line 339
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana01", array()), 'errors');
        echo "
                                ";
        // line 340
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "kana", array()), "kana02", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 344
        echo "                        <div id=\"customer_info_list__address\" class=\"form-group\">
                            ";
        // line 345
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "address", array()), 'label');
        echo "
                            <div id=\"customer_info_list__zip\" class=\"col-sm-9 col-lg-10 input_zip form-inline\">
                                〒";
        // line 347
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip01", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip02", array()), 'widget');
        echo "
                                ";
        // line 348
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip01", array()), 'errors');
        echo "
                                ";
        // line 349
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "zip", array()), "zip02", array()), 'errors');
        echo "
                                <span><button type=\"button\" id=\"zip-search\" class=\"btn btn-default btn-sm\">郵便番号から自動入力</button></span>
                            </div>
                        </div>
                        ";
        // line 354
        echo "                        <div class=\"form-group\">
                            <div id=\"customer_info_list__pref\" class=\"col-sm-offset-2 col-sm-9 col-lg-10 form-inline\">
                                ";
        // line 356
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "pref", array()), 'widget');
        echo "
                                ";
        // line 357
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "pref", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 361
        echo "                        <div class=\"form-group\">
                            <div id=\"customer_info_list__addr01\" class=\"col-sm-offset-2 col-sm-9 col-lg-10\">
                                ";
        // line 363
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr01", array()), 'widget', array("attr" => array("placeholder" => "市区町村名（例：千代田区神田神保町）")));
        echo "
                                ";
        // line 364
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr01", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 368
        echo "                        <div class=\"form-group\">
                            <div id=\"customer_info_list__addr02\" class=\"col-sm-offset-2 col-sm-9 col-lg-10\">
                                ";
        // line 370
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr02", array()), 'widget', array("attr" => array("placeholder" => "番地・ビル名（例：1-3-5）")));
        echo "
                                ";
        // line 371
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "address", array()), "addr02", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 375
        echo "                        <div id=\"customer_info_list__email\" class=\"form-group\">
                            ";
        // line 376
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "email", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10\">
                                ";
        // line 378
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "email", array()), 'widget');
        echo "
                                ";
        // line 379
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "email", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 383
        echo "                        <div id=\"customer_info_list__tel\" class=\"form-group\">
                            ";
        // line 384
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "tel", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10 input_tel form-inline\">
                                ";
        // line 386
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel01", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel02", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel03", array()), 'widget');
        echo "
                                ";
        // line 387
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel01", array()), 'errors');
        echo "
                                ";
        // line 388
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel02", array()), 'errors');
        echo "
                                ";
        // line 389
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "tel", array()), "tel03", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 393
        echo "                        <div id=\"customer_info_list__fax\" class=\"form-group\">
                            ";
        // line 394
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "fax", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10 input_tel form-inline\">
                                ";
        // line 396
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "fax", array()), "fax01", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "fax", array()), "fax02", array()), 'widget');
        echo "-";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute(($context["form"] ?? null), "fax", array()), "fax03", array()), 'widget');
        echo "
                                ";
        // line 397
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "fax", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 401
        echo "                        <div id=\"customer_info_list__company_name\" class=\"form-group\">
                            ";
        // line 402
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10\">
                                ";
        // line 404
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'widget');
        echo "
                                ";
        // line 405
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "company_name", array()), 'errors');
        echo "
                            </div>
                        </div>
                        ";
        // line 409
        echo "                        <div id=\"customer_info_list__message\" class=\"form-group\">
                            ";
        // line 410
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "message", array()), 'label');
        echo "
                            <div class=\"col-sm-9 col-lg-10\">
                                ";
        // line 412
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "message", array()), 'widget', array("attr" => array("placeholder" => "3000文字まで入力可能")));
        echo "
                                ";
        // line 413
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
        // line 428
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
        // line 440
        if (($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array()) != 1)) {
            // line 441
            echo "                                <li><a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#searchProductModal\">商品の追加</a></li>
                                ";
        }
        // line 443
        echo "                                <li><button type=\"submit\" class=\"btn btn-default\" name=\"mode\" value=\"calc\">計算結果の更新</button></li>
                            </ul>
                        </div>
                        <div class=\"tableish\"
                             id=\"order_detail_list\"
                             data-prototype=\"
                                ";
        // line 449
        echo twig_escape_filter($this->env,         $this->renderBlock("__internal_4c2075cada8eb3224ab5d4357125c456ec1ae1042b42ba9790e1fc6a8cd1ab0b", $context, $blocks));
        // line 451
        echo "\">

                            ";
        // line 453
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
            // line 454
            echo "                                <div id=\"product_info_list__item--";
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_box\">
                                    ";
            // line 455
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "Product", array()), 'widget');
            echo "
                                    ";
            // line 456
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "ProductClass", array()), 'widget');
            echo "
                                    ";
            // line 457
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "product_name", array()), 'widget');
            echo "
                                    ";
            // line 458
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "product_code", array()), 'widget');
            echo "
                                    ";
            // line 459
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "class_name1", array()), 'widget');
            echo "
                                    ";
            // line 460
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "class_name2", array()), 'widget');
            echo "
                                    ";
            // line 461
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "class_category_name1", array()), 'widget');
            echo "
                                    ";
            // line 462
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "class_category_name2", array()), 'widget');
            echo "
                                    ";
            // line 463
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "tax_rule", array()), 'widget');
            echo "
                                    <div id=\"product_info_list__item_detail--";
            // line 464
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_detail\">
                                        <div id=\"product_info_list__detail_name--";
            // line 465
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_name_area\">
                                            <strong id=\"product_info_list__product_name--";
            // line 466
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_name\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "product_name", array()), "html", null, true);
            echo "</strong><br>
                                            <span id=\"product_info_list__product_code--";
            // line 467
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_id small\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "product_code", array()), "html", null, true);
            echo "</span>
                                            <span id=\"product_info_list__class_category_name--";
            // line 468
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_pattern small\">
                                                ";
            // line 469
            if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_category_name1", array()))) {
                // line 470
                echo "                                                / (
                                                    ";
                // line 471
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_name1", array()), "html", null, true);
                echo "：
                                                    ";
                // line 472
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_category_name1", array()), "html", null, true);
                echo "
                                                    ";
                // line 473
                if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_category_name2", array()))) {
                    // line 474
                    echo "                                                        /
                                                        ";
                    // line 475
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_name2", array()), "html", null, true);
                    echo "：
                                                        ";
                    // line 476
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "class_category_name2", array()), "html", null, true);
                    echo "
                                                    ";
                }
                // line 478
                echo "                                                    )
                                                ";
            }
            // line 480
            echo "                                            </span>
                                        </div>
                                        <div class=\"row\">
                                            <div id=\"product_info_list__price--";
            // line 483
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                                <span class=\"input-group item_price col-xs-8 col-sm-6 col-md-12\">
                                                    ";
            // line 485
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "price", array()), 'widget');
            echo "
                                                    ";
            // line 486
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "price", array()), 'errors');
            echo "
                                                </span>
                                            </div>
                                            <div class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                                <span id=\"product_info_list__quantity--";
            // line 490
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_quantity\">
                                                    ";
            // line 491
            $context["detail_id"] = $this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "id", array());
            // line 492
            echo "                                                    ";
            if ($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "OrderDetails", array(), "any", false, true), ($context["detail_id"] ?? null), array(), "array", true, true)) {
                // line 493
                echo "                                                        ";
                $context["prev_quantity"] = ($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "OrderDetails", array()), ($context["detail_id"] ?? null), array(), "array"), "quantity", array()) . " ");
                // line 494
                echo "                                                    ";
            } else {
                // line 495
                echo "                                                        ";
                $context["prev_quantity"] = "";
                // line 496
                echo "                                                    ";
            }
            // line 497
            echo "                                                    ";
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
                // line 498
                echo "                                                        数量：";
                echo twig_escape_filter($this->env, ($context["prev_quantity"] ?? null), "html", null, true);
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "quantity", array()), 'widget', array("read_only" => "readonly"));
                echo "
                                                    ";
            } else {
                // line 500
                echo "                                                        数量：";
                echo twig_escape_filter($this->env, ($context["prev_quantity"] ?? null), "html", null, true);
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "quantity", array()), 'widget');
                echo "
                                                    ";
            }
            // line 502
            echo "                                                    ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "quantity", array()), 'errors');
            echo "
                                                </span>
                                            </div>
                                            <div class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                                <span id=\"product_info_list__tax_rate--";
            // line 506
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"item_tax\">
                                                    税率：
                                                    <span class=\"input-group\">
                                                    ";
            // line 509
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "tax_rate", array()), 'widget');
            echo "
                                                    ";
            // line 510
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["orderDetailForm"], "tax_rate", array()), 'errors');
            echo "
                                                    <span class=\"input-group-addon\">%</span>
                                                    </span>
                                                </span>
                                            </div>
                                            <div id=\"product_info_list__total_price--";
            // line 515
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "\" class=\"col-md-12 col-lg-3 item_subtotal text-right\">
                                                <span>小計：</span> ";
            // line 516
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute($this->getAttribute($this->getAttribute($context["orderDetailForm"], "vars", array()), "value", array()), "total_price", array())), "html", null, true);
            echo "
                                            </div>
                                        </div>

                                    </div>
                                    ";
            // line 521
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
                // line 522
                echo "                                    ";
            } else {
                // line 523
                echo "                                    <div id=\"product_info_list__button_multiple_shipping_delete--";
                echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                echo "\" class=\"icon_edit\">
                                        <button type=\"button\" class=\"btn btn-default btn-sm delete-item\">削除</button>
                                    </div>
                                    ";
            }
            // line 527
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
        // line 529
        echo "                        </div>

                        <div id=\"product_info_result_box__sub_price\" class=\"row with-border2 no-margin text-right\">
                            <div class=\"col-lg-7 col-lg-offset-5\">
                                <dl id=\"product_info_result_box__body_sub_price\" class=\"dl-horizontal\">
                                    <dt id=\"product_info_result_box__subtotal\">小計：</dt>
                                    <dd>";
        // line 535
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "subtotal", array())), "html", null, true);
        echo "</dd>
                                    <dt id=\"product_info_result_box__discount\">値引き：</dt>
                                    <dd class=\"form-group form-inline\">
                                        ";
        // line 538
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "discount", array()), 'widget');
        echo "
                                        ";
        // line 539
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "discount", array()), 'errors');
        echo "
                                    </dd>
                                    <dt id=\"product_info_result_box__delivery_fee_total\">送料：</dt>
                                    <dd class=\"form-group form-inline\">
                                        ";
        // line 543
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "delivery_fee_total", array()), 'widget');
        echo "
                                        ";
        // line 544
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "delivery_fee_total", array()), 'errors');
        echo "
                                    </dd>
                                    <dt id=\"product_info_result_box__charge\">手数料：</dt>
                                    <dd class=\"form-group form-inline\">
                                        ";
        // line 548
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "charge", array()), 'widget');
        echo "
                                        ";
        // line 549
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
        // line 560
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "use_point", array()), 'widget');
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "use_point", array()), 'errors');
        echo "</dd>
    <dt id=\"product_info_result_box__point_add\">加算ポイント&nbsp;:</dt>
    <dd>";
        // line 562
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "add_point", array()), 'widget');
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "add_point", array()), 'errors');
        echo "</dd>
</dl>
<dl id=\"product_info_result_box__body_summary\" class=\"dl-horizontal\">
                                    <dt id=\"product_info_result_box__total\">合計：</dt>
                                    <dd>";
        // line 566
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "total", array())), "html", null, true);
        echo "</dd>
                                    <dt id=\"product_info_result_box__payment_total\">お支払合計：</dt>
                                    <dd>";
        // line 568
        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPriceFilter($this->getAttribute(($context["Order"] ?? null), "payment_total", array())), "html", null, true);
        echo "</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            ";
        // line 577
        echo "            <div id=\"payment_info_box\" class=\"box accordion\">
                <div id=\"payment_info_box__toggle\" class=\"box-header toggle active\">
                    <h3 class=\"box-title\">お支払情報<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                </div><!-- /.box-header -->
                <div id=\"payment_info_box__body\" class=\"box-body accpanel\" style=\"display: block;\">
                    <dl id=\"payment_info_box__payment_method\" class=\"dl-horizontal\">
                        <dt>お支払方法</dt>
                        <dd class=\"form-group form-inline\">
                            ";
        // line 585
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "value", array()), "payment_method", array()), "html", null, true);
        echo "<br/>
                            ";
        // line 586
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Payment", array()), 'widget');
        echo "
                            ";
        // line 587
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "Payment", array()), 'errors');
        echo "
                            <p class=\"small\">お支払方法の変更に伴う手数料の変更は手動にてお願いします。</p>
                        </dd>
                    </dl>
                </div>
            </div>

            ";
        // line 595
        echo "            ";
        if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
            // line 596
            echo "            <div id=\"shipping_info__button_new\"><button type=\"submit\" class=\"btn btn-default\" name=\"mode\" value=\"add_delivery\">お届け先を新規追加</button></div>
            ";
        }
        // line 598
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
            // line 599
            echo "            ";
            $context["shippingIndex"] = $this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "name", array());
            // line 600
            echo "            <div id=\"shipping_info_box--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"box accordion\">
                <div id=\"shipping_info_box__toggle--";
            // line 601
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"box-header toggle active\">
                    <h3 class=\"box-title\">お届け先情報";
            // line 602
            if ((twig_length_filter($this->env, $this->getAttribute(($context["form"] ?? null), "Shippings", array())) > 1)) {
                echo "(";
                echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                echo ")";
            }
            echo "<svg class=\"cb cb-angle-down icon_down\"> <use xlink:href=\"#cb-angle-down\" /></svg></h3>
                </div><!-- /.box-header -->
                    <div id=\"shipping_info_box__body--";
            // line 604
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"box-body accpanel\" style=\"display: block;\">
                    <div id=\"shipping_info_list--";
            // line 605
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"order_list\">
                        <div class=\"btn_area\">
                            <ul id=\"shipping_info_list__menu--";
            // line 607
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\">
                                <li><a class=\"btn btn-default copyCustomerToShippingButton\" data-idx=\"";
            // line 608
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\">注文者情報をコピー</a></li>
                                ";
            // line 609
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
                // line 610
                echo "                                <li><a class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#searchProductModal\" data-idx=\"";
                echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                echo "\">商品の追加</a></li>
                                ";
                // line 611
                if ((twig_length_filter($this->env, $this->getAttribute(($context["form"] ?? null), "Shippings", array())) > 1)) {
                    // line 612
                    echo "                                    <li><button type=\"button\" class=\"btn btn-default delete_delivery\" data-idx=\"";
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "\">お届け先情報を削除</button></li>
                                ";
                }
                // line 614
                echo "                                ";
            }
            // line 615
            echo "                            </ul>
                        </div>

                        ";
            // line 618
            if ($this->getAttribute(($context["BaseInfo"] ?? null), "optionMultipleShipping", array())) {
                // line 619
                echo "                        <div class=\"tableish\"
                             id=\"shipment_item_list";
                // line 620
                echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                echo "\"
                             data-prototype=\"
                             ";
                // line 622
                echo twig_escape_filter($this->env,                 $this->renderBlock("__internal_ab08adf125466b5efbc27c4188f928844f208beccaba58438f98b5f4aed794e7", $context, $blocks));
                // line 624
                echo "\">

                        ";
                // line 626
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["shippingForm"], "ShipmentItems", array()));
                foreach ($context['_seq'] as $context["shippingItemkey"] => $context["shipmentItemForm"]) {
                    // line 627
                    echo "                            <div id=\"shipment_item__id--";
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_box shipment_item_idx";
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "\">
                                ";
                    // line 628
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "Product", array()), 'widget');
                    echo "
                                ";
                    // line 629
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "ProductClass", array()), 'widget');
                    echo "
                                ";
                    // line 630
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "Product", array()), 'widget');
                    echo "
                                ";
                    // line 631
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "ProductClass", array()), 'widget');
                    echo "
                                ";
                    // line 632
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "product_name", array()), 'widget');
                    echo "
                                ";
                    // line 633
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "product_code", array()), 'widget');
                    echo "
                                ";
                    // line 634
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "class_name1", array()), 'widget');
                    echo "
                                ";
                    // line 635
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "class_name2", array()), 'widget');
                    echo "
                                ";
                    // line 636
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "class_category_name1", array()), 'widget');
                    echo "
                                ";
                    // line 637
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "class_category_name2", array()), 'widget');
                    echo "
                                <div id=\"shipment_item__detail--";
                    // line 638
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_detail\">
                                    <div id=\"shipment_item__name_detail--";
                    // line 639
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_name_area\">
                                        <strong id=\"shipment_item__product_name--";
                    // line 640
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_name\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "product_name", array()), "html", null, true);
                    echo "</strong><br>
                                        <span id=\"shipment_item__product_code--";
                    // line 641
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_id small\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "product_code", array()), "html", null, true);
                    echo "</span>
                                            <span id=\"shipment_item__class_category_name--";
                    // line 642
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"item_pattern small\">
                                                ";
                    // line 643
                    if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_category_name1", array()))) {
                        // line 644
                        echo "                                                    / (
                                                    ";
                        // line 645
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_name1", array()), "html", null, true);
                        echo "：
                                                    ";
                        // line 646
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_category_name1", array()), "html", null, true);
                        echo "
                                                    ";
                        // line 647
                        if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_category_name2", array()))) {
                            // line 648
                            echo "                                                        /
                                                        ";
                            // line 649
                            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_name2", array()), "html", null, true);
                            echo "：
                                                        ";
                            // line 650
                            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "class_category_name2", array()), "html", null, true);
                            echo "
                                                    ";
                        }
                        // line 652
                        echo "                                                    )
                                                ";
                    }
                    // line 654
                    echo "                                            </span>
                                    </div>
                                    <div id=\"shipment_item__info_item--";
                    // line 656
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"row\">
                                        <div id=\"shipment_item__price--";
                    // line 657
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                            ";
                    // line 658
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "price", array()), 'widget', array("read_only" => "readonly"));
                    echo "
                                        </div>
                                        <div id=\"shipment_item__quantity--";
                    // line 660
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                            <span class=\"item_quantity\">
                                                ";
                    // line 662
                    $context["item_id"] = $this->getAttribute($this->getAttribute($this->getAttribute($context["shipmentItemForm"], "vars", array()), "value", array()), "id", array());
                    // line 663
                    echo "                                                ";
                    if ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array(), "any", false, true), ($context["shippingIndex"] ?? null), array(), "array", false, true), "ShipmentItems", array(), "any", false, true), ($context["item_id"] ?? null), array(), "array", true, true)) {
                        // line 664
                        echo "                                                    ";
                        $context["prev_quantity"] = ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array()), ($context["shippingIndex"] ?? null), array(), "array"), "ShipmentItems", array()), ($context["item_id"] ?? null), array(), "array"), "quantity", array()) . " ");
                        // line 665
                        echo "                                                ";
                    } else {
                        // line 666
                        echo "                                                    ";
                        $context["prev_quantity"] = "";
                        // line 667
                        echo "                                                ";
                    }
                    // line 668
                    echo "                                                数量：";
                    echo twig_escape_filter($this->env, ($context["prev_quantity"] ?? null), "html", null, true);
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "quantity", array()), 'widget', array("attr" => array("class" => "shipment_quantity")));
                    echo "
                                                ";
                    // line 669
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shipmentItemForm"], "quantity", array()), 'errors');
                    echo "
                                            </span>
                                        </div>
                                            <div id=\"shipment_item__delete--";
                    // line 672
                    echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
                    echo "--";
                    echo twig_escape_filter($this->env, $context["shippingItemkey"], "html", null, true);
                    echo "\" class=\"col-md-4 col-lg-3 form-group form-inline text-right\">
                                                <button type=\"button\" class=\"btn btn-default delete_shipping_product\" data-idx=\"";
                    // line 673
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
                // line 679
                echo "                            </div>
                        ";
            }
            // line 681
            echo "
                        <hr>
                        <div id=\"shipment_item_detail--";
            // line 683
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-horizontal\">
                            <div id=\"shipment_item_detail__name--";
            // line 684
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 685
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "name", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10 input_name form-inline\">
                                    ";
            // line 687
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "name", array()), "name01", array()), 'widget', array("attr" => array("placeholder" => "姓")));
            echo "
                                    ";
            // line 688
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "name", array()), "name02", array()), 'widget', array("attr" => array("placeholder" => "名")));
            echo "
                                    ";
            // line 689
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "name", array()), "name01", array()), 'errors');
            echo "
                                    ";
            // line 690
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "name", array()), "name02", array()), 'errors');
            echo "
                                </div>
                            </div>
                            <div id=\"shipment_item_detail__kana--";
            // line 693
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 694
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "kana", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10 input_name form-inline\">
                                    ";
            // line 696
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "kana", array()), "kana01", array()), 'widget', array("attr" => array("placeholder" => "セイ")));
            echo "
                                    ";
            // line 697
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "kana", array()), "kana02", array()), 'widget', array("attr" => array("placeholder" => "メイ")));
            echo "
                                    ";
            // line 698
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "kana", array()), "kana01", array()), 'errors');
            echo "
                                    ";
            // line 699
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "kana", array()), "kana02", array()), 'errors');
            echo "
                                </div>
                            </div>
                            <div id=\"shipment_item_detail__company_name--";
            // line 702
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 703
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "company_name", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    ";
            // line 705
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "company_name", array()), 'widget');
            echo "
                                    ";
            // line 706
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "company_name", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 710
            echo "                            <div id=\"shipment_item_detail__address--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 711
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "address", array()), 'label');
            echo "
                                <div id=\"shipment_item_detail__zip--";
            // line 712
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-9 col-lg-10 input_zip form-inline\">
                                    〒";
            // line 713
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "zip", array()), "zip01", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "zip", array()), "zip02", array()), 'widget');
            echo "
                                    ";
            // line 714
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "zip", array()), "zip01", array()), 'errors');
            echo "
                                    ";
            // line 715
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "zip", array()), "zip02", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 719
            echo "                            <div class=\"form-group\">
                                <div id=\"shipment_item_detail__pref--";
            // line 720
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-offset-2 col-sm-9 col-lg-10 form-inline\">
                                    ";
            // line 721
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "pref", array()), 'widget');
            echo "
                                    ";
            // line 722
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "pref", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 726
            echo "                            <div class=\"form-group\">
                                <div id=\"shipment_item_detail__addr01--";
            // line 727
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-offset-2 col-sm-9 col-lg-10\">
                                    ";
            // line 728
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "addr01", array()), 'widget', array("attr" => array("placeholder" => "市区町村名（例：千代田区神田神保町）")));
            echo "
                                    ";
            // line 729
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "addr01", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 733
            echo "                            <div class=\"form-group\">
                                <div id=\"shipment_item_detail__addr02--";
            // line 734
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-offset-2 col-sm-9 col-lg-10\">
                                    ";
            // line 735
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "addr02", array()), 'widget', array("attr" => array("placeholder" => "番地・ビル名（例：1-3-5）")));
            echo "
                                    ";
            // line 736
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "address", array()), "addr02", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 740
            echo "                            <div id=\"shipment_item_detail__tel--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 741
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "tel", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10 input_tel form-inline\">
                                    ";
            // line 743
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel01", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel02", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel03", array()), 'widget');
            echo "
                                    ";
            // line 744
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel01", array()), 'errors');
            echo "
                                    ";
            // line 745
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel02", array()), 'errors');
            echo "
                                    ";
            // line 746
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "tel", array()), "tel03", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 750
            echo "                            <div id=\"shipment_item_detail__fax--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 751
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "fax", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10 input_tel form-inline\">
                                    ";
            // line 753
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "fax", array()), "fax01", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "fax", array()), "fax02", array()), 'widget');
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["shippingForm"], "fax", array()), "fax03", array()), 'widget');
            echo "
                                    ";
            // line 754
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "fax", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 758
            echo "                            <div id=\"shipment_item_detail__delivery--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 759
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "Delivery", array()), 'label');
            echo "
                                <div id=\"shipment_item_detail__delivery_name--";
            // line 760
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"col-sm-9 col-lg-10\">
                                    ";
            // line 761
            if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "value", array()), "shipping_delivery_name", array()))) {
                // line 762
                echo "                                    ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "value", array()), "shipping_delivery_name", array()), "html", null, true);
                echo "<br/>
                                    ";
            }
            // line 764
            echo "                                    ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "Delivery", array()), 'widget', array("attr" => array("style" => "width:auto", "class" => "shipping-delivery", "data-idx" => ($context["shippingIndex"] ?? null))));
            echo "
                                    ";
            // line 765
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "Delivery", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 769
            echo "                            <div id=\"shipment_item_detail__delivery_time--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 770
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "DeliveryTime", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    ";
            // line 772
            if ( !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "value", array()), "shipping_delivery_time", array()))) {
                // line 773
                echo "                                    ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["shippingForm"], "vars", array()), "value", array()), "shipping_delivery_time", array()), "html", null, true);
                echo "<br/>
                                    ";
            } else {
                // line 775
                echo "                                        指定なし
                                    ";
            }
            // line 777
            echo "                                    ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "DeliveryTime", array()), 'widget', array("attr" => array("style" => "width:auto", "class" => "shipping-delivery-time", "data-idx" => ($context["shippingIndex"] ?? null))));
            echo "
                                    ";
            // line 778
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "DeliveryTime", array()), 'errors');
            echo "
                                </div>
                            </div>
                            ";
            // line 782
            echo "                            <div id=\"shipment_item_detail__shipping_delivery_date--";
            echo twig_escape_filter($this->env, ($context["shippingIndex"] ?? null), "html", null, true);
            echo "\" class=\"form-group\">
                                ";
            // line 783
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "shipping_delivery_date", array()), 'label');
            echo "
                                <div class=\"col-sm-9 col-lg-10\">
                                    ";
            // line 785
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array(), "any", false, true), ($context["shippingIndex"] ?? null), array(), "array", false, true), "shipping_delivery_date", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array()), ($context["shippingIndex"] ?? null), array(), "array"), "shipping_delivery_date", array())))) {
                // line 786
                echo "                                        ";
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["arrOldOrder"] ?? null), "Shippings", array()), ($context["shippingIndex"] ?? null), array(), "array"), "shipping_delivery_date", array()), "Y-m-d"), "html", null, true);
                echo "<br/>
                                    ";
            } else {
                // line 788
                echo "                                        指定なし
                                    ";
            }
            // line 790
            echo "                                    ";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "shipping_delivery_date", array()), 'widget');
            echo "
                                    ";
            // line 791
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute($context["shippingForm"], "shipping_delivery_date", array()), 'errors');
            echo "
                                </div>
                            </div>
                            <div class=\"extra-form\">
                                ";
            // line 795
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["form"] ?? null), "getIterator", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                // line 796
                echo "                                    ";
                if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                    // line 797
                    echo "                                        ";
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'row');
                    echo "
                                    ";
                }
                // line 799
                echo "                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 800
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
        // line 806
        echo "
            <div id=\"shop_info_box\" class=\"box\">
                <div id=\"shop_info_box__header\" class=\"box-header\">
                    <h3 class=\"box-title\">ショップ用メモ欄</h3>
                </div><!-- /.box-header -->
                <div id=\"shop_info_box__note\" class=\"box-body\">";
        // line 811
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
        // line 823
        if ( !(null === ($context["id"] ?? null))) {
            // line 824
            echo "                        <p><a href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_order_page", array("page_no" => (($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array(), "any", false, true), "get", array(0 => "eccube.admin.order.search.page_no"), "method", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array(), "any", false, true), "get", array(0 => "eccube.admin.order.search.page_no"), "method"), "1")) : ("1")))), "html", null, true);
            echo "?resume=1\">戻る</a></p>
                    ";
        }
        // line 826
        echo "                </div>
            </div>

        </div><!-- /.col -->

    </form>
</div>
";
    }

    // line 449
    public function block___internal_4c2075cada8eb3224ab5d4357125c456ec1ae1042b42ba9790e1fc6a8cd1ab0b($context, array $blocks = array())
    {
        // line 450
        echo "                                     ";
        echo twig_include($this->env, $context, "Order/order_detail_prototype.twig", array("orderDetailForm" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "OrderDetails", array()), "vars", array()), "prototype", array())));
        echo "
                                ";
    }

    // line 622
    public function block___internal_ab08adf125466b5efbc27c4188f928844f208beccaba58438f98b5f4aed794e7($context, array $blocks = array())
    {
        // line 623
        echo "                                     ";
        echo twig_include($this->env, $context, "Order/shipment_item_prototype.twig", array("shipmentItemForm" => $this->getAttribute($this->getAttribute($this->getAttribute(($context["shippingForm"] ?? null), "ShipmentItems", array()), "vars", array()), "prototype", array())));
        echo "
                             ";
    }

    // line 835
    public function block_modal($context, array $blocks = array())
    {
        echo "<div class=\"modal fade\" id=\"completePaymentBtn\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"completePaymentBtn\" aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\">決済完了確認</h5>
                <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
            </div>
            <div class=\"modal-body\">
                <div id=\"\">注文番号: ";
        // line 843
        echo twig_escape_filter($this->env, $this->getAttribute(($context["Order"] ?? null), "id", array()), "html", null, true);
        echo "の受注情報を、支払方法「登録済みのクレジットカードで決済」でイプシロン決済サービスに登録します。</div>
            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-default\" data-dismiss=\"modal\">キャンセル</button>
                <button type=\"button\" id=\"register_gmo_epsilon_credit_card_btn\" class=\"btn btn-primary\" >登録する</button>
            </div>
        </div>
    </div>
</div>

";
        // line 854
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
        // line 863
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchCustomerModalForm"] ?? null), "multi", array()), 'widget', array("attr" => array("placeholder" => "会員ID・メールアドレス・お名前")));
        echo "
                </div>
                <div class=\"extra-form form-group\">
                    ";
        // line 866
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["searchCustomerModalForm"] ?? null), "getIterator", array()));
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
        // line 885
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
        // line 894
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchProductModalForm"] ?? null), "id", array()), 'widget', array("attr" => array("placeholder" => "商品名・ID・コード")));
        echo "
                </div>
                <div id=\"search_product_modal_box__category_id\" class=\"form-group\">
                    ";
        // line 897
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["searchProductModalForm"] ?? null), "category_id", array()), 'widget');
        echo "
                </div>
                <div class=\"extra-form form-group\">
                    ";
        // line 900
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["searchProductModalForm"] ?? null), "getIterator", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
            // line 901
            echo "                        ";
            if (preg_match("[^plg*]", $this->getAttribute($this->getAttribute($context["f"], "vars", array()), "name", array()))) {
                // line 902
                echo "                            ";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'label');
                echo "
                            ";
                // line 903
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'widget');
                echo "
                            ";
                // line 904
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["f"], 'errors');
                echo "
                        ";
            }
            // line 906
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 907
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
        return "__string_template__81d67888cd80b148ae56973117d57c7ec416c4136a0ee622a80937eb17fce674";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1955 => 907,  1949 => 906,  1944 => 904,  1940 => 903,  1935 => 902,  1932 => 901,  1928 => 900,  1922 => 897,  1916 => 894,  1905 => 885,  1892 => 873,  1886 => 872,  1881 => 870,  1877 => 869,  1872 => 868,  1869 => 867,  1865 => 866,  1859 => 863,  1848 => 854,  1835 => 843,  1823 => 835,  1816 => 623,  1813 => 622,  1806 => 450,  1803 => 449,  1792 => 826,  1786 => 824,  1784 => 823,  1769 => 811,  1762 => 806,  1743 => 800,  1737 => 799,  1731 => 797,  1728 => 796,  1724 => 795,  1717 => 791,  1712 => 790,  1708 => 788,  1702 => 786,  1700 => 785,  1695 => 783,  1690 => 782,  1684 => 778,  1679 => 777,  1675 => 775,  1669 => 773,  1667 => 772,  1662 => 770,  1657 => 769,  1651 => 765,  1646 => 764,  1640 => 762,  1638 => 761,  1634 => 760,  1630 => 759,  1625 => 758,  1619 => 754,  1611 => 753,  1606 => 751,  1601 => 750,  1595 => 746,  1591 => 745,  1587 => 744,  1579 => 743,  1574 => 741,  1569 => 740,  1563 => 736,  1559 => 735,  1555 => 734,  1552 => 733,  1546 => 729,  1542 => 728,  1538 => 727,  1535 => 726,  1529 => 722,  1525 => 721,  1521 => 720,  1518 => 719,  1512 => 715,  1508 => 714,  1502 => 713,  1498 => 712,  1494 => 711,  1489 => 710,  1483 => 706,  1479 => 705,  1474 => 703,  1470 => 702,  1464 => 699,  1460 => 698,  1456 => 697,  1452 => 696,  1447 => 694,  1443 => 693,  1437 => 690,  1433 => 689,  1429 => 688,  1425 => 687,  1420 => 685,  1416 => 684,  1412 => 683,  1408 => 681,  1404 => 679,  1390 => 673,  1384 => 672,  1378 => 669,  1372 => 668,  1369 => 667,  1366 => 666,  1363 => 665,  1360 => 664,  1357 => 663,  1355 => 662,  1348 => 660,  1343 => 658,  1337 => 657,  1331 => 656,  1327 => 654,  1323 => 652,  1318 => 650,  1314 => 649,  1311 => 648,  1309 => 647,  1305 => 646,  1301 => 645,  1298 => 644,  1296 => 643,  1290 => 642,  1282 => 641,  1274 => 640,  1268 => 639,  1262 => 638,  1258 => 637,  1254 => 636,  1250 => 635,  1246 => 634,  1242 => 633,  1238 => 632,  1234 => 631,  1230 => 630,  1226 => 629,  1222 => 628,  1213 => 627,  1209 => 626,  1205 => 624,  1203 => 622,  1198 => 620,  1195 => 619,  1193 => 618,  1188 => 615,  1185 => 614,  1179 => 612,  1177 => 611,  1172 => 610,  1170 => 609,  1166 => 608,  1162 => 607,  1157 => 605,  1153 => 604,  1144 => 602,  1140 => 601,  1135 => 600,  1132 => 599,  1114 => 598,  1110 => 596,  1107 => 595,  1097 => 587,  1093 => 586,  1089 => 585,  1079 => 577,  1068 => 568,  1063 => 566,  1055 => 562,  1049 => 560,  1035 => 549,  1031 => 548,  1024 => 544,  1020 => 543,  1013 => 539,  1009 => 538,  1003 => 535,  995 => 529,  980 => 527,  972 => 523,  969 => 522,  967 => 521,  959 => 516,  955 => 515,  947 => 510,  943 => 509,  937 => 506,  929 => 502,  922 => 500,  915 => 498,  912 => 497,  909 => 496,  906 => 495,  903 => 494,  900 => 493,  897 => 492,  895 => 491,  891 => 490,  884 => 486,  880 => 485,  875 => 483,  870 => 480,  866 => 478,  861 => 476,  857 => 475,  854 => 474,  852 => 473,  848 => 472,  844 => 471,  841 => 470,  839 => 469,  835 => 468,  829 => 467,  823 => 466,  819 => 465,  815 => 464,  811 => 463,  807 => 462,  803 => 461,  799 => 460,  795 => 459,  791 => 458,  787 => 457,  783 => 456,  779 => 455,  774 => 454,  757 => 453,  753 => 451,  751 => 449,  743 => 443,  739 => 441,  737 => 440,  722 => 428,  704 => 413,  700 => 412,  695 => 410,  692 => 409,  686 => 405,  682 => 404,  677 => 402,  674 => 401,  668 => 397,  660 => 396,  655 => 394,  652 => 393,  646 => 389,  642 => 388,  638 => 387,  630 => 386,  625 => 384,  622 => 383,  616 => 379,  612 => 378,  607 => 376,  604 => 375,  598 => 371,  594 => 370,  590 => 368,  584 => 364,  580 => 363,  576 => 361,  570 => 357,  566 => 356,  562 => 354,  555 => 349,  551 => 348,  545 => 347,  540 => 345,  537 => 344,  531 => 340,  527 => 339,  523 => 338,  519 => 337,  514 => 335,  507 => 331,  503 => 330,  499 => 329,  495 => 328,  490 => 326,  482 => 321,  478 => 320,  474 => 319,  469 => 316,  461 => 310,  459 => 309,  444 => 297,  440 => 296,  436 => 295,  432 => 294,  423 => 288,  419 => 287,  414 => 285,  404 => 278,  397 => 273,  387 => 269,  383 => 268,  378 => 266,  373 => 265,  370 => 264,  366 => 263,  360 => 259,  349 => 257,  346 => 256,  342 => 255,  333 => 249,  329 => 248,  303 => 225,  294 => 220,  257 => 186,  212 => 143,  209 => 142,  203 => 141,  195 => 139,  189 => 137,  186 => 136,  181 => 135,  179 => 134,  172 => 131,  169 => 130,  166 => 129,  163 => 128,  160 => 127,  158 => 126,  141 => 112,  98 => 72,  58 => 34,  55 => 33,  49 => 27,  43 => 26,  39 => 22,  37 => 31,  35 => 30,  33 => 29,  31 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__81d67888cd80b148ae56973117d57c7ec416c4136a0ee622a80937eb17fce674", "");
    }
}
