<?php
namespace Model;

class Player extends AbstractHand
{
    /**
     * @return int
     */
    public function getMaxCardCount(){
        return 2;
    }

    /**
     * @param Dealer $dealer
     * @return SolutionHand|null
     */
    public function getWinningHand(Dealer $dealer){
        $winningHand = null;
        $allCards = array_merge($this->getCards(), $dealer->getCards());
        $allCardCombos = $this->getCombinations($allCards, 5);
        foreach($allCardCombos as $cardCombo){
            $solutionHand = new SolutionHand($cardCombo);
            if (!$winningHand || $solutionHand->diff($winningHand) > 0) {
                $winningHand = $solutionHand;
            }
        }
        return $winningHand;
    }

    /**
     * @param $base
     * @param $n
     * @return array|void
     */
    protected function getCombinations($base,$n){
        #borrowed this function from StackOverflow
        $baselen = count($base);
        if($baselen == 0){
            return;
        }
        if($n == 1){
            $return = array();
            foreach($base as $b){
                $return[] = array($b);
            }
            return $return;
        }else{
            $oneLevelLower = $this->getCombinations($base,$n-1);
            $newCombs = array();
            foreach($oneLevelLower as $oll){
                $lastEl = $oll[$n-2];
                $found = false;
                foreach($base as  $key => $b){
                    if($b == $lastEl){
                        $found = true;
                        continue;
                        //last element found
                    }
                    if($found == true){
                        //add to combinations with last element
                        if($key < $baselen){
                            $tmp = $oll;
                            $newCombination = array_slice($tmp,0);
                            $newCombination[]=$b;
                            $newCombs[] = array_slice($newCombination,0);
                        }
                    }
                }
            }
        }
        return $newCombs;
    }
}