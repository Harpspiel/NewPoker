<?php

class Hole {
    private $_FirstCard;
    private $_SecondCard;

    public function __construct(Card $FirstHole, Card $SecondHole)
    {
        $this->_FirstCard = $FirstHole;
        $this->_SecondCard = $SecondHole;
    }

    /**
     * @return Card
     */
    public function getFirstCard()
    {
        return $this->_FirstCard;
    }

    /**
     * @return Card
     */
    public function getSecondCard()
    {
        return $this->_SecondCard;
    }
}
