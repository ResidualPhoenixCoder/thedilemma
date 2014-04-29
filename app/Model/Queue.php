<?php
App::uses('AppModel', 'Model');
/**
 * Queue Model
 *
 */
class Queue extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Queue';

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
	public $displayField = 'pid';

}
