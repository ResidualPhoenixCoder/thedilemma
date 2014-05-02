<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * Player Model
 *
 */
class Player extends AppModel {

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        )
    );

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'Players';

    /**
     * Primary key field
     *
     * @var string
     */
    public $primaryKey = 'pid';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';

    public function beforeSave() {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                    $this->data[$this->alias]['password']
            );
        }
        return true;
    }

}
