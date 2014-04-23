<html>
<head>
<title><?php echo $title_for_layout;?></title>
<?
	echo $this->Html->script('jquery'); 
	echo $this->Html->css('dilemmas');
	echo $this->fetch('script');
	echo $this->fetch('css');
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
</head>

<body>
	<div id="container">
		<div id="header">
			<font size="10"><?php echo $title_for_layout;?></font>
		</div>

		<div id="menu" class="nav">
			<p>
			<? echo $this->Html->link('Home', array('controller'=>'dilemmas', 'action'=>'display', 'dilemma_splash'));?>|
			<? echo $this->Html->link('Player Registration', array('controller'=>'dilemmas', 'action'=>'display', 'player_registration'));?>| 
			<? echo $this->Html->link('Player Login', array('controller'=>'dilemmas', 'action'=>'display', 'player_login'));?>
			</p>
		</div>

		<div id="content">
			<?php echo $this->fetch("content"); ?>
		</div>

		<div id="footer">

		</div>
	</div>
</body>
</html>
