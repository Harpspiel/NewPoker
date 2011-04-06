<?php

class CardRanker 
{
    public static function compareCards(Card $Card1, Card $Card2)
    {
        if ($Card1->getFaceValue() == $Card2->getFaceValue()) {
            return ($Card1->getSuitValue() > $Card2->getSuitValue()) ? -1 : 1;
        }
        return ($Card1->getFaceValue() > $Card2->getFaceValue()) ? -1 : 1;
    }
}
