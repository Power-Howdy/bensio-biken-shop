<?php

/* __string_template__bafb968150b19cc4c66ad7f6b0431bfc973e7dd93371c0cb4045701cfd0c0514 */
class __TwigTemplate_a1d80ff71fc72df211972e29509655d1a42e88c018770ca09d247084ef4a3cea extends Twig_Template
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
        echo "<script type=\"text/javascript\">
\$(function(){
    \$(\".newslist\").each(function(){
        var listLenght = \$(this).find(\"dl\").length;
        if(listLenght>5){
            \$(this).find(\"dl:gt(4)\").each(function(){\$(this).hide();});
            \$(this).append('<a id=\"news_readmore\">» もっと見る</a>');
            var dispNum = 5;
            \$(this).find(\"#news_readmore\").click(function(){
                dispNum +=5;
                \$(this).parent().find(\"dl:lt(\"+dispNum+\")\").show(400);
                if (dispNum>=listLenght) {
                    \$(this).hide();
                }
            })
        }
    });
});
</script>
<div class=\"news_contents\">
    <div id=\"news_area\">
        <h2 class=\"heading01\">新着情報</h2>
        <div class=\"accordion\">
            <div class=\"newslist\">

                ";
        // line 47
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["NewsList"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["News"]) {
            // line 48
            echo "                <dl>
                    <dt>
                        <span class=\"date\">";
            // line 50
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["News"], "date", array()), "Y/m/d"), "html", null, true);
            echo "</span>
                        <span class=\"news_title\">
                            ";
            // line 52
            echo twig_escape_filter($this->env, $this->getAttribute($context["News"], "title", array()), "html", null, true);
            echo "
                        </span>
                        ";
            // line 54
            if (($this->getAttribute($context["News"], "comment", array()) || $this->getAttribute($context["News"], "url", array()))) {
                // line 55
                echo "                        <span class=\"angle-circle\"><svg class=\"cb cb-angle-down\"><use xlink:href=\"#cb-angle-down\" /></svg></span>
                        ";
            }
            // line 57
            echo "                    </dt>
                    ";
            // line 58
            if (($this->getAttribute($context["News"], "comment", array()) || $this->getAttribute($context["News"], "url", array()))) {
                // line 59
                echo "                    <dd>";
                echo nl2br($this->getAttribute($context["News"], "comment", array()));
                echo "
                        ";
                // line 60
                if ($this->getAttribute($context["News"], "url", array())) {
                    echo "<br>
                        <a href=\"";
                    // line 61
                    echo twig_escape_filter($this->env, $this->getAttribute($context["News"], "url", array()), "html", null, true);
                    echo "\" ";
                    if (($this->getAttribute($context["News"], "link_method", array()) == "1")) {
                        echo "target=\"_blank\"";
                    }
                    echo ">
                        詳しくはこちら
                        </a>";
                }
                // line 64
                echo "                    </dd>
                    ";
            }
            // line 66
            echo "                </dl>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['News'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 68
        echo "
            </div>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "__string_template__bafb968150b19cc4c66ad7f6b0431bfc973e7dd93371c0cb4045701cfd0c0514";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 68,  98 => 66,  94 => 64,  84 => 61,  80 => 60,  75 => 59,  73 => 58,  70 => 57,  66 => 55,  64 => 54,  59 => 52,  54 => 50,  50 => 48,  46 => 47,  19 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__bafb968150b19cc4c66ad7f6b0431bfc973e7dd93371c0cb4045701cfd0c0514", "");
    }
}
