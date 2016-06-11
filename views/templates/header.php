<?php

class Header {

    private function __construct () {
    }

    public static function show () {
        ?>
        <header>
            <div id="left"></div>
            <div id="center">
                <form>
                    <input type="search" placeholder="what are you looking for?" id="search_bar" autocomplete="off">
                </form>
                <div id="search_suggestions">

                </div>
            </div>
            <div id="right"></div>
        </header>
        <?php
    }

}
