<?php

namespace Model;

class Card
{
    const SUIT_SPADE = 'spades';
    const SUIT_HEART = 'heart';
    const SUIT_CLUB = 'club';
    const SUIT_DIAMOND = 'diamond';

    const VALUE_ACE = 14;
    const VALUE_KING = 13;
    const VALUE_QUEEN = 12;
    const VALUE_JACK = 11;
    const VALUE_TEN = 10;
    const VALUE_NINE = 9;
    const VALUE_EIGHT = 8;
    const VALUE_SEVEN = 7;
    const VALUE_SIX = 6;
    const VALUE_FIVE = 5;
    const VALUE_FOUR = 4;
    const VALUE_THREE = 3;
    const VALUE_TWO = 2;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $suit;

    static protected $suits = [
        "♠"=>self::SUIT_SPADE,
        "♥"=>self::SUIT_HEART,
        "♦"=>self::SUIT_DIAMOND,
        "♣"=>self::SUIT_CLUB,
    ];

    /**
     * @var array
     */
    static protected $values = [
        "A" => self::VALUE_ACE,
        "K" => self::VALUE_KING,
        "Q" => self::VALUE_QUEEN,
        "J" => self::VALUE_JACK,
        "10" => self::VALUE_TEN,
        "9" => self::VALUE_NINE,
        "8" => self::VALUE_EIGHT,
        "7" => self::VALUE_SEVEN,
        "6" => self::VALUE_SIX,
        "5" => self::VALUE_FIVE,
        "4" => self::VALUE_FOUR,
        "3" => self::VALUE_THREE,
        "2" => self::VALUE_TWO
    ];

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getValueLabel(){
        return array_search($this->getValue(), self::getValues());
    }

    public function getSuitLabel(){
        return array_search($this->getSuit(), self::getSuits());
    }

    /**
     * @return string
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * @return array
     */
    public static function getSuits()
    {
        return self::$suits;
    }

    /**
     * @return array
     */
    public static function getValues()
    {
        return self::$values;
    }

    public function __construct($suit, $value){
        if (!(in_array($suit, self::$suits))){
            throw new \Exception("Invalid Card Type");
        }

        if (!(in_array($value, self::$values))){
            throw new \Exception("Invalid Value Type");
        }
        $this->suit = $suit;
        $this->value = $value;
    }

    public function __toString(){
        return $this->getValueLabel().$this->getSuitLabel();
    }

}