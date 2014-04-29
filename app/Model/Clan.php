<?php
App::uses('AppModel', 'Model');
/**
 * Clan Model
 *
 */
class Clan extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'Clans';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'clan_tag';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'clan_name';

}
