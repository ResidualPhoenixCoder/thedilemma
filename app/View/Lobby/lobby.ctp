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

        var pgbar = $('#bot_progressbar');
        var pglbl = $('.bot-progress-label');
        pgbar.hide();
        pgbar.progressbar({value: false,
            complete: function() {
                pglbl.text("The Bots are here!");
            }
        });

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
                var bot1 = (1 + Math.floor(Math.random() * 100)) * 100;
                var bot2 = 1 + Math.floor(Math.random() * 100);
                add_user(playerData.pid, 'Bot ' + (bot1 + bot2), playerData.clan_tag, playerData.lie, playerData.share, playerData.hide, playerData.correct);
            } else {
                add_user(playerData.pid, playerData.username, playerData.clan_tag, playerData.lie, playerData.share, playerData.hide, playerData.correct);
            }
        });
    }

    function add_user(pid, username, clantag, plie, pshare, phide, pwin) {
        var id = username;
        var total = parseInt(plie) + parseInt(pshare) + parseInt(phide);
        var perclie = ((parseInt(plie) / total) * 100).toFixed(0);
        var percsha = ((parseInt(pshare) / total) * 100).toFixed(0);
        var perchid = ((parseInt(phide) / total) * 100).toFixed(0);
        //var perwins = Math.floor((pwin / total) * 100);
        var text = "<li class='ui-widget-content user-item' pid='" + pid + "' id = '" + id + "'><a href='test'>" + (username >= 5 ? username.substring(0, 5) + "..." : username) + " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>LIES: </b>" + perclie + "%,&nbsp;&nbsp; <b>SHARES: </b>" + percsha + "%,&nbsp;&nbsp; <b>HIDES: </b>" + perchid + "%</a></li>";
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
    #main {
        width: 550px;
        margin-top: -300px;
        margin-left: -275px;
    }

    #btn_play {
        width: 500px;
    }

    #second_menu{
        width:500px;
        margin: auto auto;
    }

    #lobby_select { width: 475px; }

    /*    #feedback { font-size: 1.4em; }*/
    #lobby_select .ui-selecting { background: #FECA40; }
    #lobby_select .ui-selected { background: #F39814; color: white; }
    #lobby_select { list-style-type: none; margin: 0; padding: 0; }
    #lobby_select li { margin: 3px; padding: 0.4em; font-size: 1em; height:18px; border-radius: 3px}
    #lobby_select li > a {text-decoration: none};

    .ui-progressbar {
        position: relative;
    }

    .bot-progress-label {
        position: absolute;
        left: 30%;
        top: 75px;
        font-weight: bold;
        text-shadow: 1px 1px 0 #fff;
    }
</style>

<h1>LOBBY</h1>

<div id="bot_progressbar" style="margin: 0 auto 10px auto; width: 500px"><div class="bot-progress-label">...sending in the bots...</div></div>
<div style="width: 500px; height: 250px; overflow-y: scroll; margin-left:auto; margin-right:auto;">
    <ul id="lobby_select">
    </ul>
</div>
<div style="text-align:center;"><button id="btn_play">PLAY</button></div><br />
<div id="second_menu" style="text-align:left;"><button id="bot">Create Bots</button><button id="player">Get Players</button></div><br />
<form id="form_round_start" method="post" action="<?php echo Router::url(array('controller' => 'game', 'action' => 'rounds')); ?>">
    <input id="player2" name="player2" type="hidden"/>
    <input id="player2_pid" name="player2_pid" type="hidden"/>
</form>
