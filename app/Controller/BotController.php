<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP BotController
 * @author mlabrador
 */
class BotController extends AppController {

    public function botcreator() {
        /*
         * + Create multiple unique bot users. 10 at a time.
         * 
         * + Select one bot to play a game.
         *      + Randomly select another bot.
         *      + Retrieve 10 random questions.
         *      + Generate a UUID for the question group.
         * 
         * + Play the game.
         *      + Retrieve the opponent's previous game history and choose one.
         *      + Randomly select the player's answer.
         *      + Randomly select the opponent's answer.
         *      + Randomly select the player's actions.
         *          + If it's a lie, randomly select the player's lie answer.
         *      + Randomly select the opponent's actions.
         *          + If it's a lie, randomly select the opponent's lie answer.
         * 
         * + Win/Lose/Draw Determination.
         */
        $this->autoRender = false;

        $this->loadModel('Player');
        $this->loadModel('Question');
        $this->loadModel('Round');

        $numBots = 10;
        $numQs = 10;
        $numSims = 3;
        $numMinGames = 5;
        $numMaxGames = 10;
        $playerAnswers = array('a', 'b', 'c', 'd');
        $playerActions = array('H', 'S', 'L');

        $botData = $this->Player->find('all', array(
            'conditions' => array('Player.role' => 'bot'), 
            'order' => 'rand()', 
            'limit' => $numBots));
        
        if (sizeof($botData) <$numBots) {
            $data = array('Player' => array());
            for ($botCtr = 0; $botCtr < $numBots; $botCtr++) {
                $newBot = array();
                $newBot['username'] = uniqid('bot_');
                $newBot['password'] = uniqid();
                $newBot['email'] = $newBot['username'] . "@bot.com";
                $newBot['clan_tag'] = 'bot';
                $newBot['role'] = 'bot';
                array_push($data['Player'], $newBot);
            }

            try {
                $this->Player->create();
                $this->Player->saveAll($data['Player']);
            } catch (Exception $e) {
                
            }
        }

        //SIMULATION DRIVER
        for ($i = 0; $i < $numSims; $i++) {
            //Retrieve 2 random players.
            $players = $this->Player->find('all', array(
//                'conditions' => array('Player.role' => 'bot'),
                'order' => 'rand()',
                'limit' => 2
            ));
            $this->playGame($players[0]['Player'], $players[1]['Player'], $numQs, $playerAnswers, $playerActions, $numMinGames, $numMaxGames);

            try {
                $this->Player->create();
                $this->Player->save($players[0]['Player']);

                $this->Player->create();
                $this->Player->save($players[1]['Player']);
            } catch (Exception $e) {
                
            }
        }

        $returnData = $this->Player->find('all', array(
            'conditions' => array('Player.games >' => 0),
            'order' => 'rand()',
            'limit' => $numBots
        ));

        echo json_encode($returnData);
    }

    //Plays a game with bots.
    private function playGame(&$p1, &$p2, $numQs, $playerAnswers, $playerActions, $numMinGames, $numMaxGames) {
        for ($j = 0; $j < rand($numMinGames, $numMaxGames); $j++) {
            $rounds = array('Round' => array());
            //Create the unique question groups id.
            $rqg = uniqid();

            $rqs = $this->Question->find('all', array(
                'order' => 'rand()',
                'limit' => $numQs
            ));

            //Go through each question.
            $ctr = 0;
            foreach ($rqs as $rq) {
                $q = $rq['Question'];
                $rnd12 = array();
                $rnd21 = array();
                $this->play_round($p1, $p2, $rnd12, $q, $rqg, $ctr, $playerAnswers, $playerActions);
                $this->play_round($p2, $p1, $rnd21, $q, $rqg, $ctr++, $playerAnswers, $playerActions);
//                array_push($rounds['Round'], $rnd12);
//                array_push($rounds['Round'], $rnd21);

                try {
                    $this->Round->create();
                    $this->Round->save($rnd12);
                    $this->Round->create();
                    $this->Round->save($rnd21);
                } catch (Exception $e) {
                    
                }
            }

            $p1['games'] ++;
            $p2['games'] ++;
        }
    }

    private function play_round(&$p1, &$p2, &$rnd, $q, $rqg, $order, $playerAnswers, $playerActions) {
        //ADMINISTRATION
        $rnd['player'] = $p1['pid'];
        $rnd['opponent'] = $p2['pid'];
        //$rnd['date'] = date();
        $rnd['question_id'] = $q['qid'];
        $rnd['question_group'] = $rqg;
        $rnd['question_order'] = $order;

        //GAMEPLAY
        $rnd['player_true_answer'] = $playerAnswers[rand(0, sizeof($playerAnswers) - 1)];
        $rnd['opponent_true_answer'] = $playerAnswers[rand(0, sizeof($playerAnswers) - 1)];

        $rnd['player_act'] = $playerActions[rand(0, sizeof($playerActions) - 1)];
        $rnd['opponent_act'] = $playerActions[rand(0, sizeof($playerActions) - 1)];

        $this->act_handler($p1, $rnd['player_act'], $rnd['player_lie_answer'], $rnd['player_true_answer'], $playerAnswers);
        $this->act_handler($p2, $rnd['opponent_act'], $rnd['opponent_lie_answer'], $rnd['opponent_true_answer'], $playerAnswers);

        $this->correct_handler($p1, $q['correct_answer'], $rnd['player_true_answer']);
        $this->correct_handler($p2, $q['correct_answer'], $rnd['opponent_true_answer']);
    }

    private function correct_handler(&$p, $rightAns, $ans) {
        if ($rightAns == $ans) {
            $p['correct'] ++;
        }
    }

    //Handles how the round information gets treated when there is a certain action.
    private function act_handler(&$p, $act, &$rndlie, $ans, $playerAnswers) {
        switch ($act) {
            case 'H':
                $p['hide'] ++;
                break;
            case 'L':
                $p['lie'] ++;
                $rndlie = $this->getLie($playerAnswers, $ans);
                break;
            case 'S':
                $p['share'] ++;
                break;
        }
    }

    //Retrieves an answers aside from the one selected.
    private function getLie($answers, $pans) {
        $lieAns = array();
        foreach ($answers as $ans) {
            if ($ans != $pans) {
                array_push($lieAns, $ans);
            }
        }
        return $lieAns[rand(0, sizeof($lieAns) - 1)];
    }

}
