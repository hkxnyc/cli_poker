<?php

namespace Tests\Model;
include "autoloader.php";

use Model\Card;

class CardTest extends \PHPUnit_Framework_TestCase
{
    public function testBadCard()
    {
        $this->setExpectedException(\Exception::class);
        new Card('aa','$');

    }
}