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

	$("#is_featured").chosen();
	$("#is_featured").trigger("chosen:updated");
	
	$("#is_publish").chosen();
	$("#is_publish").trigger("chosen:updated");
	
	
	
	
	
	
	$("#name").on("blur", function () {
		if(RecordId ==''){
			onCategorySlug();
		}
	});
	
	onRefreshData();
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
        url: base_url + "/admin/getBrandsTableData?page=" + page,
        success: function(data) {
            $('#tp_datalist').html(data);
			onCheckAll();
        },
        error: function(xhr) {
            console.error("Error loading data: ", xhr.responseText);
        }
    });
}

function onRefreshData() {
    $.ajax({
        url: base_url + "/admin/getProductCategoriesTableData",
        type: "GET",
        data: { search: $("#search").val() },  // Include search value if applicable
        success: function(data) {
            $('#tp_datalist').html(data);  // Update table with new data
            onCheckAll(); // Ensure checkboxes work properly
        },
        error: function(xhr) {
            console.error("Error fetching table data:", xhr.responseText);
        }
    });
}


function onSearch() {
	$.ajax({
		url: base_url + "/admin/getProductCategoriesTableData?search="+$("#search").val(),
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
	
	$("#is_publish").trigger("chosen:updated");
	$("#is_subheader").trigger("chosen:updated");
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
	
	$("#remove_og_image").hide();
	$("#og_image").html('');
	
	$("#is_publish").trigger("chosen:updated");
	$("#is_subheader").trigger("chosen:updated");
			
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
        type: 'POST',
        url: base_url + '/admin/saveProductCategoriesData',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#submit-form").text("Saving...").attr("disabled", true);
        },
        success: function (response) {
			var msgType = response.msgType;
			var msg = response.msg;
			console.log(response);
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
        url: base_url + '/admin/getProductCategoriesById',
        data: { id: RecordId },
        success: function (response) {
            console.log("AJAX Response: ", response); // Debugging
            
            if (!response) {
                alert("No data received.");
                return;
            }

            let data = response;

            $("#RecordId").val(data.id);
            $("#name").val(data.name);
            $("#slug").val(data.slug);
            $("#is_publish").val(data.is_publish).trigger("chosen:updated");

            // Short Description
            $("#sortdescription").val(data.sortdescription ?? '');

            // Summernote (ensure it's initialized)
            if ($('#content').length) {
                $('#content').summernote({
                    height: 200,
                    placeholder: "Enter description..."
                });
                $('#content').summernote('code', data.description ?? '');
            } else {
                console.error("Summernote not initialized.");
            }

            // Category Image
            if (data.image) {
                let imageUrl = base_url + '/uploads/category/' + data.image;
                $("#view_photo_thumbnail").html('<img src="' + imageUrl + '" width="100">');
                $("#remove_photo_thumbnail").show();
            } else {
                $("#view_photo_thumbnail").html('');
                $("#remove_photo_thumbnail").hide();
            }

            // Subheader Image
            if (data.subheader_image) {
                let subheaderImageUrl = base_url + '/uploads/subcategory/' + data.subheader_image;
                $("#cat_view_photo_thumbnail").html('<img src="' + subheaderImageUrl + '" width="100">');
                $("#cat_remove_photo_thumbnail").show();
            } else {
                $("#cat_view_photo_thumbnail").html('');
                $("#cat_remove_photo_thumbnail").hide();
            }

            // OG Meta Tags
            $("#og_title").val(data.og_title ?? '');
            $("#og_keywords").val(data.og_keywords ?? '');
            $("#og_description").val(data.og_description ?? '');

            onEditPanel();
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", xhr.responseText);
            alert("Error loading data!");
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
		url: base_url + '/admin/deleteProductCategories',
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
		url: base_url + '/admin/bulkActionProductCategories',
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

//Category Slug
function onCategorySlug() {
	var StrName = $("#name").val();
	var str_name = StrName.trim();
	var strLength = str_name.length;
	if(strLength>0){
		$.ajax({
			type : 'POST',
			url: base_url + '/admin/hasProductCategorySlug',
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

$(document).ready(function () {
    // Handle Image Selection
    $("#cat_photo_thumbnail").change(function (event) {
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#cat_view_photo_thumbnail").html('<img src="' + e.target.result + '" style="max-width:100px; max-height:100px;"/>');
                $("#cat_remove_photo_thumbnail").show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove Selected Image
    $("#removeImageBtn").click(function () {
        $("#cat_photo_thumbnail").val(""); // Clear file input
        $("#cat_view_photo_thumbnail").html(""); // Remove preview image
        $("#cat_remove_photo_thumbnail").hide(); // Hide remove button
    });
});