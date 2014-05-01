<?php
/**
 * PlayerFixture
 *
 */
class PlayerFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'Players';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'pid' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => 'password', 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'clan_tag' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'daily' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'weekly' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'monthly' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'lifetime' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'hide' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'lie' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'share' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'correct' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'pid', 'unique' => 1),
			'email_UNIQUE' => array('column' => 'email', 'unique' => 1),
			'Fulle Name_UNIQUE' => array('column' => 'username', 'unique' => 1),
			'pid_UNIQUE' => array('column' => 'pid', 'unique' => 1),
			'clan_tag_idx' => array('column' => 'clan_tag', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'pid' => 1,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'clan_tag' => 'Lor',
			'daily' => 1,
			'weekly' => 1,
			'monthly' => 1,
			'lifetime' => 1,
			'hide' => 1,
			'lie' => 1,
			'share' => 1,
			'correct' => 1
		),
	);

}
