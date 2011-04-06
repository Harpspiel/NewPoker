<?php

class CardBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CardBuilder
     */
    private $_CardBuilder;

    public function setUp()
    {
        $this->_CardBuilder = new CardBuilder();
    }
    
    public function testWillThrowAnExceptionFromInvalidString()
    {
        $invalidString = 'aa';

        $this->setExpectedException('Exception', 'Invalid card string');
        
        $this->_CardBuilder->fromString($invalidString);
    }

    public function testWillThrowAnExceptionFromInvalidNumberTooHigh()
    {
        $invalidString = '15-C';

        $this->setExpectedException('Exception', 'Invalid face value');

        $this->_CardBuilder->fromString($invalidString);
    }

    public function testWillThrowAnExceptionFromInvalidNumberTooLow()
    {
        $invalidString = '1-C';

        $this->setExpectedException('Exception', 'Invalid face value');

        $this->_CardBuilder->fromString($invalidString);
    }

    public function testWillThrowAnExceptionFromInvalidSuit()
    {
        $invalidString = '2-Z';

        $this->setExpectedException('Exception', 'Invalid suit');

        $this->_CardBuilder->fromString($invalidString);
    }

    public function testWillGetACardWithValidParameters()
    {
        $invalidString = '2-C';
        $ExpectedCard = new Clubs(2);

        $ActualCard = $this->_CardBuilder->fromString($invalidString);

        $this->assertEquals($ExpectedCard, $ActualCard);
    }

    public function testWillGetACardWithFaceCard()
    {
        $invalidString = 'Q-S';
        $ExpectedCard = new Spades(Card::QUEEN);

        $ActualCard = $this->_CardBuilder->fromString($invalidString);

        $this->assertEquals($ExpectedCard, $ActualCard);
    }

    public function testWillGetACardWithJacks()
    {
        $invalidString = 'J-H';
        $ExpectedCard = new Hearts(Card::JACK);

        $ActualCard = $this->_CardBuilder->fromString($invalidString);

        $this->assertEquals($ExpectedCard, $ActualCard);
    }

    public function testWillGetACardWithKings()
    {
        $invalidString = 'K-D';
        $ExpectedCard = new Diamonds(Card::KING);

        $ActualCard = $this->_CardBuilder->fromString($invalidString);

        $this->assertEquals($ExpectedCard, $ActualCard);
    }

    public function testWillGetACardWithAce()
    {
        $invalidString = 'A-C';
        $ExpectedCard = new Clubs(Card::ACE);

        $ActualCard = $this->_CardBuilder->fromString($invalidString);

        $this->assertEquals($ExpectedCard, $ActualCard);
    }
}