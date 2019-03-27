<?php

abstract class Fighter {

    public $type = '';

    public function __construct($str) {
        $this->type = $str;
        return ($str);
    }

    abstract function fight($fighter);

}

?>