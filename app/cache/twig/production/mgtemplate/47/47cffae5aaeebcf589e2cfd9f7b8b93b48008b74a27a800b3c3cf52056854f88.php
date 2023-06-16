<?php

/* Form/form_layout.twig */
class __TwigTemplate_5beecf9b14d1152576075a86cba07d4b62aa723ff953e2ce01669a2530aca4c4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("bootstrap_3_layout.html.twig", "Form/form_layout.twig", 22);
        $this->blocks = array(
            'form_widget_compound' => array($this, 'block_form_widget_compound'),
            'form_row' => array($this, 'block_form_row'),
            'form_errors' => array($this, 'block_form_errors'),
            'form_widget' => array($this, 'block_form_widget'),
            'form_widget_simple' => array($this, 'block_form_widget_simple'),
            'hidden_row' => array($this, 'block_hidden_row'),
            'textarea_widget' => array($this, 'block_textarea_widget'),
            'choice_widget_collapsed' => array($this, 'block_choice_widget_collapsed'),
            'choice_widget_expanded' => array($this, 'block_choice_widget_expanded'),
            'checkbox_widget' => array($this, 'block_checkbox_widget'),
            'radio_widget' => array($this, 'block_radio_widget'),
            'password_widget' => array($this, 'block_password_widget'),
            'date_widget' => array($this, 'block_date_widget'),
            'name_widget' => array($this, 'block_name_widget'),
            'tel_widget' => array($this, 'block_tel_widget'),
            'fax_widget' => array($this, 'block_fax_widget'),
            'zip_widget' => array($this, 'block_zip_widget'),
            'address_widget' => array($this, 'block_address_widget'),
            'form_label' => array($this, 'block_form_label'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "bootstrap_3_layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 24
    public function block_form_widget_compound($context, array $blocks = array())
    {
        // line 25
        if ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "freeze_display_text", array())) {
            // line 26
            echo "<div class=\"dl_table\" ";
            $this->displayBlock("widget_container_attributes", $context, $blocks);
            echo ">";
            // line 27
            if ((twig_test_empty($this->getAttribute(($context["form"] ?? null), "parent", array())) && (twig_length_filter($this->env, ($context["errors"] ?? null)) > 0))) {
                // line 28
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
            }
            // line 30
            $this->displayBlock("form_rows", $context, $blocks);
            // line 31
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'rest');
            // line 32
            echo "</div>";
        } else {
            // line 34
            $this->displayBlock("form_rows", $context, $blocks);
            // line 35
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'rest');
        }
    }

    // line 39
    public function block_form_row($context, array $blocks = array())
    {
        // line 40
        if ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "freeze_display_text", array())) {
            // line 41
            $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("class" => (($this->getAttribute(($context["attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["attr"] ?? null), "class", array()), "")) : (""))));
            // line 42
            echo "    <dl>
        <dt>";
            // line 43
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'label');
            echo "</dt>
        <dd class=\"form-group";
            // line 44
            if ( !($context["valid"] ?? null)) {
                echo " has-error";
            }
            if (twig_in_filter("middle", $this->getAttribute(($context["attr"] ?? null), "class", array()))) {
                echo " input_name";
            }
            if (twig_in_filter("short", $this->getAttribute(($context["attr"] ?? null), "class", array()))) {
                echo " input_tel";
            }
            if (twig_in_filter("zip", $this->getAttribute(($context["attr"] ?? null), "class", array()))) {
                echo " input_zip";
            }
            echo "\">
            ";
            // line 45
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
            echo "
            ";
            // line 46
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
            echo "
        </dd>
    </dl>";
        } else {
            // line 50
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
            // line 51
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        }
    }

    // line 55
    public function block_form_errors($context, array $blocks = array())
    {
        // line 56
        if ((twig_length_filter($this->env, ($context["errors"] ?? null)) > 0)) {
            // line 57
            if ($this->getAttribute(($context["form"] ?? null), "parent", array())) {
                // line 58
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                    // line 59
                    if (($context["freeze_display_text"] ?? null)) {
                        // line 60
                        echo "<p class=\"errormsg text-danger\">";
                        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($this->getAttribute($context["error"], "message", array())), "html", null, true);
                        echo "</p>";
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
        }
    }

    // line 69
    public function block_form_widget($context, array $blocks = array())
    {
        // line 70
        $this->displayParentBlock("form_widget", $context, $blocks);
        // line 71
        if ((($context["freeze"] ?? null) == false)) {
            // line 72
            if ((array_key_exists("help", $context) &&  !twig_test_empty(($context["help"] ?? null)))) {
                // line 73
                echo "<p class=\"mini\"><span class=\"attention\">";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["help"] ?? null), array(), ($context["translation_domain"] ?? null)), "html", null, true);
                echo "</span></p>";
            }
        }
    }

    // line 78
    public function block_form_widget_simple($context, array $blocks = array())
    {
        // line 79
        if (($context["freeze"] ?? null)) {
            // line 80
            $context["type"] = "hidden";
            // line 81
            if (($context["freeze_display_text"] ?? null)) {
                // line 82
                echo nl2br(twig_escape_filter($this->env, ((array_key_exists("value", $context)) ? (_twig_default_filter(($context["value"] ?? null), "")) : ("")), "html", null, true));
            }
        }
        // line 85
        $this->displayParentBlock("form_widget_simple", $context, $blocks);
    }

    // line 88
    public function block_hidden_row($context, array $blocks = array())
    {
        // line 89
        if (($context["freeze_display_text"] ?? null)) {
            // line 90
            echo "<div style=\"display: none\">";
            // line 91
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
            // line 92
            echo "</div>";
        } else {
            // line 94
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        }
    }

    // line 98
    public function block_textarea_widget($context, array $blocks = array())
    {
        // line 99
        if (($context["freeze"] ?? null)) {
            // line 100
            $this->displayBlock("form_widget_simple", $context, $blocks);
        } else {
            // line 102
            $this->displayParentBlock("textarea_widget", $context, $blocks);
            // line 103
            if ((array_key_exists("help", $context) &&  !twig_test_empty(($context["help"] ?? null)))) {
                // line 104
                echo "<p class=\"mini\"><span class=\"attention\">";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["help"] ?? null), array(), ($context["translation_domain"] ?? null)), "html", null, true);
                echo "</span></p>";
            }
        }
    }

    // line 109
    public function block_choice_widget_collapsed($context, array $blocks = array())
    {
        // line 110
        if (($context["freeze"] ?? null)) {
            // line 111
            echo "        ";
            $context["flag"] = false;
            // line 112
            echo "        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["choices"] ?? null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["choice"]) {
                // line 113
                echo "            ";
                if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->isSelectedChoice($context["choice"], ($context["value"] ?? null))) {
                    // line 114
                    if (($context["freeze_display_text"] ?? null)) {
                        // line 115
                        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($this->getAttribute($context["choice"], "label", array()), array(), ($context["translation_domain"] ?? null)), "html", null, true);
                        echo "
                ";
                    }
                    // line 117
                    echo "                <input type=\"hidden\" value=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["choice"], "value", array()), "html", null, true);
                    echo "\" ";
                    $this->displayBlock("widget_attributes", $context, $blocks);
                    echo " />
                ";
                    // line 118
                    $context["flag"] = true;
                    // line 119
                    echo "            ";
                }
                // line 120
                echo "        ";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['choice'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 121
            echo "        ";
            if ((($context["flag"] ?? null) == false)) {
                echo "<input type=\"hidden\" value=\"\" ";
                $this->displayBlock("widget_attributes", $context, $blocks);
                echo " />";
            }
        } else {
            // line 123
            $this->displayParentBlock("choice_widget_collapsed", $context, $blocks);
        }
    }

    // line 128
    public function block_choice_widget_expanded($context, array $blocks = array())
    {
        // line 129
        if (($context["freeze"] ?? null)) {
            // line 130
            if (($context["freeze_display_text"] ?? null)) {
                // line 131
                if ($this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->isObject($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))) {
                    // line 132
                    echo "                ";
                    echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array(), "any", false, true), "data", array(), "any", false, true), "name", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array(), "any", false, true), "data", array(), "any", false, true), "name", array()), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))) : ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))), "html", null, true);
                    echo "
            ";
                } else {
                    // line 134
                    echo "                ";
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(($context["choices"] ?? null));
                    foreach ($context['_seq'] as $context["_key"] => $context["choice"]) {
                        // line 135
                        echo "                    ";
                        if ((sprintf($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array())) === sprintf($this->getAttribute($context["choice"], "value", array())))) {
                            // line 136
                            echo "                        ";
                            echo twig_escape_filter($this->env, $this->getAttribute($context["choice"], "label", array()), "html", null, true);
                            echo "
                    ";
                        }
                        // line 138
                        echo "                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['choice'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 139
                    echo "            ";
                }
            }
            // line 141
            echo "<input type=\"hidden\" value=\"";
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array(), "any", false, true), "data", array(), "any", false, true), "id", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array(), "any", false, true), "data", array(), "any", false, true), "id", array()), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))) : ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))), "html", null, true);
            echo "\" ";
            $this->displayBlock("widget_attributes", $context, $blocks);
            echo " />";
        } else {
            // line 143
            $this->displayParentBlock("choice_widget_expanded", $context, $blocks);
        }
    }

    // line 148
    public function block_checkbox_widget($context, array $blocks = array())
    {
        // line 149
        if (($context["freeze"] ?? null)) {
            // line 150
            if (($context["checked"] ?? null)) {
                // line 151
                if (($context["freeze_display_text"] ?? null)) {
                    // line 152
                    $this->displayBlock("form_label", $context, $blocks);
                }
                // line 154
                echo "<input type=\"hidden\" ";
                $this->displayBlock("widget_attributes", $context, $blocks);
                if (array_key_exists("value", $context)) {
                    echo " value=\"";
                    echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
                    echo "\"";
                }
                echo " />";
            }
        } else {
            // line 157
            $this->displayParentBlock("checkbox_widget", $context, $blocks);
        }
    }

    // line 161
    public function block_radio_widget($context, array $blocks = array())
    {
        // line 162
        if (($context["freeze"] ?? null)) {
            // line 163
            if (($context["checked"] ?? null)) {
                // line 164
                if (($context["freeze_display_text"] ?? null)) {
                    // line 165
                    $this->displayBlock("form_label", $context, $blocks);
                }
                // line 167
                echo "<input type=\"hidden\" ";
                $this->displayBlock("widget_attributes", $context, $blocks);
                if (array_key_exists("value", $context)) {
                    echo " value=\"";
                    echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
                    echo "\"";
                }
                echo " />";
            }
        } else {
            // line 170
            $this->displayParentBlock("radio_widget", $context, $blocks);
        }
    }

    // line 175
    public function block_password_widget($context, array $blocks = array())
    {
        // line 176
        if (($context["freeze"] ?? null)) {
            // line 177
            echo "<input type=\"hidden\" ";
            $this->displayBlock("widget_attributes", $context, $blocks);
            echo " value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()), "html", null, true);
            echo "\" />";
        } else {
            // line 179
            $this->displayParentBlock("password_widget", $context, $blocks);
        }
    }

    // line 184
    public function block_date_widget($context, array $blocks = array())
    {
        // line 185
        if (($context["freeze"] ?? null)) {
            // line 186
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                // line 187
                if ( !twig_test_empty($this->getAttribute($this->getAttribute($context["child"], "vars", array()), "value", array()))) {
                    // line 188
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget');
                    // line 189
                    if (($this->getAttribute($context["loop"], "last", array()) == false)) {
                        echo "/";
                    }
                }
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } else {
            // line 193
            $this->displayParentBlock("date_widget", $context, $blocks);
        }
    }

    // line 202
    public function block_name_widget($context, array $blocks = array())
    {
        // line 203
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 204
            if (($context["freeze"] ?? null)) {
                // line 205
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget');
            } else {
                // line 207
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget');
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 210
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 211
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 215
    public function block_tel_widget($context, array $blocks = array())
    {
        // line 216
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 217
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget', array("type" => "tel", "attr" => array("style" => "ime-mode: disabled;")));
            // line 218
            if (($context["freeze"] ?? null)) {
                // line 219
                if (($context["freeze_display_text"] ?? null)) {
                    // line 220
                    if ( !twig_test_empty($this->getAttribute($this->getAttribute($context["child"], "vars", array()), "value", array()))) {
                        // line 221
                        if (($this->getAttribute($context["loop"], "last", array()) == false)) {
                            echo "&nbsp;-&nbsp;";
                        }
                    }
                }
            } else {
                // line 225
                if (($this->getAttribute($context["loop"], "last", array()) == false)) {
                    echo "&nbsp;-&nbsp;";
                }
            }
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 228
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 229
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 233
    public function block_fax_widget($context, array $blocks = array())
    {
        // line 234
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 235
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget', array("attr" => array("style" => "ime-mode: disabled;")));
            // line 236
            if (($this->getAttribute($context["loop"], "last", array()) == false)) {
                echo "&nbsp;-&nbsp;";
            }
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 238
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 239
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 243
    public function block_zip_widget($context, array $blocks = array())
    {
        // line 244
        if (($context["freeze"] ?? null)) {
            // line 245
            if (($context["freeze_display_text"] ?? null)) {
                echo "〒&nbsp;";
            }
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "zip01_name", array()), array(), "array"), 'widget');
            if (($context["freeze_display_text"] ?? null)) {
                echo "&nbsp;-&nbsp;";
            }
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "zip02_name", array()), array(), "array"), 'widget');
        } else {
            // line 247
            echo "〒";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "zip01_name", array()), array(), "array"), 'widget', array("id" => "zip01", "attr" => array("style" => "ime-mode: disabled;", "pattern" => "\\d*")));
            echo "-";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "zip02_name", array()), array(), "array"), 'widget', array("id" => "zip02", "attr" => array("style" => "ime-mode: disabled;", "pattern" => "\\d*")));
            // line 248
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                // line 249
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 251
            echo "<div class=\"zip-search\"><button type=\"button\" id=\"zip-search\" class=\"btn btn-default btn-sm\">郵便番号から自動入力</button></div>";
        }
    }

    // line 255
    public function block_address_widget($context, array $blocks = array())
    {
        // line 256
        echo "<div class=\"form-inline form-group input_zip\">";
        // line 257
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "pref_name", array()), array(), "array"), 'widget', array("id" => "pref"));
        // line 258
        echo "</div>";
        // line 259
        if (($context["freeze"] ?? null)) {
            // line 260
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "addr01_name", array()), array(), "array"), 'widget');
            // line 261
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "addr02_name", array()), array(), "array"), 'widget');
        } else {
            // line 263
            echo "<div class=\"form-group\">";
            // line 264
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "addr01_name", array()), array(), "array"), 'widget', array("id" => "addr01", "attr" => array("style" => "ime-mode: active;", "placeholder" => "form.address1.help")));
            echo "<br />
        </div>
        <div class=\"form-group\">";
            // line 267
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "addr02_name", array()), array(), "array"), 'widget', array("id" => "addr02", "attr" => array("style" => "ime-mode: active;", "placeholder" => "form.address2.help")));
            echo "<br />
        </div>";
            // line 269
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                // line 270
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    // line 275
    public function block_form_label($context, array $blocks = array())
    {
        // line 276
        $this->displayParentBlock("form_label", $context, $blocks);
        // line 277
        if ( !($context["freeze"] ?? null)) {
            // line 278
            if (($context["required"] ?? null)) {
                echo "<span class=\"required\">必須</span>";
            }
        }
    }

    public function getTemplateName()
    {
        return "Form/form_layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  692 => 278,  690 => 277,  688 => 276,  685 => 275,  676 => 270,  672 => 269,  668 => 267,  663 => 264,  661 => 263,  658 => 261,  656 => 260,  654 => 259,  652 => 258,  650 => 257,  648 => 256,  645 => 255,  640 => 251,  634 => 249,  630 => 248,  625 => 247,  615 => 245,  613 => 244,  610 => 243,  602 => 239,  598 => 238,  582 => 236,  580 => 235,  563 => 234,  560 => 233,  552 => 229,  548 => 228,  531 => 225,  524 => 221,  522 => 220,  520 => 219,  518 => 218,  516 => 217,  499 => 216,  496 => 215,  488 => 211,  484 => 210,  477 => 207,  474 => 205,  472 => 204,  468 => 203,  465 => 202,  460 => 193,  442 => 189,  440 => 188,  438 => 187,  421 => 186,  419 => 185,  416 => 184,  411 => 179,  404 => 177,  402 => 176,  399 => 175,  394 => 170,  383 => 167,  380 => 165,  378 => 164,  376 => 163,  374 => 162,  371 => 161,  366 => 157,  355 => 154,  352 => 152,  350 => 151,  348 => 150,  346 => 149,  343 => 148,  338 => 143,  331 => 141,  327 => 139,  321 => 138,  315 => 136,  312 => 135,  307 => 134,  301 => 132,  299 => 131,  297 => 130,  295 => 129,  292 => 128,  287 => 123,  279 => 121,  265 => 120,  262 => 119,  260 => 118,  253 => 117,  248 => 115,  246 => 114,  243 => 113,  225 => 112,  222 => 111,  220 => 110,  217 => 109,  209 => 104,  207 => 103,  205 => 102,  202 => 100,  200 => 99,  197 => 98,  192 => 94,  189 => 92,  187 => 91,  185 => 90,  183 => 89,  180 => 88,  176 => 85,  172 => 82,  170 => 81,  168 => 80,  166 => 79,  163 => 78,  155 => 73,  153 => 72,  151 => 71,  149 => 70,  146 => 69,  133 => 60,  131 => 59,  127 => 58,  125 => 57,  123 => 56,  120 => 55,  115 => 51,  113 => 50,  107 => 46,  103 => 45,  88 => 44,  84 => 43,  81 => 42,  79 => 41,  77 => 40,  74 => 39,  69 => 35,  67 => 34,  64 => 32,  62 => 31,  60 => 30,  57 => 28,  55 => 27,  51 => 26,  49 => 25,  46 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Form/form_layout.twig", "/home/wp614605/biken-shop-mall.com/public_html/app/template/mgtemplate/Form/form_layout.twig");
    }
}
