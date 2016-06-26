<?php

class Header {

    private function __construct () {
    }

    public static function show () {
        ?>
        <header>
            <div id="left"></div>
            <div id="center">

                <input type="search" placeholder="what are you looking for?" id="search_bar" autocomplete="off">
                <div id="search_suggestions">

	                <div id="search_product_suggestions"></div>
	                <div id="search_category_suggestions"></div>

                </div>
            </div>
	        <div id="right">
		        <a href="admin">admin</a>
		        <a href="seller">seller</a>
	        </div>
        </header>
        <?php
    }

}
