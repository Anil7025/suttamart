var $ = jQuery.noConflict();

$(function () {
	"use strict";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$("#submit-form").on("click", function () {
        $("#DataEntry_formId").submit();
    });

	
});


function showPerslyError() {
    $('.parsley-error-list').show();
}

jQuery('#DataEntry_formId').parsley({
    listeners: {
        onFieldValidate: function (elem) {
            if (!$(elem).is(':visible')) {
                return true;
            } else {
                showPerslyError();
                return false;
            }
        },
        onFormSubmit: function (isFormValid, event) {
            if (isFormValid) {
                onConfirmWhenAddEdit();
                return false;
            }
        }
    }
});

function onConfirmWhenAddEdit() {
    $.ajax({
        type: 'POST',
        url: base_url + '/admin/saveProductSEOData',
        data: $('#DataEntry_formId').serialize(),
        success: function(response) {            
            var msgType = response.msgType;
            var msg = response.msg;

            if (msgType === "success") {
                onSuccessMsg(msg);

                // Log redirection
                console.log("Redirecting to:", base_url + "/admin/products");

                // Redirect with delay
                setTimeout(function() {
                    window.location.replace(base_url + "/admin/products");
                }, 1000);
            } else {
                onErrorMsg(msg);
            }
        },
        error: function(xhr) {
            console.error("AJAX Error:", xhr.responseText);
        }
    });
}


