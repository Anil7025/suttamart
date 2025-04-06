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

	$("#product_name").on("blur", function () {
		onProductSlug();
	});
	
	$("#brand_id").chosen();
	$("#brand_id").trigger("chosen:updated");
	
	$("#cat_id").chosen();
	$("#cat_id").trigger("chosen:updated");

	$("#tax_id").chosen();
	$("#tax_id").trigger("chosen:updated");
	
	$("#is_featured").chosen();
	$("#is_featured").trigger("chosen:updated");
	
	$("#is_publish").chosen();
	$("#is_publish").trigger("chosen:updated");
	
		onCategoryList();
		onBrandList();
	
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
	var formData = new FormData($('#DataEntry_formId')[0]);
    $.ajax({
		type : 'POST',
		url: base_url + '/admin/updateProductsData',
		data: formData,
        processData: false, 
        contentType: false, 
		success: function (response) {			
			var msgType = response.msgType;
			var msg = response.msg;
			if (msgType == "success") {
				onSuccessMsg(msg);
				var id = response.id;
				window.location.href= base_url + '/admin/price/'+id;
			} else {
				onErrorMsg(msg);
			}
		}
	});
}

//Product Slug
function onProductSlug() {
	var StrName = $("#product_name").val();
	var str_name = StrName.trim();
	var strLength = str_name.length;
	if(strLength>0){
		$.ajax({
			type : 'POST',
			url: base_url + '/admin/hasProductSlug',
			data: 'slug='+StrName,
			success: function (response) {
				var slug = response.slug;
				$("#slug").val(slug);
			}
		});
	}
}

function onCategoryList() {
	
	$.ajax({
		type : 'POST',
		url: base_url + '/admin/getCategoryList',
		data: 'lan='+$('#lan').val(),
		success: function (data) {
			var html = '<option value="" selected="selected">'+TEXT['Select Category']+'</option>';
			$.each(data, function (key, obj) {
				html += '<option value="' + obj.id + '">' + obj.name + '</option>';
			});
			
			$("#cat_id").html(html);
			$("#cat_id").chosen();
			$("#cat_id").trigger("chosen:updated");
		}
	});
}

function onBrandList() {
	
	$.ajax({
		type : 'POST',
		url: base_url + '/admin/getBrandList',
		data: 'lan='+$('#lan').val(),
		success: function (data) {
			var html = '<option value="0" selected="selected">No Brand</option>';
			$.each(data, function (key, obj) {
				html += '<option value="' + obj.id + '">' + obj.name + '</option>';
			});
			
			$("#brand_id").html(html);
			$("#brand_id").chosen();
			$("#brand_id").trigger("chosen:updated");
		}
	});
}
$(document).ready(function () {
    $("#featured_image").change(function (event) {
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#view_featured_image").html('<img src="' + e.target.result + '" style="max-width:100px; max-height:100px;"/>');
                $("#remove_featured_image").show();
            };
            reader.readAsDataURL(file);
        }
    });

    $("#removeImageBtn").click(function () {
        $("#featured_image").val(""); 
        $("#view_featured_image").html("");
        $("#remove_featured_image").hide(); 
    });
});

$(document).ready(function () {
    $("#featured_image2").change(function (event) {
        var file = event.target.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#view_featured_image2").html('<img src="' + e.target.result + '" style="max-width:100px; max-height:100px;"/>');
                $("#remove_featured_image2").show();
            };
            reader.readAsDataURL(file);
        }
    });

    $("#removeImageBtn2").click(function () {
        $("#featured_image2").val(""); 
        $("#view_featured_image2").html("");
        $("#remove_featured_image2").hide(); 
    });
});