<?php
App::uses('AppModel', 'Model');
/**
 * Question Model
 *
 */
class Question extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Questions';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'qid';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'question';

}
