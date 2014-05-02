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
        //$this->loadModel("Question");
        //$data = $this->request->input('json_decode', true);
        //print_r($this->request->data);
        $this->set('opponent', $this->request->data['player2']);
//        try {
//            $this->Question->create();
//            $this->Question->save($data);
//        } catch(Exception $e) {
//            
//        }
    }
}
