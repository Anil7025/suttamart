var $ = jQuery.noConflict();

$(function () {
	"use strict";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).on('click', '.pagination a', function(event){
		event.preventDefault(); 
		var page = $(this).attr('href').split('page=')[1];
		onPaginationDataLoad(page);
	});
	
});

function onPaginationDataLoad(page) {

	$.ajax({
		url:base_url + "/frontend/getProductReviewsGrid",
		data:{page:page,item_id:item_id},
		success:function(data){
			$('#tp_datalist').html(data);
		}
	});
}


$(document).ready(function () {
    $("#commentForm").on("submit", function (e) {
        e.preventDefault(); 
       
        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url:base_url + "/submit-review",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function (response) {
                alert(response.success); // Show success message
                $("#commentForm")[0].reset(); // Reset form
                $("#rating").val(0); 
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert("Error submitting review. Please try again.");
            }
        });
    });
});



