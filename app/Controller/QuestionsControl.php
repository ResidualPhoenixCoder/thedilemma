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
    
    public function question_round() {
        $this->loadModel("Question");
        $data = $this->request->input('json_decode', true);
        try {
            $this->questions->create();
            $this->questions->save($data);
        } catch(Exception $e) {
            
        }
        echo json_encode($data);
    }
}
