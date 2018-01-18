/* scripts js add somme effects on wout'i website */
$(document).ready(function(){
	
	//we can try ti use addClass & removeClass
	$('#itemFirst').hover(function(e){
			$('#itemLast').slideDown(180)
			$('#itemFirst').css("background-color","rgba(0,162,232,0.7)")
		},function(){
			$('#itemLast').slideUp("fast")
			$('#itemFirst').css("background-color","rgba(0,162,232,0.4)")
	});

});
