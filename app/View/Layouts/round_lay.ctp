<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout; ?></title>
        <?php
        echo $this->Html->css('ui-lightness/jquery-ui-1.10.4.css');
        echo $this->Html->script('jquery-1.10.2.js');
        echo $this->Html->script('jquery-ui-1.10.4.js');
        echo $this->Html->script('jquery.corner.js');
        echo $this->Html->css('style');
        ?>
    </head>
    <style>
        #score {
            position: absolute;
            left: 10px;
            top: 90px;
            /*            border: 10px solid;
                        border-color: #4A96AD;
                        background-color: #7D1935;*/
            background-color: #212121;
            box-shadow: 8px 8px 15px black;
            border-radius: 20px;
/*            margin-left: auto;
            margin-right: auto;*/
            font-weight: bold;
            padding: 10px;
            width: 190px;
        }

        #score table {
            width:100%;
            border: 0px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
    </style>
    <body>
        <div id="logo">
            <?php echo $this->Html->image('logo_small.png'); ?>
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
        </div>

        <div id="wrapper">
            <?php echo $this->fetch("content"); ?>
        </div>
    </body>
</html>