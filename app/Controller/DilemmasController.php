<?php
App::uses('AppController', 'Controller');

class DilemmasController extends AppController {
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->authenticate = array('Form');
            $this->Auth->allow('register', 'login');
        }
        
        /*
         * Registers the user in the database and validates to make sure
         * the user does not exist either by username or by e-mail.
         */
	public function register() {
            $this->loadModel('Player');
            
            /*
             * Sample Model Access
             */
            
            /*
             * $this->Player->find('first');
             * foreach($players as $player) {
             *      echo $player['Player']['username'];
             *      echo "<br/>";
             * }
             */
            
            $this->autoRender=false;
            $data = $this->request->input('json_decode', true);
            if(!empty($data) && !(empty($data['username']) || empty($data['password']) || empty($data['email']))) {
                $playerByUsername = $this->Player->find('first', array('conditions' => array('Player.username' => mysql_real_escape_string($data['username']))));
                $playerByEmail = $this->Player->find('first', array('conditions' => array('Player.email' => mysql_real_escape_string($data['email']))));
                
                //Check whether this player exists by username or e-mail.
                if(!empty($playerByUsername) || !empty($playerByEmail)) {
                    $error = "";
                    $ctr = 0;
                    if(!empty($playerByUsername)) {
                        $error = "Player exists by username";
                        $ctr++;
                    }
                    
                    if(!empty($playerByEmail)) {
                        if($ctr == 0) {
                            $error = "Player exists by e-mail";
                        } else {
                            $error .= ", and e-mail";
                        }
                    }
                    
                    $data['error'] = true;
                    $data['errorMsg'] = $error . ".";
                    $data['exists'] = true;
                } else {
                    //Create the new user object to be inserted into the database.
                    $newUser = array('username' => $data['username'], 'email' => $data['email'], 'password' => $data['password']);
                    try{
                        $this->Player->create();
                        $this->Player->save($newUser); //Inserts this user into the database.
                    } catch(Exception $e) {
                        $data['error'] = true;
                        $data['errorMsg'] = "User creation not possible.";
                    }
                }
            /*
             * The following checks whether any of the essential fields are empty.  If they are, 
             * then the error message is constructed.
             */ 
            } else {
                $data['error'] = true;
                $data['errorMsg'] = "Data object retrieval failed.";
            }
            echo json_encode($data);
	}
        
        public function login() {
            $this->autoRender = false;
            if($this->request->is('post')) {
                $data = $this->request->input('json_decode', true);
                $this->request->data['Player']['username'] = $data['username'];
                $this->request->data['Player']['password'] = $data['password'];
                $this->Auth->authenticate = array(AuthComponent::ALL => array('userModel' => 'Player'), 'Basic', 'Form');
                if($this->Auth->login()) {
                    $data['auth'] = true;
                    $data['redirect'] = Router::url(array('controller' => 'lobby', 'action' => 'lobby'));
                    $data['error'] = false;
                } else {
                    $data['error'] = true;
                    $data['errorMsg'] = "Incorrect username or password.";
                }
                
                echo json_encode($data);
            }
        }
        
        public function logout() {
            return $this->redirect($this->Auth->logout());
        }
}
?>
