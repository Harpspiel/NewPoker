<?php

class Community {

    private $_First;
    private $_Second;
    private $_Third;
    private $_Turn;
    private $_River;

    public function __construct(Flop $Flop, Card $Turn, Card $River)
    {
        $this->_First = $Flop->getFirst();
        $this->_Second = $Flop->getSecond();
        $this->_Third = $Flop->getThird();
        $this->_Turn = $Turn;
        $this->_River = $River;
    }

    public function getFirstFlop()
    {
        return $this->_First;
    }

    public function getSecondFlop()
    {
        return $this->_Second;
    }

    public function getThirdFlop()
    {
        return $this->_Third;
    }

    public function getTurn()
    {
        return $this->_Turn;
    }

    public function getRiver()
    {
        return $this->_River;
    }

    public function getAll()
    {
        return array(
            $this->_First,
            $this->_Second,
            $this->_Third,
            $this->_Turn,
            $this->_River
        );
    }
}
