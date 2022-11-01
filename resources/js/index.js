$.ajaxSetup({
	headers: {
	  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

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

$('#create_product_submit').click(function (e) {
    e.preventDefault();
    $(this).html('Creating...');
  
    $.ajax({
      data: $('#product_create_form').serialize(),
      url: "{{ route('products.store') }}",
      type: "POST",
      dataType: 'json',
      success: function (data) {   
          $('#product_create_form').trigger("reset");
          $('#createProductModal').modal('hide');
          table.draw();       
      },
      error: function (data) {
          console.log('Error:', data);
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



// $('#filter_by_cat').change( function (e) {
//     e.preventDefault();
  
//     $.ajax({
//       data: JSON.stringify({
//       	 category_id : $('#filter_by_cat').val() 
//       }),
//       url: "{{ route('get-subcategories') }}",
//       type: "POST",
//       dataType: 'json',
//       success: function (data) {   
//       	alert(data);
//           $('#filter_by_subcat').val(data.data.id);
//       },
//       error: function (data) {
//           alert('Error:', data);
//       }
//   });
// });


$('#filter_form').click( function (e) {
    e.preventDefault();
  
    $.ajax({
      data: $('#filter_form').serialize(),
      url: "{{ url('filter') }}",
      type: "POST",
      dataType: 'json',
      success: function (data) {   
      	alert("data");
          // $('#filter_by_subcat').val(data.data.id);
      },
      error: function (data) {
          alert('Error:', data);
      }
  });
});


// $("#table_id").load(window.location + " #table_id");