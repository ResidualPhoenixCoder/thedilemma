<script>
    var questions = <?php echo $questions; ?>;
    var opponent = <?php echo $opponent; ?>;
    var pid = "<?php echo $current; ?>";
    var qgroup = "<?php echo $question_group; ?>";
    var qctr = 0;
    var currq;

    /*TIMER*/
    var max_time = 10;
    var gameSpeed = 700;
    var cinterval;

    function countdown_timer() {
        // decrease timer
        max_time--;
        document.getElementById('countdown').innerHTML = max_time;
        if (max_time <= 0) {
            clearInterval(cinterval);
            timer_ran_out();
        }
    }

    //Package the current answers and actions up and send that stuff back out to be saved.
    function save_answers() {
        var formObj = new Object();
        formObj.player = pid;
        formObj.opponent = opponent.pid;
        formObj.question_id = currq.question_id;
        formObj.question_group = qgroup;
        formObj.question_order = qctr;
        formObj.player_act = "H";
        formObj.player_true_answer = "A";
        formObj.player_lie_answer = "";
        formObj.opponent_act = currq.player_act;
        formObj.opponent_true_answer = currq.player_true_answer;
        formObj.opponent_lie_answer = currq.player_lie_answer;
        
        var formData = JSON.stringify(formObj);

        $.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'game', 'action' => 'roundComplete')); ?>",
            data: formData,
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Server is unavailable. Error: " + jqXHR.responseText);
            }
        });
    }
    
    function change_background() {
        var imageUrl = "<?php echo $this->request->webroot; ?>" + 'img/' + String(Math.floor(Math.random() * 10) + 1) + '.png';
        $('body').css('background-image', 'url(' + imageUrl + ')');
    }

    //Load the next question or head on out.
    function timer_ran_out() {
        if (typeof currq === undefined || !currq) {
            alert("Current Question is Empty!");
        } else if (qctr < questions.length) {
            max_time = 11;
            save_answers();
            currq = questions[qctr++]['RoundAnswer'];
            change_background();
            load_question(currq.question, currq.answer_a, currq.answer_b, currq.answer_c, currq.answer_d);
            cinterval = setInterval("countdown_timer()", gameSpeed);
        } else {
            window.location = "<?php echo Router::url(array('controller' => 'lobby', 'action' => 'lobby'));?>";
        }
    }

    $(function() {
        var oppDispName = (opponent.username.length >= 10) ? opponent.username.substring(0, 10) + "..." : opponent.username;
        var total = parseInt(opponent.hide) + parseInt(opponent.share) + parseInt(opponent.lie);
        var perchid = ((parseInt(opponent.hide) / total) * 100).toFixed(0);
        var percsha = ((parseInt(opponent.share) / total) * 100).toFixed(0);
        var perclie = ((parseInt(opponent.lie) / total) * 100).toFixed(0);


        $('.playerName').html(oppDispName);

        $('#hideStat').html(perchid + "%");
        $('#shareStat').html(percsha + "%");
        $('#lieState').html(perclie + "%");

        // Hide, share, lie radio button set
        $("#rgAction").buttonset();

        // Answer A, B, C, D radio button set
        $("#rgAnswer").buttonset();

        // Logout button
        $("#btnLogout")
                .button()
                .click(function(event) {
                    event.preventDefault();
                    window.location = "<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'logout')); ?>";
                });

        // Load question data
        currq = questions[qctr++]['RoundAnswer'];
        change_background();
        load_question(currq.question, currq.answer_a, currq.answer_b, currq.answer_c, currq.answer_d);

        // 1,000 means 1 second.
        cinterval = setInterval('countdown_timer()', gameSpeed);
    });

    function load_question(question, aA, aB, aC, aD) {
        $("#spnQText").html(question);
        $("#spnAnsA").html(aA);
        $("#spnAnsB").html(aB);
        $("#spnAnsC").html(aC);
        $("#spnAnsD").html(aD);
    }
</script>

<style>	
    #wrapper {
        background: #212121;
        width: 450px;
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

    .main-arena {
        width: 300px;
    }

    .main-arena table {
        /*width: 100%*/
    }

    #stats {
        /*width: 35%;*/
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
        width:100%;
        border: 0px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    #action {
        /*width: 35%;*/
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
        /*width: 35%;*/
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

    h2 {
        margin: 0;
    }
</style>

<div id="wrapper">

    <div id="timer">
        DECIDE<br />
        <span id="countdown">10</span>
    </div>

    <div id="stats" class="main-arena">
        <table>
            <tr><td colspan="3"><h2><span id="playerName_profile" class="playerName">Fellow Prisoner</span>'s Profile</h2></td></tr>
            <tr>
                <td><b>HIDE</b></td>
                <td><b>SHARE</b></td>
                <td><b>LIE</b></td>
            </tr>
            <tr>
                <td><span id="hideStat">33%</span></td>
                <td><span id="shareStat">33%</span></td>
                <td><span id="lieStat">33%</span></td>
            </tr>
        </table>
    </div><br />

    <div id="prompt" class="main-arena">
        <span><h2><span id="playerName_decision" class="playerName">Fellow Prisoner</span>'s  Answer: <b><span id="spnDecision">HIDDEN</span></b></h2></span>
        <br /><br />

        <span id="spnQText">You have been denied a question...</span>
        <table>
            <tr><td>A:</td><td><span id="spnAnsA">Deadly Answer A</span></td></tr>
            <tr><td>B:</td><td><span id="spnAnsB">Deadly Answer B</span></td><tr>
            <tr><td>C:</td><td><span id="spnAnsC">Deadly Answer C</span></td></tr>
            <tr><td>D:</td><td><span id="spnAnsD">Deadly Answer D</span></td></tr>
        </table><br />

        <div id="rgAnswer">
            <input type="radio" id="rdoAnsA" name="rgAnswerSet"><label for="rdoAnsA">A</label>
            <input type="radio" id="rdoAnsB" name="rgAnswerSet"><label for="rdoAnsB">B</label>
            <input type="radio" id="rdoAnsC" name="rgAnswerSet"><label for="rdoAnsC">C</label>
            <input type="radio" id="rdoAnsD" name="rgAnswerSet"><label for="rdoAnsD">D</label>
        </div>

    </div><br />

    <div id="action" class="main-arena">
        <div id="rgAction">
            <input type="radio" name="rgActionSet" id="rdoHide" checked><label for="rdoHide">HIDE</label>
            <input type="radio" name="rgActionSet" id="rdoShare"><label for="rdoShare">SHARE</label>
            <input type="radio" name="rgActionSet" id="rdoLie"><label for="rdoLie">LIE</label>
        </div>
    </div><br />
    <?php
    if ($this->Session->read('Auth')) {
        echo "<div style='text-align:center;'><button id='btnLogout'>LOGOUT, YOU WUSS!</button></div><br />";
    }
    ?>
</div>