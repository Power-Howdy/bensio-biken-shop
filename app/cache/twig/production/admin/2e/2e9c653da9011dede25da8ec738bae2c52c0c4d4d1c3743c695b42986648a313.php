<?php

/* __string_template__cba9d774b181e8a58bed685c41ec6846bb5e3cc5e3a843b6afeeb5bf3de7d3d8 */
class __TwigTemplate_29ad05ccf165204d9911e396dee413ef47266d75574d74c40fd8c75d868abecd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("login_frame.twig", "__string_template__cba9d774b181e8a58bed685c41ec6846bb5e3cc5e3a843b6afeeb5bf3de7d3d8", 22);
        $this->blocks = array(
            'main' => array($this, 'block_main'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "login_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 24
        $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme(($context["form"] ?? null), array(0 => "Form/bootstrap_3_horizontal_layout.html.twig"));
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    public function block_main($context, array $blocks = array())
    {
        // line 27
        echo "
    <div class=\"login-box\">
        ";
        // line 29
        echo twig_include($this->env, $context, "alert.twig");
        echo "
        <div class=\"login-box-body\">
            <p class=\"login-logo2\"><img src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_urlpath", array()), "html", null, true);
        echo "/assets/img/logo2.png\" width=\"106\"></p>
            <form name=\"form1\" id=\"form1\" method=\"post\" action=\"";
        // line 32
        echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath(($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "admin_route", array()) . "_login_check"));
        echo "\">
                ";
        // line 33
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "has", array(0 => "eccube.admin.login.target.path"), "method")) {
            // line 34
            echo "                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "get", array(0 => "eccube.admin.login.target.path"), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["targetPath"]) {
                // line 35
                echo "                        <input type=\"hidden\" name=\"_target_path\" value=\"";
                echo twig_escape_filter($this->env, $context["targetPath"], "html", null, true);
                echo "\" />
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['targetPath'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 37
            echo "                ";
        }
        // line 38
        echo "                <div class=\"form-group has-feedback\">
                    ";
        // line 39
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "login_id", array()), 'widget', array("id" => "login_id", "attr" => array("style" => "ime-mode: disabled;", "size" => 20, "class" => "box25", "placeholder" => "ログインID", "autofocus" => true)));
        echo "
                </div>
                <div class=\"form-group has-feedback\">
                    ";
        // line 42
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "password", array()), 'widget', array("attr" => array("size" => 20, "class" => "box25", "placeholder" => "パスワード")));
        echo "
                </div>
                ";
        // line 44
        if (($context["error"] ?? null)) {
            // line 45
            echo "                <div class=\"form-group\">
                    <span class=\"text-danger\">";
            // line 46
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["error"] ?? null));
            echo "</span>
                </div>
                ";
        }
        // line 49
        echo "                <p class=\"btn_area\"><button type=\"submit\" class=\"btn btn-primary btn-block btn-lg\">ログイン</button></p>
                <input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderCsrfToken("authenticate"), "html", null, true);
        echo "\">
                ";
        // line 51
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'rest');
        echo "
            </form>
        </div><!-- /.login-box-body -->
        <p class=\"text-center\"><small class=\"copyright\">Copyright &copy; 2000-";
        // line 54
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo " EC-CUBE CO.,LTD. All Rights Reserved.</small></p>
    </div><!-- /.login-box -->

";
    }

    public function getTemplateName()
    {
        return "__string_template__cba9d774b181e8a58bed685c41ec6846bb5e3cc5e3a843b6afeeb5bf3de7d3d8";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  108 => 54,  102 => 51,  98 => 50,  95 => 49,  89 => 46,  86 => 45,  84 => 44,  79 => 42,  73 => 39,  70 => 38,  67 => 37,  58 => 35,  53 => 34,  51 => 33,  47 => 32,  43 => 31,  38 => 29,  34 => 27,  31 => 26,  27 => 22,  25 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__cba9d774b181e8a58bed685c41ec6846bb5e3cc5e3a843b6afeeb5bf3de7d3d8", "");
    }
}
