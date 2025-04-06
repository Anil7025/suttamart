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

	$("#status_id").chosen();
	$("#status_id").trigger("chosen:updated");
	
	$("#role_id").chosen();
	$("#role_id").trigger("chosen:updated");
	
	$('.toggle-password').on('click', function() {
		$(this).toggleClass('fa-eye-slash');
			let input = $($(this).attr('toggle'));
		if (input.attr('type') == 'password') {
			input.attr('type', 'text');
		}else {
			input.attr('type', 'password');
		}
	});
	
	
	$("#media_select_file").on("click", function () {	
		var thumbnail = $("#thumbnail").val();

		if(thumbnail !=''){
			$("#photo_thumbnail").val(thumbnail);
			$("#view_photo_thumbnail").html('<img src="'+public_path+'/uploads/users/'+thumbnail+'">');
		}

		$("#remove_photo_thumbnail").show();
		$('#global_media_modal_view').modal('hide');
    });
	
});

function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
	$.ajax({
		url:base_url + "/admin/getUsersTableData?page="+page,
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onRefreshData() {
	$.ajax({
		url:base_url + "/admin/getUsersTableData",
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onSearch() {
	var search = $("#search").val();
	$.ajax({
		url: base_url + "/admin/getUsersTableData?search="+search,
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
	
	$("#status_id").trigger("chosen:updated");
	$("#role_id").trigger("chosen:updated");
}

function onListPanel() {
	$('.parsley-error-list').hide();
    $('#list-panel, .btn-form').show();
    $('#form-panel, .btn-list').hide();
}

function onFormPanel() {
	var passtype = $('#password').attr('type');
	if(passtype == 'text'){
		$(".toggle-password").removeClass("fa-eye-slash");
		$(".toggle-password").addClass("fa-eye");
		$('#password').attr('type', 'password');
	}
	
    resetForm("DataEntry_formId");
	RecordId = '';
	
	$("#status_id").trigger("chosen:updated");

	$("#remove_photo_thumbnail").hide();
	$("#photo_thumbnail").html('');
	
    $('#list-panel, .btn-form').hide();
    $('#form-panel, .btn-list').show();
}

function onEditPanel() {
    $('#list-panel, .btn-form').hide();
    $('#form-panel, .btn-list').show();	
}

function onMediaImageRemove(type) {
	$('#photo_thumbnail').val('');
	$("#remove_photo_thumbnail").hide();
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
		url: "/admin/saveUsersData", // Update with your correct route
		data: formData,
		processData: false,  // Important: Don't process data
		contentType: false,  // Important: Don't set content type manually
		beforeSend: function () {
			$("#submit-form").text("Saving...").attr("disabled", true);
		},
		success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;

			if (msgType == "success") {
				setTimeout(function () {
				console.log("Success: " + msg);
				$('#DataEntry_formId')[0].reset(); // Reset form
				onRefreshData();
				onSuccessMsg(msg);
				onListPanel();
                }, 3000);
			} else {
				console.log("Error: " + msg);
			}
		},
		complete: function () {
			$("#submit-form").text("Save").attr("disabled", false);
		},
		error: function (xhr, status, error) {
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
		type : 'POST',
		url: base_url + '/admin/getUserById',
		data: 'id='+RecordId,
		success: function (response) {

			var data = response;
			var passtype = $('#password').attr('type');
			if(passtype == 'text'){
				$(".toggle-password").removeClass("fa-eye-slash");
				$(".toggle-password").addClass("fa-eye");
				$('#password').attr('type', 'password');
			}
	
			$("#RecordId").val(data.id);
			$("#name").val(data.name);
			$("#email").val(data.email);
			$("#password").val(data.password);
			$("#phone").val(data.mobile);
			$("#address").val(data.address);
			$("#pincode").val(data.pincode);
			$("#state").val(data.state);
			$("#country").val(data.country);
			$("#status").val(data.status).trigger("chosen:updated");

			if (data.image != null) {
				let imageUrl = '/storage/uploads/users/' + data.image; // Corrected path
				$("#photo_thumbnail").val(data.image);
				$("#view_photo_thumbnail").html('<img src="' + imageUrl + '" style="max-width:100px; max-height:100px;">');
				$("#remove_photo_thumbnail").show();
			} else {
				$("#photo_thumbnail").val('');
				$("#view_photo_thumbnail").html('');
				$("#remove_photo_thumbnail").hide();
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
		url: base_url + '/admin/deleteUser',
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
	
	if(BulkAction == 'active'){
		var msg = TEXT["Do you really want to active this records"];
	}else if(BulkAction == 'inactive'){
		var msg = TEXT["Do you really want to inactive this records"];
	}else if(BulkAction == 'delete'){
		var msg = TEXT["Do you really want to delete this records"];
	}
	
	onCustomModal(msg, "onConfirmBulkAction");	
}

function onConfirmBulkAction() {

    $.ajax({
		type : 'POST',
		url: base_url + '/admin/bulkActionUsers',
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
    $("#photo_thumbnail").change(function (event) {
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#view_photo_thumbnail").html('<img src="' + e.target.result + '" style="max-width:100px; max-height:100px;"/>');
                $("#remove_photo_thumbnail").show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove Selected Image
    $("#removeImageBtn").click(function () {
        $("#photo_thumbnail").val(""); // Clear file input
        $("#view_photo_thumbnail").html(""); // Remove preview image
        $("#remove_photo_thumbnail").hide(); // Hide remove button
    });
});


document.getElementById('pincode').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 6); // Removes non-digits and limits to 6 digits
});
