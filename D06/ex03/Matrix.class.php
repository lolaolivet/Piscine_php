<?php
class Matrix
{
    public static $verbose = FALSE;
    public static $doc_path = "Matrix.doc.txt";

    const IDENTITY = "IDENTITY", SCALE = "SCALE", RX = "Ox ROTATION", RY = "Oy ROTATION";
    const RZ = "Oz ROTATION", TRANSLATION = "TRANSLATION", PROJECTION = "PROJECTION";
    private $_preset, $_scale, $_angle, $_vtc, $_fov, $_ratio, $_near, $_far;
    private $matrix;

    public function __construct(array $arr = NULL)
    {
        if (isset($arr))
        {
            if (array_key_exists("preset", $arr))
                $this->_preset = $arr['preset'];
            if (array_key_exists("scale", $arr))
                $this->_scale = $arr['scale'];
            if (array_key_exists("angle", $arr))
                $this->_angle = $arr['angle'];
            if (array_key_exists("vtc", $arr))
                $this->_vtc = $arr['vtc'];
            if (array_key_exists("fov", $arr))
                $this->_fov = $arr['fov'];
            if (array_key_exists("ratio", $arr))
                $this->_ratio = $arr['ratio'];
            if (array_key_exists("near", $arr))
                $this->_near = $arr['near'];
            if (array_key_exists("far", $arr))
                $this->_far = $arr['far'];
            $this->create_matrix();
            if (self::$verbose)
            {
                if ($this->_preset != self::IDENTITY)
                    print "Matrix ".$this->_preset." preset instance constructed\n";
                else
                    print "Matrix ".$this->_preset." instance constructed\n";
            }
        }
    }

    public function __destruct()
    {
        if (self::$verbose)
            printf("Matrix instance destructed\n");
    }

    public function __toString()
    {
        $str = "M | vtcX | vtcY | vtcZ | vtxO\n-----------------------------\n";
        $str .= "x | %0.2f | %0.2f | %0.2f | %0.2f\ny | %0.2f | %0.2f | %0.2f | %0.2f\n";
        $str .= "z | %0.2f | %0.2f | %0.2f | %0.2f\nw | %0.2f | %0.2f | %0.2f | %0.2f";
        return (vsprintf($str, array($this->matrix[0], $this->matrix[1], $this->matrix[2], $this->matrix[3], $this->matrix[4], $this->matrix[5], $this->matrix[6], $this->matrix[7], $this->matrix[8], $this->matrix[9], $this->matrix[10], $this->matrix[11], $this->matrix[12], $this->matrix[13], $this->matrix[14], $this->matrix[15])));
    }

    public static function doc()
    {
        if (!file_exists(self::$doc_path) ||
            ($content = file_get_contents(self::$doc_path)) === FALSE)
            return (NULL);
        return ($content);
    }

    public function mult(Matrix $rhs)
    {
        $matrix = new Matrix();
        $matrix->matrix = array();
        for ($i = 0; $i < 16; $i += 4)
        {
            for ($j = 0; $j < 4; $j++)
            {
                $matrix->matrix[$i + $j] = 0;
                $matrix->matrix[$i + $j] += $this->matrix[$i + 0] * $rhs->matrix[$j + 0];
                $matrix->matrix[$i + $j] += $this->matrix[$i + 1] * $rhs->matrix[$j + 4];
                $matrix->matrix[$i + $j] += $this->matrix[$i + 2] * $rhs->matrix[$j + 8];
                $matrix->matrix[$i + $j] += $this->matrix[$i + 3] * $rhs->matrix[$j + 12];
            }
        }
        return $matrix;
    }

    public function transformVertex(Vertex $vtx)
    {
        return (new Vertex(array(
            'x' => $vtx->getX() * $this->matrix[0] + $vtx->getY() * $this->matrix[1] + $vtx->getZ() * $this->matrix[2] + $vtx->getW() * $this->matrix[3],
            'y' => $vtx->getX() * $this->matrix[4] + $vtx->getY() * $this->matrix[5] + $vtx->getZ() * $this->matrix[6] + $vtx->getW() * $this->matrix[7],
            'z' => $vtx->getX() * $this->matrix[8] + $vtx->getY() * $this->matrix[9] + $vtx->getZ() * $this->matrix[10] + $vtx->getW() * $this->matrix[11],
            'w' => $vtx->getX() * $this->matrix[11] + $vtx->getY() * $this->matrix[13] + $vtx->getZ() * $this->matrix[14] + $vtx->getW() * $this->matrix[15],
            'color' => $vtx->getColor()
        )));
    }

    private function create_matrix()
    {
        $this->matrix = array();
        for ($i = 0; $i < 16; $i++)
            $this->matrix[$i] = 0;
        $this->get_identity(1);
        if ($this->_preset == self::TRANSLATION)
            $this->translation();
        else if ($this->_preset == self::SCALE)
            $this->get_identity($this->_scale);
        else if ($this->_preset == self::RX)
            $this->rotation_x();
        else if ($this->_preset == self::RY)
            $this->rotation_y();
        else if ($this->_preset == self::RZ)
            $this->rotation_z();
        else if ($this->_preset == self::PROJECTION)
            $this->projection();
    }

    private function get_identity($scale)
    {
        $this->matrix[0] = $scale;
        $this->matrix[5] = $scale;
        $this->matrix[10] = $scale;
        $this->matrix[15] = 1;
    }

    private function translation()
    {
        $this->matrix[3] = $this->_vtc->getX();
        $this->matrix[7] = $this->_vtc->getY();
        $this->matrix[11] = $this->_vtc->getZ();
    }

    private function rotation_x()
    {
        $this->matrix[5] = cos($this->_angle);
        $this->matrix[6] = -sin($this->_angle);
        $this->matrix[9] = sin($this->_angle);
        $this->matrix[10] = cos($this->_angle);
    }

    private function rotation_y()
    {
        $this->matrix[0] = cos($this->_angle);
        $this->matrix[2] = sin($this->_angle);
        $this->matrix[8] = -sin($this->_angle);
        $this->matrix[10] = cos($this->_angle);
    }

    private function rotation_z()
    {
        $this->matrix[0] = cos($this->_angle);
        $this->matrix[1] = -sin($this->_angle);
        $this->matrix[4] = sin($this->_angle);
        $this->matrix[5] = cos($this->_angle);
    }

    private function projection()
    {
        $this->matrix[5] = 1 / tan(0.5 * deg2rad($this->_fov));
        $this->matrix[0] = $this->matrix[5] / $this->_ratio;
        $this->matrix[10] = -1 * (-$this->_near - $this->_far) / ($this->_near - $this->_far);
        $this->matrix[11] = (2 * $this->_near * $this->_far) / ($this->_near - $this->_far);
        $this->matrix[14] = -1;
        $this->matrix[15] = 0;
    }
}
?>