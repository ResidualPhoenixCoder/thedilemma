<div id="lobby">
This is the fucking lobby.
<?php 
    if($this->Session->read('Auth')){
        echo $this->Html->link('Logout', array('controller' => 'dilemmas', 'action' => 'logout'));
    }      
?>;
</div>