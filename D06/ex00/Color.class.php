<?php

class Color {

    public $red = 0;
    public $green = 0;
    public $blue = 0;
    public static $verbose = FALSE;

    function __construct(array $kwargs) {
        if (array_key_exists('rgb', $kwargs))
        {
            $this->red = (int)($kwargs['rgb'] & 0xff0000) >> 16;
            $this->green = (int)($kwargs['rgb'] & 0xff00) >> 8;
            $this->blue = (int)($kwargs['rgb'] & 0xff);
        }
        else
        {
            $this->red = (int)$kwargs['red'];
            $this->green = (int)$kwargs['green'];
            $this->blue = (int)$kwargs['blue'];
        }
        if (self::$verbose === TRUE)
            print($this . ' constructed.'. PHP_EOL);
        return;
    }

    function __destruct() {
        if (self::$verbose === TRUE)
            print($this . ' destructed.'. PHP_EOL);
        return;
    }

    function __toString()
    {
        $output = 'Color( red: ' . STR_PAD($this->red, 3, ' ', STR_PAD_LEFT) . ', green: ' . STR_PAD($this->green, 3, ' ', STR_PAD_LEFT) . ', blue: ' . STR_PAD($this->blue, 3, ' ', STR_PAD_LEFT) . ' )';
        return $output;
    }

    public static function doc() {
        $output = file_get_contents('Color.doc.txt');
        return $output;
    }

    public function add(Color $color) {
        return (new Color(array('red' => $this->red + $color->red, 'green' => $this->green + $color->green, 'blue' => $this->blue + $color->blue)));
    }

    public function sub(Color $color) {
        return (new Color(array('red' => $this->red - $color->red, 'green' => $this->green - $color->green, 'blue' => $this->blue - $color->blue)));
    }

    public function mult($f) {
        return (new Color(array('red' => $this->red * $f, 'green' => $this->green * $f, 'blue' => $this->blue * $f)));
    }
}

?>