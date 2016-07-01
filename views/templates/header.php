<?php

class Header {

	private function __construct () {
	}

	public static function show () {
		?>
		<header>
			<div id="left">
				<a href="admin">admin</a>
				<a href="seller">seller</a><br/>
			</div>
			<div id="center">

				<input type="search" placeholder="what are you looking for?" id="search_bar" autocomplete="off">
				<div id="search_suggestions">

					<div id="search_product_suggestions"></div>
					<div id="search_category_suggestions"></div>
					<div id="search_shop_suggestions"></div>

				</div>
			</div>
			<div id="right">

				<div id="header_contact" class="header_mini_hide">
					<button class="btn_right_buttons">contact</button>
				</div>
				<div id="header_login" class="header_mini_hide" data-show-modal="1">
					<button id="header_login_button" class="btn_right_buttons">login</button>
					<div id="profile_modal" hidden>
						<button id="view_profile" class="btn_right_buttons">view profile</button>
						<button id="logout" class="btn_right_buttons">logout</button>
					</div>
				</div>
				<div id="header_more" class="header_mini_hide">
					<button class="btn_right_buttons">more</button>
				</div>
				<div id="header_cart" class="header_mini_show">
					<button class="btn_right_buttons">cart</button>
				</div>
				<div id="header_wishlist" class="header_mini_show">
					<button class="btn_right_buttons">whislist</button>
				</div>

			</div>
		</header>
		<?php
	}

}
