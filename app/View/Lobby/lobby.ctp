<script>
    $(function() {
        $.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'lobby', 'action' => 'getPlayers')); ?>",
            success: function(data, textStatus, jqXHR) {
                var rdata = JSON.parse(data);
                load_users(rdata, false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Server is unavailable. Error: " + jqXHR.responseText);
            }
        });

        var pgbar = $('#progressbar');
        var pglbl = $('.progress-label');
        pgbar.hide();
        pgbar.progressbar({value: false,
            complete: function() {
                pglbl.text("The Bots are here!");
            }
        });

        $("#descript").accordion({active: false, collapsible: true, heightStyle: "content"});

        $("#lobby_select").selectable({
            selected: user_selected,
            unselected: user_selected
        });
        //button_state(true);
        $("#btn_play").prop('disabled', true);
        $("#btn_play")
                .button()
                .click(function(event) {
                    $("#form_round_start").submit();
                });
        $("#bot")
                .button()
                .click(function(event) {
                    event.preventDefault();
                    $('#lobby_select').selectable('disable');
                    $('#lobby_select').selectable('refresh');
                    $("#bot").prop('disabled', true);
                    $("#bot").button('refresh');
                    $("#player").prop('disabled', true);
                    $("#player").button('refresh');
                    pgbar.show();
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo Router::url(array('controller' => 'bot', 'action' => 'botcreator')); ?>",
                        success: function(data, textStatus, jqXHR) {
                            var rdata = JSON.parse(data);
                            load_users(rdata, true);
                            $("#player").prop('disabled', false);
                            $("#player").button('refresh');
                            $("#bot").prop('disabled', false);
                            $("#bot").button('refresh');
                            $("#lobby_select").selectable('enable');
                            $('#lobby_select').selectable('refresh');
                            pgbar.hide();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert("Server is unavailable. Error: " + jqXHR.responseText);
                        }
                    });
                });
        $("#player")
                .button()
                .click(function(event) {
                    event.preventDefault();
                    $('#lobby_select').selectable('disable');
                    $('#lobby_select').selectable('refresh');
                    $("#bot").prop('disabled', true);
                    $("#bot").button('refresh');
                    $("#player").prop('disabled', true);
                    $("#player").button('refresh');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo Router::url(array('controller' => 'lobby', 'action' => 'getPlayers')); ?>",
                        success: function(data, textStatus, jqXHR) {
                            var rdata = JSON.parse(data);
                            load_users(rdata, true);
                            $("#player").prop('disabled', false);
                            $("#player").button('refresh');
                            $("#bot").prop('disabled', false);
                            $("#bot").button('refresh');
                            $("#lobby_select").selectable('enable');
                            $('#lobby_select').selectable('refresh');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert("Server is unavailable. Error: " + jqXHR.responseText);
                        }
                    });
                });
    });

    function load_users(data, reset) {
        if (reset) {
            $('.user-item').remove();
        }

        $.each(data, function(index, value) {
            var playerData = value['Player'];
            if (playerData.clan_tag === 'bot') {
                add_user(playerData.pid, 'Bot Player', playerData.clan_tag, playerData.lie, playerData.share, playerData.hide, playerData.correct);
            } else {
                add_user(playerData.pid, playerData.username, playerData.clan_tag, playerData.lie, playerData.share, playerData.hide, playerData.correct);
            }
        });
    }

    function pad_stat(num) {
        var newnum = num + "";
        while (newnum.length < 3) {
            newnum = "0" + newnum;
        }
        return newnum;
    }

    function format_username(name) {
        var newname = name;
        if (name.length > 10) {
            newname = name.substring(0, 8) + "...";
        } else {
            var pad = 10 - name.length;
            for (var i = 0; i < pad; i++) {
                newname += '&nbsp;';
            }
        }
        return newname;
    }

    function add_user(pid, username, clantag, plie, pshare, phide, pwin) {
        var id = username;
        var total = parseInt(plie) + parseInt(pshare) + parseInt(phide);
        var perclie = ((parseInt(plie) / total) * 100).toFixed(0);
        var percsha = ((parseInt(pshare) / total) * 100).toFixed(0);
        var perchid = ((parseInt(phide) / total) * 100).toFixed(0);
        var percwin = ((parseInt(pwin) / total) * 100).toFixed(0);
        
        username = format_username(username);

        var text = "<li class='ui-widget-content user-item' pid='" + pid + "' id = '" + id + 
                    "'><table class='playerEntry' style='width:100%; color: #212121'><tr><td width='100px'>" + username + "</td><td><b>L: </b>" + (isNaN(perclie) ? ' -- ' : pad_stat(perclie)) +
                    "%,</td><td><b>S: </b>" + (isNaN(percsha) ? ' --  ' : pad_stat(percsha)) +
                    "%,</td><td><b>H: </b>" + (isNaN(perchid) ? ' -- ' : pad_stat(perchid)) +
                    "%,</td><td><b>W: </b>" + (isNaN(percwin) ? ' -- ' : pad_stat(percwin)) + "%</td></tr></table></li>";
        $("#lobby_select").append(text);
        $("#lobby_select").selectable("refresh");
    }

    function user_selected(event, ui) {
        var collSel = $(".ui-selected");
        var sel = collSel.get(0);
        if (typeof sel !== 'undefined') {
            $("#player2").val($(sel).attr('id'));
            $("#player2_pid").val($(sel).attr('pid'));
            button_state(false);
        } else {
            button_state(true);
        }
    }

    function button_state(disable) {
        $("#btn_play").prop("disabled", disable);
        $("#btn_play").button("refresh");
    }
