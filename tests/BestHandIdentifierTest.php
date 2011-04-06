<?php
class BestHandIdentifierTest extends PHPUnit_Framework_TestCase
{
    /** @var BestHandIdentifier */
    private $_HandIdentifier;

    /** @var Community */
    private $_Community;

    /** @var Hand */
    private $_Hand;

    /** @var Hole */
    private $_Hole;

    public function setUp()
    {
        parent::setUp();

        $this->_HandIdentifier = new BestHandIdentifier();
    }

    public function testWillGetTwoOfAKind()
    {
        $this->_theSevenCardsAre('A-S', 'A-H', '7-C', '5-D', '4-S', '2-H', 'J-C');
        
        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('TwoOfAKind', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', 'A-H', 'J-C', '7-C', '5-D');
    }

    public function testWillGetTwoOfAKindWithADifferentPair()
    {
        $this->_theSevenCardsAre('A-S', '7-H', '7-C', '5-D', '4-S', '2-H', 'J-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('TwoOfAKind', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', '7-H', 'J-C', '7-C', '5-D');
    }

    public function testWillGetThreeOfAKind()
    {
        $this->_theSevenCardsAre('7-S', '7-H', '7-C', '5-D', '4-S', '2-H', 'J-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('ThreeOfAKind', $this->_Hand);
        $this->_theBestHandShouldContain('7-S', '7-H', '7-C', 'J-C', '5-D');
    }

    public function testWillGetJustAHighCard()
    {
        $this->_theSevenCardsAre('A-S', '3-H', '7-C', '5-D', '4-S', '2-H', 'J-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('HighCard', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', 'J-C', '7-C', '5-D', '4-S');
    }

//    public function testWillGetStraightFlush()
//    {
//        $this->_theSevenCardsAre('2-H', '6-S', '3-S', '7-S', '5-S', '4-S', 'J-C');
//
//        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);
//
//        $this->assertType('StraightFlush', $this->_Hand);
//        $this->_theBestHandShouldContain('6-S', '7-S', '5-S', '4-S', '3-S');
//    }

    public function testWillGetRoyalFlush()
    {
        $this->_theSevenCardsAre('2-H', 'A-S', 'K-S', 'Q-S', 'J-S', '10-S', 'J-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('RoyalFlush', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', 'K-S', 'Q-S', 'J-S', '10-S');
    }

    public function testWillGetFlush()
    {
        $this->_theSevenCardsAre('2-H', 'A-S', '3-S', '7-S', '5-S', '4-S', 'J-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('Flush', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', '7-S', '5-S', '4-S', '3-S');
    }

    public function testWillGetSixCardsSameSuit()
    {
        $this->_theSevenCardsAre('A-S', '3-S', '7-S', '5-S', '4-S', '2-S', 'J-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('Flush', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', '7-S', '5-S', '4-S', '3-S');
    }

    public function testWillGetFourOfAKind()
    {
        // Setup
        $this->_theSevenCardsAre('A-S', '4-S', 'A-C', 'A-D', 'A-H', '2-H', 'J-C');

        //System Under Test (SUT)
        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        // Assertions
        $this->assertType('FourOfAKind', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', 'A-H', 'A-C', 'A-D', 'J-C');
    }

    public function testWillGetFullHouse()
    {
        $this->_theSevenCardsAre('A-S', 'A-H', 'A-C', '5-D', '5-S', '2-H', 'J-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('FullHouse', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', 'A-H', 'A-C', '5-S', '5-D');
    }

    public function testWillGetStraight1()
    {
        $this->_theSevenCardsAre('2-H', 'A-S', 'K-H', 'J-C', 'Q-D', '10-S', 'J-S');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('Straight', $this->_Hand);
        $this->_theBestHandShouldContain('A-S', 'K-H', 'J-S', 'Q-D', '10-S');
    }

    public function testWillGetStraight2()
    {
        $this->_theSevenCardsAre('A-S', '10-H', '9-C', '8-D', '7-S', '6-H', '3-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('Straight', $this->_Hand);
        $this->_theBestHandShouldContain('10-H', '9-C', '8-D', '7-S', '6-H');
    }

    public function testWillGetStraight3()
    {
        $this->_theSevenCardsAre('A-S', 'K-H', '7-C', '6-D', '5-S', '4-H', '3-C');

        $this->_Hand = $this->_HandIdentifier->identify($this->_Hole, $this->_Community);

        $this->assertType('Straight', $this->_Hand);
        $this->_theBestHandShouldContain('7-C', '6-D', '5-S', '4-H', '3-C');
    }


    private function _theSevenCardsAre()
    {
        $cards = func_get_args();
        if (count($cards) != 7) {
            $this->fail('lrn2count');
        }

        list($this->_Hole, $this->_Community) = $this->_buildCardStringIntoAHoleAndCommunity($cards);
    }

    private function _theBestHandShouldContain()
    {
        $cards = func_get_args();
        if (count($cards) != 5) {
            $this->fail('lrn2count');
        }

        $ExpectedHand = $this->_buildCardStringIntoAHand($cards);

        $this->_assertHandsMatch($ExpectedHand, $this->_Hand);
    }

    private function _buildCardStringIntoACardArray(array $cards)
    {
        $Cards = array();

        foreach ($cards as $cardString) {
            $Cards[] = $this->_makeCardFromString($cardString);
        }

        return $Cards;
    }

    /**
     * @param string $cardString
     * @return Card
     */
    private function _makeCardFromString($cardString)
    {
        $CardBuilder = new CardBuilder();
        return $CardBuilder->fromString($cardString);
    }

    private function _buildCardStringIntoAHand(array $cards)
    {
        return new Hand($this->_buildCardStringIntoACardArray($cards));
    }

    private function _buildCardStringIntoAHoleAndCommunity($cards)
    {
        list($Card1, $Card2, $Card3, $Card4, $Card5, $Card6, $Card7) = $this->_buildCardStringIntoACardArray($cards);

        $Hole = new Hole($Card1, $Card2);
        $Community = new Community(new Flop($Card3, $Card4, $Card5), $Card6, $Card7);

        return array($Hole, $Community);
    }

    /**
     * @param Hand $ExpectedHand
     * @param Hand $ActualHand
     * @return void
     */
    private function _assertHandsMatch(Hand $ExpectedHand, Hand $ActualHand)
    {
        foreach ($ExpectedHand->getCards() as $ExpectedCard) {
            $this->assertTrue(in_array($ExpectedCard, $ActualHand->getCards()),
                "$ExpectedCard should have been returned"
            );    
        }

        foreach ($ActualHand->getCards() as $ActualCard) {
            $this->assertTrue(in_array($ActualCard, $ExpectedHand->getCards()),
                "$ActualCard should not have been returned"
            );
        }
    }
}