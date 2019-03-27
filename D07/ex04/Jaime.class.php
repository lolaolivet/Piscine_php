<?php

class Jaime extends Lannister {

    public function sleepWith($someone)
    {
        if (get_parent_class($this) == get_parent_class($someone)) {
            if (get_class($someone) == Cersei::class)
                print ("With pleasure, but only in a tower in Winterfell, then." . PHP_EOL);
            else
                print ("Not even if I'm drunk !". PHP_EOL);
        }
        else
            print ("Let's do this.". PHP_EOL);
    }

}

?>