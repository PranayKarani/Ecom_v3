<?php

namespace admin;

class SearchBox {

    public static function show ($placeholder) {
        ?>
        <div id='search_box'>
            <input type='search' placeholder='<?php echo $placeholder ?>' class='search_bar'>

            <div id='search_results_box'></div>
        </div>
        <?php
    }

}
