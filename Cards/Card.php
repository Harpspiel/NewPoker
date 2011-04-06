<?php
 
class Card {
    const JACK = 11;
    const QUEEN = 12;
    const KING = 13;
    const ACE = 14;

    const CLUBS = 'Clubs';
    const HEARTS = 'Hearts';
    const SPADES = 'Spades';
    const DIAMONDS = 'Diamonds';

    private $_faceValue;

    public function __construct($faceValue = 0)
    {
        $this->_faceValue = $faceValue;
    }

    /**
     * @return int
     */
    public function getFaceValue()
    {
        return $this->_faceValue;
    }

    public function getSuit()
    {
        return $this->_suit;
    }

    public function getSuitValue()
    {
        switch ($this->_suit) {
            case self::SPADES:
                return 4;
            case self::HEARTS:
                return 3;
            case self::CLUBS:
                return 2;
            case self::DIAMONDS:
                return 1;
        }
    }

    public function __toString()
    {
        switch ($this->getFaceValue()) {
            case self::ACE:
                $faceValue = 'A';
                break;
            case self::KING:
                $faceValue = 'K';
                break;
            case self::QUEEN:
                $faceValue = 'Q';
                break;
            case self::JACK:
                $faceValue = 'J';
                break;
            default:
                $faceValue = $this->getFaceValue();
                break;
        }
        return $faceValue . '-' . substr($this->getSuit(), 0, 1);
    }
}
