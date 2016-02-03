<?php
namespace Model;

abstract class AbstractCardCollection
{
    /**
     * @var array | Card[]
     */
    protected $cards = [];

    /**
     * @return array | Card[]
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     *
     */
    public function sortByValue(){
        usort($this->cards, function(Card $a, Card $b){
            if ($a->getValue() === $b->getValue()){
                return strcmp($a->getSuit(), $b->getSuit());
            }
            return $a->getValue() > $b->getValue();
        });
    }

    /**
     *
     */
    public function sortBySuit(){
        usort($this->cards, function(Card $a, Card $b){
            $cmp = strcmp($a->getSuit(), $b->getSuit());
            if ($cmp === 0){
               return $a->getValue() > $b->getValue();
            }
            return $cmp;
        });
    }

    /**
     * @return array
     */
    public function getStackByValue(){
        $result = [];
        $cards = $this->getCards();
        foreach($cards as $card){
            $result[$card->getValue()][]= $card;
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getStackBySuit(){
        $result = [];
        $cards = $this->getCards();
        foreach($cards as $card){
            $result[$card->getSuit()][]= $card;
        }
        return $result;
    }

    public function __toString()
    {
        $string = "";
        foreach ($this->getCards() as $card) {
            if ($string) {
                $string.=",";
            }
            $string.=$card;
        }
        return $string;
    }
}