</script>
<style>
    #playerEntry{
        width:100%;
        color: #212121;
    }
    
    #main {
        width: 550px;
        /*        margin-top: -450px;*/
        /*        margin-left: -275px;*/
        margin-bottom: 80px;
    }

    #btn_play {
        margin-top: 10px;
        width: 500px;
        height: 50px
    }

    #second_menu{
        width:500px;
        margin: auto auto;
    }

    #second_menu button {
        width: 100%;
    }

    #lobby_select { width: 500px; }

    /*    #feedback { font-size: 1.4em; }*/
    #lobby_select .ui-selecting { background: #FECA40; }
    #lobby_select .ui-selected { background: #F39814; color: white; }
    #lobby_select { list-style-type: none; margin: 0; padding: 0; }
    #lobby_select li { margin: 3px; padding: 0.4em; font-size: 1em; height:18px; border-radius: 3px}
    #lobby_select li > a {text-decoration: none};

    .ui-progressbar {
        position: relative;
    }

    .progress-label {
        position: relative;
        left: 32%;
        top: 10px;
        margin-bottom: -20px;
        font-weight: bold;
        text-shadow: 1px 1px 0 #fff;
    }

    #progressbar {
        margin: 0 auto 10px auto; 
        width: 500px;
    }

    #playerStats {
        width: 480px;
        margin: 0 auto 20px auto;
        padding: 10px;
        background: #212121;
        border-radius: 20px;
    }

    #playerStats table {
        width: 100%;
        text-align: center;
    }

    h2 {
        margin: 0 0 0 0;
    }

    #playnow {
        width: 500px;
        margin: 0 auto 0 auto;
        text-align: center;
    } 

    .description p {
        font-size: 20px;
        margin: 10px 0 0 0;
    }
    #descript {
        width: 494px;
        margin: 0 auto 10px auto;
    }

    #descript .ui-icon {
        display: none;
    }

    #descript h3 {
        text-align: center;
    }

    #players_list {
        width: 500px; 
        height: 250px; 
        overflow-y: hidden; 
        margin-left:auto; 
        margin-right:auto;
    }

    #players_list::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #D62929;

    }
</style>

<h1><?php echo $player; ?>'s Lobby</h1>
<div id="descript">
    <h3>Game Description</h3>
    <div id="entry">
        <p>
            In each game, you will have 10 second to answer a choice question, and then you can choose your action button to influence your opponent. The best strategy is that you get the right answer and make your opponent get the wrong answer. Then you can get the full points in this game. Don’t forget the opponent’s profile. It can help you analyze your opponent’s strategy. In the profile, there are history records of cheat, share and hide for this player. For example, if your opponent’s cheat percentage is high, that means this player is good at influence other players. You should rethink your opponent’s answer if it is post. Every day, there are some special questions. Try it! You can get special credits! 
        </p>
    </div>
</div>
<div id="progressbar"><div class="progress-label">...sending in the bots...</div></div>
<div id="players_list">
    <ul id="lobby_select">
    </ul>
</div>
<div id="playnow" class="description">
    <p>SELECT A PLAYER ABOVE AND PRESS PLAY!</p>
</div>
<div style="text-align:center;"><button id="btn_play">PLAY</button></div><br />

<div id="second_menu" style="text-align:left;"><button id="bot">Run a Bot Simulation</button><br><button id="player">Get Random Set of Players</button></div><br />
<div id="playerStats">
    <table id="stats">
        <tr><td><b>My Hides</b></td><td><b>My Shares</b></td><td><b>My Lies</b></td><td></tr>
        <tr><td colspan="4"> <hr></td></tr>
        <tr><td><?php echo $stat['hide']; ?>%</td><td><?php echo $stat['share']; ?>%</td><td><?php echo $stat['lie']; ?>%</td></tr>
        <tr><td colspan="3">&nbsp;</tr>
        <tr><td><b>My Wins</b></td><td><b>My Losses</b></td><td><b>My Draws</b></td></tr>
        <tr><td colspan="4"> <hr></td></tr>
        <tr><td><?php echo $stat['wins']; ?></td><td><?php echo $stat['losses']; ?></td><td><?php echo $stat['draws']; ?></td></tr>
    </table>
</div>
<form id="form_round_start" method="post" action="<?php echo Router::url(array('controller' => 'game', 'action' => 'rounds')); ?>">
    <input id="player2" name="player2" type="hidden"/>
    <input id="player2_pid" name="player2_pid" type="hidden"/>
</form>
