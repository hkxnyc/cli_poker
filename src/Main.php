<?php
include "autoloader.php";
echo("Number of players [2-12]:");
$input = (int) fgets(STDIN);
if (!is_int($input) || $input < 2 || $input > 12 ){
    die("Bad Input");
}
$playerCount = $input;
$players=[];
$deck = new \Model\Deck();
$deck->shuffleDeck();

for($i = 1; $i<=$playerCount; $i++){
    $playerCards = [$deck->drawCard(), $deck->drawCard()];
    $players["player".$i]= new \Model\Player($playerCards);
}

$dealerCards = new \Model\Dealer([
    $deck->drawCard(),
    $deck->drawCard(),
    $deck->drawCard(),
    $deck->drawCard(),
    $deck->drawCard(),
]);
echo("Dealer has ".$dealerCards);
echo("\n");
$winningPlayerName = null;
$winningPlayerHand = null;
foreach($players as $playerName=>$playerCards){
    echo($playerName." has ".$playerCards);
    echo("\n");
    $playersBestHand = $playerCards->getWinningHand($dealerCards);
    echo($playerName." best value " . $playersBestHand." which is a ". $playersBestHand->getHandTypeLabel()."\n");
    if (!$winningPlayerHand || $playersBestHand->diff($winningPlayerHand) > 0) {
        $winningPlayerHand = $playersBestHand;
        $winningPlayerName = $playerName;
    }
}

echo($winningPlayerName." is the winner with ".$winningPlayerHand->getHandTypeLabel(). " as the winning hand.");

