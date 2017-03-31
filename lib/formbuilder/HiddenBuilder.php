<?php

/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 31.03.2017
 * Time: 13:18
 */
class HiddenBuilder extends Builder
{
    public function __construct()
    {
        $this->addProperty('name');
        $this->addProperty('value');
    }

    public function build()
    {
        $result = "<input name='{$this->name}' type='hidden' value='{$this->value}'>";

        return $result;
    }
}