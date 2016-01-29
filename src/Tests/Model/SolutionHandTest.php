<?php

namespace Tests\Model;
include "autoloader.php";

use Model\Card;
use Model\SolutionHand;

class SolutionHandTest extends \PHPUnit_Framework_TestCase
{
    public function testHighCardCheck()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_SPADE, Card::VALUE_ACE),
            new Card(Card::SUIT_SPADE, Card::VALUE_JACK),
            new Card(Card::SUIT_SPADE, Card::VALUE_TWO),
            new Card(Card::SUIT_SPADE, Card::VALUE_QUEEN),
            new Card(Card::SUIT_CLUB, Card::VALUE_KING),
        ]);
        $this->assertEquals(SolutionHand::TYPE_HIGH_CARD, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_ACE, $solutionHand->getHighValue());
    }

    public function testOnePairCheck()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_SPADE, Card::VALUE_ACE),
            new Card(Card::SUIT_SPADE, Card::VALUE_JACK),
            new Card(Card::SUIT_SPADE, Card::VALUE_TWO),
            new Card(Card::SUIT_SPADE, Card::VALUE_QUEEN),
            new Card(Card::SUIT_CLUB, Card::VALUE_ACE),
        ]);
        $this->assertEquals(SolutionHand::TYPE_ONE_PAIR, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_ACE, $solutionHand->getHighValue());
    }

    public function testTwoPair()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_SPADE, Card::VALUE_ACE),
            new Card(Card::SUIT_SPADE, Card::VALUE_JACK),
            new Card(Card::SUIT_SPADE, Card::VALUE_TWO),
            new Card(Card::SUIT_SPADE, Card::VALUE_TWO),
            new Card(Card::SUIT_CLUB, Card::VALUE_ACE),
        ]);
        $this->assertEquals(SolutionHand::TYPE_TWO_PAIR, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_ACE, $solutionHand->getHighValue());
    }

    public function testThreeKindCheck()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_SPADE, Card::VALUE_ACE),
            new Card(Card::SUIT_SPADE, Card::VALUE_JACK),
            new Card(Card::SUIT_HEART, Card::VALUE_ACE),
            new Card(Card::SUIT_SPADE, Card::VALUE_TWO),
            new Card(Card::SUIT_CLUB, Card::VALUE_ACE),
        ]);
        $this->assertEquals(SolutionHand::TYPE_THREE_OF_A_KIND, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_ACE, $solutionHand->getHighValue());
    }

    public function testFourKindCheck()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_SPADE, Card::VALUE_ACE),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_ACE),
            new Card(Card::SUIT_HEART, Card::VALUE_ACE),
            new Card(Card::SUIT_SPADE, Card::VALUE_TWO),
            new Card(Card::SUIT_CLUB, Card::VALUE_ACE),
        ]);
        $this->assertEquals(SolutionHand::TYPE_FOUR_OF_A_KIND, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_ACE, $solutionHand->getHighValue());
    }

    public function testStraightCheck()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_SPADE, Card::VALUE_FOUR),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_THREE),
            new Card(Card::SUIT_HEART, Card::VALUE_TWO),
            new Card(Card::SUIT_SPADE, Card::VALUE_FIVE),
            new Card(Card::SUIT_CLUB, Card::VALUE_SIX),
        ]);
        $this->assertEquals(SolutionHand::TYPE_STRAIGHT, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_SIX, $solutionHand->getHighValue());
    }

    public function testFlushCheck()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_DIAMOND, Card::VALUE_FOUR),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_ACE),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_TWO),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_NINE),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_SIX),
        ]);
        $this->assertEquals(SolutionHand::TYPE_FLUSH, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_ACE, $solutionHand->getHighValue());
    }

    public function testFullHouseCheck()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_DIAMOND, Card::VALUE_FOUR),
            new Card(Card::SUIT_SPADE, Card::VALUE_FOUR),
            new Card(Card::SUIT_HEART, Card::VALUE_TWO),
            new Card(Card::SUIT_CLUB, Card::VALUE_TWO),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_TWO),
        ]);
        $this->assertEquals(SolutionHand::TYPE_FULL_HOUSE, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_TWO, $solutionHand->getHighValue());
    }

    public function testStraightFlush()
    {
        $solutionHand = new SolutionHand([
            new Card(Card::SUIT_DIAMOND, Card::VALUE_FOUR),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_FIVE),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_SIX),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_SEVEN),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_EIGHT),
        ]);
        $this->assertEquals(SolutionHand::TYPE_STRAIGHT_FLUSH, $solutionHand->getHandType());
        $this->assertEquals(Card::VALUE_EIGHT, $solutionHand->getHighValue());
    }

    public function testDiff()
    {
        $playerHandFlush = new SolutionHand([
            new Card(Card::SUIT_DIAMOND, Card::VALUE_FOUR),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_ACE),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_TWO),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_NINE),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_SIX),
        ]);

        $playerHandStraight = new SolutionHand([
            new Card(Card::SUIT_SPADE, Card::VALUE_FOUR),
            new Card(Card::SUIT_DIAMOND, Card::VALUE_THREE),
            new Card(Card::SUIT_HEART, Card::VALUE_TWO),
            new Card(Card::SUIT_SPADE, Card::VALUE_FIVE),
            new Card(Card::SUIT_CLUB, Card::VALUE_SIX),
        ]);
        $this->assertEquals(0, $playerHandStraight->diff($playerHandStraight));
        $this->assertGreaterThan(0, $playerHandFlush->diff($playerHandStraight));
        $this->assertLessThan(0, $playerHandStraight->diff($playerHandFlush));
    }
}