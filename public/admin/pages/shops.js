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

	$("#is_featured").chosen();
	$("#is_featured").trigger("chosen:updated");
	
	$("#is_publish").chosen();
	$("#is_publish").trigger("chosen:updated");
	
	
});

function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
	$.ajax({
		url:base_url + "/admin/getShopsTableData?page="+page,
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onRefreshData() {
	$.ajax({
		url:base_url + "/admin/getShopsTableData?search="+$("#search").val(),
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onSearch() {
	var search = $("#search").val();
	$.ajax({
		url: base_url + "/admin/getShopsTableData?search="+$("#search").val(),
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
	
	$("#is_featured").trigger("chosen:updated");
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
	
	$("#remove_shop_logo").hide();
	$("#shop_logo").html('');
	
	$("#is_featured").trigger("chosen:updated");
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
        url: "/admin/saveShopsData", 
        data: formData,
        processData: false, 
        contentType: false, 
        beforeSend: function () {
            $("#submit-form").text("Saving...").attr("disabled", true);
        },
        success: function (response) {
            var msgType = response.msgTypes;
            var msg = response.msg;

            if (msgType == "success") {
                setTimeout(function () {
                    console.log("Success: " + msg);
                    $('#DataEntry_formId')[0].reset(); 
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
		url: base_url + '/admin/getShopsById',
		data: 'id='+RecordId,
		success: function (response) {
			var data = response;
			$("#RecordId").val(data.id);
			$("#name").val(data.name);
			$("#email").val(data.email);
			$("#mobile").val(data.mobile);
			$("#address").val(data.address);
			$("#is_publish").val(data.is_publish).trigger("chosen:updated");
			
 			if(data.thumbnail != null){
				$("#shop_logo").val(data.thumbnail);
				$("#view_shop_logo").html('<img src="'+public_path+'/uploads/shops/'+data.thumbnail+'">');
				$("#remove_shop_logo").show();
			}else{
				$("#shop_logo").val('');
				$("#view_shop_logo").html('');
				$("#remove_shop_logo").hide();
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
		url: base_url + '/admin/deleteShops',
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
		url: base_url + '/admin/bulkActionShops',
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
    $("#shop_logo").change(function (event) {
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#view_shop_logo").html('<img src="' + e.target.result + '" style="max-width:100px; max-height:100px;"/>');
                $("#remove_shop_logo").show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove Selected Image
    $("#removeImageBtn").click(function () {
        $("#shop_logo").val(""); // Clear file input
        $("#view_shop_logo").html(""); // Remove preview image
        $("#remove_shop_logo").hide(); // Hide remove button
    });
});

document.getElementById('mobile').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 10); // Removes non-digits and limits to 10 digits
});

