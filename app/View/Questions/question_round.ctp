<?php echo $this->Html->script('timer.js'); ?>	
<script>
	$(function() {
		$( "#radio" ).buttonset();
		load_question();			
	});
	
	function load_question() {
		$("#qText").html("Which of the following books did you find most boring?");
		$("#ansA").html("The Social Life of Information");
		$("#ansB").html("In The Age Of The Smart Machine");
		$("#ansC").html("The Origin of Virtue");
		$("#ansD").html("All of the above");
	}
	
	function timer_ran_out() {
		window.location='login.html';
	}
	
	</script>
	<style>
	#main {
		width: 400px;
		margin-top: -200px;
		margin-left: -200px;
	}
	
	table {
		border: 0px;
		margin-left: auto;
		margin-right: auto;
	}
	
	#radio {
		text-align: center;
	}
	
	#btn_prev, #btn_next {
		width: 180px;
	}
	</style>

<div id="main">
	<h1>QUESTION</h1>
	<p id="qText" style="text-align:center; font-weight:bold;">QUESTION TEXT</p>
	<div>
		<table>
			<tr><td>A:</td><td><span id="ansA">ANSWER A</span></td></tr>
			<tr><td>B:</td><td><span id="ansB">ANSWER B</span></td><tr>
			<tr><td>C:</td><td><span id="ansC">ANSWER C</span></td></tr>
			<tr><td>D:</td><td><span id="ansD">ANSWER D</span></td></tr>
		</table><br />
	</div>
	<div id="radio">
		<input type="radio" id="radioA" name="radio"><label for="radioA">A</label>
		<input type="radio" id="radioB" name="radio"><label for="radioB">B</label>
		<input type="radio" id="radioC" name="radio"><label for="radioC">C</label>
		<input type="radio" id="radioD" name="radio"><label for="radioD">D</label>
	</div><br />
	<p style="text-align:center; font-weight:bold;">
	Time remaining: <span id="countdown">10</span> seconds...
	</p>
	<br />
	
	
</div>