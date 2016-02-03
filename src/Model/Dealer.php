<?php

namespace Model;

class Dealer extends AbstractHand
{
    /**
     * @return int
     */
    public function getMaxCardCount(){
        return 5;
    }
}