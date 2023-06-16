<?php

/* Form/form_layout.twig */
class __TwigTemplate_d5da8e78a562f44f20ba0d681fdf9f8cc9bb6ca4aaa8f9f09dce1a235088e8c1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("form_table_layout.html.twig", "Form/form_layout.twig", 22);
        $this->blocks = array(
            'form_widget_compound' => array($this, 'block_form_widget_compound'),
            'form_row' => array($this, 'block_form_row'),
            'form_errors' => array($this, 'block_form_errors'),
            'form_widget' => array($this, 'block_form_widget'),
            'form_widget_simple' => array($this, 'block_form_widget_simple'),
            'widget_attributes' => array($this, 'block_widget_attributes'),
            'hidden_row' => array($this, 'block_hidden_row'),
            'textarea_widget' => array($this, 'block_textarea_widget'),
            'choice_widget_collapsed' => array($this, 'block_choice_widget_collapsed'),
            'choice_widget_expanded' => array($this, 'block_choice_widget_expanded'),
            'checkbox_widget' => array($this, 'block_checkbox_widget'),
            'radio_widget' => array($this, 'block_radio_widget'),
            'password_widget' => array($this, 'block_password_widget'),
            'name_widget' => array($this, 'block_name_widget'),
            'tel_widget' => array($this, 'block_tel_widget'),
            'fax_widget' => array($this, 'block_fax_widget'),
            'zip_widget' => array($this, 'block_zip_widget'),
            'address_widget' => array($this, 'block_address_widget'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "form_table_layout.html.twig";
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
            echo "<table ";
            $this->displayBlock("widget_container_attributes", $context, $blocks);
            echo ">";
            // line 27
            if ((twig_test_empty($this->getAttribute(($context["form"] ?? null), "parent", array())) && (twig_length_filter($this->env, ($context["errors"] ?? null)) > 0))) {
                // line 28
                echo "<tr>
                <td colspan=\"2\">";
                // line 30
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
                // line 31
                echo "</td>
            </tr>";
            }
            // line 34
            $this->displayBlock("form_rows", $context, $blocks);
            // line 35
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'rest');
            // line 36
            echo "</table>";
        } else {
            // line 38
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
            // line 39
            $this->displayBlock("form_rows", $context, $blocks);
            // line 40
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'rest');
        }
    }

    // line 44
    public function block_form_row($context, array $blocks = array())
    {
        // line 45
        if ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "freeze_display_text", array())) {
            // line 46
            echo "<tr>
            <th>";
            // line 48
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'label');
            // line 49
            if ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "required", array())) {
                echo "<span class=\"attention\">※</span>";
            }
            // line 50
            echo "            </th>
            <td>";
            // line 52
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
            // line 53
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
            // line 54
            echo "</td>
        </tr>";
        } else {
            // line 57
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
            // line 58
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        }
    }

    // line 62
    public function block_form_errors($context, array $blocks = array())
    {
        // line 63
        if ((twig_length_filter($this->env, ($context["errors"] ?? null)) > 0)) {
            // line 64
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 65
                if (($context["freeze_display_text"] ?? null)) {
                    // line 66
                    echo "<span class=\"attention\">※ ";
                    echo twig_escape_filter($this->env, twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($this->getAttribute($context["error"], "messageTemplate", array()), $this->getAttribute($context["error"], "messageParameters", array()), "validators"), array("{{ field }}" => ($context["label"] ?? null))), "html", null, true);
                    echo "<br /></span>";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    // line 74
    public function block_form_widget($context, array $blocks = array())
    {
        // line 75
        $this->displayParentBlock("form_widget", $context, $blocks);
        // line 76
        if ((($context["freeze"] ?? null) == false)) {
            // line 77
            if ((array_key_exists("help", $context) &&  !twig_test_empty(($context["help"] ?? null)))) {
                // line 78
                echo "<p class=\"mini\"><span class=\"attention\">";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["help"] ?? null), array(), ($context["translation_domain"] ?? null)), "html", null, true);
                echo "</span></p>";
            }
        }
    }

    // line 83
    public function block_form_widget_simple($context, array $blocks = array())
    {
        // line 84
        if (($context["freeze"] ?? null)) {
            // line 85
            $context["type"] = "hidden";
            // line 86
            if (($context["freeze_display_text"] ?? null)) {
                // line 87
                echo nl2br(twig_escape_filter($this->env, ((array_key_exists("value", $context)) ? (_twig_default_filter(($context["value"] ?? null), "")) : ("")), "html", null, true));
            }
        }
        // line 90
        $this->displayParentBlock("form_widget_simple", $context, $blocks);
    }

    // line 93
    public function block_widget_attributes($context, array $blocks = array())
    {
        // line 94
        if ((twig_length_filter($this->env, ($context["errors"] ?? null)) > 0)) {
            // line 95
            $context["style"] = "background-color:#ffe8e8;";
            // line 96
            if (($context["attr"] ?? null)) {
                // line 97
                if (($this->getAttribute(($context["attr"] ?? null), "style", array(), "array", true, true) && (twig_length_filter($this->env, $this->getAttribute(($context["attr"] ?? null), "style", array(), "array")) > 0))) {
                    // line 98
                    $context["style"] = ((($context["style"] ?? null) . " ") . $this->getAttribute(($context["attr"] ?? null), "style", array(), "array"));
                }
                // line 100
                $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("style" => ($context["style"] ?? null)));
            } else {
                // line 102
                $context["attr"] = array("style" => ($context["style"] ?? null));
            }
        }
        // line 105
        echo "id=\"";
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, ($context["full_name"] ?? null), "html", null, true);
        echo "\"";
        if (($context["read_only"] ?? null)) {
            echo "disabled=\"disabled\"";
        }
        if (($context["required"] ?? null)) {
            echo " required=\"required\"";
        }
        if (($context["pattern"] ?? null)) {
            echo " pattern=\"";
            echo twig_escape_filter($this->env, ($context["pattern"] ?? null), "html", null, true);
            echo "\"";
        }
        // line 106
        if ((($context["freeze"] ?? null) == false)) {
            // line 107
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attr"] ?? null));
            foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
                echo " ";
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
                echo "\" ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    // line 111
    public function block_hidden_row($context, array $blocks = array())
    {
        // line 112
        if (($context["freeze_display_text"] ?? null)) {
            // line 113
            echo "<tr style=\"display: none\">
            <td colspan=\"2\">";
            // line 115
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
            // line 116
            echo "</td>
        </tr>";
        } else {
            // line 119
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        }
    }

    // line 123
    public function block_textarea_widget($context, array $blocks = array())
    {
        // line 124
        if (($context["freeze"] ?? null)) {
            // line 125
            $this->displayBlock("form_widget_simple", $context, $blocks);
        } else {
            // line 127
            $this->displayParentBlock("textarea_widget", $context, $blocks);
            // line 128
            if ((array_key_exists("help", $context) &&  !twig_test_empty(($context["help"] ?? null)))) {
                // line 129
                echo "<p class=\"mini\"><span class=\"attention\">";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["help"] ?? null), array(), ($context["translation_domain"] ?? null)), "html", null, true);
                echo "</span></p>";
            }
        }
    }

    // line 134
    public function block_choice_widget_collapsed($context, array $blocks = array())
    {
        // line 135
        if (($context["freeze"] ?? null)) {
            // line 136
            echo "        ";
            $context["flag"] = false;
            // line 137
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
                // line 138
                echo "            ";
                if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->isSelectedChoice($context["choice"], ($context["value"] ?? null))) {
                    // line 139
                    if (($context["freeze_display_text"] ?? null)) {
                        // line 140
                        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($this->getAttribute($context["choice"], "label", array()), array(), ($context["translation_domain"] ?? null)), "html", null, true);
                        echo "
                ";
                    }
                    // line 142
                    echo "                <input type=\"hidden\" value=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["choice"], "value", array()), "html", null, true);
                    echo "\" ";
                    $this->displayBlock("widget_attributes", $context, $blocks);
                    echo " />
                ";
                    // line 143
                    $context["flag"] = true;
                    // line 144
                    echo "            ";
                }
                // line 145
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
            // line 146
            echo "        ";
            if ((($context["flag"] ?? null) == false)) {
                echo "<input type=\"hidden\" value=\"\" ";
                $this->displayBlock("widget_attributes", $context, $blocks);
                echo " />";
            }
        } else {
            // line 148
            $this->displayParentBlock("choice_widget_collapsed", $context, $blocks);
        }
    }

    // line 153
    public function block_choice_widget_expanded($context, array $blocks = array())
    {
        // line 154
        if (($context["freeze"] ?? null)) {
            // line 155
            if (($context["freeze_display_text"] ?? null)) {
                // line 156
                echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array(), "any", false, true), "data", array(), "any", false, true), "name", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array(), "any", false, true), "data", array(), "any", false, true), "name", array()), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))) : ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))), "html", null, true);
            }
            // line 158
            echo "<input type=\"hidden\" value=\"";
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array(), "any", false, true), "data", array(), "any", false, true), "id", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array(), "any", false, true), "data", array(), "any", false, true), "id", array()), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))) : ($this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()))), "html", null, true);
            echo "\" ";
            $this->displayBlock("widget_attributes", $context, $blocks);
            echo " />";
        } else {
            // line 160
            $this->displayParentBlock("choice_widget_expanded", $context, $blocks);
        }
    }

    // line 165
    public function block_checkbox_widget($context, array $blocks = array())
    {
        // line 166
        if (($context["freeze"] ?? null)) {
            // line 167
            if (($context["checked"] ?? null)) {
                // line 168
                if (($context["freeze_display_text"] ?? null)) {
                    // line 169
                    $this->displayBlock("form_label", $context, $blocks);
                }
                // line 171
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
            // line 174
            $this->displayParentBlock("checkbox_widget", $context, $blocks);
        }
    }

    // line 178
    public function block_radio_widget($context, array $blocks = array())
    {
        // line 179
        if (($context["freeze"] ?? null)) {
            // line 180
            if (($context["checked"] ?? null)) {
                // line 181
                if (($context["freeze_display_text"] ?? null)) {
                    // line 182
                    $this->displayBlock("form_label", $context, $blocks);
                }
                // line 184
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
            // line 187
            $this->displayParentBlock("radio_widget", $context, $blocks);
        }
    }

    // line 192
    public function block_password_widget($context, array $blocks = array())
    {
        // line 193
        if (($context["freeze"] ?? null)) {
            // line 194
            echo "<input type=\"hidden\" ";
            $this->displayBlock("widget_attributes", $context, $blocks);
            echo " value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "data", array()), "html", null, true);
            echo "\" />";
        } else {
            // line 196
            $this->displayParentBlock("password_widget", $context, $blocks);
        }
    }

    // line 203
    public function block_name_widget($context, array $blocks = array())
    {
        // line 204
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 205
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 207
        if (($context["freeze"] ?? null)) {
            // line 208
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "name01", array()), array(), "array"), 'widget');
            // line 209
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "name02", array()), array(), "array"), 'widget');
        } else {
            // line 211
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "name01", array()), array(), "array"), 'widget');
            // line 212
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "name02", array()), array(), "array"), 'widget');
        }
        // line 215
        if (($this->getAttribute(($context["loop"] ?? null), "last", array()) == false)) {
            echo "　";
        }
    }

    // line 218
    public function block_tel_widget($context, array $blocks = array())
    {
        // line 219
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 220
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 222
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
            // line 223
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget', array("attr" => array("style" => "ime-mode: disabled;")));
            // line 224
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
    }

    // line 228
    public function block_fax_widget($context, array $blocks = array())
    {
        // line 229
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 230
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 232
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
            // line 233
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget', array("attr" => array("style" => "ime-mode: disabled;")));
            // line 234
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
    }

    // line 238
    public function block_zip_widget($context, array $blocks = array())
    {
        // line 239
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 240
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 242
        if (($context["freeze"] ?? null)) {
            // line 243
            echo "〒&nbsp;";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "zip01_name", array()), array(), "array"), 'widget');
            echo "&nbsp;-&nbsp;";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "zip02_name", array()), array(), "array"), 'widget');
        } else {
            // line 245
            echo "〒&nbsp;";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "zip01_name", array()), array(), "array"), 'widget', array("attr" => array("style" => "ime-mode: disabled;")));
            echo "&nbsp;-&nbsp;";
            // line 246
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "zip02_name", array()), array(), "array"), 'widget', array("attr" => array("style" => "ime-mode: disabled;")));
            echo "
        <a class=\"btn-normal\" href=\"javascript:;\" name=\"address_input\" onclick=\"eccube.getAddress('";
            // line 247
            echo $this->env->getExtension('Eccube\Twig\Extension\EccubeExtension')->getPath("input_zip");
            echo "', 'zip01', 'zip02', 'pref', 'addr01'); return false;\">住所入力</a>";
        }
    }

    // line 251
    public function block_address_widget($context, array $blocks = array())
    {
        // line 252
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 253
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'errors');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 255
        if (($context["freeze"] ?? null)) {
            // line 256
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "pref_name", array()), array(), "array"), 'widget');
            // line 257
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "addr01_name", array()), array(), "array"), 'widget');
            // line 258
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "addr02_name", array()), array(), "array"), 'widget');
        } else {
            // line 260
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "pref_name", array()), array(), "array"), 'widget');
            echo "<br />";
            // line 261
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "addr01_name", array()), array(), "array"), 'widget', array("attr" => array("style" => "ime-mode: active;")));
            echo "<br />";
            // line 262
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), $this->getAttribute($this->getAttribute(($context["form"] ?? null), "vars", array()), "addr02_name", array()), array(), "array"), 'widget', array("attr" => array("style" => "ime-mode: active;")));
            echo "<br />";
            // line 263
            if ((array_key_exists("help", $context) &&  !twig_test_empty(($context["help"] ?? null)))) {
                // line 264
                echo "<span class=\"attention\">";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["help"] ?? null), array(), ($context["translation_domain"] ?? null)), "html", null, true);
                echo "</span>";
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
        return array (  634 => 264,  632 => 263,  629 => 262,  626 => 261,  623 => 260,  620 => 258,  618 => 257,  616 => 256,  614 => 255,  608 => 253,  604 => 252,  601 => 251,  595 => 247,  591 => 246,  587 => 245,  581 => 243,  579 => 242,  573 => 240,  569 => 239,  566 => 238,  548 => 234,  546 => 233,  529 => 232,  523 => 230,  519 => 229,  516 => 228,  498 => 224,  496 => 223,  479 => 222,  473 => 220,  469 => 219,  466 => 218,  460 => 215,  457 => 212,  455 => 211,  452 => 209,  450 => 208,  448 => 207,  442 => 205,  438 => 204,  435 => 203,  430 => 196,  423 => 194,  421 => 193,  418 => 192,  413 => 187,  402 => 184,  399 => 182,  397 => 181,  395 => 180,  393 => 179,  390 => 178,  385 => 174,  374 => 171,  371 => 169,  369 => 168,  367 => 167,  365 => 166,  362 => 165,  357 => 160,  350 => 158,  347 => 156,  345 => 155,  343 => 154,  340 => 153,  335 => 148,  327 => 146,  313 => 145,  310 => 144,  308 => 143,  301 => 142,  296 => 140,  294 => 139,  291 => 138,  273 => 137,  270 => 136,  268 => 135,  265 => 134,  257 => 129,  255 => 128,  253 => 127,  250 => 125,  248 => 124,  245 => 123,  240 => 119,  236 => 116,  234 => 115,  231 => 113,  229 => 112,  226 => 111,  210 => 107,  208 => 106,  191 => 105,  187 => 102,  184 => 100,  181 => 98,  179 => 97,  177 => 96,  175 => 95,  173 => 94,  170 => 93,  166 => 90,  162 => 87,  160 => 86,  158 => 85,  156 => 84,  153 => 83,  145 => 78,  143 => 77,  141 => 76,  139 => 75,  136 => 74,  124 => 66,  122 => 65,  118 => 64,  116 => 63,  113 => 62,  108 => 58,  106 => 57,  102 => 54,  100 => 53,  98 => 52,  95 => 50,  91 => 49,  89 => 48,  86 => 46,  84 => 45,  81 => 44,  76 => 40,  74 => 39,  72 => 38,  69 => 36,  67 => 35,  65 => 34,  61 => 31,  59 => 30,  56 => 28,  54 => 27,  50 => 26,  48 => 25,  45 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "Form/form_layout.twig", "/home/wp614605/biken-shop-mall.com/public_html/src/Eccube/Resource/template/admin/Form/form_layout.twig");
    }
}
