<?php

class CardBuilder
{

    public function fromString($cardString = 'A-S')
    {
        $cardStringAsArray = explode('-', $cardString);

        if (count($cardStringAsArray) != 2) {
            throw new Exception('Invalid card string');
        }
        
        list($faceValue, $suit) = $cardStringAsArray;

        $faceValue = $this->_convertValueFromLetterToNumber($faceValue);

        if ($faceValue > Card::ACE || $faceValue < 2) {
            throw new Exception('Invalid face value');
        }

        switch ($suit) {
            case 'D':
                $Card = new Diamonds($faceValue);
                break;

            case 'H':
                $Card = new Hearts($faceValue);
                break;

            case 'S':
                $Card = new Spades($faceValue);
                break;

            case 'C':
                $Card = new Clubs($faceValue);
                break;

            default:
                throw new Exception('Invalid suit');
        }

        return $Card;
    }

    private function _convertValueFromLetterToNumber($faceValue)
    {
        switch ($faceValue) {
            case 'A':
                $faceValue = Card::ACE;
                break;

            case 'J':
                $faceValue = Card::JACK;
                break;

            case 'Q':
                $faceValue = Card::QUEEN;
                break;

            case 'K':
                $faceValue = Card::KING;
                break;
        }

        return $faceValue;
    }
}
