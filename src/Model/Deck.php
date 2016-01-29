<?php

namespace Model;

class Deck extends AbstractCardCollection
{
    public function __construct(){
        foreach(Card::getSuits() as $suit){
            foreach(Card::getValues() as $value){
                $this->cards[] = new Card($suit, $value);
            }
        }
    }
    /**
     * @return bool
     */
    public function shuffleDeck(){
        shuffle($this->cards);
    }

    /**
     * @return Card
     */
    public function drawCard(){
        return array_shift($this->cards);
    }
}