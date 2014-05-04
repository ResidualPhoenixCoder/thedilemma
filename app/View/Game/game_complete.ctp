<script>
    $(function() {
        $("#lobbybtn")
                .button()
                .click(function(event) {
                    window.location="<?php echo Router::url(array('controller' => 'lobby', 'action' => 'lobby')); ?>";
                });
    })
</script>

<style>
    #results {
        text-align: center;
        vertical-align: top;
        width: 100%;
    }

    #toast {
        font-size: 50px;
        font-weight: bold;
    }

    #lobbybtn {
        width:380px;
        margin: 0 5px 0 5px;
    }

    .scores {
        font-size: 30px;
        text-align: right;
    }
</style>

<table id="results">
    <tr>
        <td><span id="toast"><?php
                if ($results['draw'] == false) {
                    echo "It was a draw!";
                } else if ($results['winner'] == $pid) {
                    echo "You won!";
                } else {
                    echo "You lost!";
                }
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td><span class="scores"><?php
                if ($results['winner'] == $pid) {
                    echo "Your score: " . $results['winfinal'];
                } else {
                    echo "Your score: " . $results['losefinal'];
                }
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td>
            <span class="scores">
                <?php
                if ($results['winner'] == $pid) {
                    echo "Their score: " . $results['losefinal'];
                } else {
                    echo "Their score: " . $results['winfinal'];
                }
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td>
            <button id="lobbybtn">Go back to Lobby</button>
        </td>
    </tr>
</table>
