<?php

/* bootstrap_3_layout.html.twig */
class __TwigTemplate_e05f1c9ec5ee0d12cf77dd45cb4bf3782243ea7fd28889f391800bdb3d68b8da extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("form_div_layout.html.twig", "bootstrap_3_layout.html.twig", 1);
        // line 1
        if (!$_trait_0->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."form_div_layout.html.twig".'" cannot be used as a trait.');
        }
        $_trait_0_blocks = $_trait_0->getBlocks();

        $this->traits = $_trait_0_blocks;

        $this->blocks = array_merge(
            $this->traits,
            array(
                'form_widget_simple' => array($this, 'block_form_widget_simple'),
                'textarea_widget' => array($this, 'block_textarea_widget'),
                'button_widget' => array($this, 'block_button_widget'),
                'money_widget' => array($this, 'block_money_widget'),
                'percent_widget' => array($this, 'block_percent_widget'),
                'datetime_widget' => array($this, 'block_datetime_widget'),
                'date_widget' => array($this, 'block_date_widget'),
                'time_widget' => array($this, 'block_time_widget'),
                'choice_widget_collapsed' => array($this, 'block_choice_widget_collapsed'),
                'choice_widget_expanded' => array($this, 'block_choice_widget_expanded'),
                'checkbox_widget' => array($this, 'block_checkbox_widget'),
                'radio_widget' => array($this, 'block_radio_widget'),
                'form_label' => array($this, 'block_form_label'),
                'choice_label' => array($this, 'block_choice_label'),
                'checkbox_label' => array($this, 'block_checkbox_label'),
                'radio_label' => array($this, 'block_radio_label'),
                'checkbox_radio_label' => array($this, 'block_checkbox_radio_label'),
                'form_row' => array($this, 'block_form_row'),
                'button_row' => array($this, 'block_button_row'),
                'choice_row' => array($this, 'block_choice_row'),
                'date_row' => array($this, 'block_date_row'),
                'time_row' => array($this, 'block_time_row'),
                'datetime_row' => array($this, 'block_datetime_row'),
                'checkbox_row' => array($this, 'block_checkbox_row'),
                'radio_row' => array($this, 'block_radio_row'),
                'form_errors' => array($this, 'block_form_errors'),
            )
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "
";
        // line 4
        echo "
";
        // line 5
        $this->displayBlock('form_widget_simple', $context, $blocks);
        // line 11
        echo "
";
        // line 12
        $this->displayBlock('textarea_widget', $context, $blocks);
        // line 16
        echo "
";
        // line 17
        $this->displayBlock('button_widget', $context, $blocks);
        // line 21
        echo "
";
        // line 22
        $this->displayBlock('money_widget', $context, $blocks);
        // line 39
        echo "
";
        // line 40
        $this->displayBlock('percent_widget', $context, $blocks);
        // line 46
        echo "
";
        // line 47
        $this->displayBlock('datetime_widget', $context, $blocks);
        // line 60
        echo "
";
        // line 61
        $this->displayBlock('date_widget', $context, $blocks);
        // line 79
        echo "
";
        // line 80
        $this->displayBlock('time_widget', $context, $blocks);
        // line 94
        echo "
";
        // line 95
        $this->displayBlock('choice_widget_collapsed', $context, $blocks);
        // line 99
        echo "
";
        // line 100
        $this->displayBlock('choice_widget_expanded', $context, $blocks);
        // line 119
        echo "
";
        // line 120
        $this->displayBlock('checkbox_widget', $context, $blocks);
        // line 130
        echo "
";
        // line 131
        $this->displayBlock('radio_widget', $context, $blocks);
        // line 141
        echo "
";
        // line 143
        echo "
";
        // line 144
        $this->displayBlock('form_label', $context, $blocks);
        // line 148
        echo "
";
        // line 149
        $this->displayBlock('choice_label', $context, $blocks);
        // line 154
        echo "
";
        // line 155
        $this->displayBlock('checkbox_label', $context, $blocks);
        // line 160
        echo "
";
        // line 161
        $this->displayBlock('radio_label', $context, $blocks);
        // line 166
        echo "
";
        // line 167
        $this->displayBlock('checkbox_radio_label', $context, $blocks);
        // line 191
        echo "
";
        // line 193
        echo "
";
        // line 194
        $this->displayBlock('form_row', $context, $blocks);
        // line 201
        echo "
";
        // line 202
        $this->displayBlock('button_row', $context, $blocks);
        // line 207
        echo "
";
        // line 208
        $this->displayBlock('choice_row', $context, $blocks);
        // line 212
        echo "
";
        // line 213
        $this->displayBlock('date_row', $context, $blocks);
        // line 217
        echo "
";
        // line 218
        $this->displayBlock('time_row', $context, $blocks);
        // line 222
        echo "
";
        // line 223
        $this->displayBlock('datetime_row', $context, $blocks);
        // line 227
        echo "
";
        // line 228
        $this->displayBlock('checkbox_row', $context, $blocks);
        // line 234
        echo "
";
        // line 235
        $this->displayBlock('radio_row', $context, $blocks);
        // line 241
        echo "
";
        // line 243
        echo "
";
        // line 244
        $this->displayBlock('form_errors', $context, $blocks);
    }

    // line 5
    public function block_form_widget_simple($context, array $blocks = array())
    {
        // line 6
        if (( !array_key_exists("type", $context) || !twig_in_filter(($context["type"] ?? null), array(0 => "file", 1 => "hidden")))) {
            // line 7
            $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["attr"] ?? null), "class", array()), "")) : ("")) . " form-control"))));
        }
        // line 9
        $this->displayParentBlock("form_widget_simple", $context, $blocks);
    }

    // line 12
    public function block_textarea_widget($context, array $blocks = array())
    {
        // line 13
        $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["attr"] ?? null), "class", array()), "")) : ("")) . " form-control"))));
        // line 14
        $this->displayParentBlock("textarea_widget", $context, $blocks);
    }

    // line 17
    public function block_button_widget($context, array $blocks = array())
    {
        // line 18
        $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["attr"] ?? null), "class", array()), "btn-default")) : ("btn-default")) . " btn"))));
        // line 19
        $this->displayParentBlock("button_widget", $context, $blocks);
    }

    // line 22
    public function block_money_widget($context, array $blocks = array())
    {
        // line 23
        $context["prepend"] =  !(is_string($__internal_fef880c0730dfb64b42b0ef88a6ea83d9d9803980900acba67b193dd1b663ac9 = ($context["money_pattern"] ?? null)) && is_string($__internal_7e6f4cc2e9f72f9056dd6b5c61dfa74addee997a9b7aafecdbfac6a069a9b22c = "{{") && ('' === $__internal_7e6f4cc2e9f72f9056dd6b5c61dfa74addee997a9b7aafecdbfac6a069a9b22c || 0 === strpos($__internal_fef880c0730dfb64b42b0ef88a6ea83d9d9803980900acba67b193dd1b663ac9, $__internal_7e6f4cc2e9f72f9056dd6b5c61dfa74addee997a9b7aafecdbfac6a069a9b22c)));
        // line 24
        echo "    ";
        $context["append"] =  !(is_string($__internal_244c3a60670fa7ed6647b83dac0dceab3881e500610e398725edb4cc81c52391 = ($context["money_pattern"] ?? null)) && is_string($__internal_2bf348660281ccda85a73551c258889f645f73686c4c88e4fcbb7c60fc6d384f = "}}") && ('' === $__internal_2bf348660281ccda85a73551c258889f645f73686c4c88e4fcbb7c60fc6d384f || $__internal_2bf348660281ccda85a73551c258889f645f73686c4c88e4fcbb7c60fc6d384f === substr($__internal_244c3a60670fa7ed6647b83dac0dceab3881e500610e398725edb4cc81c52391, -strlen($__internal_2bf348660281ccda85a73551c258889f645f73686c4c88e4fcbb7c60fc6d384f))));
        // line 25
        echo "    ";
        if ((($context["prepend"] ?? null) || ($context["append"] ?? null))) {
            // line 26
            echo "        <div class=\"input-group\">
            ";
            // line 27
            if (($context["prepend"] ?? null)) {
                // line 28
                echo "                <span class=\"input-group-addon\">";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->encodeCurrency($this->env, ($context["money_pattern"] ?? null));
                echo "</span>
            ";
            }
            // line 30
            $this->displayBlock("form_widget_simple", $context, $blocks);
            // line 31
            if (($context["append"] ?? null)) {
                // line 32
                echo "                <span class=\"input-group-addon\">";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->encodeCurrency($this->env, ($context["money_pattern"] ?? null));
                echo "</span>
            ";
            }
            // line 34
            echo "        </div>
    ";
        } else {
            // line 36
            $this->displayBlock("form_widget_simple", $context, $blocks);
        }
    }

    // line 40
    public function block_percent_widget($context, array $blocks = array())
    {
        // line 41
        echo "<div class=\"input-group\">";
        // line 42
        $this->displayBlock("form_widget_simple", $context, $blocks);
        // line 43
        echo "<span class=\"input-group-addon\">%</span>
    </div>";
    }

    // line 47
    public function block_datetime_widget($context, array $blocks = array())
    {
        // line 48
        if ((($context["widget"] ?? null) == "single_text")) {
            // line 49
            $this->displayBlock("form_widget_simple", $context, $blocks);
        } else {
            // line 51
            $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["attr"] ?? null), "class", array()), "")) : ("")) . " form-inline"))));
            // line 52
            echo "<div ";
            $this->displayBlock("widget_container_attributes", $context, $blocks);
            echo ">";
            // line 53
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "date", array()), 'errors');
            // line 54
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "time", array()), 'errors');
            // line 55
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "date", array()), 'widget', array("datetime" => true));
            // line 56
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "time", array()), 'widget', array("datetime" => true));
            // line 57
            echo "</div>";
        }
    }

    // line 61
    public function block_date_widget($context, array $blocks = array())
    {
        // line 62
        if ((($context["widget"] ?? null) == "single_text")) {
            // line 63
            $this->displayBlock("form_widget_simple", $context, $blocks);
        } else {
            // line 65
            $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["attr"] ?? null), "class", array()), "")) : ("")) . " form-inline"))));
            // line 66
            if (( !array_key_exists("datetime", $context) ||  !($context["datetime"] ?? null))) {
                // line 67
                echo "<div ";
                $this->displayBlock("widget_container_attributes", $context, $blocks);
                echo ">";
            }
            // line 69
            echo twig_replace_filter(($context["date_pattern"] ?? null), array("{{ year }}" =>             // line 70
$this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "year", array()), 'widget'), "{{ month }}" =>             // line 71
$this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "month", array()), 'widget'), "{{ day }}" =>             // line 72
$this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "day", array()), 'widget')));
            // line 74
            if (( !array_key_exists("datetime", $context) ||  !($context["datetime"] ?? null))) {
                // line 75
                echo "</div>";
            }
        }
    }

    // line 80
    public function block_time_widget($context, array $blocks = array())
    {
        // line 81
        if ((($context["widget"] ?? null) == "single_text")) {
            // line 82
            $this->displayBlock("form_widget_simple", $context, $blocks);
        } else {
            // line 84
            $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["attr"] ?? null), "class", array()), "")) : ("")) . " form-inline"))));
            // line 85
            if (( !array_key_exists("datetime", $context) || (false == ($context["datetime"] ?? null)))) {
                // line 86
                echo "<div ";
                $this->displayBlock("widget_container_attributes", $context, $blocks);
                echo ">";
            }
            // line 88
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "hour", array()), 'widget');
            if (($context["with_minutes"] ?? null)) {
                echo ":";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "minute", array()), 'widget');
            }
            if (($context["with_seconds"] ?? null)) {
                echo ":";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($this->getAttribute(($context["form"] ?? null), "second", array()), 'widget');
            }
            // line 89
            echo "        ";
            if (( !array_key_exists("datetime", $context) || (false == ($context["datetime"] ?? null)))) {
                // line 90
                echo "</div>";
            }
        }
    }

    // line 95
    public function block_choice_widget_collapsed($context, array $blocks = array())
    {
        // line 96
        $context["attr"] = twig_array_merge(($context["attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["attr"] ?? null), "class", array()), "")) : ("")) . " form-control"))));
        // line 97
        $this->displayParentBlock("choice_widget_collapsed", $context, $blocks);
    }

    // line 100
    public function block_choice_widget_expanded($context, array $blocks = array())
    {
        // line 101
        if (twig_in_filter("-inline", (($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")))) {
            // line 102
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                // line 103
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget', array("parent_label_class" => (($this->getAttribute(                // line 104
($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")), "translation_domain" =>                 // line 105
($context["choice_translation_domain"] ?? null)));
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } else {
            // line 109
            echo "<div ";
            $this->displayBlock("widget_container_attributes", $context, $blocks);
            echo ">";
            // line 110
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["form"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                // line 111
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock($context["child"], 'widget', array("parent_label_class" => (($this->getAttribute(                // line 112
($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")), "translation_domain" =>                 // line 113
($context["choice_translation_domain"] ?? null)));
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 116
            echo "</div>";
        }
    }

    // line 120
    public function block_checkbox_widget($context, array $blocks = array())
    {
        // line 121
        $context["parent_label_class"] = ((array_key_exists("parent_label_class", $context)) ? (_twig_default_filter(($context["parent_label_class"] ?? null), (($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")))) : ((($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : (""))));
        // line 122
        if (twig_in_filter("checkbox-inline", ($context["parent_label_class"] ?? null))) {
            // line 123
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'label', array("widget" => $this->renderParentBlock("checkbox_widget", $context, $blocks)));
        } else {
            // line 125
            echo "<div class=\"checkbox\">";
            // line 126
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'label', array("widget" => $this->renderParentBlock("checkbox_widget", $context, $blocks)));
            // line 127
            echo "</div>";
        }
    }

    // line 131
    public function block_radio_widget($context, array $blocks = array())
    {
        // line 132
        $context["parent_label_class"] = ((array_key_exists("parent_label_class", $context)) ? (_twig_default_filter(($context["parent_label_class"] ?? null), (($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")))) : ((($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : (""))));
        // line 133
        if (twig_in_filter("radio-inline", ($context["parent_label_class"] ?? null))) {
            // line 134
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'label', array("widget" => $this->renderParentBlock("radio_widget", $context, $blocks)));
        } else {
            // line 136
            echo "<div class=\"radio\">";
            // line 137
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'label', array("widget" => $this->renderParentBlock("radio_widget", $context, $blocks)));
            // line 138
            echo "</div>";
        }
    }

    // line 144
    public function block_form_label($context, array $blocks = array())
    {
        // line 145
        $context["label_attr"] = twig_array_merge(($context["label_attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")) . " control-label"))));
        // line 146
        $this->displayParentBlock("form_label", $context, $blocks);
    }

    // line 149
    public function block_choice_label($context, array $blocks = array())
    {
        // line 151
        $context["label_attr"] = twig_array_merge(($context["label_attr"] ?? null), array("class" => twig_trim_filter(twig_replace_filter((($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")), array("checkbox-inline" => "", "radio-inline" => "")))));
        // line 152
        $this->displayBlock("form_label", $context, $blocks);
    }

    // line 155
    public function block_checkbox_label($context, array $blocks = array())
    {
        // line 156
        $context["label_attr"] = twig_array_merge(($context["label_attr"] ?? null), array("for" => ($context["id"] ?? null)));
        // line 158
        $this->displayBlock("checkbox_radio_label", $context, $blocks);
    }

    // line 161
    public function block_radio_label($context, array $blocks = array())
    {
        // line 162
        $context["label_attr"] = twig_array_merge(($context["label_attr"] ?? null), array("for" => ($context["id"] ?? null)));
        // line 164
        $this->displayBlock("checkbox_radio_label", $context, $blocks);
    }

    // line 167
    public function block_checkbox_radio_label($context, array $blocks = array())
    {
        // line 168
        echo "    ";
        // line 169
        echo "    ";
        if (array_key_exists("widget", $context)) {
            // line 170
            echo "        ";
            if (($context["required"] ?? null)) {
                // line 171
                echo "            ";
                $context["label_attr"] = twig_array_merge(($context["label_attr"] ?? null), array("class" => twig_trim_filter(((($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")) . " required"))));
                // line 172
                echo "        ";
            }
            // line 173
            echo "        ";
            if (array_key_exists("parent_label_class", $context)) {
                // line 174
                echo "            ";
                $context["label_attr"] = twig_array_merge(($context["label_attr"] ?? null), array("class" => twig_trim_filter((((($this->getAttribute(($context["label_attr"] ?? null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["label_attr"] ?? null), "class", array()), "")) : ("")) . " ") . ($context["parent_label_class"] ?? null)))));
                // line 175
                echo "        ";
            }
            // line 176
            echo "        ";
            if (( !(($context["label"] ?? null) === false) && twig_test_empty(($context["label"] ?? null)))) {
                // line 177
                if ( !twig_test_empty(($context["label_format"] ?? null))) {
                    // line 178
                    $context["label"] = twig_replace_filter(($context["label_format"] ?? null), array("%name%" =>                     // line 179
($context["name"] ?? null), "%id%" =>                     // line 180
($context["id"] ?? null)));
                } else {
                    // line 183
                    $context["label"] = $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->humanize(($context["name"] ?? null));
                }
            }
            // line 186
            echo "        <label";
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
            // line 187
            echo ($context["widget"] ?? null);
            echo " ";
            echo twig_escape_filter($this->env, (( !(($context["label"] ?? null) === false)) ? ((((($context["translation_domain"] ?? null) === false)) ? (($context["label"] ?? null)) : ($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans(($context["label"] ?? null), array(), ($context["translation_domain"] ?? null))))) : ("")), "html", null, true);
            // line 188
            echo "</label>
    ";
        }
    }

    // line 194
    public function block_form_row($context, array $blocks = array())
    {
        // line 195
        echo "<div class=\"form-group";
        if ((( !($context["compound"] ?? null) || ((array_key_exists("force_error", $context)) ? (_twig_default_filter(($context["force_error"] ?? null), false)) : (false))) &&  !($context["valid"] ?? null))) {
            echo " has-error";
        }
        echo "\">";
        // line 196
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'label');
        // line 197
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        // line 198
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
        // line 199
        echo "</div>";
    }

    // line 202
    public function block_button_row($context, array $blocks = array())
    {
        // line 203
        echo "<div class=\"form-group\">";
        // line 204
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        // line 205
        echo "</div>";
    }

    // line 208
    public function block_choice_row($context, array $blocks = array())
    {
        // line 209
        $context["force_error"] = true;
        // line 210
        $this->displayBlock("form_row", $context, $blocks);
    }

    // line 213
    public function block_date_row($context, array $blocks = array())
    {
        // line 214
        $context["force_error"] = true;
        // line 215
        $this->displayBlock("form_row", $context, $blocks);
    }

    // line 218
    public function block_time_row($context, array $blocks = array())
    {
        // line 219
        $context["force_error"] = true;
        // line 220
        $this->displayBlock("form_row", $context, $blocks);
    }

    // line 223
    public function block_datetime_row($context, array $blocks = array())
    {
        // line 224
        $context["force_error"] = true;
        // line 225
        $this->displayBlock("form_row", $context, $blocks);
    }

    // line 228
    public function block_checkbox_row($context, array $blocks = array())
    {
        // line 229
        echo "<div class=\"form-group";
        if ( !($context["valid"] ?? null)) {
            echo " has-error";
        }
        echo "\">";
        // line 230
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        // line 231
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
        // line 232
        echo "</div>";
    }

    // line 235
    public function block_radio_row($context, array $blocks = array())
    {
        // line 236
        echo "<div class=\"form-group";
        if ( !($context["valid"] ?? null)) {
            echo " has-error";
        }
        echo "\">";
        // line 237
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'widget');
        // line 238
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->searchAndRenderBlock(($context["form"] ?? null), 'errors');
        // line 239
        echo "</div>";
    }

    // line 244
    public function block_form_errors($context, array $blocks = array())
    {
        // line 245
        if ((twig_length_filter($this->env, ($context["errors"] ?? null)) > 0)) {
            // line 246
            if ( !$this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->isRootForm(($context["form"] ?? null))) {
                echo "<span class=\"help-block\">";
            } else {
                echo "<div class=\"alert alert-danger\">";
            }
            // line 247
            echo "    <ul class=\"list-unstyled\">";
            // line 248
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 249
                echo "<li><span class=\"glyphicon glyphicon-exclamation-sign\"></span> ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["error"], "message", array()), "html", null, true);
                echo "</li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 251
            echo "</ul>
    ";
            // line 252
            if ( !$this->env->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->isRootForm(($context["form"] ?? null))) {
                echo "</span>";
            } else {
                echo "</div>";
            }
        }
    }

    public function getTemplateName()
    {
        return "bootstrap_3_layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  692 => 252,  689 => 251,  681 => 249,  677 => 248,  675 => 247,  669 => 246,  667 => 245,  664 => 244,  660 => 239,  658 => 238,  656 => 237,  650 => 236,  647 => 235,  643 => 232,  641 => 231,  639 => 230,  633 => 229,  630 => 228,  626 => 225,  624 => 224,  621 => 223,  617 => 220,  615 => 219,  612 => 218,  608 => 215,  606 => 214,  603 => 213,  599 => 210,  597 => 209,  594 => 208,  590 => 205,  588 => 204,  586 => 203,  583 => 202,  579 => 199,  577 => 198,  575 => 197,  573 => 196,  567 => 195,  564 => 194,  558 => 188,  554 => 187,  539 => 186,  535 => 183,  532 => 180,  531 => 179,  530 => 178,  528 => 177,  525 => 176,  522 => 175,  519 => 174,  516 => 173,  513 => 172,  510 => 171,  507 => 170,  504 => 169,  502 => 168,  499 => 167,  495 => 164,  493 => 162,  490 => 161,  486 => 158,  484 => 156,  481 => 155,  477 => 152,  475 => 151,  472 => 149,  468 => 146,  466 => 145,  463 => 144,  458 => 138,  456 => 137,  454 => 136,  451 => 134,  449 => 133,  447 => 132,  444 => 131,  439 => 127,  437 => 126,  435 => 125,  432 => 123,  430 => 122,  428 => 121,  425 => 120,  420 => 116,  414 => 113,  413 => 112,  412 => 111,  408 => 110,  404 => 109,  397 => 105,  396 => 104,  395 => 103,  391 => 102,  389 => 101,  386 => 100,  382 => 97,  380 => 96,  377 => 95,  371 => 90,  368 => 89,  358 => 88,  353 => 86,  351 => 85,  349 => 84,  346 => 82,  344 => 81,  341 => 80,  335 => 75,  333 => 74,  331 => 72,  330 => 71,  329 => 70,  328 => 69,  323 => 67,  321 => 66,  319 => 65,  316 => 63,  314 => 62,  311 => 61,  306 => 57,  304 => 56,  302 => 55,  300 => 54,  298 => 53,  294 => 52,  292 => 51,  289 => 49,  287 => 48,  284 => 47,  279 => 43,  277 => 42,  275 => 41,  272 => 40,  267 => 36,  263 => 34,  257 => 32,  255 => 31,  253 => 30,  247 => 28,  245 => 27,  242 => 26,  239 => 25,  236 => 24,  234 => 23,  231 => 22,  227 => 19,  225 => 18,  222 => 17,  218 => 14,  216 => 13,  213 => 12,  209 => 9,  206 => 7,  204 => 6,  201 => 5,  197 => 244,  194 => 243,  191 => 241,  189 => 235,  186 => 234,  184 => 228,  181 => 227,  179 => 223,  176 => 222,  174 => 218,  171 => 217,  169 => 213,  166 => 212,  164 => 208,  161 => 207,  159 => 202,  156 => 201,  154 => 194,  151 => 193,  148 => 191,  146 => 167,  143 => 166,  141 => 161,  138 => 160,  136 => 155,  133 => 154,  131 => 149,  128 => 148,  126 => 144,  123 => 143,  120 => 141,  118 => 131,  115 => 130,  113 => 120,  110 => 119,  108 => 100,  105 => 99,  103 => 95,  100 => 94,  98 => 80,  95 => 79,  93 => 61,  90 => 60,  88 => 47,  85 => 46,  83 => 40,  80 => 39,  78 => 22,  75 => 21,  73 => 17,  70 => 16,  68 => 12,  65 => 11,  63 => 5,  60 => 4,  57 => 2,  14 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "bootstrap_3_layout.html.twig", "/home/wp614605/biken-shop-mall.com/public_html/vendor/symfony/twig-bridge/Resources/views/Form/bootstrap_3_layout.html.twig");
    }
}
