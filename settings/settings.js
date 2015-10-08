$(document).ready(function () {

    disableInputSingle("#submit", true);

    $(document).on("keyup click", function () {
        var test = "";

        /* Validating textareas for correct CSS */
        test = "#bio";        
        if($(test).val() != null && $(test).val() != ""){
            if(validateBIO($(test).val())) {
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
        if (((validateBIO($("#bio").val()) || $("#bio").val() == null || $("#bio").val() == "") && 
            ((validatePassword($("#pass").val()) && validatePassword($("#pass2").val()) && $("#pass").val() == $("#pass2").val()) || 
            (($("#pass2").val() == "" || $("#pass2").val() == null) && ($("#pass").val() == "" || $("#pass").val() == null)))) || 
            ($("#pass").val() != "" && $("#pass2").val() != "" && $("#bio").val() != "")) {
            disableInputSingle("#submit", false);
        } else {
            disableInputSingle("#submit", true);
        }

    });
});

function disableInputSingle(b, a) {
    $(b).prop("disabled", a)
}

function validateBIO(b) {
    if (b == null || b == "" || b.length > 300) {
        return false
    }
    return true;
}

function validatePassword(b) {
    if (b == null || b == "") {
        return false
    }
    var a = /^[a-z0-9_-]{6,25}$/;
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












