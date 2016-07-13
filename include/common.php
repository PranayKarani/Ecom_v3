<?php

$UID = -2532;

function cookieSet ($name) {
	
	if (isset($_COOKIE[$name])) {
		return $_COOKIE[$name];
	} else {
		return -2352;
	}
	
}
