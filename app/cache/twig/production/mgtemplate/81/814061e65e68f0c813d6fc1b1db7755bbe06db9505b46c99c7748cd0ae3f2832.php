<?php

/* form_div_layout.html.twig */
class __TwigTemplate_ba2c1522d61263440b3dad5197278d5cc4fdf592eef5298e1e71a7637c9581ba extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'form_widget' => array($this, 'block_form_widget'),
            'form_widget_simple' => array($this, 'block_form_widget_simple'),
            'form_widget_compound' => array($this, 'block_form_widget_compound'),
            'collection_widget' => array($this, 'block_collection_widget'),
            'textarea_widget' => array($this, 'block_textarea_widget'),
            'choice_widget' => array($this, 'block_choice_widget'),
            'choice_widget_expanded' => array($this, 'block_choice_widget_expanded'),
            'choice_widget_collapsed' => array($this, 'block_choice_widget_collapsed'),
            'choice_widget_options' => array($this, 'block_choice_widget_options'),
            'checkbox_widget' => array($this, 'block_checkbox_widget'),
            'radio_widget' => array($this, 'block_radio_widget'),
            'datetime_widget' => array($this, 'block_datetime_widget'),
            'date_widget' => array($this, 'block_date_widget'),
            'time_widget' => array($this, 'block_time_widget'),
            'number_widget' => array($this, 'block_number_widget'),
            'integer_widget' => array($this, 'block_integer_widget'),
            'money_widget' => array($this, 'block_money_widget'),
            'url_widget' => array($this, 'block_url_widget'),
            'search_widget' => array($this, 'block_search_widget'),
            'percent_widget' => array($this, 'block_percent_widget'),
            'password_widget' => array($this, 'block_password_widget'),
            'hidden_widget' => array($this, 'block_hidden_widget'),
            'email_widget' => array($this, 'block_email_widget'),
            'button_widget' => array($this, 'block_button_widget'),
            'submit_widget' => array($this, 'block_submit_widget'),
            'reset_widget' => array($this, 'block_reset_widget'),
            'form_label' => array($this, 'block_form_label'),
            'button_label' => array($this, 'block_button_label'),
            'repeated_row' => array($this, 'block_repeated_row'),
            'form_row' => array($this, 'block_form_row'),
            'button_row' => array($this, 'block_button_row'),
            'hidden_row' => array($this, 'block_hidden_row'),
            'form' => array($this, 'block_form'),
            'form_start' => array($this, 'block_form_start'),
            'form_end' => array($this, 'block_form_end'),
            'form_enctype' => array($this, 'block_form_enctype'),
            'form_errors' => array($this, 'block_form_errors'),
            'form_rest' => array($this, 'block_form_rest'),
            'form_rows' => array($this, 'block_form_rows'),
            'widget_attributes' => array($this, 'block_widget_attributes'),
            'widget_container_attributes' => array($this, 'block_widget_container_attributes'),
            'button_attributes' => array($this, 'block_button_attributes'),
            'attributes' => array($this, 'block_attributes'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        $this->displayBlock('form_widget', $context, $blocks);
        // line 11
        $this->displayBlock('form_widget_simple', $context, $blocks);
        // line 16
        $this->displayBlock('form_widget_compound', $context, $blocks);
        // line 26
        $this->displayBlock('collection_widget', $context, $blocks);
        // line 33
        $this->displayBlock('textarea_widget', $context, $blocks);
        // line 37
        $this->displayBlock('choice_widget', $context, $blocks);
        // line 45
        $this->displayBlock('choice_widget_expanded', $context, $blocks);
        // line 54
        $this->displayBlock('choice_widget_collapsed', $context, $blocks);
        // line 74
        $this->displayBlock('choice_widget_options', $context, $blocks);
        // line 87
        $this->displayBlock('checkbox_widget', $context, $blocks);
        // line 91
        $this->displayBlock('radio_widget', $context, $blocks);
        // line 95
        $this->displayBlock('datetime_widget', $context, $blocks);
        // line 108
        $this->displayBlock('date_widget', $context, $blocks);
        // line 122
        $this->displayBlock('time_widget', $context, $blocks);
        // line 133
        $this->displayBlock('number_widget', $context, $blocks);
        // line 139
        $this->displayBlock('integer_widget', $context, $blocks);
        // line 144
        $this->displayBlock('money_widget', $context, $blocks);
        // line 148
        $this->displayBlock('url_widget', $context, $blocks);
        // line 153
        $this->displayBlock('search_widget', $context, $blocks);
        // line 158
        $this->displayBlock('percent_widget', $context, $blocks);
        // line 163
        $this->displayBlock('password_widget', $context, $blocks);
        // line 168
        $this->displayBlock('hidden_widget', $context, $blocks);
        // line 173
        $this->displayBlock('email_widget', $context, $blocks);
        // line 178
        $this->displayBlock('button_widget', $context, $blocks);
        // line 192
        $this->displayBlock('submit_widget', $context, $blocks);
        // line 197
        $this->displayBlock('reset_widget', $context, $blocks);
        // line 204
        $this->displayBlock('form_label', $context, $blocks);
        // line 232
        $this->displayBlock('button_label', $context, $blocks);
        // line 236
        $this->displayBlock('repeated_row', $context, $blocks);
        // line 244
        $this->displayBlock('form_row', $context, $blocks);
        // line 252
        $this->displayBlock('button_row', $context, $blocks);
        // line 258
        $this->displayBlock('hidden_row', $context, $blocks);
        // line 264
        $this->displayBlock('form', $context, $blocks);
        // line 270
        $this->displayBlock('form_start', $context, $blocks);
        // line 284
        $this->displayBlock('form_end', $context, $blocks);
        // line 291
        $this->displayBlock('form_enctype', $context, $blocks);
        // line 295
        $this->displayBlock('form_errors', $context, $blocks);
        // line 305
        $this->displayBlock('form_rest', $context, $blocks);
        // line 326
        echo "
";
        // line 329
        $this->displayBlock('form_rows', $context, $blocks);
        // line 335
        $this->displayBlock('widget_attributes', $context, $blocks);
        // line 352
        $this->displayBlock('widget_container_attributes', $context, $blocks);
        // line 366
        $this->displayBlock('button_attributes', $context, $blocks);
        // line 380
        $this->displayBlock('attributes', $context, $blocks);
    }

    // line 3
    public function block_form_widget($context, array $blocks = array())
    {
        // line 4
        if (($context["compound"] ?? null)) {
            // line 5
            $this->displayBlock("form_widget_compound", $context, $blocks);
        } else {
            // line 7
            $this->displayBlock("form_widget_simple", $context, $blocks);
        }
    }

    // line 11
    public function block_form_widget_simple($context, array $blocks = array())
    {
        // line 12
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "text")) : ("text"));
        // line 13
        echo "<input type=\"";
        echo twig_escape_filter($this->env, ($context["type"] ?? null), "html", null, true);
        echo "\" ";
        $this->displayBlock("widget_attributes", $context, $blocks);
        echo " ";
        if ( !twig_test_empty(($context["value"] ?? null))) {
            echo "value=\"";
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "\" ";
        }
        echo "/>";
    }

    // line 16
    public function block_form_widget_compound($context, array $blocks = array())
    {
        // line 17
        echo "<div ";
        $this->displayBlock("widget_container_attributes", $context, $blocks);
        echo ">";
        // line 18
        if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->isRootForm(($context["form"] ?? null))) {
            // line 19
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
        }
        // line 21
        $this->displayBlock("form_rows", $context, $blocks);
        // line 22
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'rest');
        // line 23
        echo "</div>";
    }

    // line 26
    public function block_collection_widget($context, array $blocks = array())
    {
        // line 27
        if (array_key_exists("prototype", $context)) {
            // line 28
            $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("data-prototype" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["prototype"] ?? null), 'row')));
        }
        // line 30
        $this->displayBlock("form_widget", $context, $blocks);
    }

    // line 33
    public function block_textarea_widget($context, array $blocks = array())
    {
        // line 34
        echo "<textarea ";
        $this->displayBlock("widget_attributes", $context, $blocks);
        echo ">";
        echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
        echo "</textarea>";
    }

    // line 37
    public function block_choice_widget($context, array $blocks = array())
    {
        // line 38
        if (($context["expanded"] ?? null)) {
            // line 39
            $this->displayBlock("choice_widget_expanded", $context, $blocks);
        } else {
            // line 41
            $this->displayBlock("choice_widget_collapsed", $context, $blocks);
        }
    }

    // line 45
    public function block_choice_widget_expanded($context, array $blocks = array())
    {
        // line 46
        echo "<div ";
        $this->displayBlock("widget_container_attributes", $context, $blocks);
        echo ">";
        // line 47
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 48
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget');
            // line 49
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'label', array("translation_domain" => ($context["choice_translation_domain"] ?? null)));
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 51
        echo "</div>";
    }

    // line 54
    public function block_choice_widget_collapsed($context, array $blocks = array())
    {
        // line 55
        if (((((($context["required"] ?? null) && (null === ($context["placeholder"] ?? null))) &&  !($context["placeholder_in_choices"] ?? null)) &&  !($context["multiple"] ?? null)) && ( !$this->getAttribute(($context["attr"] ?? null), "size", array(), "any", true, true) || ($this->getAttribute(($context["attr"] ?? null), "size", array()) <= 1)))) {
            // line 56
            $context["required"] = false;
        }
        // line 58
        echo "<select ";
        $this->displayBlock("widget_attributes", $context, $blocks);
        if (($context["multiple"] ?? null)) {
            echo " multiple=\"multiple\"";
        }
        echo ">";
        // line 59
        if ( !(null === ($context["placeholder"] ?? null))) {
            // line 60
            echo "<option value=\"\"";
            if ((($context["required"] ?? null) && twig_test_empty(($context["value"] ?? null)))) {
                echo " selected=\"selected\"";
            }
            echo ">";
            echo twig_escape_filter($this->env, (((($context["placeholder"] ?? null) != "")) ? ($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["placeholder"] ?? null), array(), ($context["translation_domain"] ?? null))) : ("")), "html", null, true);
            echo "</option>";
        }
        // line 62
        if ((twig_length_filter($this->env, ($context["preferred_choices"] ?? null)) > 0)) {
            // line 63
            $context["options"] = ($context["preferred_choices"] ?? null);
            // line 64
            $this->displayBlock("choice_widget_options", $context, $blocks);
            // line 65
            if (((twig_length_filter($this->env, ($context["choices"] ?? null)) > 0) &&  !(null === ($context["separator"] ?? null)))) {
                // line 66
                echo "<option disabled=\"disabled\">";
                echo twig_escape_filter($this->env, ($context["separator"] ?? null), "html", null, true);
                echo "</option>";
            }
        }
        // line 69
        $context["options"] = ($context["choices"] ?? null);
        // line 70
        $this->displayBlock("choice_widget_options", $context, $blocks);
        // line 71
        echo "</select>";
    }

    // line 74
    public function block_choice_widget_options($context, array $blocks = array())
    {
        // line 75
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["options"] ?? null));
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
        foreach ($context['_seq'] as $context["group_label"] => $context["choice"]) {
            // line 76
            if (twig_test_iterable($context["choice"])) {
                // line 77
                echo "<optgroup label=\"";
                echo twig_escape_filter($this->env, (((($context["choice_translation_domain"] ?? null) === false)) ? ($context["group_label"]) : ($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["group_label"], array(), ($context["choice_translation_domain"] ?? null)))), "html", null, true);
                echo "\">
                ";
                // line 78
                $context["options"] = $context["choice"];
                // line 79
                $this->displayBlock("choice_widget_options", $context, $blocks);
                // line 80
                echo "</optgroup>";
            } else {
                // line 82
                echo "<option value=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["choice"], "value", array()), "html", null, true);
                echo "\"";
                if ($this->getAttribute($context["choice"], "attr", array())) {
                    echo " ";
                    $context["attr"] = $this->getAttribute($context["choice"], "attr", array());
                    $this->displayBlock("attributes", $context, $blocks);
                }
                if ($this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->isSelectedChoice($context["choice"], ($context["value"] ?? null))) {
                    echo " selected=\"selected\"";
                }
                echo ">";
                echo twig_escape_filter($this->env, (((($context["choice_translation_domain"] ?? null) === false)) ? ($this->getAttribute($context["choice"], "label", array())) : ($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($this->getAttribute($context["choice"], "label", array()), array(), ($context["choice_translation_domain"] ?? null)))), "html", null, true);
                echo "</option>";
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
        unset($context['_seq'], $context['_iterated'], $context['group_label'], $context['choice'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 87
    public function block_checkbox_widget($context, array $blocks = array())
    {
        // line 88
        echo "<input type=\"checkbox\" ";
        $this->displayBlock("widget_attributes", $context, $blocks);
        if (array_key_exists("value", $context)) {
            echo " value=\"";
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "\"";
        }
        if (($context["checked"] ?? null)) {
            echo " checked=\"checked\"";
        }
        echo " />";
    }

    // line 91
    public function block_radio_widget($context, array $blocks = array())
    {
        // line 92
        echo "<input type=\"radio\" ";
        $this->displayBlock("widget_attributes", $context, $blocks);
        if (array_key_exists("value", $context)) {
            echo " value=\"";
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "\"";
        }
        if (($context["checked"] ?? null)) {
            echo " checked=\"checked\"";
        }
        echo " />";
    }

    // line 95
    public function block_datetime_widget($context, array $blocks = array())
    {
        // line 96
        if ((($context["widget"] ?? null) == "single_text")) {
            // line 97
            $this->displayBlock("form_widget_simple", $context, $blocks);
        } else {
            // line 99
            echo "<div ";
            $this->displayBlock("widget_container_attributes", $context, $blocks);
            echo ">";
            // line 100
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "date", array()), 'errors');
            // line 101
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "time", array()), 'errors');
            // line 102
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "date", array()), 'widget');
            // line 103
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "time", array()), 'widget');
            // line 104
            echo "</div>";
        }
    }

    // line 108
    public function block_date_widget($context, array $blocks = array())
    {
        // line 109
        if ((($context["widget"] ?? null) == "single_text")) {
            // line 110
            $this->displayBlock("form_widget_simple", $context, $blocks);
        } else {
            // line 112
            echo "<div ";
            $this->displayBlock("widget_container_attributes", $context, $blocks);
            echo ">";
            // line 113
            echo twig_replace_filter(($context["date_pattern"] ?? null), array("{{ year }}" =>             // line 114
$this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "year", array()), 'widget'), "{{ month }}" =>             // line 115
$this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "month", array()), 'widget'), "{{ day }}" =>             // line 116
$this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "day", array()), 'widget')));
            // line 118
            echo "</div>";
        }
    }

    // line 122
    public function block_time_widget($context, array $blocks = array())
    {
        // line 123
        if ((($context["widget"] ?? null) == "single_text")) {
            // line 124
            $this->displayBlock("form_widget_simple", $context, $blocks);
        } else {
            // line 126
            $context["vars"] = (((($context["widget"] ?? null) == "text")) ? (array("attr" => array("size" => 1))) : (array()));
            // line 127
            echo "<div ";
            $this->displayBlock("widget_container_attributes", $context, $blocks);
            echo ">
            ";
            // line 128
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "hour", array()), 'widget', ($context["vars"] ?? null));
            if (($context["with_minutes"] ?? null)) {
                echo ":";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "minute", array()), 'widget', ($context["vars"] ?? null));
            }
            if (($context["with_seconds"] ?? null)) {
                echo ":";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "second", array()), 'widget', ($context["vars"] ?? null));
            }
            // line 129
            echo "        </div>";
        }
    }

    // line 133
    public function block_number_widget($context, array $blocks = array())
    {
        // line 135
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "text")) : ("text"));
        // line 136
        $this->displayBlock("form_widget_simple", $context, $blocks);
    }

    // line 139
    public function block_integer_widget($context, array $blocks = array())
    {
        // line 140
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "number")) : ("number"));
        // line 141
        $this->displayBlock("form_widget_simple", $context, $blocks);
    }

    // line 144
    public function block_money_widget($context, array $blocks = array())
    {
        // line 145
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->encodeCurrency($this->env, ($context["money_pattern"] ?? null),         $this->renderBlock("form_widget_simple", $context, $blocks));
    }

    // line 148
    public function block_url_widget($context, array $blocks = array())
    {
        // line 149
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "url")) : ("url"));
        // line 150
        $this->displayBlock("form_widget_simple", $context, $blocks);
    }

    // line 153
    public function block_search_widget($context, array $blocks = array())
    {
        // line 154
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "search")) : ("search"));
        // line 155
        $this->displayBlock("form_widget_simple", $context, $blocks);
    }

    // line 158
    public function block_percent_widget($context, array $blocks = array())
    {
        // line 159
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "text")) : ("text"));
        // line 160
        $this->displayBlock("form_widget_simple", $context, $blocks);
        echo " %";
    }

    // line 163
    public function block_password_widget($context, array $blocks = array())
    {
        // line 164
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "password")) : ("password"));
        // line 165
        $this->displayBlock("form_widget_simple", $context, $blocks);
    }

    // line 168
    public function block_hidden_widget($context, array $blocks = array())
    {
        // line 169
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "hidden")) : ("hidden"));
        // line 170
        $this->displayBlock("form_widget_simple", $context, $blocks);
    }

    // line 173
    public function block_email_widget($context, array $blocks = array())
    {
        // line 174
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "email")) : ("email"));
        // line 175
        $this->displayBlock("form_widget_simple", $context, $blocks);
    }

    // line 178
    public function block_button_widget($context, array $blocks = array())
    {
        // line 179
        if (twig_test_empty(($context["label"] ?? null))) {
            // line 180
            if ( !twig_test_empty(($context["label_format"] ?? null))) {
                // line 181
                $context["label"] = twig_replace_filter(($context["label_format"] ?? null), array("%name%" =>                 // line 182
($context["name"] ?? null), "%id%" =>                 // line 183
($context["id"] ?? null)));
            } else {
                // line 186
                $context["label"] = $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->humanize(($context["name"] ?? null));
            }
        }
        // line 189
        echo "<button type=\"";
        echo twig_escape_filter($this->env, ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "button")) : ("button")), "html", null, true);
        echo "\" ";
        $this->displayBlock("button_attributes", $context, $blocks);
        echo ">";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["label"] ?? null), array(), ($context["translation_domain"] ?? null)), "html", null, true);
        echo "</button>";
    }

    // line 192
    public function block_submit_widget($context, array $blocks = array())
    {
        // line 193
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "submit")) : ("submit"));
        // line 194
        $this->displayBlock("button_widget", $context, $blocks);
    }

    // line 197
    public function block_reset_widget($context, array $blocks = array())
    {
        // line 198
        $context["type"] = ((array_key_exists("type", $context)) ? (_twig_default_filter(($context["type"] ?? null), "reset")) : ("reset"));
        // line 199
        $this->displayBlock("button_widget", $context, $blocks);
    }

    // line 204
    public function block_form_label($context, array $blocks = array())
    {
        // line 205
        if ( !(($context["label"] ?? null) === false)) {
            // line 206
            if ( !($context["compound"] ?? null)) {
                // line 207
                $context["label_attr"] = twig_array_merge(($context["label_attr"] ?? null), array("for" => ($context["id"] ?? null)));
            }
            // line 209
            if (($context["required"] ?? null)) {
                // line 210
                $context["label_attr"] = twig_array_merge(($context["label_attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")) . " required"))));
            }
            // line 212
            if (twig_test_empty(($context["label"] ?? null))) {
                // line 213
                if ( !twig_test_empty(($context["label_format"] ?? null))) {
                    // line 214
                    $context["label"] = twig_replace_filter(($context["label_format"] ?? null), array("%name%" =>                     // line 215
($context["name"] ?? null), "%id%" =>                     // line 216
($context["id"] ?? null)));
                } else {
                    // line 219
                    $context["label"] = $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->humanize(($context["name"] ?? null));
                }
            }
            // line 222
            echo "<label";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["label_attr"] ?? null));
            foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
                echo " ";
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
                echo "\"";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo ">";
            // line 223
            if ((($context["translation_domain"] ?? null) === false)) {
                // line 224
                echo twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
            } else {
                // line 226
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["label"] ?? null), array(), ($context["translation_domain"] ?? null)), "html", null, true);
            }
            // line 228
            echo "</label>";
        }
    }

    // line 232
    public function block_button_label($context, array $blocks = array())
    {
    }

    // line 236
    public function block_repeated_row($context, array $blocks = array())
    {
        // line 241
        $this->displayBlock("form_rows", $context, $blocks);
    }

    // line 244
    public function block_form_row($context, array $blocks = array())
    {
        // line 245
        echo "<div>";
        // line 246
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'label');
        // line 247
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
        // line 248
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        // line 249
        echo "</div>";
    }

    // line 252
    public function block_button_row($context, array $blocks = array())
    {
        // line 253
        echo "<div>";
        // line 254
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        // line 255
        echo "</div>";
    }

    // line 258
    public function block_hidden_row($context, array $blocks = array())
    {
        // line 259
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
    }

    // line 264
    public function block_form($context, array $blocks = array())
    {
        // line 265
        echo         $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->renderBlock(($context["form"] ?? null), 'form_start');
        // line 266
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        // line 267
        echo         $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->renderBlock(($context["form"] ?? null), 'form_end');
    }

    // line 270
    public function block_form_start($context, array $blocks = array())
    {
        // line 271
        $this->getAttribute(($context["form"] ?? null), "setMethodRendered", array(), "method");
        // line 272
        $context["method"] = twig_upper_filter($this->env, ($context["method"] ?? null));
        // line 273
        if (twig_in_filter(($context["method"] ?? null), array(0 => "GET", 1 => "POST"))) {
            // line 274
            $context["form_method"] = ($context["method"] ?? null);
        } else {
            // line 276
            $context["form_method"] = "POST";
        }
        // line 278
        echo "<form";
        if ((($context["name"] ?? null) != "")) {
            echo " name=\"";
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\"";
        }
        echo " method=\"";
        echo twig_escape_filter($this->env, twig_lower_filter($this->env, ($context["form_method"] ?? null)), "html", null, true);
        echo "\" action=\"";
        echo twig_escape_filter($this->env, ($context["action"] ?? null), "html", null, true);
        echo "\"";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["attr"] ?? null));
        foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
            echo " ";
            echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
            echo "=\"";
            echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
            echo "\"";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        if (($context["multipart"] ?? null)) {
            echo " enctype=\"multipart/form-data\"";
        }
        echo ">";
        // line 279
        if ((($context["form_method"] ?? null) != ($context["method"] ?? null))) {
            // line 280
            echo "<input type=\"hidden\" name=\"_method\" value=\"";
            echo twig_escape_filter($this->env, ($context["method"] ?? null), "html", null, true);
            echo "\" />";
        }
    }

    // line 284
    public function block_form_end($context, array $blocks = array())
    {
        // line 285
        if (( !array_key_exists("render_rest", $context) || ($context["render_rest"] ?? null))) {
            // line 286
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'rest');
        }
        // line 288
        echo "</form>";
    }

    // line 291
    public function block_form_enctype($context, array $blocks = array())
    {
        // line 292
        if (($context["multipart"] ?? null)) {
            echo "enctype=\"multipart/form-data\"";
        }
    }

    // line 295
    public function block_form_errors($context, array $blocks = array())
    {
        // line 296
        if ((twig_length_filter($this->env, ($context["errors"] ?? null)) > 0)) {
            // line 297
            echo "<ul>";
            // line 298
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 299
                echo "<li>";
                echo twig_escape_filter($this->env, $this->getAttribute($context["error"], "message", array()), "html", null, true);
                echo "</li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 301
            echo "</ul>";
        }
    }

    // line 305
    public function block_form_rest($context, array $blocks = array())
    {
        // line 306
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 307
            if ( !$this->getAttribute($context["child"], "rendered", array())) {
                // line 308
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'row');
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 312
        if (( !$this->getAttribute(($context["form"] ?? null), "methodRendered", array()) && $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->isRootForm(($context["form"] ?? null)))) {
            // line 313
            $this->getAttribute(($context["form"] ?? null), "setMethodRendered", array(), "method");
            // line 314
            $context["method"] = twig_upper_filter($this->env, ($context["method"] ?? null));
            // line 315
            if (twig_in_filter(($context["method"] ?? null), array(0 => "GET", 1 => "POST"))) {
                // line 316
                $context["form_method"] = ($context["method"] ?? null);
            } else {
                // line 318
                $context["form_method"] = "POST";
            }
            // line 321
            if ((($context["form_method"] ?? null) != ($context["method"] ?? null))) {
                // line 322
                echo "<input type=\"hidden\" name=\"_method\" value=\"";
                echo twig_escape_filter($this->env, ($context["method"] ?? null), "html", null, true);
                echo "\" />";
            }
        }
    }

    // line 329
    public function block_form_rows($context, array $blocks = array())
    {
        // line 330
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            // line 331
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'row');
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 335
    public function block_widget_attributes($context, array $blocks = array())
    {
        // line 336
        echo "id=\"";
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, ($context["full_name"] ?? null), "html", null, true);
        echo "\"";
        // line 337
        if (($context["read_only"] ?? null)) {
            echo " readonly=\"readonly\"";
        }
        // line 338
        if (($context["disabled"] ?? null)) {
            echo " disabled=\"disabled\"";
        }
        // line 339
        if (($context["required"] ?? null)) {
            echo " required=\"required\"";
        }
        // line 340
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["attr"] ?? null));
        foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
            if ((("readonly" != $context["attrname"]) ||  !($context["read_only"] ?? null))) {
                // line 341
                echo " ";
                // line 342
                if (twig_in_filter($context["attrname"], array(0 => "placeholder", 1 => "title"))) {
                    // line 343
                    echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                    echo "=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["attrvalue"], array(), ($context["translation_domain"] ?? null)), "html", null, true);
                    echo "\"";
                } elseif ((                // line 344
$context["attrvalue"] === true)) {
                    // line 345
                    echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                    echo "=\"";
                    echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                    echo "\"";
                } elseif ( !(                // line 346
$context["attrvalue"] === false)) {
                    // line 347
                    echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                    echo "=\"";
                    echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
                    echo "\"";
                }
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 352
    public function block_widget_container_attributes($context, array $blocks = array())
    {
        // line 353
        if ( !twig_test_empty(($context["id"] ?? null))) {
            echo "id=\"";
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"";
        }
        // line 354
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["attr"] ?? null));
        foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
            // line 355
            echo " ";
            // line 356
            if (twig_in_filter($context["attrname"], array(0 => "placeholder", 1 => "title"))) {
                // line 357
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["attrvalue"], array(), ($context["translation_domain"] ?? null)), "html", null, true);
                echo "\"";
            } elseif ((            // line 358
$context["attrvalue"] === true)) {
                // line 359
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "\"";
            } elseif ( !(            // line 360
$context["attrvalue"] === false)) {
                // line 361
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
                echo "\"";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 366
    public function block_button_attributes($context, array $blocks = array())
    {
        // line 367
        echo "id=\"";
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, ($context["full_name"] ?? null), "html", null, true);
        echo "\"";
        if (($context["disabled"] ?? null)) {
            echo " disabled=\"disabled\"";
        }
        // line 368
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["attr"] ?? null));
        foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
            // line 369
            echo " ";
            // line 370
            if (twig_in_filter($context["attrname"], array(0 => "placeholder", 1 => "title"))) {
                // line 371
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["attrvalue"], array(), ($context["translation_domain"] ?? null)), "html", null, true);
                echo "\"";
            } elseif ((            // line 372
$context["attrvalue"] === true)) {
                // line 373
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "\"";
            } elseif ( !(            // line 374
$context["attrvalue"] === false)) {
                // line 375
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
                echo "\"";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 380
    public function block_attributes($context, array $blocks = array())
    {
        // line 381
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["attr"] ?? null));
        foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
            // line 382
            echo " ";
            // line 383
            if (twig_in_filter($context["attrname"], array(0 => "placeholder", 1 => "title"))) {
                // line 384
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans($context["attrvalue"], array(), ($context["translation_domain"] ?? null)), "html", null, true);
                echo "\"";
            } elseif ((            // line 385
$context["attrvalue"] === true)) {
                // line 386
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "\"";
            } elseif ( !(            // line 387
$context["attrvalue"] === false)) {
                // line 388
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
                echo "\"";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "form_div_layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  1046 => 388,  1044 => 387,  1039 => 386,  1037 => 385,  1032 => 384,  1030 => 383,  1028 => 382,  1024 => 381,  1021 => 380,  1009 => 375,  1007 => 374,  1002 => 373,  1000 => 372,  995 => 371,  993 => 370,  991 => 369,  987 => 368,  978 => 367,  975 => 366,  963 => 361,  961 => 360,  956 => 359,  954 => 358,  949 => 357,  947 => 356,  945 => 355,  941 => 354,  935 => 353,  932 => 352,  919 => 347,  917 => 346,  912 => 345,  910 => 344,  905 => 343,  903 => 342,  901 => 341,  896 => 340,  892 => 339,  888 => 338,  884 => 337,  878 => 336,  875 => 335,  867 => 331,  863 => 330,  860 => 329,  852 => 322,  850 => 321,  847 => 318,  844 => 316,  842 => 315,  840 => 314,  838 => 313,  836 => 312,  829 => 308,  827 => 307,  823 => 306,  820 => 305,  815 => 301,  807 => 299,  803 => 298,  801 => 297,  799 => 296,  796 => 295,  790 => 292,  787 => 291,  783 => 288,  780 => 286,  778 => 285,  775 => 284,  768 => 280,  766 => 279,  738 => 278,  735 => 276,  732 => 274,  730 => 273,  728 => 272,  726 => 271,  723 => 270,  719 => 267,  717 => 266,  715 => 265,  712 => 264,  708 => 259,  705 => 258,  701 => 255,  699 => 254,  697 => 253,  694 => 252,  690 => 249,  688 => 248,  686 => 247,  684 => 246,  682 => 245,  679 => 244,  675 => 241,  672 => 236,  667 => 232,  662 => 228,  659 => 226,  656 => 224,  654 => 223,  639 => 222,  635 => 219,  632 => 216,  631 => 215,  630 => 214,  628 => 213,  626 => 212,  623 => 210,  621 => 209,  618 => 207,  616 => 206,  614 => 205,  611 => 204,  607 => 199,  605 => 198,  602 => 197,  598 => 194,  596 => 193,  593 => 192,  583 => 189,  579 => 186,  576 => 183,  575 => 182,  574 => 181,  572 => 180,  570 => 179,  567 => 178,  563 => 175,  561 => 174,  558 => 173,  554 => 170,  552 => 169,  549 => 168,  545 => 165,  543 => 164,  540 => 163,  535 => 160,  533 => 159,  530 => 158,  526 => 155,  524 => 154,  521 => 153,  517 => 150,  515 => 149,  512 => 148,  508 => 145,  505 => 144,  501 => 141,  499 => 140,  496 => 139,  492 => 136,  490 => 135,  487 => 133,  482 => 129,  472 => 128,  467 => 127,  465 => 126,  462 => 124,  460 => 123,  457 => 122,  452 => 118,  450 => 116,  449 => 115,  448 => 114,  447 => 113,  443 => 112,  440 => 110,  438 => 109,  435 => 108,  430 => 104,  428 => 103,  426 => 102,  424 => 101,  422 => 100,  418 => 99,  415 => 97,  413 => 96,  410 => 95,  396 => 92,  393 => 91,  379 => 88,  376 => 87,  346 => 82,  343 => 80,  341 => 79,  339 => 78,  334 => 77,  332 => 76,  315 => 75,  312 => 74,  308 => 71,  306 => 70,  304 => 69,  298 => 66,  296 => 65,  294 => 64,  292 => 63,  290 => 62,  281 => 60,  279 => 59,  272 => 58,  269 => 56,  267 => 55,  264 => 54,  260 => 51,  254 => 49,  252 => 48,  248 => 47,  244 => 46,  241 => 45,  236 => 41,  233 => 39,  231 => 38,  228 => 37,  220 => 34,  217 => 33,  213 => 30,  210 => 28,  208 => 27,  205 => 26,  201 => 23,  199 => 22,  197 => 21,  194 => 19,  192 => 18,  188 => 17,  185 => 16,  171 => 13,  169 => 12,  166 => 11,  161 => 7,  158 => 5,  156 => 4,  153 => 3,  149 => 380,  147 => 366,  145 => 352,  143 => 335,  141 => 329,  138 => 326,  136 => 305,  134 => 295,  132 => 291,  130 => 284,  128 => 270,  126 => 264,  124 => 258,  122 => 252,  120 => 244,  118 => 236,  116 => 232,  114 => 204,  112 => 197,  110 => 192,  108 => 178,  106 => 173,  104 => 168,  102 => 163,  100 => 158,  98 => 153,  96 => 148,  94 => 144,  92 => 139,  90 => 133,  88 => 122,  86 => 108,  84 => 95,  82 => 91,  80 => 87,  78 => 74,  76 => 54,  74 => 45,  72 => 37,  70 => 33,  68 => 26,  66 => 16,  64 => 11,  62 => 3,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "form_div_layout.html.twig", "/home/wp614605/biken-shop-mall.com/public_html/vendor/symfony/twig-bridge/Resources/views/Form/form_div_layout.html.twig");
    }
}
