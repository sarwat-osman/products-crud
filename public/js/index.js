$.ajaxSetup({
	headers: {
	  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});


// CREATE PRODUCT MODAL POPUP
$(document).on('click', '#create_prod_btn', function(event) {
    event.preventDefault();

    $.ajax({
        beforeSend: function() {
            $('#loader').show();
        },
        success: function() {
            $('#createProductModal').modal("show");
        },
        complete: function() {
            $('#loader').hide();
        },
        error: function(error) {
            alert("Error:" + error);
            $('#loader').hide();
        }
    })
});


// CREATE PRODUCT FORM SUBMIT AJAX
$('#product_create_form').submit(function (e) {
    e.preventDefault();
  	var form = $(this);
    $.ajax({
        data: form.serialize(),
        url: form.attr('action'),
        type: form.attr('method'),
		dataType: 'json',
		headers: {
			'X-CSRF-Token': '{{ csrf_token() }}',
		},
		success: function (data) {   
			form.trigger("reset");
			$('#createProductModal').modal('hide');
			$("#products_table").load(window.location + " #products_table");
		},
		error: function (data) {
			alert('Error:', data.error);
		}
	});
});
  
// $('body').on('click', '.del_prod_btn', function () {
 
//     var product_id = $(this).data("id");
//     confirm("Are You sure want to delete !");
    
//     $.ajax({
//         type: "DELETE",
//         url: "{{ route('products.destroy') }}"+'/'+product_id,
//         success: function (data) {
//             table.draw();
//         },
//         error: function (data) {
//             console.log('Error:', data);
//         }
//     });
// });




$(document).ready(function() {

	// AUTOLOAD SUBCATEGORIES BASED ON DROPDOWN CATEGORY SELECTION AJAX
	$('#filter_by_cat').change( function (e) {
	    e.preventDefault();
	  
	    $.ajax({
	      data: JSON.stringify({
	      	 category_id : $('#filter_by_cat').val() 
	      }),
	      url: "/get-subcategories",
	      type: "POST",
	      dataType: 'json',
	      success: function (response) {   
	          $('#filter_by_subcat').val(response.data.id);
	      },
	      error: function (response) {
	          alert('Error:', response.error);
	      }
	  });
	});


	// FILTER PRODUCTS BY CATEGORY/PRICE 
	$('#filter_form').submit( function (e) {
	    e.preventDefault();
	    var form = $(this);
	    $.ajax({
	        data: form.serialize(),
	        url: "/filter",
	        type: "POST",
	        dataType: 'json',
	        headers: {
	            'X-CSRF-Token': '{{ csrf_token() }}',
	        },
	        success: function (response) {   
	        	alert(response.data);
	        	$('#products_table tbody').html(response.data);
	            // $("#products_table").load(window.location + " #products_table");
	        },
	        error: function (response) {
	            alert('Error:\n' + response.error);
	        }
	    });
	});


	// SEARCH PRODUCTS BY TITLE
	$('#search_form').submit( function (e) {
	    e.preventDefault();
	    var form = $(this);
	    $.ajax({
	        data: form.serialize(),
	        url: "/search",
	        type: "POST",
	        dataType: 'json',
	        headers: {
	            'X-CSRF-Token': '{{ csrf_token() }}',
	        },
	        success: function (response) {  
	        	$('#products_table tbody').html(response.data);
	        },
	        error: function (response) {
	            alert('Error:\n' + response.error);
	        }
	    });
	});
	
});