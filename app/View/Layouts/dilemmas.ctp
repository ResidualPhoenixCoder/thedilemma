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

/*            #divwrap {
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
            }*/

/*            #main {
                width: 550px;
                margin-left: -200px;
                float:left;
                margin: 0 0 0 20px;
                border: 10px solid;
                border-color: #4A96AD;
                background-color: #7D1935;
                box-shadow: 8px 8px 15px #949494;
                border-radius: 20px;

            }*/

/*#main{
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
        <div id="logo">
	<a href="<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'index', 'dilemma_splash')); ?>"><?php echo $this->Html->image('logo_small.png'); ?></a>
</div>
        <div id="lookup">
            <?php echo $this->Html->image('lookup.png'); ?>
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
