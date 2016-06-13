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

                </div>
            </div>
            <div id="right"></div>
        </header>
        <?php
    }

}
