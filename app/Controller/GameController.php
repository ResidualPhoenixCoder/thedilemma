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
class GameController extends AppController{
    
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
    }
    
    public function roundComplete() {
            $this->autoRender = false;
//        $data = $this->request->input('json_decode', true);
    }
}
