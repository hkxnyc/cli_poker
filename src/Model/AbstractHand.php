<?php
namespace Model;

abstract class AbstractHand extends AbstractCardCollection
{
    public abstract function getMaxCardCount();

    protected function addCard(Card $card){
        $this->cards[]= $card;
        return $this->getCards();
    }

    public function __construct(array $cards){

        if (count($cards)> $this->getMaxCardCount()) {
            throw new \Exception("Too many cards");
        }

        foreach ($cards as $card){
            $this->addCard($card);
        }
    }
}