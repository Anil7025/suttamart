var $ = jQuery.noConflict();
var RecordId = '';

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
	
	
});

function onPaginationDataLoad(page) {
    var base_url = "{{ url('/') }}"; 
    var product_id = "{{ $product->id }}"; 

    $.ajax({
        url: base_url + "/admin/getProductImagesTableData?page=" + page + "&id=" + product_id,
        type: "GET",
        success: function(response) {
            if (response.html.trim() !== "") {
                $('#tp_datalist').html(response.html);
            } else {
                $('#tp_datalist').html('<p class="text-center">No images found</p>');
            }
        },
        error: function(xhr) {
            console.error("Pagination Load Error:", xhr.responseText);
        }
    });
}


function onRefreshData() {
    $.ajax({
        url: base_url + "/admin/getProductImagesTableData?id=" + product_id,
        type: "GET",
        success: function(response) {
            $('#tp_datalist').html(response.html);
        },
        error: function(xhr) {
            console.error("Refresh Data Error:", xhr.responseText);
        }
    });
}


function resetForm(id) {
    $('#' + id).each(function () {
        this.reset();
    });
}

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
    formData.append('product_id', product_id); 

    $.ajax({
        type: 'POST',
        url: base_url + '/admin/saveProductImagesData',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {            
            if (response.msgType === "success") {
                resetForm("DataEntry_formId"); // ✅ Ensure this function exists
                onSuccessMsg(response.msg);
                onRefreshData();
                setTimeout(function () {
                    var id = response.id;
                    window.location.href = base_url + '/admin/related-products/' + id;
                }, 10000); 
            } else {
                onErrorMsg(response.msg);
            }
        },
        error: function(xhr) {
            console.error("Upload failed!", xhr.responseText);
            alert('Upload failed! Please try again.');
        }
    });
}



function onDelete(id) {
    RecordId = id;
    var msg = "Do you really want to delete this record?";
    onCustomModal(msg, "onConfirmDelete");	
}

function onConfirmDelete() {
    $.ajax({
        type: 'POST',
        url: base_url + '/admin/deleteProductImages',
        data: {
            id: RecordId,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for security
        },
        success: function (response) {
            if (response.msgType === "success") {
                onSuccessMsg(response.msg);
                onRefreshData(); // Refresh data after deletion
            } else {
                onErrorMsg(response.msg);
            }
        },
        error: function(xhr) {
            alert("Delete failed! Please try again.");
        }
    });
}

$(document).ready(function () {
    $("#pro_image").change(function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.createElement("img");
            output.src = reader.result;
            output.style.maxWidth = "200px"; // Adjust as needed
            $("#imagePreview").html(output);
        };
        reader.readAsDataURL(event.target.files[0]);
    });
});

$(document).ready(function () {
    $("#pro_image").change(function (event) {
        var file = event.target.files[0];
        if (file) {
            $("#pro_large_image").val(file.name); // Store file name
        }
    });
});

$('#pro_images').on('change', function () {
    $('#imagePreview').html('');
    var files = this.files;
    
    $.each(files, function (index, file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').append('<img src="' + e.target.result + '" width="100" height="100" class="m-1">');
        };
        reader.readAsDataURL(file);
    });
});
