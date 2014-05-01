<?php
App::uses('Clan', 'Model');

/**
 * Clan Test Case
 *
 */
class ClanTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.clan'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Clan = ClassRegistry::init('Clan');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Clan);

		parent::tearDown();
	}

}
