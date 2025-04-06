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
	
	$("#title").on("blur", function () {
		if(RecordId ==''){
			onPageTitleSlug();
		}
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
	
	$("#ViewByPostStatus").val(0);
	
		
	//Summernote
	$('#content').summernote({
		codeviewFilter: true,
		codeviewFilterRegex: /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*?>/gi,
		codeviewIframeFilter: true,
		codeviewIframeWhitelistSrc: [],
		tabDisable: false,
		height: 200,
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
		url: base_url + "/admin/getPagePaginationData?page="+page
		+"&post_status="+$("#ViewByPostStatus").val()
		+"&search="+$("#search").val(),
		success:function(data){
			$('#page_datalist').html(data);
			onCheckAll();
		}
	});
}

function onRefreshData() {
    let postStatus = $("#ViewByPostStatus").val();
    let searchQuery = $("#search").val();
    
    $.ajax({
        url: `${base_url}/admin/getPagePaginationData`,
        type: "GET",
        data: {
            post_status: postStatus,
            search: searchQuery
        },
        success: function (data) {
			location.reload();
            $('#page_datalist').html(data);
            onCheckAll();
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
}


function onSearch() {
	$.ajax({
		url: base_url + "/admin/getPagePaginationData?search="+$("#search").val()
		+"&post_status="+$("#ViewByPostStatus").val(),
		success:function(data){
			$('#page_datalist').html(data);
			onCheckAll();
		}
	});
}

function onDataViewByStatus(post_status) {
	$("#ViewByPostStatus").val(post_status);
	
	$(".viewstatus").removeClass('active')
	$("#viewstatus_"+post_status).addClass('active');
	
	$.ajax({
		url: base_url + "/admin/getPagePaginationData?post_status="+post_status
		+"&search="+$("#search").val(),
		success:function(data){
			$('#page_datalist').html(data);
			onCheckAll();
		}
	});
}

function resetForm(id) {
    $('#' + id).each(function () {
        this.reset();
    });
}

function onListPanel() {
	$('.parsley-error-list').hide();
    $('#list-panel, .btn-form').show();
    $('#form-panel, .btn-list').hide();
}

function onFormPanel() {
    resetForm("DataEntry_formId");
	RecordId = '';
	$('#description').summernote('reset');
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

function onConfirmWhenAddEdit() {

    $.ajax({
		type : 'POST',
		url: base_url + '/admin/savePageData',
		data: $('#DataEntry_formId').serialize(),
		success: function (response) {			
			var msgType = response.msgType;
			var msg = response.msg;

			if (msgType == "success") {
				resetForm("DataEntry_formId");
				onRefreshData();
				onSuccessMsg(msg);
				onListPanel();
			} else {
				onErrorMsg(msg);
			}
			
			onCheckAll();
		}
	});
}

//Page title Slug
function onPageTitleSlug() {
	var StrName = $("#title").val();
	var str_name = StrName.trim();
	var strLength = str_name.length;
	if(strLength>0){
		$.ajax({
			type : 'POST',
			url: base_url + '/admin/hasPageTitleSlug',
			data: 'slug='+StrName,
			success: function (response) {
				var slug = response.slug;
				$("#slug").val(slug);
			}
		});
	}
}

function onEdit(id) {
	RecordId = id;
	var msg = TEXT["Do you really want to edit this record"];
	onCustomModal(msg, "onLoadEditData");	
}

function onLoadEditData() {

    $.ajax({
		type : 'POST',
		url: base_url + '/admin/getPageById',
		data: 'id='+RecordId,
		success: function (response) {
			var data = response;
			console.log(data);
			$("#RecordId").val(data.id);
			$("#title").val(data.title);
			$("#sortcontent").val(data.content);
			$("#slug").val(data.slug);
			if(data.description != null){
				$('#content').summernote('code', data.description);
			}else{
				$('#content').summernote('code', '');
			}
			$("#is_publish").val(data.is_publish).trigger("chosen:updated");
			
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
		url: base_url + '/admin/deletePage',
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
		url: base_url + '/admin/bulkActionPage',
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

