<?php
$i = new AcceptanceTester($scenario);
$i->wantTo('log in with correct details');
$i->maximizeWindow();
$i->amOnPage('/');

$i->login('superman@dailyplanet.com', '123');
