<script>
function validate() {
    var result = true;
    
    return result;
}

function showErrorMsg(msg) {
    $("#txf_errorlbl").show();
    $("#txf_error").text(msg);
    $("#txf_error").show();
}

function hideErrorMsg() {
    $("#txf_errorlbl").hide();
    $("#txf_error").hide();
    $("#txf_error").text("");
}
    
$(function() {
        hideErrorMsg();
        $('#form_login')
                .submit(function(event) {
                    if(validate()) {
                        var formDataObj = new Object();
                        formDataObj.error = false;
                        formDataObj.errorMsg = "";
                        formDataObj.auth = false;
                        formDataObj.redirect = "";
                        formDataObj.username = $("#txf_user").val();
                        formDataObj.password = $("#txf_pswrd").val();
                        
                        var formData = JSON.stringify(formDataObj);
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'login')); ?>",
                            data: formData,
                            success : function (data, textStatus, jqXHR) {
                                var rdata = JSON.parse(data);
                                if(rdata.auth) {
                                    window.location=rdata.redirect;
                                } else {
                                    if(rdata.error) {
                                        showErrorMsg(rdata.errorMsg + " " + rdata.username + " | " + rdata.password);
                                    } else {
                                        showErrorMsg("Shit just hit the fan.");
                                    }
                                }
                            },
                            error : function(jqXHR, textStatus, errorThrown) {
                                showErrorMsg("Server is unavailable.");
                            }
                        });
                    }
                    event.preventDefault();
                });

        $("#btn_register")
                .button()
                .click(function(event) {
                        window.location="<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'index', 'register')); ?>";
                        event.preventDefault();
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
<?php echo $this->Form->create("dilemmas", array('id' => 'form_login')); ?>
<table id="treg">
        <tr><td><span id="txf_errorlbl">Error:</span></td><td><span id="txf_error"></span></td></tr>
        <tr><td>Username:</td><td><?php echo $this->Form->input('Username', array('id' => 'txf_user', 'class' => 'registration_fields', 'label' => false)); ?></td></tr>
        <tr><td>Password:</td><td><?php echo $this->Form->input('Password', array('type' => 'password', 'id' => 'txf_pswrd','class' => 'registration_fields', 'label' => false)); ?></td></tr>
</table><br />
<div style="text-align:center;"><?php echo $this->Form->submit('LOGIN', array('id'=>'btn_login')); ?><button id="btn_register">REGISTER</button></div><br />
<?php echo $this->Form->end(); ?>
</div>
