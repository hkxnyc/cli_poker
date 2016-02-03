<?php
namespace Model;

class SolutionHand extends AbstractHand
{
    const TYPE_HIGH_CARD = 1;
    const TYPE_ONE_PAIR = 2;
    const TYPE_TWO_PAIR = 3;
    const TYPE_THREE_OF_A_KIND = 4;
    const TYPE_STRAIGHT = 5;
    const TYPE_FLUSH = 6;
    const TYPE_FULL_HOUSE = 7;
    const TYPE_FOUR_OF_A_KIND = 8;
    const TYPE_STRAIGHT_FLUSH = 9;

    static protected $handTypes = [
        "High Card" => self::TYPE_HIGH_CARD,
        "One Pair" => self::TYPE_ONE_PAIR,
        "Two Pair" => self::TYPE_TWO_PAIR,
        "Three of a Kind" => self::TYPE_THREE_OF_A_KIND,
        "Straight" => self::TYPE_STRAIGHT,
        "Flush" => self::TYPE_FLUSH,
        "Full House" => self::TYPE_FULL_HOUSE,
        "Four of a Kind" => self::TYPE_FOUR_OF_A_KIND,
        "Straight Flush" => self::TYPE_STRAIGHT_FLUSH,
    ];

    protected $handType;

    protected $highValue;

    public function __construct(array $cards){
        parent::__construct($cards);
        $this->highCardCheck();
        $this->onePairCheck();
        $this->twoPairCheck();
        $this->threeKindCheck();
        $this->straightCheck();
        $this->flushCheck();
        $this->fullHouseCheck();
        $this->fourKindCheck();
        $this->straightFlushCheck();
    }

    /**
     * @return int
     */
    public function getMaxCardCount(){
        return 5;
    }
    /**
     * @return array
     */
    public static function getHandTypes()
    {
        return self::$handTypes;
    }

    /**
     * @return mixed
     */
    public function getHighValue()
    {
        return $this->highValue;
    }


    /**
     * @return mixed
     */
    public function getHandType()
    {
        return $this->handType;
    }

    /**
     * @return Card
     */
    protected function highCardCheck(){
        $this->sortByValue();
        $this->handType = self::TYPE_HIGH_CARD;
        $cards = $this->getCards();
        $this->highValue = end($cards)->getValue();
    }

    /**
     * @return Card
     */
    protected function onePairCheck(){
        foreach($this->getStackByValue() as $element){
            if (count($element) === 2) {
                $this->handType = self::TYPE_ONE_PAIR;
                $this->highValue = end($element)->getValue();
                break;
            }
        }
    }

    /**
     * @return Card
     */
    protected function twoPairCheck() {
        $counter = 0;
        $highVal = null;
        foreach ($this->getStackByValue() as $element) {
            if (count($element) === 2) {
                $counter ++;
                $currentVal = end($element)->getValue();
                if (!$highVal || $highVal < $currentVal ){
                    $highVal = $currentVal;
                }
            }
        }
        if ($counter === 2){
            $this->handType = self::TYPE_TWO_PAIR;
            $this->highValue = $highVal;
        }
    }

    /**
     * @return Card
     */
    protected function threeKindCheck(){
        foreach($this->getStackByValue() as $element){
            if (count($element) === 3) {
                $this->handType = self::TYPE_THREE_OF_A_KIND;
                $this->highValue = end($element)->getValue();
                break;
            }
        }
    }

    /**
     * @return Card
     */
    protected function fourKindCheck(){
        foreach($this->getStackByValue() as $element){
            if (count($element) === 4) {
                $this->handType = self::TYPE_FOUR_OF_A_KIND;
                $this->highValue = end($element)->getValue();
                break;
            }
        }
    }

    /**
     * @return Card
     */
    protected function fullHouseCheck(){
        $hasPair = false;
        $threeKindValue = null;
        foreach($this->getStackByValue() as $element){
            if (count($element) === 2) {
                $hasPair = true;
            }
            if (count($element) === 3) {
                $threeKindValue = end($element)->getValue();
            }
        }
        if ($hasPair && $threeKindValue !== null){
            $this->handType = self::TYPE_FULL_HOUSE;
            $this->highValue = $threeKindValue;
        }
    }

    /**
     * @return Card
     */
    protected function flushCheck(){
        foreach($this->getStackBySuit() as $element){
            if (count($element) === 5) {
                $this->handType = self::TYPE_FLUSH;
                $this->sortByValue();
                $cards = $this->getCards();
                $this->highValue = end($cards)->getValue();
                break;
            }
        }
    }

    /**
     * @return Card
     */
    protected function straightCheck(){
        $lastCardVal = null;
        $this->sortByValue();
        foreach ($this->getCards() as $card) {
            if (!$lastCardVal || $lastCardVal == $card->getValue()-1) {
                $lastCardVal = $card->getValue();
            } else {
                return;
            }
        }
        $this->handType = self::TYPE_STRAIGHT;
        $this->highValue = $lastCardVal;

    }

    /**
     * @return Card
     */
    protected function straightFlushCheck(){
        $lastCardVal = null;
        $this->sortByValue();
        foreach ($this->getCards() as $card) {
            if (!$lastCardVal || $lastCardVal == $card->getValue()-1) {
                $lastCardVal = $card->getValue();
            } else {
                return;
            }
        }
        foreach($this->getStackBySuit() as $element){
            if (count($element) === 5) {
                $this->handType = self::TYPE_STRAIGHT_FLUSH;
                $this->highValue = $lastCardVal;
                break;
            }
        }
    }

    public function diff (SolutionHand $compHand){
        if ($this->handType === $compHand->getHandType()){
            return $this->getHighValue() - $compHand->getHighValue();
        }
        return $this->getHandType() - $compHand->getHandType();
    }

    public function getHandTypeLabel(){
        return array_search($this->getHandType(), self::$handTypes);
    }
}