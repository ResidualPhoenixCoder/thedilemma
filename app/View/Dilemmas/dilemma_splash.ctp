<script>
	$(function() {
		$("#btn_begin")
			.button()
			.click(function( event ) {
				window.location="<?php echo Router::url(array('controller' => 'dilemmas', 'action' => 'index', 'login')); ?>";
			});
	});
</script>

<style>
	#main {
		margin-top: -200px;
	}

	#btn_begin {
		width: 360px;
	}
</style>

<h1>THE DILEMMA</h1>
<p class="block">
The Dilemma is a trivia game played between two players at a time. 
A question is presented to both players at which point each player has ten seconds 
to choose one of multiple choices as their answer. In addition to choosing an answer 
each player chooses whether they would like to hide, share, or lie about their answer 
to the other player. If a player chooses to share or lie about their answer then the 
other player will be given a chance to decide whether they want to stick with their 
original answer or switch to the answer given to them by the other player. To help 
each player decide what to do with their answers they are given the strengths, weaknesses, 
and overall reputation of the other player.
</p>
<div style="text-align:center;"><button id="btn_begin">BEGIN</button></div><br />
