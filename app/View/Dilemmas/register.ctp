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

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
}

function validate(dataObj) {
    var result = true;
    var minLength = 4;
    var user = $("#txf_user");
    var email = $("#txf_email");
    var pass = $("#txf_pswrd");
    var passc = $("#txf_pswrd_cnfrm");
    
    if(dataObj.username === "" || dataObj.username.length < minLength) {
        user.addClass('border_error');
        if(dataObj.username === "") {
            showErrorMsg("Username is blank.");
        } else {
            showErrorMsg("Username must be longer than 4 characters.");
        }
        return false;
    } else {
        user.removeClass('border_error');
    }
    
    if(dataObj.email === "" || !isValidEmailAddress(dataObj.email)) {
        email.addClass('border_error');
        if(dataObj.email === "") {
            showErrorMsg("Email is blank.");
        } else {
            showErrorMsg("Email must be of the form name@domain.com.");
        }
        return false;
    } else {
        email.removeClass('border_error');
    }
    
    if(dataObj.password === "" || dataObj.password.length < minLength) {
        pass.addClass('border_error');
        if(dataObj.password === "") {
            showErrorMsg("Password is blank.");
        } else {
            showErrorMsg("Password must be longer than 4 characters.");
        }
        return false;
    } else {
        if(dataObj.password !== passc.val()) {
            pass.addClass('border_error');
            passc.addClass('border_error');
            showErrorMsg("Passwords do not match.");
            return false;
        } else {
            pass.removeClass('border_error');
            passc.removeClass('border_error');
        }
    }
    
    return result;
}

$(function() {
    hideErrorMsg();

    $('#btn_register')
            .button()
            .click(function(event) {
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
                            alert(data);
                            var rdata = JSON.parse(data);
                            if(rdata.error) {
                                showErrorMsg(rdata.errorMsg);
                            } else {
                                hideErrorMsg();
                                //alert("User " + rdata.username + " successfully created!");
                                $("#txf_success").text(rdata.username + " successfully created!");
                                $("#success_dialog").dialog({modal: true, resizable: false});
                            }
                        },
                        error : function(jqXHR, textStatus, errorThrown) {
                            showErrorMsg("Server is unavailable. Error: " + jqXHR.responseText);
                        }
                    });
                }
                event.preventDefault();
            });
            
            $("#success_dialog").bind('dialogclose', function(event) {
            window.location="<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'index', 'login')); ?>";
    });
});
</script>
<style>
#main {
	width: 500px;
	margin-top: 15%;
/*	margin-left: -250px;*/
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
    <div id="success_dialog" title="User Successfully Created!">
        <p id="txf_success"></p>
    </div>
        <?php echo $this->Form->create('dilemmas', array('id' => 'form_registration')); ?>
	<table id="treg">
                <tr><td><span id="txf_errorlbl">Error:</span></td><td><span id="txf_error"></span></td></tr>
		<tr><td>*Username:</td><td><?php echo $this->Form->input('Username', array('id' => 'txf_user', 'class' => 'registration_fields', 'label' => false)); ?></td></tr>
		<tr><td>*Email:</td><td><?php echo $this->Form->input('Email', array('id' => 'txf_email','class' => 'registration_fields', 'label' => false)); ?></td></tr>
		<tr><td>*Password:</td><td><?php echo $this->Form->input('Password', array('type' => 'password', 'id' => 'txf_pswrd','class' => 'registration_fields', 'label' => false)); ?></td></tr>
		<tr><td>*Password (Confirm):</td><td><?php echo $this->Form->input('Password (Confirm)', array('type' => 'password', 'id' => 'txf_pswrd_cnfrm','class' => 'registration_fields', 'label' => false)); ?></td></tr>
	</table><br />
        <div style="text-align:center;"><button id="btn_register">REGISTER</button></div><br />
        <?php echo $this->Form->end(); ?>
</div>

