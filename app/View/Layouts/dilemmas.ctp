<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout; ?></title>
        <?php
        echo $this->Html->css('ui-lightness/jquery-ui-1.10.4.css');
        echo $this->Html->script('jquery-1.10.2.js');
        echo $this->Html->script('jquery-ui-1.10.4.js');
        echo $this->Html->css('style');
        ?>
        <script>
            $(function() {
                $('#genLogout')
                        .button()
                        .click(function(event) {
                            window.location = "<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'logout')); ?>";
                        });
            });
        </script>

        <style>
            #genLogout {
                margin: 10px
            }
        </style>
    </head>

    <body>
        <div id="tips" class="main">
            <p>
                In each game, you will have 10 second to answer a choice question, and then you can choose your action button to influence your opponent. The best strategy is that you get the right answer and make your opponent get the wrong answer. Then you can get the full points in this game. Don’t forget the opponent’s profile. It can help you analyze your opponent’s strategy. In the profile, there are history records of cheat, share and hide for this player. For example, if your opponent’s cheat percentage is high, that means this player is good at influence other players. You should rethink your opponent’s answer if it is post. Every day, there are some special questions. Try it! You can get special credits! 
            </p>
            
            <ul>
                <li>When you believe you get the right answer, don’t forget to choose lie button. If your opponent is misled by you, you will get more points!</li>
                <li>When you do not know the right answer, it is better to share your answers. If your opponent chooses a wrong answer, it is always helpful for you to avoid losing too many points.</li>
                <li>Your opponent’s profile always gives you useful information. Do not forget it. You can know which kind of player your opponent is.</li>
                <li>Before you want to follow your opponent’s answer, don’t forget to check opponent’s profile. This is a strategy game!</li>
                <li>Today’s special questions are post! Let’s try to get more special credits!</li>
                <li>Share your right answer to make more friends!</li>
            </ul>
        </div>
        <div id="main" class="main">
            <?php echo $this->fetch("content"); ?>
            <div id="footer">
                <?php
                if ($this->Session->read('Auth')) {
                    //echo $this->Html->link('Logout', array('controller' => 'dilemmas', 'action' => 'logout'), array('id' => 'genLogout'));
                    echo "<button id='genLogout'>Logout</button>";
                }
                ?>
            </div>
        </div>

    </body>
</html>
