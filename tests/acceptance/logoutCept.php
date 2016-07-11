<?php
$i = new AcceptanceTester($scenario);
$i->wantTo('logout');
$i->maximizeWindow();
$i->amOnPage('/');

// login first
$i->cantSeeElement("#login_modal");
$i->wait(3);
$i->canSeeElement("#login_modal");
$i->fillField('#login_email', 'superman@dailyplanet.com');
$i->fillField('#login_password', '123');
$i->click('#login_button');
$i->expectTo("yell... WHERE IS MY UID!!?? WHERE IS IT !!!???");
$i->wait(2);
$uid = $i->grabCookie('UID');
$uname = $i->grabCookie('UN');
$i->see($uname);
codecept_debug("my uid is $uid.");

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