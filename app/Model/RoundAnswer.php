<?php
App::uses('AppModel', 'Model');
/**
 * RoundAnswer Model
 *
 */
class RoundAnswer extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'RoundAnswers';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'rid';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'player';

}
