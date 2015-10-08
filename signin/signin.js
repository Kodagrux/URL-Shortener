/*
    Author: Albin Hubsch (http://www.albinhubsch.se)
    Modifications: Arvid Bräne (http://www.arvidbrane.se)
*/

$(document).ready(function () {


    $(document).on("keyup click", function () {
        inputTester();
    });

    $("input").change( function() {
        //inputTester();
        if(($("#uName").val() == null || $("#uName").val() == "") || ($("#pass").val() == null || $("#pass").val() == "")) {
            disableInputSingle("#submit", true);
        }
    });

});

function inputTester(){
        //alert($("#uName").val());   

        
        var test = "";

        /* Validating textareas for correct CSS */
        test="#uName";
        if($(test).val() != null && $(test).val() != ""){
            if( validateEmail($(test).val())) {
                   ok(test);
            } else {
                if(validateUName($(test).val())) {
                    ok(test);
                }
            }
        } else {
            removeC(test);
        }

        test="#pass";
        if($(test).val() != null && $(test).val() != ""){
            if(validatePassword($(test).val())) {
                ok(test);
            }
        } else {
            removeC(test);
        }


        /* Validation for submit button */
        if ((validateEmail($("#uName").val()) || validateUName($("#uName").val())) && validatePassword($("#pass").val())) {
            disableInputSingle("#submit", false);

        } else {
            disableInputSingle("#submit", true);
        }
}


function disableInputSingle(b, a) {
    $(b).prop("disabled", a)
}

function validateEmail(a) {
    if (a == null || a == "" || a.length > 40) {
        return false
    }
    var b = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return b.test(a)
}

function validateUName(a) {
    if (a == null || a == "") {
        return false
    }
    var b = /^[A-Za-z0-9_-]{5,25}$/;
    return b.test(a)
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