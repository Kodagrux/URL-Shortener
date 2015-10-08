/*
    Author: Albin Hubsch (http://www.albinhubsch.se)
    Modification: Arvid Bräne (http://www.arvidbrane.se)
*/



$(document).ready(function () {

    disableInputSingle("#submit", true);
    
    var b = {
        Version: function () {
            var c = 999;
            if (navigator.appVersion.indexOf("MSIE") != -1) {
                c = parseFloat(navigator.appVersion.split("MSIE")[1])
            }
            return c
        }
    };
    if (b.Version() < 9) {
        setTimeout(function () {
            alert("You're using an outdated version of Internet Explorer. Please update or change your webbrowser.\notherwise you may not be able to complete the registration")
        }, 700)
    }

    $(document).on("keyup click", function () {
        var test = "";

        /* Validating textareas for correct CSS */
        test = "#fName";        
        if($(test).val() != null && $(test).val() != ""){
            if(validateFName($(test).val())) {
                ok(test);
            } else {
                removeC(test);
            }
        } else {
            removeC(test);
        }

        test="#eMail";
        if($(test).val() != null && $(test).val() != ""){
            if( validateEmail($(test).val())) {
                   ok(test);
            } else {
                removeC(test);
            }
        } else {
            removeC(test);
        }

        test="#pass";
        if($(test).val() != null && $(test).val() != ""){
            if(validatePassword($(test).val())) {
                ok(test);
            } else {
                removeC(test);
            }
        } else {
            removeC(test);
        }

        test="#pass2";
        if($(test).val() != null && $(test).val() != ""){
            if($(test).val() == $("#pass").val()) {
                ok(test);
            } else {
                deny(test);
            }
        } else {
            removeC(test);
        }



        /* Validation for submit button */
        if (validateFName($("#fName").val()) && validateEmail($("#eMail").val()) && validatePassword($("#pass").val()) && validatePassword($("#pass2").val()) && $("#pass").val() == $("#pass2").val() && validateUName($("#uName").val()) && $("#recaptcha_response_field").val() != "" && $("#recaptcha_response_field").val() != null) {
            disableInputSingle("#submit", false);
        } else {
            disableInputSingle("#submit", true);
        }

    });
});

function disableInput(b, a) {
    $(b + " input").prop("disabled", a);
}

function disableInputSingle(b, a) {
    $(b).prop("disabled", a)
}

function validateEmail(a) {
    if (a == null || a == "" || a.length > 40) {
        return false
    }
    var b = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zåäöA-ZÅÄÖ\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return b.test(a)
}

function validateUName(a) {
    if (a == null || a == "") {
        return false
    }
    var b = /^[A-Za-z0-9_-]{5,25}$/;
    return b.test(a)
}

function validateFName(b) {
    if (b == null || b == "" || b.length < 4 || b.length > 40) {
        return false
    }
    var a = /[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i;
    return !a.test(b)
}

function validatePassword(b) {
    if (b == null || b == "") {
        return false
    }
    var a = /^[a-zA-Z0-9_-]{6,25}$/;
    return a.test(b)
}

function deny(a){
    removeC(a);
    $(a).addClass("deny");
}

function ok(a){
    removeC(a);
    $(a).addClass("ok");
}

function removeC(a) {
    $(a).removeClass("ok");
    $(a).removeClass("deny");
}

function checkAvailability(str) {

    test="#uName";
    if($(test).val() != null && $(test).val() != ""){
        if(validateUName($(test).val())) {
            ok(test);
        } else {
            removeC(test);
        }
    } else {
        removeC(test);
    }

    if (str.length < 5) { 
        document.getElementById("uName_check").innerHTML = "";
        return;
    }

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            //alert("'" + xmlhttp.responseText + "'");

            if (xmlhttp.responseText == 1) {
                document.getElementById("uName_check").innerHTML = "<span class='green'>Available</span>";
                ok("#uName");
            } else if (xmlhttp.responseText == 0) {
                document.getElementById("uName_check").innerHTML = "<span class='red'>Taken</span>";
                deny("#uName");
            }
        }
    }

    xmlhttp.open("GET", "checkAvailability.php?q=" + str, true);
    xmlhttp.send();
}