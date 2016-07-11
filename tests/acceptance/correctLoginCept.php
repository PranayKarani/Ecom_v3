<?php
$i = new AcceptanceTester($scenario);
$i->wantTo('log in with correct details');
$i->maximizeWindow();
$i->amOnPage('/');
$i->cantSeeElement("#login_modal");
$i->wait(3);
$i->canSeeElement("#login_modal");
$i->fillField('#login_email', 'superman@dailyplanet.com');
$i->fillField('#login_password', '123');
$i->click('#login_button');
$i->expectTo("yell... WHERE IS MY UID!!?? WHERE IS IT !!!???");
$i->wait(2);
$uid = $i->grabCookie('UID');
codecept_debug("my uid is $uid.");
