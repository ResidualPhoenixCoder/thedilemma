<?php echo $this->Html->script('keypress.js'); ?>
<script>
    var questions = <?php echo $questions; ?>;
    var opponent = <?php echo $opponent; ?>;
    var pid = "<?php echo $current; ?>";
    var qgroup = "<?php echo $question_group; ?>";
    var qctr = 0;
    var currq;
    var playerAnswer = "a";
    var playerAction = "H";
    var playerLieAnswer = null;

    /*WINNER DETERMINATION*/
    var playerPoints = 0;
    var opponentPoints = 0;

    /*TIMER*/
    var max_time = 10;
    var gameSpeed = 700;
    var cinterval;

    window.onerror = function() {
        if (qctr < questions.length) {
            /*SET FORM TO DEFAULT*/
            playerAnswer = "a";
            playerAction = "H";

            $(":radio").prop("checked", false);
            $(":radio").button("refresh");
            $(":radio").focus(function() {
                this.blur();
            });

            change_background();
            currq = questions[++qctr]['RoundAnswer'];
            load_question(currq);
            max_time = 10;
            cinterval = setInterval("countdown_timer()", gameSpeed);
        } else {
            $("#winner").val(pid);
            $("#loser").val(opponent.pid);
            $("#winfinal").val(playerPoints);
            $("#losefinal").val(opponentPoints);

            if (playerPoints === opponentPoints) {
                $("#draw").val(true);
                $("#winfinal").val(playerPoints);
                $("#losefinal").val(opponentPoints);
            } else if (playerPoints < opponentPoints) {
                $("#winner").val(opponent.pid);
                $("#winfinal").val(opponentPoints);
                $("#loser").val(pid);
                $("#losefinal").val(playerPoints);
            }
            $("#form_game_complete").submit();
        }
    }

    /*KEYBOARD SHIT*/
    var kbl = new window.keypress.Listener();

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

        $("#rgAnswer :radio").click(function(event) {
            playerAnswer = $(this).val();
        });

        $("#rgAction :radio").click(function(event) {
            playerAction = $(this).val();
        });

        // Load question data
        currq = questions[qctr]['RoundAnswer'];
        change_background();
        load_question(currq);

        // 1,000 means 1 second.
        cinterval = setInterval('countdown_timer()', gameSpeed);

        /*KEYBOARD BINDINGS*/
        /*Answers*/
        kbl.simple_combo('1', function() {
            $("#rdoAnsA").prop('checked', true);
            $("#rdoAnsA").button("refresh");
            playerAnswer = "a";
        });
        kbl.simple_combo('2', function() {
            $("#rdoAnsB").prop('checked', true);
            $("#rdoAnsB").button("refresh");
            playerAnswer = "b";
        });
        kbl.simple_combo('3', function() {
            $("#rdoAnsC").prop('checked', true);
            $("#rdoAnsC").button("refresh");
            playerAnswer = "c";
        });
        kbl.simple_combo('4', function() {
            $("#rdoAnsD").prop('checked', true);
            $("#rdoAnsD").button("refresh");
            playerAnswer = "d";
        });

        /*Actions*/
        kbl.simple_combo('left', function() {
            $("#rdoHide").prop('checked', true);
            $("#rdoHide").button("refresh");
            playerAction = "H";
        });
        kbl.simple_combo('down', function() {
            $("#rdoShare").prop('checked', true);
            $("#rdoShare").button("refresh");
            playerAction = "S";
        });
        kbl.simple_combo('right', function() {
            $("#rdoLie").prop('checked', true);
            $("#rdoLie").button("refresh");
            playerAction = "L";
        });
    });

    function load_question(q) {
        switch (q.player_act) {
            case "L":
                if (q.player_lie_answer) {
                    $("#spnDecision").html(q.player_lie_answer.toUpperCase());
                } else {
                    $("#spnDecision").html("Hidden");
                }
                break;
            case "H":
                $("#spnDecision").html("Hidden");
                break;
            case "S":
                if (q.player_true_answer) {
                    $("#spnDecision").html(q.player_true_answer.toUpperCase());
                } else {
                    $("#spnDecision").html("Hidden");
                }
                break;
            default:
                $("#spnDecision").html("Hidden");
                break;
        }
        $("#spnQNum").text(qctr + 1);
        $("#spnQText").html(q.question);
        $("#spnAnsA").html(q.answer_a);
        $("#spnAnsB").html(q.answer_b);
        $("#spnAnsC").html(q.answer_c);
        $("#spnAnsD").html(q.answer_d);
    }

    function getLie(ans) {
        var tmpAns = modAns(ans);
        var rInd = Math.floor(Math.random() * tmpAns.length);
        return tmpAns[rInd];
    }

    function modAns(ans) {
        var possAns = ["A", "B", "C", "D"];
        var tmpAns = [];
        for (var i = 0; i < possAns.length; i++) {
            if (possAns[i] !== ans) {
                tmpAns.push(possAns[i]);
            }
        }
        return  tmpAns;
    }

    function countdown_timer() {
        // decrease timer
        max_time--;
        document.getElementById('countdown').innerHTML = max_time;
        if (max_time <= 0) {
            clearInterval(cinterval);
            timer_ran_out();
        }
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
            /*SEND ROUND DATA TO SERVER FOR SAVE*/
            save_answers();

            /*DETERMINE POINTS EARNED THIS ROUND*/
            points_accounting();
            update_score();
//            alert("PlayerAns: " + playerAnswer + ", PlayerAct: " + playerAction);

            /*SET FORM TO DEFAULT*/
            playerAnswer = "a";
            playerAction = "H";

            $(":radio").prop("checked", false);
            $(":radio").button("refresh");
            $(":radio").focus(function() {
                this.blur();
            });

            change_background();
            currq = questions[++qctr]['RoundAnswer'];
            load_question(currq);
            max_time = 10;
            cinterval = setInterval("countdown_timer()", gameSpeed);
        } else {
            $("#winner").val(pid);
            $("#loser").val(opponent.pid);
            $("#winfinal").val(playerPoints);
            $("#losefinal").val(opponentPoints);

            if (playerPoints === opponentPoints) {
                $("#draw").val(true);
                $("#winfinal").val(playerPoints);
                $("#losefinal").val(opponentPoints);
            } else if (playerPoints < opponentPoints) {
                $("#winner").val(opponent.pid);
                $("#winfinal").val(opponentPoints);
                $("#loser").val(pid);
                $("#losefinal").val(playerPoints);
            }
            $("#form_game_complete").submit();
        }
    }

    function update_score() {
        $("#youScore").text(playerPoints);
        $("#themScore").text(opponentPoints);
    }

    function points_accounting() {
        var pR = (playerAnswer === currq.correct_answer);
        var oR = (currq.player_true_answer === currq.correct_answer);
        var opponentAction = currq.player_action;

        if (pR || oR) {
            if (pR && oR) {
                if (playerAction !== "S") {
                    playerPoints += 8;
                } else {
                    playerPoints += 6;
                }

                if (opponentAction !== "S") {
                    opponentPoints += 8;
                } else {
                    opponentPoints += 6;
                }
            } else if (pR && !oR) {
                if (playerAction !== "S" && opponentAction === "H") {
                    playerPoints += 10;
                    opponentPoints -= 2;
                } else if (playerAction === "H" && opponentAction !== "H") {
                    playerPoints += 8;
                    opponentPoints -= (opponentAction === "L") ? 4 : 0;
                }
            } else if (!pR && oR) {
                if (playerAction === "H" && opponentAction !== "H") {
                    playerPoints -= 2;
                    opponentPoints += (opponentAction === "L") ? 8 : 0;
                } else {
                    switch (playerAction) {
                        case "H":
                            playerPoints -= 2;
                            opponentPoints += 10;
                            break;
                        case "S":
                            playerPoints += 2;
                            opponentPoints += 8;
                            break;
                        case "L":
                            playerPoints -= 4;
                            opponentPoints += 8;
                            break;
                    }
                }
            }
        } else {
            if (playerAction === "H") {
                playerPoints -= 2;
                switch (opponentAction) {
                    case "H":
                        opponentPoints -= 2;
                        break;
                    case "S":
                        opponentPoints += 0;
                        break;
                    case "L":
                        opponentPoints -= 4;
                        break;
                }
            } else {
                switch (playerAction) {
                    case "S":
                        playerPoints += 2;
                        break;
                    case "L":
                        playerPoints -= 4;
                        opponentPoints -= 2;
                        break;
                }
            }
        }
    }

    //Package the current answers and actions up and send that stuff back out to be saved.
    function save_answers() {
        var formObj = new Object();
        formObj.player = pid;
        formObj.opponent = opponent.pid;
        formObj.question_id = currq.question_id;
        formObj.question_group = qgroup;
        formObj.question_order = qctr - 1;
        formObj.player_act = playerAction;
        formObj.player_true_answer = playerAnswer;
        formObj.player_lie_answer = (playerAction === "L") ? playerLieAnswer : null;
        formObj.opponent_act = currq.player_act;
        formObj.opponent_true_answer = currq.player_true_answer;
        formObj.opponent_lie_answer = currq.player_lie_answer;
        formObj.correct = currq.correct_answer;

        var formData = JSON.stringify(formObj);

        $.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'game', 'action' => 'roundComplete')); ?>",
            data: formData
