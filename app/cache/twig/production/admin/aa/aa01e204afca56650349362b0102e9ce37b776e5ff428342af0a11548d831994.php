<?php

/* alert.twig */
class __TwigTemplate_c2f6fded0f3b0949e701be38159b88f5cf335e5488a9d747ffe861eee18043a6 extends Twig_Template
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
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "has", array(0 => "eccube.admin.success"), "method")) {
            // line 23
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "get", array(0 => "eccube.admin.success"), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 24
                echo "        <div class=\"row\">
            <div class=\"alert alert-success alert-dismissable alert-section\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span class=\"alert-close\" aria-hidden=\"true\">&times;</span></button>
                <svg class=\"cb cb-info-circle\"> <use xlink:href=\"#cb-info-circle\" /></svg> ";
                // line 27
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["message"]), "html", null, true);
                echo "
            </div>
        </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 32
        echo "
";
        // line 33
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "has", array(0 => "eccube.admin.info"), "method")) {
            // line 34
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "get", array(0 => "eccube.admin.info"), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 35
                echo "        <div class=\"row\">
            <div class=\"alert alert-info alert-dismissable alert-section\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span class=\"alert-close\" aria-hidden=\"true\">&times;</span></button>
                <svg class=\"cb cb-info-circle\"> <use xlink:href=\"#cb-info-circle\" /></svg> ";
                // line 38
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["message"]), "html", null, true);
                echo "
            </div>
        </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 43
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "has", array(0 => "eccube.admin.warning"), "method")) {
            // line 44
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "get", array(0 => "eccube.admin.warning"), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 45
                echo "        <div class=\"row\">
            <div class=\"alert alert-warning alert-dismissable alert-section\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span class=\"alert-close\" aria-hidden=\"true\">&times;</span></button>
                <svg class=\"cb cb-info-circle\"> <use xlink:href=\"#cb-info-circle\" /></svg> ";
                // line 48
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["message"]), "html", null, true);
                echo "
            </div>
        </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 53
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "has", array(0 => "eccube.admin.danger"), "method")) {
            // line 54
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "get", array(0 => "eccube.admin.danger"), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 55
                echo "        <div class=\"row\">
            <div class=\"alert alert-danger alert-dismissable alert-section\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span class=\"alert-close\" aria-hidden=\"true\">&times;</span></button>
                <svg class=\"cb cb-info-circle\"> <use xlink:href=\"#cb-info-circle\" /></svg> ";
                // line 58
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["message"]), "html", null, true);
                echo "
            </div>
        </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 63
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "has", array(0 => "eccube.admin.error"), "method")) {
            // line 64
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "session", array()), "flashBag", array()), "get", array(0 => "eccube.admin.error"), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 65
                echo "        <div class=\"row\">
            <div class=\"alert alert-danger alert-dismissable alert-section\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span class=\"alert-close\" aria-hidden=\"true\">&times;</span></button>
                <svg class=\"cb cb-info-circle\"> <use xlink:href=\"#cb-info-circle\" /></svg> ";
                // line 68
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["message"]), "html", null, true);
                echo "
            </div>
        </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    public function getTemplateName()
    {
        return "alert.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 68,  121 => 65,  116 => 64,  114 => 63,  103 => 58,  98 => 55,  93 => 54,  91 => 53,  80 => 48,  75 => 45,  70 => 44,  68 => 43,  57 => 38,  52 => 35,  47 => 34,  45 => 33,  42 => 32,  31 => 27,  26 => 24,  21 => 23,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "alert.twig", "/home/wp614605/biken-shop-mall.com/public_html/src/Eccube/Resource/template/admin/alert.twig");
    }
}
