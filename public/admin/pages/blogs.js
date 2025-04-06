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

	$(document).on('click', '.ProductCategories nav ul.pagination a', function(event){
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
	
	$("#category_id").chosen();
	$("#category_id").trigger("chosen:updated");
	
	$("#on_thumbnail").on("click", function () {
		media_type = 'Blog_Thumbnail';
		onGlobalMediaModalView();
    });

	$("#on_og_image").on("click", function () {
		media_type = 'SEO_Image';
		onGlobalMediaModalView();
    });
	
	$("#blog_title").on("blur", function () {
		if(RecordId ==''){
			onCategorySlug();
		}
	});
		onRefreshData();
	
	//Summernote
	$('#description').summernote({
		codeviewFilter: true,
		codeviewFilterRegex: /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*?>/gi,
		codeviewIframeFilter: true,
		codeviewIframeWhitelistSrc: [],
		tabDisable: false,
		height: 300,
		toolbar: [
		  ['style', ['style']],
		  ['font', ['bold', 'italic', 'underline', 'clear']],
		  ['para', ['ul', 'ol', 'paragraph']],
		  ['table', ['table']],
		  ['insert', ['link', 'unlink']],
		]
	});
});

function onCheckAll() {
    $(".checkAll").on("click", function () {
        $("input:checkbox").not(this).prop("checked", this.checked);
    });
}

function onPaginationDataLoad(page) {
	$.ajax({
		url:base_url + "/admin/getBlogTableData?page="+page
		+"&search="+$("#search").val(),
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onRefreshData() {
	$.ajax({
		url:base_url + "/admin/getBlogTableData?search="+$("#search").val(),
		success:function(data){
			$('#tp_datalist').html(data);
			onCheckAll();
		}
	});
}

function onSearch() {
	$.ajax({
		url: base_url + "/admin/getBlogTableData?search="+$("#search").val(),
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
	
	$("#lan").trigger("chosen:updated");
	$("#is_publish").trigger("chosen:updated");
	$("#category_id").trigger("chosen:updated");
}

function onListPanel() {
	$('.parsley-error-list').hide();
    $('#list-panel, .btn-form').show();
    $('#form-panel, .btn-list').hide();
}

function onFormPanel() {
    resetForm("DataEntry_formId");
	RecordId = '';
	
	$("#remove_category_thumbnail").hide();
	$("#category_thumbnail").html('');
	
	$("#remove_subheader_image").hide();
	$("#subheader_image").html('');
	
	$('#description').summernote('reset');
	$("#is_publish").trigger("chosen:updated");
	$("#category_id").trigger("chosen:updated");

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
		type : 'POST',
		url: base_url + '/admin/saveBlogData',
		data: formData,
        processData: false, 
        contentType: false, 
        beforeSend: function () {
            $("#submit-form").text("Saving...").attr("disabled", true);
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
                    onListPanel(); 
					location.reload();
                }, 1000); 
            } else {
                console.error("Error: " + msg);
            }
			onCheckAll();
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
		type : 'POST',
		url: base_url + '/admin/getBlogById',
		data: 'id='+RecordId,
		success: function (response) {
			var data = response;
			$("#RecordId").val(data.id);
			$("#blog_title").val(data.title);
			$("#slug").val(data.slug);
			$("#is_publish").val(data.is_publish).trigger("chosen:updated");
			$("#category_id").val(data.category_id).trigger("chosen:updated");
			
			if(data.description != null){
				$('#description').summernote('code', data.description);
			}else{
				$('#description').summernote('code', '');
			}

			if (data.image) {
				$("#view_category_thumbnail").html('<img src="'+base_url+'/uploads/blogs/'+data.image+'" class="img-fluid">');
				$("#remove_category_thumbnail").show();
			} else {
				$("#view_category_thumbnail").html('');
				$("#remove_category_thumbnail").hide();
			}

			if(data.og_title != null){
				$("#og_title").val(data.og_title);
			}else{
				$("#og_title").val('');
			}
			
			if(data.og_keywords != null){
				$("#og_keywords").val(data.og_keywords);
			}else{
				$("#og_keywords").val('');
			}
			
			if(data.og_description != null){
				$("#og_description").val(data.og_description);
			}else{
				$("#og_description").val('');
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
		url: base_url + '/admin/deleteBlog',
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
		url: base_url + '/admin/bulkActionBlog',
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

//Slug
function onCategorySlug() {
	var StrName = $("#blog_title").val();
	var str_name = StrName.trim();
	var strLength = str_name.length;
	if(strLength>0){
		$.ajax({
			type : 'POST',
			url: base_url + '/admin/hasBlogSlug',
			data: 'slug='+StrName,
			success: function (response) {
				var slug = response.slug;
				$("#slug").val(slug);
			}
		});
	}
}

$(document).ready(function () {
    // Handle Image Selection
    $("#category_thumbnail").change(function (event) {
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#view_category_thumbnail").html('<img src="' + e.target.result + '" style="max-width:100px; max-height:100px;"/>');
                $("#remove_category_thumbnail").show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove Selected Image
    $("#removeImageBtn").click(function () {
        $("#category_thumbnail").val(""); // Clear file input
        $("#view_category_thumbnail").html(""); // Remove preview image
        $("#remove_category_thumbnail").hide(); // Hide remove button
    });
});