//            error: function(jqXHR, textStatus, errorThrown) {
//                alert("SaveAnswer Server is unavailable. Error: " + jqXHR.responseText);
//            }
        });
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
        height: 106%;
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
        font-size: 100px;
    }

    .main-arena {
        width: 300px;
    }

    .main-arena table {
        /*width: 100%*/
    }

    #score {
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

    #score table {
        width:100%;
        border: 0px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
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

    #music {
        display: none;
    }

    h2 {
        margin: 0;
    }

    h3 {
        margin: 0;
    }

    .answer {
        padding: 3px;
    }

    #answers {
        width: 80%;
        text-align: center;
    }
</style>

<div id="wrapper">

    <div id="timer">
        DECIDE! 
        <span id="countdown">10</span>
    </div>

    <div id="score" class="main-arena">
        <table>
            <tr><td colspan="2"><h2>SCORE</h2><hr></td></tr>
            <tr>
                <td align="center"><b>YOU</b></td>
                <td align="center"><b>THEM</b></td>
            </tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr>
                <td align="center"><font size="6"><b><span id="youScore">0</span></b></font></td>
                <td align="center"><font size="6"><b><span id="themScore">0</span></b></font></td>
            </tr>
        </table>
    </div><br />

    <div id="prompt" class="main-arena">
        <span id="spnQLbl"><h2>Question <span id="spnQNum">1</span></h2></span>
        <hr>
        <span><h3><span id="playerName_decision" class="playerName">Fellow Prisoner</span>'s  Answer: <br /><b><span id="spnDecision">HIDDEN</span></b></h3></span>
        <hr><br />
        <span id="spnQText">You have been denied a question...</span><br />
        <table id="answers" cellpadding="3" cellspacing="4">
            <tr><td class="answer"><b>A.</b> <span id="spnAnsA">Deadly Answer A</span></td><td class="answer"><b>B.</b> <span id="spnAnsB">Deadly Answer B</span></td></tr>
            <tr><td class="answer"><b>C.</b> <span id="spnAnsC">Deadly Answer C</span></td><td class="answer"><b>D.</b> <span id="spnAnsD">Deadly Answer D</span></td></tr>
        </table><br />

        <div id="rgAnswer">
            <input type="radio" id="rdoAnsA" name="rgAnswerSet" value="a"><label for="rdoAnsA">A</label>
            <input type="radio" id="rdoAnsB" name="rgAnswerSet" value="b"><label for="rdoAnsB">B</label>
            <input type="radio" id="rdoAnsC" name="rgAnswerSet" value="c"><label for="rdoAnsC">C</label>
            <input type="radio" id="rdoAnsD" name="rgAnswerSet" value="d"><label for="rdoAnsD">D</label>
        </div>

    </div><br />

    <div id="action" class="main-arena">
        <div id="rgAction">
            <input type="radio" name="rgActionSet" id="rdoHide" value="H"><label for="rdoHide">HIDE</label>
            <input type="radio" name="rgActionSet" id="rdoShare" value="S"><label for="rdoShare">SHARE</label>
            <input type="radio" name="rgActionSet" id="rdoLie" value="L"><label for="rdoLie">LIE</label>
        </div>
    </div><br />
    <div id="stats" class="main-arena">
        <table>
            <tr><td colspan="3"><h3><span id="playerName_profile" class="playerName">Fellow Prisoner</span>'s Profile</h3><hr></td></tr>
            <tr>
                <td><b>HIDE</b></td>
                <td><b>SHARE</b></td>
                <td><b>LIE</b></td>
            </tr>
            <tr><td colspan="3"><hr></td></tr>
            <tr>
                <td><font size="4"><b><span id="hideStat">33%</span></b></font></td>
                <td><font size="4"><b><span id="shareStat">33%</span></b></font></td>
                <td><font size="4"><b><span id="lieStat">33%</span></b></font></td>
            </tr>
        </table>
    </div><br />
    <div id="music">
        <audio autoplay="autoplay" type="hidden" controls>
            <source src="<?php echo $music; ?>">
        </audio>
    </div>
</div>
<form id="form_game_complete" method="post" action="<?php echo Router::url(array('controller' => 'game', 'action' => 'game_complete')); ?>">
    <input id="draw" name ="draw" type="hidden" value ="false" />
    <input id="winner" name="winner" type="hidden" value="<?php echo $current; ?>"/>
    <input id="loser" name="loser" type="hidden" value="<?php echo $opponent['pid']; ?>"/>
    <input id="winfinal" name="winfinal" type="hidden"/>
    <input id="losefinal" name="losefinal" type="hidden"/>
    <input id="qgroup" name="qgroup" type="hidden" value="<?php echo $question_group; ?>"/>
</form>