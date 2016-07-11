<?php

class LoginModal {

	public static function show () {
		?>
		<div id="login_modal" hidden>
			<input type="button" value="X" id="close_modal"/>
			<div id="login_box">
				<div id="login_left_section">
					<!--sign up-->
					<strong>Sign Up</strong><br/>
					Name: <input type="text" id="signup_name"/><br/>
					Email: <input type="text" id="signup_email"/><br/>
					Contact: <input type="text" id="signup_contact"/><br/>
					Password: <input type="password" id="signup_password"/><br/>
					<!--			enter address-->
					<input type="button" value="sign up" id="signup_button"/>
				</div>
				<div id="login_right_section">
					<!--log in-->
					<strong>Log in</strong><br/>
					Email: <input type="text" id="login_email"/><br/>
					Password: <input type="password" id="login_password"/><br/>
					<input type="button" value="log in" id="login_button"/><br/>
					<h3 style="color: red" id="login_message" hidden></h3>
				</div>
			</div>
		</div>
		<?php
	}

}