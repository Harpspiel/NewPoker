<?php
class BestHandIdentifier
{
    public function identify(Hole $Hole, Community $Community)
    {
        $AllCards[] = $Hole->getFirstCard();
        $AllCards[] = $Hole->getSecondCard();
        $AllCards = array_merge($AllCards, $Community->getAll());

        /** @var Card[] $AllCards */
        foreach ($AllCards as $Card) {
            $CardsGroupedByValues[$Card->getFaceValue()][] = $Card;
        }

        foreach ($AllCards as $SuitCard) {
            $CardsGroupedBySuits[$SuitCard->getSuitValue()][] = $SuitCard;
        }

        foreach ($CardsGroupedBySuits as $SuitCards) {
            if (count($SuitCards) >= 5) {
                $SuitCards = $this->_getSortedCards($SuitCards);
                $LowestCard = $SuitCards[4];
                if ($LowestCard->getFaceValue() == 10) {
                    return new RoyalFlush(array_slice($SuitCards, 0, 5));
                } else {
                    return new Flush(array_slice($SuitCards, 0, 5));
                }
            }
        }

        if (count($CardsGroupedByValues) >= 5) {
            krsort($CardsGroupedByValues);
            $BestSuitPerValue = array();
            foreach ($CardsGroupedByValues as $Cards) {
                $Cards = $this->_getSortedCards($Cards);
                $BestSuitPerValue[] = $Cards[0];
            }
            if (count($BestSuitPerValue) >= 5 && $this->_areNextFiveCardsConsecutive($BestSuitPerValue)) {
                return new Straight(array_slice($BestSuitPerValue, 0, 5));
            }
            array_shift($BestSuitPerValue);
            if (count($BestSuitPerValue) >= 5 && $this->_areNextFiveCardsConsecutive($BestSuitPerValue)) {
              return new Straight(array_slice($BestSuitPerValue, 0, 5));
            }
            array_shift($BestSuitPerValue);
            if (count($BestSuitPerValue) >= 5 && $this->_areNextFiveCardsConsecutive($BestSuitPerValue)) {
              return new Straight(array_slice($BestSuitPerValue, 0, 5));
            }
        }

        foreach ($CardsGroupedByValues as $faceValue => $Cards) {
            if (count($Cards) == 4) {
                $CardsNotOfValue = $this->_getCardsNotOfFaceValue($faceValue, $CardsGroupedByValues);
                list($Kicker1) = $this->_getSortedCards($CardsNotOfValue);
                return new FourOfAKind(array_merge($Cards, array($Kicker1)));
            }
        }

        foreach ($CardsGroupedByValues as $Cards) {
            if (count($Cards) == 3) {
                foreach ($CardsGroupedByValues as $InnerCards) {
                    if (count($InnerCards) == 2) {
                        return new FullHouse(array_merge($Cards, $InnerCards));
                    }
                }
            }
        }

        foreach ($CardsGroupedByValues as $faceValue => $Cards) {
            if (count($Cards) == 3) {
                $CardsNotOfValue = $this->_getCardsNotOfFaceValue($faceValue, $CardsGroupedByValues);
                list($Kicker1, $Kicker2) = $this->_getSortedCards($CardsNotOfValue);
                return new ThreeOfAKind(array_merge($Cards, array($Kicker1, $Kicker2)));
            }
        }

        foreach ($CardsGroupedByValues as $faceValue => $Cards) {
            if (count($Cards) == 2) {
                $CardsNotOfValue = $this->_getCardsNotOfFaceValue($faceValue, $CardsGroupedByValues);
                list($Kicker1, $Kicker2, $Kicker3) = $this->_getSortedCards($CardsNotOfValue);
                return new TwoOfAKind(array_merge($Cards, array($Kicker1, $Kicker2, $Kicker3)));
            }
        }

        return new HighCard(array_slice($this->_getSortedCards($AllCards), 0, 5));
    }

    private function _getCardsNotOfFaceValue($faceValue, $CardsGroupedByValues)
    {
        $NotOfValue = array();
        unset($CardsGroupedByValues[$faceValue]);
        foreach ($CardsGroupedByValues as $Cards) {
            foreach ($Cards as $Card) {
                $NotOfValue[] = $Card;
            }
        }
        return $NotOfValue;
    }

    private function _getSortedCards($UnsortedCardArray)
    {
        usort($UnsortedCardArray, 'self::compareCards');
        return $UnsortedCardArray;
    }

    private function _areNextFiveCardsConsecutive(array $CardArray)
    {
        $FirstCard =  $CardArray[0];
        $SecondCard = $CardArray[1];
        $ThirdCard =  $CardArray[2];
        $FourthCard = $CardArray[3];
        $FifthCard =  $CardArray[4];
        return
            ($SecondCard->getFaceValue() == ($FirstCard->getFaceValue() -1) &&
            $ThirdCard->getFaceValue() == ($FirstCard->getFaceValue() -2) &&
            $FourthCard->getFaceValue() == ($FirstCard->getFaceValue() -3) &&
            $FifthCard->getFaceValue() == ($FirstCard->getFaceValue() -4));
    }

    public static function compareCards(Card $Card1, Card $Card2)
    {
        if ($Card1->getFaceValue() == $Card2->getFaceValue()) {
            return ($Card1->getSuitValue() > $Card2->getSuitValue()) ? -1 : 1;
        }
        return ($Card1->getFaceValue() > $Card2->getFaceValue()) ? -1 : 1;
    }
}
