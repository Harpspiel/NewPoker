<?php

class AcceptanceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $_inputs;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_inputs = '';
    }

    /**
     * @test
     */
    public function shouldBeAbleToIdentifyATwoOfAKind() 
    {
        $this->_givenTheseInputs("A-S  A-H  7-C  5-D  4-S  2-H  J-C")
            ->_theOutputShouldBe("A-S  A-H  J-C  7-C  5-D  (Two Of A Kind)");
    }

    /**
     * @test
     */
    public function shouldBeAbleToIdentifyAThreeOfAKind()
    {
        $this->_givenTheseInputs("A-S  A-H  A-C  5-D  4-S  2-H  J-C")
            ->_theOutputShouldBe("A-S  A-H  A-C  J-C  5-D  (Three Of A Kind)");
    }

    /**
     * @test
     */
    public function shouldBeAbleToIdentifyAHighCard()
    {
        $this->_givenTheseInputs("A-S  7-H  6-C  5-D  4-S  2-H  J-C")
            ->_theOutputShouldBe("A-S  J-C  7-H  6-C  5-D  (High Card)");
    }

    /**
     * @test
     */
    public function shouldReturnFailureMessageWhenNotEnoughCardsArePassed() 
    {
        $this->_givenTheseInputs("A-S  A-H  7-C  5-D  4-S  2-H")
            ->_theOutputShouldBe("Sorry, you did not pass all the needed cards, there should only be seven, e.g. A-S  7-H  6-C  5-D  4-S  2-H  J-C");
    }

    /**
     * @test
     */
    public function shouldReturnFailureMessageWhenTooManyCardsArePassed() 
    {
        $this->_givenTheseInputs("A-S  A-H  7-C  5-D  4-S  2-H  3-H  Q-S")
            ->_theOutputShouldBe("Sorry, you passed too many cards, there should only be seven, e.g. A-S  7-H  6-C  5-D  4-S  2-H  J-C");
    }

    /**
     * @test
     */
    public function shouldReturnFailureMessageWhenCardsAreNotPassed()
    {
        $this->_givenTheseInputs("one two three four five six seven")
            ->_theOutputShouldBe(
                "Invalid input detected, please pass "
              . "cards in the format 'value-suit', "
              . "e.g. A-S for Ace of Spades, or 7-C for Seven of Clubs"
        );
    }

    private function _givenTheseInputs($inputs)
    {
        $this->_inputs = $inputs;
        return $this;
    }

    private function _theOutputShouldBe($expectedOutput)
    {
        $actualOutput = `php ../script.php {$this->_inputs}`;
        $this->assertEquals($expectedOutput . "\n", $actualOutput);
    }
}