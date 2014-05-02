/* Code from www.sourcecodetuts.com */

var max_time = 10;
var cinterval;
 
function countdown_timer(){
  // decrease timer
  max_time--;
  document.getElementById('countdown').innerHTML = max_time;
  if(max_time == 0){
    clearInterval(cinterval);
	timer_ran_out();
  }
}
// 1,000 means 1 second.
cinterval = setInterval('countdown_timer()', 1000);