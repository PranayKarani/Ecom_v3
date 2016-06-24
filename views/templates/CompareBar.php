<?php

class CompareBar {

	public static function show () {
		?>
		<div id="compare_bar" hidden>
			<div class="compare_product_slot" data-slot-no="1" data-product-id="" data-counter=""
			     data-product-category="">
				<div class="compared_product"></div>
				<input type="image"
				       src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-22-128.png"
				       class="remove_from_compare"/>
			</div>
			<div class="compare_product_slot" data-slot-no="2" data-product-id="" data-counter=""
			     data-product-category="">
				<div class="compared_product"></div>
				<input type="image"
				       src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-22-128.png"
				       class="remove_from_compare"/>
			</div>
			<div class="compare_product_slot" data-slot-no="3" data-product-id="" data-counter=""
			     data-product-category="">
				<div class="compared_product"></div>
				<input type="image"
				       src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-22-128.png"
				       class="remove_from_compare"/>
			</div>
			<div class="compare_product_slot" data-slot-no="4" data-product-id="" data-counter=""
			     data-product-category="">
				<div class="compared_product"></div>
				<input type="image"
				       src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-22-128.png"
				       class="remove_from_compare"/>
			</div>
			<!--	    <div id="compare_product_button_holder">-->
			<!--	    </div>-->
			<input type="button" value="compare" onclick="goCompare()" class="compare_product_button"/>
			<input type="button" value="clear all and close" onclick="clearAll()" class="compare_product_button"/>
		</div>
		<?php
	}

}