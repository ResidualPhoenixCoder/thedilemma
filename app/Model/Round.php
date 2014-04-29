<?php
App::uses('AppModel', 'Model');
/**
 * Round Model
 *
 */
class Round extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Rounds';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'sid';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'sid';

}
