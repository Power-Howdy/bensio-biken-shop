<?php

/* __string_template__86f591e47fbb77fad962549c14f3ce2667d344514950d9b589dea93cff16f7ed */
class __TwigTemplate_a12aeb3a18d42d18dc266ef4eaa8e1663e38771831509a168de91d8c2da42c67 extends Twig_Template
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
        if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\SecurityExtension')->isGranted("ROLE_USER")) {
            // line 23
            echo "    <div id=\"member\" class=\"member drawer_block pc\">
        <ul class=\"member_link\">
            <li>
                <a href=\"";
            // line 26
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("mypage");
            echo "\">
                    <img src=\"/html/template/mgtemplate/img/user_ico.png\" alt=\"マイページ\" /><span class=\"deco\">マイページ</span>
                </a>
            </li>
            ";
            // line 30
            if (($this->getAttribute(($context["BaseInfo"] ?? null), "option_favorite_product", array()) == 1)) {
                // line 31
                echo "                <li><a href=\"";
                echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("mypage_favorite");
                echo "\"><img src=\"/html/template/mgtemplate/img/bookmark.png\" alt=\"お気に入り\" /><span class=\"deco\">お気に入り</span></a></li>
            ";
            }
            // line 33
            echo "            <li>
                <a href=\"";
            // line 34
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("logout");
            echo "\">
                    <img src=\"/html/template/mgtemplate/img/login_ico.png\" alt=\"ログアウト\" /><span class=\"deco\">ログアウト</span>
                </a>
            </li>
        </ul>
    </div>
";
        } else {
            // line 41
            echo "    <div id=\"member\" class=\"member drawer_block pc\">
        <ul class=\"member_link\">
            <li>
                <a href=\"";
            // line 44
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("entry");
            echo "\">
                    <img src=\"/html/template/mgtemplate/img/user_ico.png\" alt=\"マイページ\" /><span class=\"deco\">新規SHOP会員登録</span>
                </a>
            </li>
            ";
            // line 48
            if (($this->getAttribute(($context["BaseInfo"] ?? null), "option_favorite_product", array()) == 1)) {
                // line 49
                echo "                <li><a href=\"";
                echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("mypage_favorite");
                echo "\"><img src=\"/html/template/mgtemplate/img/bookmark.png\" alt=\"お気に入り\" /><span class=\"deco\">お気に入り</span></a></li>
            ";
            }
            // line 51
            echo "            <li>
                <a href=\"";
            // line 52
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getUrl("mypage_login");
            echo "\">
                    <img src=\"/html/template/mgtemplate/img/login_ico.png\" alt=\"ログアウト\" /><span class=\"deco\">ログイン</span>
                </a>
            </li>
        </ul>
    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "__string_template__86f591e47fbb77fad962549c14f3ce2667d344514950d9b589dea93cff16f7ed";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 52,  74 => 51,  68 => 49,  66 => 48,  59 => 44,  54 => 41,  44 => 34,  41 => 33,  35 => 31,  33 => 30,  26 => 26,  21 => 23,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__86f591e47fbb77fad962549c14f3ce2667d344514950d9b589dea93cff16f7ed", "");
    }
}
