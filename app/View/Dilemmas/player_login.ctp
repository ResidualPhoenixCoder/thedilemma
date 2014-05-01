<script>
function validate() {

}
    
$(function() {
        $("#btn_login")
                .button()
                .click(function(event) {
                    if(validate()) {
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo Router::url(array('controller' => 'login', 'action' => 'login')); ?>",
                            data: formData,
                            success : function (data, textStatus, jqXHR) {
                                var rdata = JSON.parse(data);
                                if(rdata.error) {
                                    showErrorMsg(rdata.errorMsg);
                                } else {
                                    hideErrorMsg();
                                    alert("User " + rdata.username + " successfully created!");
                                    window.location="/dilemmas/display/player_login";
                                }
                            },
                            error : function(jqXHR, textStatus, errorThrown) {
                                showErrorMsg("Server is unavailable.");
                            }
                        });
                    }
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
<div style="margin:10px; text-align:center;"><label id="txf_errorlbl">Error: </label><span id="txf_error"></span></div>
<div style="margin:10px; text-align:center;"><label>Username: </label><input type="text" id="txf_user" value="szuboff" /></div>
<div style="margin:10px; text-align:center;"><label>Password: </label><input type="password" id="txf_pswrd" value="pulpmill" /></div>
<div style="text-align:center;"><button id="btn_login">LOGIN</button><button id="btn_register">REGISTER</button></div><br />
</div>
