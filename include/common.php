<?php

$UID = -2532;

function cookieSet ($name) {
	
	if (isset($_COOKIE[$name])) {
		return $_COOKIE[$name];
	} else {
		return -2352;
	}
	
}

function wishlistThumbnail ($w, $id) {
	
	if (isset($w)) {
		
		if ($w > 0) {
			echo "<span class='add_to_wishlist' style='float: left'>";
			echo "<input 
						class='wishlist_thumbnail' 
						type='image' 
						name='$id' 
						data-id='$id' 
						data-in='1' 
						onclick='toggleThumbnail(this)' 
						src='res/images/extra/cross.png' 
						style='width: 100%;outline: none' 
						title='remove from swishlist'/>";
			echo "</span>";
		} else {
			echo "<span class='add_to_wishlist'>";
			echo "<input 
						class='wishlist_thumbnail' 
						type='image' 
						name='$id' 
						data-id='$id' 
						data-in='0' 
						onclick='toggleThumbnail(this)' 
						src='res/images/extra/heart.png' 
						style='width: 100%;outline: none' 
						title='add to wishlist'/>";
			echo "</span>";
		}
		
	} else {// means, not logged in
		echo "<span class='add_to_wishlist' title='login to add to wishlist' style='left: 1px'>";
		echo "<input 
						class='wishlist_thumbnail' 
						type='image' 
						name='$id' 
						data-id='$id' 
						data-in='0' 
						onclick='showLoginModal()' 
						src='res/images/extra/heart.png' 
						style='width: 100%;outline: none' 
						title='login to add to wishlist'/>";
		echo "</span>";
		echo "</span>";
		
	}
	
}
