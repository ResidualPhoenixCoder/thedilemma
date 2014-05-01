<?php
App::uses('AppModel', 'Model');
/**
 * Player Model
 *
 */
class Player extends AppModel {

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

}
