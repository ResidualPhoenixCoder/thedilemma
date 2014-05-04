<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LobbyController
 *
 * @author mlabrador
 */
class LobbyController extends AppController{
    public function beforeFilter() {
        
    }
    
    public function lobby() {
        
    }
    
    public function getPlayers() {
        if($this->Auth->login()) {
            $numPlayer = 10;
            $this->autoRender = false;
            $this->loadModel('Player');
            $data = $this->Player->find('all', array(
                'conditions' => array('Player.games >' => 0, 'Player.role' => 'real', 'Player.pid <>' => $this->Auth->user('pid')),
                'order' => 'rand()',
                'limit' => $numPlayer
            ));
           
            //If there are not enough players, retrieve the rest from the bot pools.
            if(sizeof($data) > 0 && sizeof($data) < $numPlayer) {
                $addBotData = $this->Player->find('all', array(
                   'conditions' => array('Player.role' => 'bot', 'Player.games >' => 0),
                   'order' => 'rand()',
                   'limit' => $numPlayer - sizeof($data)
                ));
                $data = array_merge($data, $addBotData);
            } else if(sizeof($data) <= 0) {
                //Retrieve players from the bots list.
                $data = $this->Player->find('all', array(
                   'conditions' => array('Player.role' => 'bot', 'Player.games >' => 0),
                   'order' => 'rand()',
                   'limit' => $numPlayer
                ));
            }
            echo json_encode($data);
        }
    }
}
