<?php

class UnHolyFactory {

    private $_fighter_obj;

    public function __construct()
    {
        $this->_fighter_obj = [];
    }

    public function absorb($fighter) {
        if (isset($fighter)) {
            if (isset($fighter) && get_parent_class($fighter) == Fighter::class) {
                foreach ($this->_fighter_obj as $e) {
                    if ($e->type == $fighter->type) {
                        print ("(Factory already absorbed a fighter of type " . $fighter->type . ")" . PHP_EOL);
                        return;
                    }
                }
                $this->_fighter_obj [] = $fighter;
                print("(Factory absorbed a fighter of type " . $fighter->type . ")" . PHP_EOL);
            } else
                print ("(Factory can't absorb this, it's not a fighter)". PHP_EOL);
        }
        return;
    }

    public function fabricate($fighter) {
        foreach ($this->_fighter_obj as $key => $value)
        {
            if ($value->type == $fighter)
            {
                print("(Factory fabricates a fighter of type ". $fighter .")". PHP_EOL);
                return $value;
            }
        }
        print ("(Factory hasn't absorbed any fighter of type ". $fighter .")". PHP_EOL);
        return NULL;
    }
}

?>