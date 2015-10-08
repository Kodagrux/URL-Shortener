$("li.mi-2, li.mi-3, div.message_box").hide();
$(document).ready(function () {
	$("li.mi-2, li.mi-3, div.message_box").hide();
	$('.fancyFooter').fancybox();
	$("div.message_box").delay(500).slideToggle();

	$("li.mi-1, li.mi-2, li.mi-3").hover(function(){
 			$("li.mi-2, li.mi-3").show();
 		},
 		function(){
  			$("li.mi-2, li.mi-3").hide();
 		}
 	);
});