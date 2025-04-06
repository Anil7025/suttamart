var $ = jQuery.noConflict();
var RecordId = '';
var BulkAction = '';
var ids = [];

$(function () {
	"use strict";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	resetForm("DataEntry_formId");
	
	$("#submit-form").on("click", function () {
        $("#DataEntry_formId").submit();
    });
	
	$(document).on('click', '.users_pagination nav ul.pagination a', function(event){
		event.preventDefault(); 
		var page = $(this).attr('href').split('page=')[1];
		onPaginationDataLoad(page);
	});
		
	$('input:checkbox').prop('checked',false);
	
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });

	$("#offer_ad_type").chosen();
	$("#offer_ad_type").trigger("chosen:updated");
	
	$("#is_publish").chosen();
});

function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
	$.ajax({
		url:base_url + "/admin/getOfferAdsTableData?page="+page,
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}
function onRefreshData() {
    $.ajax({
        url: "/admin/getOfferAdsTableData",
        success: function (data) {
            $('#tp_datalist').html(data); // Update table
            onCheckAll(); // Ensure checkboxes work if needed
            console.log("Data refreshed successfully!");
        },
        error: function (xhr, status, error) {
            console.error("Failed to refresh data:", xhr.responseText);
        }
    });
}

function onSearch() {
	var search = $("#search").val();
	$.ajax({
		url: base_url + "/admin/getOfferAdsTableData?search="+search,
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function resetForm(id) {
    $('#' + id).each(function () {
        this.reset();
    });
	
	$("#offer_ad_type").trigger("chosen:updated");
	$("#is_publish").trigger("chosen:updated");
}

function onListPanel() {
	$('.parsley-error-list').hide();
    $('#list-panel, .btn-form').show();
    $('#form-panel, .btn-list').hide();
}

function onFormPanel() {
    resetForm("DataEntry_formId");
	RecordId = '';
	
	$("#remove_offer_image").hide();
	$("#offer__image").html('');
	
	$("#offer_ad_type").trigger("chosen:updated");
	$("#is_publish").trigger("chosen:updated");
	
    $('#list-panel, .btn-form').hide();
    $('#form-panel, .btn-list').show();
}

function onEditPanel() {
    $('#list-panel, .btn-form').hide();
    $('#form-panel, .btn-list').show();	
}


function showPerslyError() {
    $('.parsley-error-list').show();
}

jQuery('#DataEntry_formId').parsley({
    listeners: {
        onFieldValidate: function (elem) {
            if (!$(elem).is(':visible')) {
                return true;
            }
            else {
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

$(document).ready(function () {
	$("#submit-form").click(function () {
		onConfirmWhenAddEdit();
	});
});

function onConfirmWhenAddEdit() {
    var formData = new FormData($('#DataEntry_formId')[0]);

    $.ajax({
        type: "POST",
        url: "/admin/saveOfferAdsData", 
        data: formData,
        processData: false, 
        contentType: false, 
        beforeSend: function () {
            $("#submit-form").text("Saving...").attr("disabled", true);
        },
        success: function (response) {
            console.log("Server Response:", response); // Debugging log

            var msgType = response.msgType; // Fix msgTypes to msgType
            var msg = response.msg;

            if (msgType === "success") {
                setTimeout(function () {
                    console.log("Success: " + msg);

                    $('#DataEntry_formId')[0].reset(); // Reset form
                    onRefreshData(); // Refresh table
                    onSuccessMsg(msg); // Show success message
                    onListPanel(); // Hide form and show list panel
                }, 1000); // Reduce delay to 1 sec for better UX
            } else {
                console.error("Error: " + msg);
            }
        },
        complete: function () {
            $("#submit-form").text("Save").attr("disabled", false);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
            alert("Something went wrong! " + xhr.responseText);
        }
    });
}



function onEdit(id) {
	RecordId = id;
	var msg = TEXT["Do you really want to edit this record"];
	onCustomModal(msg, "onLoadEditData");
}

function onLoadEditData() {
    $.ajax({
		type: 'POST',
		url: base_url + '/admin/getOfferAdsById',
		data: { id: RecordId },
		success: function (response) {
			var data = response;

			// Fill form fields with data
			$("#RecordId").val(data.id);
			$("#title").val(data.title);
			$("#description").val(data.description);
			$("#is_publish").val(data.is_publish).trigger("chosen:updated");
			$("#url").val(data.url);

			// Handle Image Preview
			if (data.image) {
				$("#view_offer_image").html('<img src="'+base_url+'/uploads/offerimages/'+data.image+'" class="img-fluid">');
				$("#remove_offer_image").show();
			} else {
				$("#view_offer_image").html('');
				$("#remove_offer_image").hide();
			}

			onEditPanel();
		}
    });
}

function onDelete(id) {
	RecordId = id;
	var msg = TEXT["Do you really want to delete this record"];
	onCustomModal(msg, "onConfirmDelete");	
}

function onConfirmDelete() {

    $.ajax({
		type : 'POST',
		url: base_url + '/admin/deleteOfferAds',
		data: 'id='+RecordId,
		success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;

			if(msgType == "success"){
				onSuccessMsg(msg);
				onRefreshData();
			}else{
				onErrorMsg(msg);
			}
			
			onCheckAll();
		}
    });
}



function onConfirmBulkAction() {

    $.ajax({
		type : 'POST',
		url: base_url + '/admin/bulkActionOfferAds',
		data: 'ids='+ids+'&BulkAction='+BulkAction,
		success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;

			if(msgType == "success"){
				onSuccessMsg(msg);
				onRefreshData();
				ids = [];
			}else{
				onErrorMsg(msg);
			}
			
			onCheckAll();
		}
    });
}

$(document).ready(function () {
    // Handle Image Selection
    $("#offer_image").change(function (event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#view_offer_image").html('<img src="' + e.target.result + '" style="max-width:100px; max-height:100px;"/>');
                $("#remove_offer_image").show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove Selected Image
    $("#removeImageBtn").click(function () {
        $("#offer_image").val(""); // Clear file input
        $("#view_offer_image").html(""); // Remove preview image
        $("#remove_offer_image").hide(); // Hide remove button
    });
});
