<script>
	$(function() {
		$("#login_button")
		.button()
		.click(function(event) {
			var name = $('#username').val() ? $('#username').val() : "No one";
			var pass = $('#password').val() ? $('#password').val() : "No password";
			alert("Logging in player: " + name + " with password: " + pass);
		});
	});
</script>

<h1>Player Login Page</h1>
<p>
This is where a player enters his/her credentials to login to the application.  
Upon login, the user should either enter into a lobby or be automatically paired
up with a player that is currently online.  If there are no players online, the player
can play against a simple bot.
</p>

<div id="login_container">
	<div id="login_panel">
		<div class="forms" id="login_credentials">
			<div class="form_block"><label for="username">Username</label><input type="text" id="username"></div>
			<div class="form_block"><label for="password">Password</label><input type="password" id="password"></div>
		</div>
		<input type="submit" value="Login" id="login_button">
	</div>
</div>
