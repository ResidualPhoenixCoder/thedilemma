<?php echo $this->Html->script('timer.js'); ?>	
<script>
    $(function() {

        // Hide, share, lie radio button set
        $("#rgAction").buttonset();

        // Answer A, B, C, D radio button set
        $("#rgAnswer").buttonset();

        // Logout button
        $("#btnLogout")
                .button()
                .click(function(event) {
                    event.preventDefault();
                    window.location="<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'logout')); ?>";
                });
        ;

        // Load question data
        load_question();

    });

    function load_question() {
        $("#spnQText").html("Which of the following books did you find most boring?");
        $("#spnAnsA").html("The Social Life of Information");
        $("#spnAnsB").html("In The Age Of The Smart Machine");
        $("#spnAnsC").html("The Origin of Virtue");
        $("#spnAnsD").html("All of the above");
    }

    function timer_ran_out() {
        window.location = "<?php echo Router::url(array('controller' => 'lobby', 'action' => 'lobby')); ?>";
    }
</script>

<style>	
    #wrapper {
        background: #212121;
        width: 75%;
        padding: 0px;
        margin-left: auto;
        margin-right: auto;
        text-align: left;
        border-style: none;
        height: 100%;
    }

    html, body {
        height: 100%;
        -ms-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        background-color: white;
        margin: 0;
    }

    #timer {
        text-align: center;
        font-size: 60px;
        font-weight: bold;
    }

    #countdown {
        font-size: 60px;
    }

    #stats {
        width: 35%;
        border: 10px solid;
        border-color: #4A96AD;
        background-color: #7D1935;
        box-shadow: 8px 8px 15px black;
        border-radius: 20px;
        margin-left: auto;
        margin-right: auto;
        font-weight: bold;
        padding: 10px;
    }

    #stats table {
        border: 0px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    #action {
        width: 35%;
        border: 10px solid;
        border-color: #4A96AD;
        background-color: #7D1935;
        box-shadow: 8px 8px 15px black;
        border-radius: 20px;
        margin-left: auto;
        margin-right: auto;
        font-weight: bold;
        text-align: center;
        padding: 10px;
    }

    #prompt {
        width: 35%;
        border: 10px solid;
        border-color: #4A96AD;
        background-color: #7D1935;
        box-shadow: 8px 8px 15px black;
        border-radius: 20px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        padding: 10px;
    }

    #prompt table {
        border: 0px;
        margin-left: auto;
        margin-right: auto;
        text-align: left;
        font-size: 80%;
    }

</style>

<div id="wrapper">

    <div id="timer">
        DECIDE<br />
        <span id="countdown">10</span>
    </div>

    <div id="stats">
        <table>
            <tr><td colspan="3"> * Fellow Prisoner Profile * </td></tr>
            <tr>
                <td>HIDE</td>
                <td>SHARE</td>
                <td>LIE</td>
            </tr>
            <tr>
                <td>33%</td>
                <td>33%</td>
                <td>33%</td>
            </tr>
        </table>
    </div><br />

    <div id="prompt">

        <span>Fellow Prisoner Decision: </span>
        <span id="spnDecision">HIDDEN</id><br /><br />

            <span id="spnQText">QUESTION</span>
            <table>
                <tr><td>A:</td><td><span id="spnAnsA">ANSWER A</span></td></tr>
                <tr><td>B:</td><td><span id="spnAnsB">ANSWER B</span></td><tr>
                <tr><td>C:</td><td><span id="spnAnsC">ANSWER C</span></td></tr>
                <tr><td>D:</td><td><span id="spnAnsD">ANSWER D</span></td></tr>
            </table><br />

            <div id="rgAnswer">
                <input type="radio" id="rdoAnsA" name="rgAnswerSet"><label for="rdoAnsA">A</label>
                <input type="radio" id="rdoAnsB" name="rgAnswerSet"><label for="rdoAnsB">B</label>
                <input type="radio" id="rdoAnsC" name="rgAnswerSet"><label for="rdoAnsC">C</label>
                <input type="radio" id="rdoAnsD" name="rgAnswerSet"><label for="rdoAnsD">D</label>
            </div>

    </div><br />

    <div id="action">
        <div id="rgAction">
            <input type="radio" name="rgActionSet" id="rdoHide" checked><label for="rdoHide">HIDE</label>
            <input type="radio" name="rgActionSet" id="rdoShare"><label for="rdoShare">SHARE</label>
            <input type="radio" name="rgActionSet" id="rdoLie"><label for="rdoLie">LIE</label>
        </div>
    </div><br />
    <?php
    if ($this->Session->read('Auth')) {
        echo   "<div style='text-align:center;'><button id='btnLogout'>LOGOUT, YOU WUSS!</button></div><br />";
    }
    ?>
</div>