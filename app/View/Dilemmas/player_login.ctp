<script>
	$(function() {
		$("#btn_login")
			.button()
			.click(function(event) {
				window.location="/dilemmas/display/player_login";
			});

		$("#btn_register")
			.button()
			.click(function(event) {
				window.location="/dilemmas/display/player_registration";
			});
	});
</script>
<style>
#main {
	margin-top: -150px;
}

#btn_login, #btn_register{
	width: 180px;
}
</style>
<div id="main">
<h1>PLAYER LOGIN</h1>
<div style="margin:10px; text-align:center;"><label>Username: </label><input type="text" id="txf_user" value="szuboff" /></div>
<div style="margin:10px; text-align:center;"><label>Password: </label><input type="password" id="txf_pswrd" value="pulpmill" /></div>
<div style="text-align:center;"><button id="btn_login">LOGIN</button><button id="btn_register">REGISTER</button></div><br />
</div>
