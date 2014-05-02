<script>
    $(function() {
        $.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'lobby', 'action' => 'getPlayers')); ?>",
            success: function(data, textStatus, jqXHR) {
                var rdata = JSON.parse(data);
                $.each(rdata, function(index, value) {
                    var playerData = value['Player'];
                    add_user(playerData.username, playerData.clan_tag, playerData.lie, playerData.share, playerData.hide, playerData.correct);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Server is unavailable. Error: " + jqXHR.responseText);
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
    });

    function add_user(username, clantag, plie, pshare, phide, pwin) {
        var id = username;
        var text = "<li class='ui-widget-content' id = '" + id + "'><a href='test'>" + username + " | " + clantag + " | " + plie + " | " + pshare + " | " + phide + " | " + pwin + "</a></li>";
        $("#lobby_select").append(text);
        $("#lobby_select").selectable("refresh");
    }

    function user_selected(event, ui) {
        var collSel = $(".ui-selected");
        var sel = collSel.get(0);
        if (typeof sel !== 'undefined') {
            $("#player2").val($(sel).attr('id'));
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

    #lobby_select { width: 475px; }

    /*    #feedback { font-size: 1.4em; }*/
    #lobby_select .ui-selecting { background: #FECA40; }
    #lobby_select .ui-selected { background: #F39814; color: white; }
    #lobby_select { list-style-type: none; margin: 0; padding: 0; }
    #lobby_select li { margin: 3px; padding: 0.4em; font-size: 1em; height:18px; border-radius: 3px}
    #lobby_select li > a {text-decoration: none};
</style>

<h1>LOBBY</h1>
<div style="width: 500px; height: 250px; overflow-y: scroll; margin-left:auto; margin-right:auto;">
    <ul id="lobby_select">
    </ul>
</div>
<div style="text-align:center;"><button id="btn_play">PLAY</button></div><br />
<form id="form_round_start" method="post" action="<?php echo Router::url(array('controller' => 'game', 'action' => 'rounds'));?>">
    <input id="player2" name="player2" type="hidden"/>
</form>
