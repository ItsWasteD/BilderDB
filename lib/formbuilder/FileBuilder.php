<?php

/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 27.03.2017
 * Time: 14:26
 */
class FileBuilder extends Builder
{
    public function __construct()
    {
        $this->addProperty('label');
        $this->addProperty('name');
    }

    public function build()
    {
        $result = '<div class="form-group">';
        $result .= "    <label class=\"col-md-2 control-label\" for=\"fileinput\">{$this->label}</label>";
        $result .= '    <div class="col-md-4">';
        $result .= "        <input name=\"{$this->name}\" type=\"file\" class=\"form-control input-md\" required>";
        $result .= '    </div>';
        $result .= '</div>';

        return $result;
    }
}