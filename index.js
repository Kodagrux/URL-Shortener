$(document).ready(function () {

    $("header").delay(800).animate({top: 0}, 300).animate({top: -10}, 100);

    $("section#photo").delay(150).animate({
        opacity: 1
    }, 300);

    $("section.wrapper").delay(180).animate({
        opacity: 1
    }, 300);

    $("#url_box").delay(300).animate({
        opacity: 1
    }, 300);

    $("div.photo_info").delay(500).animate({
        opacity: 1
    }, 300);

    $("h1.header1").delay(600).animate({
        opacity: 1
    }, 300);

    $(".about_info_safe").delay(900).animate({
        opacity: 1
    }, 300);

    $(".about_info_stats").delay(1100).animate({
        opacity: 1
    }, 300);

    $(".about_info_short").delay(1300).animate({
        opacity: 1
    }, 300);

     $("h1.header2").delay(1600).animate({
        opacity: 1
    }, 300);

    $("a.button").delay(1800).animate({
        opacity: 1
    }, 300);

     $("footer").delay(180).animate({
        opacity: 1
    }, 300);







    
    //$("#link").each(function () {
    //    setTimeout(function () {this.focus()}, 1000); 
    //});

	if($("#link").val() == null || $("#link").val() == "") {
		disableInputSingle("#submit", true);
	}

    $(document).on("keyup click", function () {


        /* Validating textareas for correct CSS */
        var test="#link";
        if(validateLink($(test).val())) {
            ok(test);
        } else {
            removeC(test);
        }


        /* Validation for submit button */
        if (validateLink($(test).val()) && $(test).val() != "") {
            disableInputSingle("#submit", false);
        } else {
            disableInputSingle("#submit", true);
        }

    });
});

function disableInputSingle(b, a) {
    $(b).prop("disabled", a)
}

function validateLink(a) {
    if (a == null || a == "") {
        return false
    }
    var b = /^(https?:\/\/)?([\da-zåäöA-ZÅÄÖ0-9\.-]+)\.([a-zA-Z0-9\.]{1,6})([\/\w \.-]*)*\/?$/;
    return b.test(a)
}

function ok(a){
    removeC(a);
    $(a).addClass("ok");
}

function removeC(a) {
    $(a).removeClass("ok");
    $(a).removeClass("deny");
}