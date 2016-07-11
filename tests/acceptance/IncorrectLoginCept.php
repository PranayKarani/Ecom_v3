<?php
$i = new AcceptanceTester($scenario);
$i->wantTo('log in with incorrect details');
$i->maximizeWindow();
$i->amOnPage('/');
$i->cantSeeElement("#login_modal");
$i->wait(3);
$i->canSeeElement("#login_modal");
$i->fillField('#login_email', 'batman@wayne.com');
$i->fillField('#login_password', '153');
$i->click('#login_button');
$i->expectTo("Stay logged out and keep seeing the login_modal");
$i->canSeeElement("#login_modal");
$i->amGoingTo("oh yeah!");
