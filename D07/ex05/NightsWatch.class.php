<?php

class NightsWatch {

    public function recruit($someone) {
        if ($someone instanceof IFighter)
            print($someone->fight());
        return;
    }

    public function fight() {
        return;
    }
}

?>