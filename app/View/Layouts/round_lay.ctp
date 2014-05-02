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
    </head>

    <body>
        <div id="wrapper">
            <?php echo $this->fetch("content"); ?>
            <div id="footer">

            </div>
        </div>
    </body>
</html>