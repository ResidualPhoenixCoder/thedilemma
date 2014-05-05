<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionsControl
 *
 * @author mlabrador
 */
class GameController extends AppController {

    public function rounds() {
        $this->layout = 'round_lay';
        $this->loadModel("Player");
        $this->loadModel("Question");
        $this->loadModel("RoundAnswer");

        $opid = $this->request->data['player2_pid'];

        $current = $this->Auth->user('pid');
        $opponent = $this->Player->find('first', array(
            'conditions' => array('Player.pid' => $opid)
        ));

        /*
         * Retrieve the player's past games.  Select one of the past games, and use the same behaviors to pit against the user.
         */
        $p2hist = $this->RoundAnswer->find('first', array(
            'conditions' => array('RoundAnswer.player' => $opid),
            'order' => 'rand()'
        ));

        $questions = $this->RoundAnswer->find('all', array(
            'conditions' => array('RoundAnswer.question_group' => $p2hist['RoundAnswer']['question_group'], 'RoundAnswer.player' => $opid),
            'order' => 'question_order ASC'
        ));

        $this->set('questions', json_encode($questions));
        $this->set('question_group', uniqid());
        $this->set('current', $current);
        $this->set('opponent', json_encode($opponent['Player']));
        $this->set('music', $this->webroot . 'media/' . rand(1, 5) .'.mp3');
    }

    public function roundComplete() {
        $this->autoRender = false;
        $this->loadModel('Player');
        $this->loadModel('Round');
        $data = $this->request->input('json_decode', true);

        //Increment the player's action records, per round.
        $this->account_acts($data['player'], $data['player_act']);
        $this->account_acts($data['opponent'], $data['opponent_act']);

        //Check who was correct, and update the player record.
        $this->account_correct($data['player'], $data['player_true_answer'], $data['correct']);
        $this->account_correct($data['opponent'], $data['opponent_true_answer'] . $data['correct']);

        //QUESTION ADMINISTRATION
        $qid = $data['question_id'];
        $qg = $data['question_group'];
        $qo = $data['question_order'];
        
        //ADMINISTRATION OF ROUND RECORDS
        $p1data = $this->assemble_player_record($data['player'], $data['player_act'], $data['player_true_answer'], $data['player_lie_answer'], $qid, $qg, $qo);
        $p2data = $this->assemble_player_record($data['opponent'], $data['opponent_act'], $data['opponent_true_answer'], $data['opponent_lie_answer'], $qid, $qg, $qo);
        
        $p1vp2 = $this->assemble_round_record($p1data, $p2data, $qid, $qg, $qo);
        $p2vp1 = $this->assemble_round_record($p2data, $p1data, $qid, $qg, $qo);
        
        $this->save_round($p1vp2);
        $this->save_round($p2vp1);
    }

    public function game_complete() {
//        $this->autoRender = false;
        $this->loadModel('Player');
        $data = $this->request->data;

        //Increment the game counter for both players.
        $this->Player->updateAll(array('Player.games' => 'Player.games + 1'), array('OR' =>
            array(
                array('Player.pid' => $data['winner']),
                array('Player.pid' => $data['loser'])
            )
                )
        );
        
        $this->Player->updateAll(array('Player' => 'Player.totalpoints + ' . $data['winfinal']), array('Player.pid' => $data['winner']));
        $this->Player->updateAll(array('Player' => 'Player.totalpoints + ' . $data['losefinal']), array('Player.pid' => $data['loser']));
        
        $this->set('results', $data);
        $this->set('resultsJSON', json_encode($data));
        $this->set('pid', $this->Auth->user('pid'));
    }

    private function save_round($rec) {
        try {
            $this->Round->create();
            $this->Round->save($rec);
        } catch (Exception $e) {
            
        }
    }

    private function assemble_player_record($pid, $act, $trueAns, $lieAns, $qid, $qg, $qo) {
        $rec = array();
        $rec['player'] = $pid;
        $rec['question_id'] = $qid;
        $rec['question_group'] = $qg;
        $rec['question_order'] = $qo;
        $rec['player_act'] = $act;
        $rec['player_true_answer'] = $trueAns;
        $rec['player_lie_answer'] = $lieAns;
        return $rec;
    }

    private function assemble_round_record($p1data, $p2data, $qid, $qg, $qo) {
        return array(
            'player' => $p1data['player'],
            'opponent' => $p2data['player'],
            'question_id' => $qid,
            'question_group' => $qg,
            'question_order' => $qo,
            'player_act' => $p1data['player_act'],
            'opponent_act' => $p2data['player_act'],
            'player_true_answer' => $p1data['player_true_answer'],
            'player_lie_answer' => $p1data['player_lie_answer'],
            'opponent_true_answer' => $p2data['player_true_answer'],
            'opponent_lie_answer' => $p2data['player_lie_answer']);
    }

    private function account_correct($pid, $pans, $cans) {
        if ($pans == $cans) {
            $this->Player->updateAll(array('Player.correct' => 'Player.correct + 1'), array('Player.pid' => $pid));
        }
    }

    private function account_acts($pid, $act) {
        switch ($act) {
            case "L":
                $this->Player->updateAll(array('Player.lie' => 'Player.lie + 1'), array('Player.pid' => $pid));
                break;
            case "H":
                $this->Player->updateAll(array('Player.hide' => 'Player.hide + 1'), array('Player.pid' => $pid));
                break;
            case "S":
                $this->Player->updateAll(array('Player.share'=> 'Player.share + 1'), array('Player.pid' => $pid));
                break;
        }
    }

}
