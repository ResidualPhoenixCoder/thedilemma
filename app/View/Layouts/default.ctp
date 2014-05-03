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
        <div id="main">
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
