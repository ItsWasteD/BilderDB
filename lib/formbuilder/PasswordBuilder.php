<?php

class PasswordBuilder extends Builder
{
    public function __construct()
    {
        $this->addProperty('label');
        $this->addProperty('name');
        $this->addProperty('onkeyup');
        $this->addProperty('placeholder','min. 8 characters');
    }

    public function build()
    {
        $result = '<div class="form-group">';
        $result .= "    <label class=\"col-md-2 control-label\" for=\"textinput\">{$this->label}</label>";
        $result .= '    <div class="col-md-4">';
        $result .= "        <input name=\"{$this->name}\" type=\"password\" onkeyup=\"{$this->onkeyup}\" minlength='8' placeholder='{$this->placeholder}' class=\"form-control input-md\" required>";
        $result .= '    </div>';
        $result .= '</div>';

        return $result;
    }
}