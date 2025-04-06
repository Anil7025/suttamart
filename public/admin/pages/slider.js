var $ = jQuery.noConflict();
var RecordId = '';
var BulkAction = '';
var ids = [];
var image_type = '';

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

	$(document).on('click', '.tp_pagination nav ul.pagination a', function(event){
		event.preventDefault(); 
		var page = $(this).attr('href').split('page=')[1];
		onPaginationDataLoad(page);
	});
	
	$('input:checkbox').prop('checked',false);
	
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });

	$("#is_publish").chosen();
	$("#is_publish").trigger("chosen:updated");
	
	onRefreshData();
});

function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
    $.ajax({
        url: base_url + "/admin/getSliderTableData?page=" + page,
        dataType: "html", 
        success: function (data) {
            $('#tp_datalist').html(data);
            onCheckAll();
        },
        error: function (xhr) {
            alert("Something went wrong! " + xhr.responseText);
        }
    });
}

function onRefreshData() {
    $.ajax({
        url: base_url + "/admin/getSliderTableData",
        type: "GET",
        data: { search: $("#search").val() }, 
        dataType: "html",
        success: function (data) {
            $('#tp_datalist').html(data);
            onCheckAll();
        },
        error: function (xhr) {
            alert("Error: " + xhr.responseText);
        }
    });
}

function onSearch() {
    $.ajax({
        url: base_url + "/admin/getSliderTableData",
        type: "GET",
        data: { search: $("#search").val() },
        dataType: "html",
        success: function (data) {
            $('#tp_datalist').html(data);
            onCheckAll();
        },
        error: function (xhr) {
            alert("Error: " + xhr.responseText);
        }
    });
}


function resetForm(id) {
    $('#' + id).each(function () {
        this.reset();
    });
	
	$("#is_publish").trigger("chosen:updated");
}

function onListPanel() {
    $('#list-panel, .btn-form').show();
    $('#form-panel, .btn-list').hide();
}

function onFormPanel() {
    resetForm("DataEntry_formId");
	
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
        url: base_url + '/admin/saveSliderData', 
        data: formData,
        processData: false, 
        contentType: false, 
        dataType: "json", // Ensure response is parsed correctly
        beforeSend: function () {
            $("#submit-form").text("Saving...").attr("disabled", true);
        },
        success: function (response) {
            var msgType = response.msgType; // ✅ Fixed inconsistent key
            var msg = response.msg;

            if (msgType === "success") {
                setTimeout(function () {
                    console.log("Success: " + msg);
                    $('#DataEntry_formId')[0].reset();
                    onRefreshData();
                    onSuccessMsg(msg);
                    onListPanel();
                }, 2000);
            } else {
                console.log("Error: " + msg);
                onErrorMsg(msg); // Optional error handling function
            }
        },
        complete: function () {
            $("#submit-form").text("Save").attr("disabled", false);
        },
        error: function (xhr) {
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
        url: base_url + '/admin/getSliderById',
        data: { id: RecordId },
        dataType: 'json', // Ensure response is JSON
        success: function (response) {
            if (response) {
                $("#RecordId").val(response.id);
                $("#title").val(response.title);
                $("#description").val(response.description);
                $("#url").val(response.url);
                $("#is_publish").val(response.is_publish).trigger("chosen:updated");

                if (response.image) {
                    $("#view_slider_image").html('<img src="' + base_url + '/uploads/sliders/' + response.image + '" style="max-width:100px;">');
                    $("#remove_slider_image").show();
                } else {
                    $("#view_slider_image").html('');
                    $("#remove_slider_image").hide();
                }

                // Show the edit panel
                onEditPanel();
            } else {
                alert("Error: Unable to fetch record data.");
            }
        },
        error: function (xhr, status, error) {
            alert("Something went wrong! " + xhr.responseText);
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
		url: base_url + '/admin/deleteSlider',
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

function onBulkAction() {
	ids = [];
	$('.selected_item:checked').each(function(){
		ids.push($(this).val());
	});

	if(ids.length == 0){
		var msg = TEXT["Please select record"];
		onErrorMsg(msg);
		return;
	}
	
	BulkAction = $("#bulk-action").val();
	if(BulkAction == ''){
		var msg = TEXT["Please select action"];
		onErrorMsg(msg);
		return;
	}
	
	if(BulkAction == 'publish'){
		var msg = TEXT["Do you really want to publish this records"];
	}else if(BulkAction == 'draft'){
		var msg = TEXT["Do you really want to draft this records"];
	}else if(BulkAction == 'delete'){
		var msg = TEXT["Do you really want to delete this records"];
	}
	
	onCustomModal(msg, "onConfirmBulkAction");	
}

function onConfirmBulkAction() {

    $.ajax({
		type : 'POST',
		url: base_url + '/admin/bulkActionSlider',
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
    $("#slider_image").change(function (event) {
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#view_slider_image").html('<img src="' + e.target.result + '" style="max-width:100px; max-height:100px;"/>');
                $("#remove_slider_image").show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove Selected Image
    $("#removeImageBtn").click(function () {
        $("#slider_image").val(""); // Clear file input
        $("#view_slider_image").html(""); // Remove preview image
        $("#remove_slider_image").hide(); // Hide remove button
    });
});

