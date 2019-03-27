<?php

class Targaryen {

    public function resistsFire() {
        return FALSE;
    }

     function getBurned() {
        if ($this->resistsFire() === TRUE)
            return ('emerges naked but unharmed');
        else
            return ('burns alive');
    }
}

?>