<?php

class Flop {

    private $_First;
    private $_Second;
    private $_Third;

    public function __construct(Card $First, Card $Second, Card $Third)
    {
        $this->_First = $First;
        $this->_Second = $Second;
        $this->_Third = $Third;
    }

    /**
     * @return Card
     */
    public function getFirst()
    {
        return $this->_First;
    }

    /**
     * @return Card
     */
    public function getSecond()
    {
        return $this->_Second;
    }

    /**
     * @return Card
     */
    public function getThird()
    {
        return $this->_Third;
    }

}
