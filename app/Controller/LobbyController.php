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
        //$this->Auth->allow('lobby');
    }
    
    public function lobby() {
        $this->layout = "dilemmas";
        if($this->Auth->login()) {
            
        }
    }
}
