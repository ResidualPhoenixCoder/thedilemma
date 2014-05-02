<script>
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

function validate(dataObj) {
    var result = true;
    if(dataObj.username === "") {
        $("#txf_user").addClass('border_error');
        result = false;
    } else {
        $("#txf_user").removeClass('border_error');
    }
    
    if(dataObj.email === "") {
        $("#txf_email").addClass('border_error');
        result = false;
    } else {
        $("#txf_email").removeClass('border_error');
    }
    
    if(dataObj.password === "") {
        $("#txf_pswrd").addClass('border_error');
        result = false;
    } else {
        if(dataObj.password !== $("#txf_pswrd_cnfrm").val()) {
            $("#txf_pswrd").addClass('border_error');
            $("#txf_pswrd_cnfrm").addClass('border_error');
            result = false;
            showErrorMsg("Passwords do not match.");
        } else {
            $("#txf_pswrd").removeClass('border_error');
            $("#txf_pswrd_cnfrm").removeClass('border_error');
        }
    }
    
    return result;
}

$(function() {
    hideErrorMsg();

    $('#form_registration')
            .submit(function(event) {
                var formDataObj = {};
                formDataObj.error = false;
                formDataObj.errorMsg = "";
                formDataObj.exists = false;
                formDataObj.username = $("#txf_user").val();
                formDataObj.email = $("#txf_email").val();
                formDataObj.password = $("#txf_pswrd").val();

                if(validate(formDataObj)) {
                    var formData = JSON.stringify(formDataObj);
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'register')); ?>",
                        data: formData,
                        success : function (data, textStatus, jqXHR) {
                            var rdata = JSON.parse(data);
                            if(rdata.error) {
                                showErrorMsg(rdata.errorMsg);
                            } else {
                                hideErrorMsg();
                                alert("User " + rdata.username + " successfully created!");
                                window.location="<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'index', 'login')); ?>";
                            }
                        },
                        error : function(jqXHR, textStatus, errorThrown) {
                            showErrorMsg("Server is unavailable. Error: " + jqXHR.responseText);
                        }
                    });
                }
                event.preventDefault();
            });
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
        <?php echo $this->Form->create('dilemmas', array('id' => 'form_registration')); ?>
	<table id="treg">
                <tr><td><span id="txf_errorlbl">Error:</span></td><td><span id="txf_error"></span></td></tr>
		<tr><td>Username:</td><td><?php echo $this->Form->input('Username', array('id' => 'txf_user', 'class' => 'registration_fields', 'label' => false)); ?></td></tr>
		<tr><td>Email:</td><td><?php echo $this->Form->input('Email', array('id' => 'txf_email','class' => 'registration_fields', 'label' => false)); ?></td></tr>
		<tr><td>Password:</td><td><?php echo $this->Form->input('Password', array('type' => 'password', 'id' => 'txf_pswrd','class' => 'registration_fields', 'label' => false)); ?></td></tr>
		<tr><td>Password (Confirm):</td><td><?php echo $this->Form->input('Password (Confirm)', array('type' => 'password', 'id' => 'txf_pswrd_cnfrm','class' => 'registration_fields', 'label' => false)); ?></td></tr>
	</table><br />
        <div style="text-align:center;"><?php echo $this->Form->submit('REGISTER', array('id'=>'btn_register')); ?></div><br />
        <?php echo $this->Form->end(); ?>
</div>

