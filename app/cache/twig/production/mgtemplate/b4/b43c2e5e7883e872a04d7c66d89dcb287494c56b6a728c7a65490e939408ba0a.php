<?php

/* block.twig */
class __TwigTemplate_a6776a388cf83d03c7cf5959fd53769d0732048291445b34b63669f8127afd22 extends Twig_Template
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
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["Blocks"] ?? null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["Block"]) {
            // line 23
            echo "    <!-- ▼";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Block"], "name", array()), "html", null, true);
            echo " -->
    ";
            // line 24
            if ($this->getAttribute($context["Block"], "logic_flg", array())) {
                // line 25
                echo "        ";
                if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "http_cache", array()), "enabled", array())) {
                    // line 26
                    echo "            ";
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpKernelExtension')->renderFragmentStrategy("esi", $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath(("block_" . $this->getAttribute($context["Block"], "file_name", array()))));
                    echo "
        ";
                } else {
                    // line 28
                    echo "            ";
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpKernelExtension')->renderFragment($this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath(("block_" . $this->getAttribute($context["Block"], "file_name", array()))));
                    echo "
        ";
                }
                // line 30
                echo "    ";
            } else {
                // line 31
                echo "        ";
                echo twig_include($this->env, $context, (("Block/" . $this->getAttribute($context["Block"], "file_name", array())) . ".twig"), array(), true, true);
                echo "
    ";
            }
            // line 33
            echo "    <!-- ▲";
            echo twig_escape_filter($this->env, $this->getAttribute($context["Block"], "name", array()), "html", null, true);
            echo " -->
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Block'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "block.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 33,  61 => 31,  58 => 30,  52 => 28,  46 => 26,  43 => 25,  41 => 24,  36 => 23,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "block.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/block.twig");
    }
}
