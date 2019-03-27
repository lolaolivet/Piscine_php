<?php

class Vector {
    private $_x;
    private $_y;
    private $_z;
    private $_w;
    public static $verbose = FALSE;

    function __construct(array $kwargs) {
        if (array_key_exists('dest', $kwargs) && $kwargs['dest'] instanceof  Vertex) {
            if (array_key_exists('orig', $kwargs) && $kwargs['orig'] instanceof Vertex) {
                $this->_x = $kwargs['dest']->getX() - $kwargs['orig']->getX();
                $this->_y = $kwargs['dest']->getY() - $kwargs['orig']->getY();
                $this->_z = $kwargs['dest']->getZ() - $kwargs['orig']->getZ();
                $this->_w = $kwargs['dest']->getW() - $kwargs['orig']->getW();
            } else {
                $kwargs['orig'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
                $this->_x = $kwargs['dest']->getX() - $kwargs['orig']->getX();
                $this->_y = $kwargs['dest']->getY() - $kwargs['orig']->getY();
                $this->_z = $kwargs['dest']->getZ() - $kwargs['orig']->getZ();
                $this->_w = $kwargs['dest']->getW() - $kwargs['orig']->getW();
            }
        }
        if (self::$verbose === TRUE)
            print($this . ' constructed' . PHP_EOL);
        return;

    }

    function __destruct() {
        if (self::$verbose === TRUE)
            print($this . ' destructed' . PHP_EOL);
        return;
    }

    function __toString() {
        return (vsprintf("Vector( x:%0.2f, y:%0.2f, z:%0.2f, w:%0.2f )", array($this->_x, $this->_y, $this->_z, $this->_w)));
    }

    public static function doc() {
        $output = file_get_contents('Vector.doc.txt');
        return $output;
    }

    public function magnitude() {
        return ((float)sqrt((($this->_x * $this->_x) + ($this->_y * $this->_y) + ($this->_z * $this->_z))));
    }

    public function normalize() {
        $length = $this->magnitude();
        if ($length == 1)
            return clone $this;
        return (new Vector(array('dest' => (new Vertex (array('x' => ($this->_x / $length), 'y' => ($this->_y / $length), 'z' => ($this->_z / $length)))))));
    }

    public function add(Vector $rhs) {
        return (new Vector(array('dest' => (new Vertex (array('x' => ($this->_x + $rhs->getX()), 'y' => ($this->_y + $rhs->getY()), 'z' => ($this->_z + $rhs->getZ())))))));
    }

    public function opposite()
    {
        return (new Vector(array('dest' => (new Vertex(array('x' => ($this->_x * -1), 'y' => ($this->_y * -1), 'z' => ($this->_z * -1)))))));
    }

    public function sub(Vector $rhs) {
        return (new Vector(array('dest' => (new Vertex(array('x' => ($this->_x - $rhs->getX()), 'y' => ($this->_y - $rhs->getY()), 'z' => ($this->_z - $rhs->getZ())))))));
    }

    public function scalarProduct ($k) {
        return (new Vector(array('dest' => (new Vertex(array('x' => ($this->_x * $k), 'y' => ($this->_y * $k), 'z' => ($this->_z * $k)))))));
    }

    public function dotProduct(Vector $rhs) {
        return ((float)(($this->_x * $rhs->getX()) + ($this->_y * $rhs->getY()) + ($this->_z * $rhs->getZ())));
    }

    public function cos(Vector $rhs) {
        $dotProduct = $this->dotProduct($rhs);
        $angle = (float)($dotProduct / ($this->magnitude() * $rhs->magnitude()));
        return ($angle);
    }

    public function crossProduct(Vector $rhs) {
        return (new Vector(array('dest' => (new Vertex(array('x' => (($this->_y * $rhs->getZ()) - ($this->_z * $rhs->getY())), 'y' => (($this->_z * $rhs->getX()) - ($this->_x * $rhs->getZ())), 'z' => (($this->_x * $rhs->getY()) - ($this->_y * $rhs->getX()))))))));
    }

    public function getX()
    {
        return $this->_x;
    }

    public function getY()
    {
        return $this->_y;
    }

    public function getZ()
    {
        return $this->_z;
    }

    public function getW()
    {
        return $this->_w;
    }
}

?>