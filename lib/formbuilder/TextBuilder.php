<?php

class TextBuilder extends Builder
{
    public function __construct()
    {
        $this->addProperty('label');
        $this->addProperty('name');
        $this->addProperty('value', null);
        $this->addProperty('pattern', '.*');
        $this->addProperty('placeholder',"");
    }

    public function build()
    {
        $result = '<div class="form-group">';
        $result .= "    <label class=\"col-md-2 control-label\" for=\"textinput\">{$this->label}</label>";
        $result .= '    <div class="col-md-4">';
        $result .= "        <input name=\"{$this->name}\" type=\"text\" value=\"{$this->value}\" placeholder='{$this->placeholder}' class=\"form-control input-md\" pattern=\"{$this->pattern}\" required>";
        $result .= '    </div>';
        $result .= '</div>';

        return $result;
    }
}
