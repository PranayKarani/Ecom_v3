<?php

class exampleTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	public function testMe () {

		$this->assertEquals("xyz", $this->tester);

	}

	protected function _before () {
		$this->tester = "xyz";
	}

	// tests

	protected function _after () {
	}

}