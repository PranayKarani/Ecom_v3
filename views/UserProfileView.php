<?php

class UserProfileView {
	
	private $uID;
	private $details;
	
	public function __construct ($uID) {
		
		$this->uID = $uID;
		$this->details = UserController::getUserDetails($uID);
		
	}
	
	public function showName () {
		
		$name = $this->details['customer_name'];
		echo "<strong>Name:</strong> <input type='text' class='details' id='customer_name' value='$name' maxlength='100'/><br/>";
		
	}
	
	public function showEmail () {
		$email = $this->details['customer_email'];
		echo "<strong>Email:</strong> <input type='text' class='details' id='customer_email' value='$email' maxlength='100'/><br/>";
	}
	
	public function showContact () {
		$contact = $this->details['customer_contact'];
		echo "<strong>Contact:</strong> <input type='text' class='details' id='customer_contact' value='$contact' maxlength='100'/><br/>";
	}
	
	public function showAddress () {
		
		$room = $this->getDetails('room');
		$building = $this->getDetails('building');
		$road = $this->getDetails('road');
		$landmark = $this->getDetails('landmark');
		$near = $landmark == "" ? "" : " near $landmark,";
		$town = 'mulund west';
		$pincode = '400080';
		
		$full_addr = "$room $building,$near $road, $town $pincode";// TODO BUG: this is not dynammically updated
		
		$incorrect = " <a href='#' style='font-size: small'>is this incorrect?</a>";
		
		echo "<p>";
		echo "Room: <input type='text' class='details' id='room' value='$room' maxlength='20'/><br/>";
		echo "Building: <input type='text' class='details' id='building' value='$building' maxlength='100'/><br/>";
		echo "Road: <input type='text' class='details' id='road' value='$road' maxlength='100'/><br/>";
		echo "Landmark: near <input type='text' class='details' id='landmark' value='$landmark' maxlength='150'/><br/>";
		echo "town: <input type='text' class='details' id='town' value='$town' maxlength='100' disabled/>$incorrect<br/>";
		echo "pincode: <input type='text' class='details' id='pincode' value='$pincode' maxlength='6' disabled/>$incorrect<br/>";
		echo "<input type='hidden' id='full_address' class='details' value='$full_addr'/>";
		echo "<input type='button' value='update' onclick='updateUserDetails()'/>";
		echo "</p>";
		
	}
	
	private function getDetails ($string) {
		if (isset($this->details[$string])) {
			return $this->details[$string];
		} else {
			return "";
		}
	}
	
	public function showRecentlyViewedProducts () {
		
		$data = UserController::getRecentlyViewedProducts($this->uID);
		
		if (count($data) > 0) {
			echo "<h3>Recetly viewed products</h3>";
			for ($i = 0; $i < count($data); $i++) {
				
				$pid = $data[$i]['product_id'];
				$product = ProductController::getProductDetails($pid);
				echo ProductView::product_box($product, null);
				
			}
		}
		
	}
	
	public function showOrderedProducts () {
		$data = UserController::getOrderedProducts($this->uID);
		
		if (count($data) > 0) {
			
			echo "<h3>My Ordered products</h3>";
			
			echo "<table>";
			
			echo "<tr>";
			echo "<th width='200'>Product Name</th>";
			echo "<th width='100'>Price</th>";
			echo "<th width='100'>Date</th>";
			echo "<th width='100'>Time</th>";
			echo "<th width='100'>Type</th>";
			echo "</tr>";
			
			for ($i = 0; $i < count($data); $i++) {
				
				$pid = $data[$i]['product'];
				$name = $data[$i]['product_name'];
				$date = $data[$i]['date'];
				$time = $data[$i]['time'];
				$price = $data[$i]['price'];
				$hd = $data[$i]['method'];
				$hd = $hd == 1 ? "home delivery" : "walk-in";
				
				echo "<tr>";
				echo "<td>$name</td>";
				echo "<td>$price Rs</td>";
				echo "<td>$date</td>";
				echo "<td>$time</td>";
				echo "<td>$hd</td>";
				echo "</tr>";
				
			}
			
			echo "</table>";
		}
	}
	
}