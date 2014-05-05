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

            #divwrap {
                width: 1030px;
                margin: 0 auto;
                padding: 10px;
            }

            #tips {
                width: 400px;
                border: 10px solid;
                border-color: #4A96AD;
                background-color: #7D1935;
                box-shadow: 8px 8px 15px #949494;
                border-radius: 20px;
                float: left;
                padding: 10px;
                font-size: 15px;
                    
            }
            
            #tips p {
                font-size: 13px;
            }

            #main {
                width: 550px;
                //margin-left: -200px;
                float:left;
                margin: 0 0 0 20px;
                border: 10px solid;
                border-color: #4A96AD;
                background-color: #7D1935;
                box-shadow: 8px 8px 15px #949494;
                border-radius: 20px;

            }

            /*            .main{
                            width: 400px;
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            margin-left: -200px;
                            border: 10px solid;
                            border-color: #4A96AD;
                            background-color: #7D1935;
                            box-shadow: 8px 8px 15px #949494;
                            border-radius: 20px;
                        }*/
        </style>
    </head>

    <body>
        <div id='divwrap'>
            <div id="tips" class="main">
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
        </div>
    </body>
</html>
