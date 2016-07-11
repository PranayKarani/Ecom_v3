<?php
$i = new AcceptanceTester($scenario);
$i->wantTo('logout');
$i->maximizeWindow();
$i->amOnPage('/');

// login first
$i->login('superman@dailyplanet.com', '123');

// logout
$i->wait(2);
$i->cantSeeElement('#profile_modal');
$i->moveMouseOver("#header_login");
$i->canSeeElement('#profile_modal');
$i->click('#logout');
$i->wait(2);
$i->see('login');
$uid = $i->grabCookie('UID');
$i->expect("my cookie has been cleared");
codecept_debug("my uid is $uid.");