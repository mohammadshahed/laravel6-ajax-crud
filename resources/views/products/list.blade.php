<!DOCTYPE html>

<html>

	<head>

	    <title>Laravel 6 CRUD Application</title>
	    <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	   
	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">



	</head>

	<body>
		<div class="container-fluid bg-success text-center pt-4">
		  <h1>Laravel 6 AJAX CRUD </h1>
		  <p>By: Shahed</p> 
		  <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New Product</a>

		    <table class="table table-bordered data-table">

		        <thead>
		            <tr>
		                <th>No</th>
		                <th>Name</th>
		                <th>Description</th>
		                <th width="280px">Action</th>
		            </tr>
		        </thead>

		        <tbody>

		        </tbody>

		    </table>
		</div>
	  

		<div class="container-sm pt-5">

			<div class="modal fade" id="ajaxModel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header">
			                <h4 class="modal-title" id="modelHeading"></h4>
			            </div>
			            <div class="modal-body">
			                <form id="productForm" name="productForm" class="form-horizontal">
			                   <input type="hidden" name="product_id" id="product_id">
			                    <div class="form-group">
			                        <label for="name" class="col-sm-2 control-label">Name</label>
			                        <div class="col-sm-12">
			                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
			                        </div>
			                    </div>

			                    <div class="form-group">
			                        <label class="col-sm-2 control-label">Description</label>
			                        <div class="col-sm-12">
			                            <textarea id="description" name="description" required="" placeholder="Enter Description" class="form-control"></textarea>
			                        </div>
			                    </div>

			                    <div class="col-sm-offset-2 col-sm-10">
			                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
			                     </button>
			                    </div>
			                </form>
			            </div>
			        </div>
			    </div>
			</div>
		</div>


		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  

	</body>	
		
	<script type="text/javascript">

	  $(function () {

	     

	      $.ajaxSetup({

	          headers: {

	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

	          }

	    });

	    

	    var table = $('.data-table').DataTable({

	        processing: true,

	        serverSide: true,

	        ajax: "{{ route('products.index') }}",

	        columns: [

	            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

	            {data: 'name', name: 'name'},

	            {data: 'description', name: 'description'},

	            {data: 'action', name: 'action', orderable: false, searchable: false},

	        ]

	    });

	     

	    $('#createNewProduct').click(function () {

	        $('#saveBtn').val("create-product");

	        $('#product_id').val('');

	        $('#productForm').trigger("reset");

	        $('#modelHeading').html("Create New Product");

	        $('#ajaxModel').modal('show');

	    });

	    

	    $('body').on('click', '.editProduct', function () {

	      var product_id = $(this).data('id');

	      $.get("{{ route('products.index') }}" +'/' + product_id +'/edit', function (data) {

	          $('#modelHeading').html("Edit Product");

	          $('#saveBtn').val("edit-user");

	          $('#ajaxModel').modal('show');

	          $('#product_id').val(data.id);

	          $('#name').val(data.name);

	          $('#description').val(data.description);

	      })

	   });

	    

	    $('#saveBtn').click(function (e) {

	        e.preventDefault();

	        $(this).html('Sending..');

	    

	        $.ajax({

	          data: $('#productForm').serialize(),

	          url: "{{ route('products.store') }}",

	          type: "POST",

	          dataType: 'json',

	          success: function (data) {

	     

	              $('#productForm').trigger("reset");

	              $('#ajaxModel').modal('hide');

	              table.draw();

	         

	          },

	          error: function (data) {

	              console.log('Error:', data);

	              $('#saveBtn').html('Save Changes');

	          }

	      });

	    });

	    

	    $('body').on('click', '.deleteProduct', function () {

	     

	        var product_id = $(this).data("id");

	        confirm("Are You sure want to delete !");

	      

	        $.ajax({

	            type: "DELETE",

	            url: "{{ route('products.store') }}"+'/'+product_id,

	            success: function (data) {

	                table.draw();

	            },

	            error: function (data) {

	                console.log('Error:', data);

	            }

	        });

	    });

	     

	  });

	</script>


</html>