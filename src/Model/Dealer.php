<?php

namespace Model;

class Dealer extends AbstractHand
{
    public function getMaxCardCount(){
        return 5;
    }
}