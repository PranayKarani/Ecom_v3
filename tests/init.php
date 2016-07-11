<?php

spl_autoload_register(function ($class) {

	if (file_exists("../include/{$class}.php")) {

		require_once "../include/{$class}.php";

	} else if (file_exists("../controllers/{$class}.php")) {

		require_once "../controllers/{$class}.php";

	} else if (file_exists("../views/{$class}.php")) {

		require_once "../views/{$class}.php";

	} else if (file_exists("../views/templates/{$class}.php")) {

		require_once "../views/templates/{$class}.php";

	}

});


