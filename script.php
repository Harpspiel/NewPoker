<?php
require_once 'bootstrap.php';

// take off the name
array_shift($argv);

try {
    $numberOfPassedCards = count($argv);
    if ($numberOfPassedCards < 7) {
     die("Sorry, you did not pass all the needed cards, there should only be seven, e.g. A-S  7-H  6-C  5-D  4-S  2-H  J-C\n");
    } elseif ($numberOfPassedCards > 7) {
     die("Sorry, you passed too many cards, there should only be seven, e.g. A-S  7-H  6-C  5-D  4-S  2-H  J-C\n");
    }

    list($Card1, $Card2, $Card3, $Card4, $Card5, $Card6, $Card7) = buildCards($argv);

    $Identifier = new BestHandIdentifier();
    $BestHand = $Identifier->identify(
        new Hole($Card1, $Card2),
        new Community(
            new Flop($Card3, $Card4, $Card5),
            $Card6,
            $Card7
        )
    );

    echo $BestHand . "\n";
} catch (Exception $e) {
    echo "Invalid input detected, please pass cards in the format 'value-suit', "
       . "e.g. A-S for Ace of Spades, or 7-C for Seven of Clubs\n";
}

function asCard($cardString)
{
    $CB = new CardBuilder();
    return $CB->fromString($cardString);
}

function buildCards(array $inputValues)
{
    $AllTheCards = array();

    foreach ($inputValues as $inputValue) {
        $AllTheCards[] = asCard($inputValue);
    }

    return $AllTheCards;
}