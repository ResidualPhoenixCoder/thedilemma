<script>
$(function() {
	$("#btn_register")
		.button()
		.click(function( event ) {
			window.location='';
		});
	$("#txf_date").datepicker();
});
</script>
<style>
#main {
	width: 500px;
	margin-top: -250px;
	margin-left: -250px;
}

table {
	border: 0px;
	margin-left: auto;
	margin-right: auto;
}

#btn_register{
	width: 360px;
}
</style>

<h1>REGISTER PLAYER</h1>
<div>
	<table id="#treg">
		<tr><td>First Name:</td><td><input type="text" id="txf_first" /></td></tr>
		<tr><td>Last Name:</td><td><input type="text" id="txf_last" /></td><tr>
		<tr><td>Date:</td><td><input type="text" id="txf_date"></td></tr>
		<tr><td>Username:</td><td><input type="text" id="txf_user" /></td></tr>
		<tr><td>Email:</td><td><input type="text" id="txf_email" /></td></tr>
		<tr><td>Password:</td><td><input type="password" id="txf_pswrd" /></td></tr>
		<tr><td>Password (Confirm):</td><td><input type="password" id="txf_pswrd_cnfrm" /></td></tr>
	</table><br />
</div>
<div style="text-align:center;"><button id="btn_register">REGISTER</button></div><br />
