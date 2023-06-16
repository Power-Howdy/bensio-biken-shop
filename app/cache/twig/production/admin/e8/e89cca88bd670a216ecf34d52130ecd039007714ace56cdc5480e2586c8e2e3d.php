<?php

/* Store/plugin_table.twig */
class __TwigTemplate_56b73cec51891eb26f3f8e1e4bb4877ec99dd70a0eb1c5917938ad12d627eeb4 extends Twig_Template
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
        // line 22
        if ((twig_length_filter($this->env, ($context["Plugins"] ?? null)) > 0)) {
            // line 23
            echo "    <div class=\"table_list plugin-table\">
        <div class=\"table-responsive with-border\">
            <table class=\"table table-hover table-condensed\">
                <thead>
                <tr>
                    <th>プラグイン</th>
                    <th>バージョン</th>
                    <th>コード</th>
                    <th>アップデート</th>
                    <th>設定</th>
                </tr>
                </thead>
                <tbody>
                ";
            // line 36
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["Plugins"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["Plugin"]) {
                // line 37
                echo "                    ";
                $context["form"] = $this->getAttribute(($context["plugin_forms"] ?? null), $this->getAttribute($context["Plugin"], "id", array()), array(), "array");
                // line 38
                echo "                    <form id=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "name", array()), "html", null, true);
                echo "\" name=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "name", array()), "html", null, true);
                echo "\" method=\"post\" action=\"\" ";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'enctype');
                echo ">
                        <tr class=\"";
                // line 39
                if (($this->getAttribute($context["Plugin"], "enable", array()) == 0)) {
                    echo "active";
                }
                echo "\">
                            <td class=\"tp\">
                                <strong>";
                // line 41
                echo twig_escape_filter($this->env, $this->getAttribute($context["Plugin"], "name", array()), "html", null, true);
                echo "</strong>";
                if (($this->getAttribute($context["Plugin"], "enable", array()) == 0)) {
                    echo "<span class=\"text-danger\"> (停止中)</span>";
                }
                echo "<br>
                                ";
                // line 42
                if (($this->getAttribute($context["Plugin"], "enable", array()) == 1)) {
                    // line 43
                    echo "                                    <a href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_store_plugin_disable", array("id" => $this->getAttribute($context["Plugin"], "id", array()))), "html", null, true);
                    echo "\" ";
                    echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
                    echo " data-method=\"put\" data-confirm=\"false\">
                                        無効にする
                                    </a>
                                ";
                } else {
                    // line 47
                    echo "                                    <a href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_store_plugin_enable", array("id" => $this->getAttribute($context["Plugin"], "id", array()))), "html", null, true);
                    echo "\" ";
                    echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
                    echo " data-method=\"put\" data-confirm=\"false\">
                                        有効にする
                                    </a>
                                ";
                }
                // line 51
                echo "                                /
                                <a href=\"";
                // line 52
                echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_store_plugin_uninstall", array("id" => $this->getAttribute($context["Plugin"], "id", array()))), "html", null, true);
                echo "\" ";
                echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getCsrfTokenForAnchor();
                echo " data-method=\"delete\" data-message=\"このプラグインを削除してもよろしいですか？\">
                                    削除
                                </a>
                            </td>
                            <td class=\"tv text-center\">";
                // line 56
                echo twig_escape_filter($this->env, $this->getAttribute($context["Plugin"], "version", array()), "html", null, true);
                echo "</td>
                            <td class=\"tc\"><p>";
                // line 57
                echo twig_escape_filter($this->env, $this->getAttribute($context["Plugin"], "code", array()), "html", null, true);
                echo "</p>
                                ";
                // line 58
                if ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array(), "any", false, true), $this->getAttribute($context["Plugin"], "code", array()), array(), "array", false, true), "const", array(), "any", false, true), "readme", array(), "any", true, true)) {
                    // line 59
                    echo "                                    <a href=\"#\" class=\"view_readme\" data-toggle=\"modal\" data-target=\"#readmeModal\" data-name=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Plugin"], "name", array()), "html", null, true);
                    echo "\" data-readme=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), $this->getAttribute($context["Plugin"], "code", array()), array(), "array"), "const", array()), "readme"), "html", null, true);
                    echo "\">詳細を表示</a>
                                ";
                }
                // line 61
                echo "                            </td>
                            <td class=\"tu\">
                            ";
                // line 63
                if (($this->getAttribute($context["Plugin"], "source", array()) == 0)) {
                    // line 64
                    echo "                                ";
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "_token", array()), 'widget');
                    echo "
                                ";
                    // line 65
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "plugin_id", array()), 'widget');
                    echo "
                                ";
                    // line 66
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "plugin_archive", array()), 'widget', array("attr" => array("accept" => "application/zip,application/x-tar,application/x-gzip")));
                    echo "
                                ";
                    // line 67
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "plugin_archive", array()), 'errors');
                    echo "
                                <p></p>
                                <a class=\"btn btn-primary btn-xs\" href=\"#\" onclick=\"changeActionSubmit('";
                    // line 69
                    echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_store_plugin_update", array("id" => $this->getAttribute($context["Plugin"], "id", array()))), "html", null, true);
                    echo "', '";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "name", array()), "html", null, true);
                    echo "');\">
                                    アップロード
                                </a>
                            ";
                } else {
                    // line 73
                    echo "                                ";
                    if (($this->getAttribute($context["Plugin"], "updateStatus", array()) == 3)) {
                        // line 74
                        echo "                                    <p>新バージョンのプラグインが利用可能です。
                                        <a class=\"btn btn-default btn-xs\" href=\"";
                        // line 75
                        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("admin_store_plugin_upgrade", array("action" => "update", "id" => $this->getAttribute($context["Plugin"], "source", array()), "version" => $this->getAttribute($context["Plugin"], "version", array()))), "html", null, true);
                        echo "\">今すぐ更新</a>
                                    </p>
                                    <ul class=\"plugin-meta dl-horizontal\">
                                        <li class=\"plugin-version\">プラグインバージョン : ";
                        // line 78
                        echo twig_escape_filter($this->env, $this->getAttribute($context["Plugin"], "newVersion", array()), "html", null, true);
                        echo "</li>
                                        <li class=\"plugin-version\">EC-CUBE対応バージョン : ";
                        // line 79
                        echo twig_escape_filter($this->env, $this->getAttribute($context["Plugin"], "eccubeVersionAsString", array()), "html", null, true);
                        echo "</li>
                                        <li class=\"plugin-update\">更新日 : ";
                        // line 80
                        echo twig_escape_filter($this->env, $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getTimeAgo($this->getAttribute($context["Plugin"], "lastUpdateDate", array())), "html", null, true);
                        echo "</li>
                                    </ul>
                                ";
                    } else {
                        // line 83
                        echo "                                    <p>アップデート対象プラグインはありません。</p>
                                ";
                    }
                    // line 85
                    echo "                                <p><a href=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["Plugin"], "productUrl", array()), "html", null, true);
                    echo "\" target=\"_blank\">詳細情報</a></p>
                            ";
                }
                // line 87
                echo "                            </td>
                            <td class=\"ta text-center\">
                                ";
                // line 89
                if ($this->getAttribute(($context["configPages"] ?? null), $this->getAttribute($context["Plugin"], "code", array()), array(), "array", true, true)) {
                    // line 90
                    echo "                                   <a href='";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["configPages"] ?? null), $this->getAttribute($context["Plugin"], "code", array()), array(), "array"), "html", null, true);
                    echo "'>設定</a>
                                ";
                }
                // line 92
                echo "                            </td>
                        </tr>
                    </form>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Plugin'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 96
            echo "                </tbody>
            </table>
        </div>
    </div>
";
        } else {
            // line 101
            echo "    <div class=\"text-danger\">
        インストールされているプラグインはありません。
    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "Store/plugin_table.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  216 => 101,  209 => 96,  200 => 92,  194 => 90,  192 => 89,  188 => 87,  182 => 85,  178 => 83,  172 => 80,  168 => 79,  164 => 78,  158 => 75,  155 => 74,  152 => 73,  143 => 69,  138 => 67,  134 => 66,  130 => 65,  125 => 64,  123 => 63,  119 => 61,  111 => 59,  109 => 58,  105 => 57,  101 => 56,  92 => 52,  89 => 51,  79 => 47,  69 => 43,  67 => 42,  59 => 41,  52 => 39,  43 => 38,  40 => 37,  36 => 36,  21 => 23,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Store/plugin_table.twig", "/home/wp614605/biken-shop-mall.com/public_html/src/Eccube/Resource/template/admin/Store/plugin_table.twig");
    }
}
