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
class QuestionsControl {
    public function questions() {
        $this->loadModel("Question");
        
        try {
            $this->questions->create();
        } catch(Exception $e) {
            
        }
    }
}
