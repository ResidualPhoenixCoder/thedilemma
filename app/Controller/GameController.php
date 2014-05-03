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
        $this->loadModel("Round");
        $this->loadModel("RoundAnswer");
        $opid = $this->request->data['player2_pid'];
        $this->set('opponent', $this->request->data['player2']);
        
        
        //$this->Round->find('all', array('conditions' => ));
//        try {
//            $this->Round->create();
//            $this->Question->save($data);
//        } catch(Exception $e) {
//            
//        }
    }
}
