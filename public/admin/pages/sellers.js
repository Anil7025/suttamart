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
	
	$('.toggle-password').on('click', function() {
		$(this).toggleClass('fa-eye-slash');
			let input = $($(this).attr('toggle'));
		if (input.attr('type') == 'password') {
			input.attr('type', 'text');
		}else {
			input.attr('type', 'password');
		}
	});
});

function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
	$.ajax({
		url:base_url + "/admin/getSellersTableData?page="+page,
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onRefreshData() {
    console.log("Refreshing data..."); // Debugging

    $.ajax({
        url: base_url + "/admin/getSellersTableData?search="+$("#search").val()+"&status="+$("#view_by_status").val(),
        type: "GET",
        dataType: "html",
        success: function (data) {
            console.log("Data fetched successfully:", data); // Debugging
            $("#tp_datalist").html(data);
            onCheckAll(); // Ensure this function is defined properly
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", xhr.responseText);
        }
    });
}



function onSearch() {

	$.ajax({
		url: base_url + "/admin/getSellersTableData?search="+$("#search").val()+"&status="+$("#view_by_status").val(),
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onDataViewByStatus(status) {

	$(".orderstatus").removeClass('active')
	$("#orderstatus_"+status).addClass('active');
	
	$.ajax({
		url: base_url + "/admin/getSellersTableData?search="+$("#search").val(),
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

function onConfirmWhenAddEdit() {
    var formData = new FormData($('#DataEntry_formId')[0]);
    
    $.ajax({
        type: 'POST',
        url: base_url + '/admin/saveSellersData',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#submit-form").text("Saving...").prop("disabled", true);
        },
        success: function (response) {           
            var msgType = response.msgType;
            var msg = response.msg;

            if (msgType === "success") {
                setTimeout(function () {
                    console.log("Success: " + msg);
                    $('#DataEntry_formId')[0].reset();
                    onRefreshData();
                    onSuccessMsg(msg);
                    location.reload();
                }, 1000);
            } else {
                console.log("Error: " + msg);
                onErrorMsg(msg);
            }
        },
        complete: function () {
            $("#submit-form").text("Save").prop("disabled", false);
        },
        error: function (xhr, status, error) {
            alert("Something went wrong! " + xhr.responseText);
            $("#submit-form").text("Save").prop("disabled", false);
        }
    });
}

// Bind event listener for form submission
$(document).ready(function () {
    $("#submit-form").on("click", function () {
        onConfirmWhenAddEdit();
    });
});



function onEdit(id) {
	RecordId = id;
	var msg = TEXT["Do you really want to edit this record"];
	onCustomModal(msg, "onLoadEditData");	
}

function onLoadEditData() {

    $.ajax({
		type : 'POST',
		url: base_url + '/admin/getSellerById',
		data: 'id='+RecordId,
        success: function (response) {
           
            var seller_data = response;

            // Populate form fields
            $("#RecordId").val(seller_data.id);
            $("#name").val(seller_data.name);
            $("#email").val(seller_data.email);
            $("#password").val(seller_data.bactive); // Security: Keep password empty
            $("#phone").val(seller_data.mobile);
            $("#shop_name").val(seller_data.shop).trigger("change");
            $("#address").val(seller_data.address);
            $("#city").val(seller_data.district);
            $("#state").val(seller_data.state);
            $("#pin_code").val(seller_data.pincode);
            $("#status_id").val(seller_data.status).trigger("change");

            if (seller_data.image && seller_data.image.trim() !== "") {
                let imagePath = base_url + '/uploads/sellers/' + seller_data.image;
                $("#view_photo_thumbnail").html(`<img src="${imagePath}" width="100" class="img-thumbnail">`);
                $("#remove_photo_thumbnail").show();
            } else {
                $("#view_photo_thumbnail").html('');
                $("#remove_photo_thumbnail").hide();
            }


            // Status Update
            if (seller_data.status == 1) {
                $("#seller_status").removeClass("inactive").addClass("active").text("Active");
            } else {
                $("#seller_status").removeClass("active").addClass("inactive").text("Inactive");
            }

            // Open Edit Panel
            onEditPanel();
        },
        error: function (xhr, status, error) {
            console.log("AJAX Error:", xhr.responseText);
            alert("Failed to load seller data. Please try again.");
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
		url: base_url + '/admin/deleteSeller',
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
		url: base_url + '/admin/bulkActionSellers',
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