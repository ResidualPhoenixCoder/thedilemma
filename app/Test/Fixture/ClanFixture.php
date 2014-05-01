<?php
/**
 * ClanFixture
 *
 */
class ClanFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'Clans';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'clan_tag' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'clan_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'motto' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'clan_tag', 'unique' => 1),
			'clan_name_UNIQUE' => array('column' => 'clan_name', 'unique' => 1)
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
			'clan_tag' => 'Lor',
			'clan_name' => 'Lorem ipsum dolor sit amet',
			'motto' => 'Lorem ipsum dolor sit amet'
		),
	);

}
