<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor {
	use _generated\AcceptanceTesterActions;

	/**
	 * Define custom actions here
	 */

	public function login ($email, $password) {
		$i = $this;
		
		if ($i->loadSessionSnapshot('login')) {
			return;
		}
		
		$i->amOnPage('/');
		$i->cantSeeElement("#login_modal");
		$i->wait(3);
		$i->canSeeElement("#login_modal");
		$i->fillField('#login_email', $email);
		$i->fillField('#login_password', $password);
		$i->click('#login_button');
		$i->expectTo("yell... WHERE IS MY UID!!?? WHERE IS IT !!!???");
		$i->wait(2);
		$uid = $i->grabCookie('UID');
		$uname = $i->grabCookie('UN');
		$i->see($uname);
		codecept_debug("my uid is $uid.");
		
		$i->saveSessionSnapshot('login');

	}

}
