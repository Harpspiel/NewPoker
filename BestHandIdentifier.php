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
                $NonConsecutiveCards = $SuitCards;
                $LowestCard = $SuitCards[4];
                if ($LowestCard->getFaceValue() == 10) {
                    return new RoyalFlush(array_slice($SuitCards, 0, 5));
                }
                while (count($SuitCards) >= 5) {
                    if ($this->_areNextFiveCardsConsecutive($SuitCards)) {
                        return new StraightFlush(array_slice($SuitCards, 0, 5));
                    } else array_shift($SuitCards);
                } return new Flush(array_slice($NonConsecutiveCards, 0, 5));
            }
        }

        if (count($CardsGroupedByValues) >= 5) {
            krsort($CardsGroupedByValues);
            $BestSuitPerValue = array();
            foreach ($CardsGroupedByValues as $Cards) {
                $Cards = $this->_getSortedCards($Cards);
                $BestSuitPerValue[] = $Cards[0];
            }
            while (count($BestSuitPerValue) >= 5) {
                if ($this->_areNextFiveCardsConsecutive($BestSuitPerValue)) {
                    return new Straight(array_slice($BestSuitPerValue, 0, 5));
                } else array_shift($BestSuitPerValue);
            }
        }

        foreach ($CardsGroupedByValues as $faceValue => $Cards) {
            if (count($Cards) == 4) {
                $Cards = $this->_getSortedCards($Cards);
                $CardsNotOfValue = $this->_getCardsNotOfFaceValue($faceValue, $CardsGroupedByValues);
                list($Kicker1) = $this->_getSortedCards($CardsNotOfValue);
                return new FourOfAKind(array_merge($Cards, array($Kicker1)));
            }
        }

        foreach ($CardsGroupedByValues as $Cards) {
            if (count($Cards) == 3) {
                $Cards = $this->_getSortedCards($Cards);
                foreach ($CardsGroupedByValues as $InnerCards) {
                    if (count($InnerCards) == 2) {
                        $InnerCards = $this->_getSortedCards($InnerCards);
                        return new FullHouse(array_merge($Cards, $InnerCards));
                    }
                }
            }
        }

        foreach ($CardsGroupedByValues as $faceValue => $Cards) {
            if (count($Cards) == 3) {
                $Cards = $this->_getSortedCards($Cards);
                $CardsNotOfValue = $this->_getCardsNotOfFaceValue($faceValue, $CardsGroupedByValues);
                list($Kicker1, $Kicker2) = $this->_getSortedCards($CardsNotOfValue);
                return new ThreeOfAKind(array_merge($Cards, array($Kicker1, $Kicker2)));
            }
        }

        $CardsRemaining = $CardsGroupedByValues;
        foreach ($CardsRemaining as $faceValue => $Cards) {
            if (count($Cards) == 2) {
                $Cards = $this->_getSortedCards($Cards);
                unset ($CardsRemaining[$faceValue]);
                foreach ($CardsRemaining as $faceValue => $InnerCards) {
                    if (count($InnerCards) == 2) {
                        $InnerCards = $this->_getSortedCards($InnerCards);
                        $CardsNotOfValue = $this->_getCardsNotOfFaceValue($faceValue, $CardsRemaining);
                        list($Kicker1) = $this->_getSortedCards($CardsNotOfValue);
                        return new TwoPair(array_merge($Cards, $InnerCards, array($Kicker1)));
                    }
                }
            }
        }

        foreach ($CardsGroupedByValues as $faceValue => $Cards) {
            if (count($Cards) == 2) {
                $Cards = $this->_getSortedCards($Cards);
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
        usort($UnsortedCardArray, 'CardRanker::compareCards');
        return $UnsortedCardArray;
    }

    private function _areNextFiveCardsConsecutive(array $CardArray)
    {
        $FirstCard =  $CardArray[0];
        $FifthCard =  $CardArray[4];
        return
            ($FifthCard->getFaceValue() == ($FirstCard->getFaceValue() -4));
    }
}
