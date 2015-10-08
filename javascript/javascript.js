moment2(moment1());
fordjupningsuppgift();
moment3();


function moment1() {
	var month = new Date().getMonth();
	var temp, color, bild;

	// Bakgrundsbild - Månad
	if (month <= 3) { // Kvartal 1 - Vinter
		bild = "abN";
		temp = Math.floor(Math.random() * (-5 + 20 + 1)) - 20;
	}
	else if (month > 3 && month <= 6) { // Kvartal 2 - Vår
		bild = "abo";
		temp = Math.floor(Math.random() * (10 + 5 + 1)) - 5;
	}
	else if (month > 6 && month <= 9) { // Kvartal 3 - Sommar
		bild = "abO";
		temp = Math.floor(Math.random() * (25 - 10 + 1)) + 10;
	}
	else { // Kvartal 4 - Höst
		bild = "abp";
		temp = Math.floor(Math.random() * (10 + 5 + 1)) - 5;
	}
	document.write("<div id='info'><img height='300' src='http://www.arbr.se/" + bild + "'/>");

	// Färg - Temp
	if (temp <= -15) color = "3333CC";
	else if (-15 < temp && temp <= -10) color = "3366FF";
	else if (-10 < temp && temp <= -5) color = "6666FF";
	else if (-5 < temp && temp <= 0) color = "99CCFF";
	else if (0 < temp && temp <= 5) color = "FFCCCC";
	else if (5 < temp && temp <= 10) color = "FF6666";
	else if (10 < temp && temp <= 15) color = "FF5050";
	else color = "CC0000";
	document.getElementById("body").style.backgroundColor = "#" + color;
	document.write("<br/><br/><b>Temp:</b> " + temp + "<br/><b>Månad:</b> " + (month + 1));

	return temp;
}

function moment2(temp) {
	var text;

	// Visdomsord - Temp
	document.write("<br/><b>Dagens visdomsord: </b>'<i>");
	if (temp <= -15) text = "Aforismer är som vattendroppar; var för sig är de ingenting men tillsammans utgör de ett hav.";
	else if (-15 < temp && temp <= -10) text = "Det är framtiden jag är intresserad av - eftersom att jag kommer tillbringa resten av mitt liv där.";
	else if (-10 < temp && temp <= -5) text = "Det är inte vad som händer dig som räknas – utan hur du reagerar på det.";
	else if (-5 < temp && temp <= 0) text = "Lägg aldrig energi på det du inte kan påverka.";
	else if (0 < temp && temp <= 5) text = "Rikedom mäts inte i hur mycket du har utan i hur mycket du ger.";
	else if (5 < temp && temp <= 10) text = "Det vackraste vi kan uppleva är det svårförklarade. Att erkänna universums mysterium är vägen för all sann vetenskap.";
	else if (10 < temp && temp <= 15) text = "Varför väntar du och vad väntar du på?";
	else text = "Bekymmer kommer oftast dit där de är mest välkomna.";

	document.write(text + "</i>'</div>");
}

function moment3() {
	// Punkt 1
	punkt1();	
	function punkt1() {
		document.write("<br/><a href='#' id='link1'>Dölj info</a><br/><a href='#' id='link2'>Visa info</a>");
		$("a#link2").hide();
		$("a").mouseover(function(){$(this).css("text-decoration","none");});
	}

	// Punkt 2
	punkt2();	
	function punkt2() {
		$("a#link1").click(function(){
			$("div#info").hide();
			$("a#link2").show();
			$(this).hide();
		});

		$("a#link2").click(function(){
			$("div#info").show();
			$("a#link1").show();
			$(this).hide();
		});
	}

	// Punkt 3
	punkt3();
	function punkt3() {
		text = "Remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		document.write("<br/><br/><p id='p1' style='width:700px'><b>Text 1: (Tryck på texten för att sänka opaciteten)</b><br/>" + text + "</p><br/><p id='p2' style='width:700px'><b>Text 2: (Tryck på texten för att sänka opaciteten)</b><br/>" + text + "</p>");
		
		$("p#p1").click(function(){$(this).fadeTo(100, 0.3);});
		$("p#p2").click(function(){$(this).fadeTo(100, 0.6);});
	}
}

function fordjupningsuppgift() {
	// Punkt 1
	punkt1();	
	function punkt1() {
		document.write("<br/><b>Meny: (tryck på 'Länk 3' för att visa effekten)</b><br/><ul style='list-style-type:none;'><li style='display:inline; margin-left:20px;'><a href='#'>Länk 1</a></li><li style='display:inline; margin-left:20px;'><a href='#'>Länk 2</a></li><ul style='list-style-type:none; display:inline; margin-left:-20px;'><li style='display:inline;'><a href='#' id='link3'>Länk 3</a></li><li style='margin-left:147px; margin-top:10px;' id='link4'><a href='#'>Länk 4</a></li></ul></ul><br/>");
		$("li#link4").hide();

		$("a#link3").click(function () {$("li#link4").slideDown();});
		$("li#link4").click(function () {$("li#link4").slideUp();});
	}

	// Punkt 2
	punkt2();	
	function punkt2() {
		document.write("Has user resized window?: <span id='svar'>No</span><br/>");

		$(window).resize(function() {
		  	document.getElementById("svar").innerHTML = "Yes";
		});
	}
}