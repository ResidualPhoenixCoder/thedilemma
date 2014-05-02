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
            $this->autoRender = false;
            $this->loadModel('Player');
            $data = $this->Player->find('all', array(
                'order' => 'rand()',
                'limit' => 10
            ));
            echo json_encode($data);
        }
    }
}
