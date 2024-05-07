@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">

			<div class="card">
				<div class="card-body">

					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;Product Recieve</h4><br>


					<form method="post" class="btn-submit" enctype="multipart/form-data">
						@csrf

						<div class="col-md-12 p-0 row">


							<div class="form-group col-md-2">
								<label class="mb-1">Date:<span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group mb-2">

									<input type="date" name="invoice_date" class="form-control"  required="" autocomplete="off" required="">

								</div>
							</div>



							<div class="form-group col-md-2">
								<label class="mb-1">Voucer No:<span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group mb-2">

									<input type="text" name="voucer" value="{{ old('voucer') }}" class="form-control"  required="" autocomplete="off" required="">

								</div>
							</div>





							<div class="form-group col-md-3">
								<label class="mb-1">Supplier Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group mb-2">
									<select class="form-control myselect" name="supplier_id" id=
									"supplier_id" required="">

									<option value="">- - - - -</option>

									@foreach($supplier as $s)
									<option value="{{ $s->id }}">{{ $s->supplier_name }}</option>
									@endforeach


								</select>

							</div>
						</div>


						<div class="form-group col-md-2">
							<label class="mb-1">Brand Name: </label>
							<div class="input-group mb-2">
								<select class="form-control" name="brand_id" id=
								"brand_id" onchange="return getbrandproduct()">

								<option value="">- - - - -</option>

								@foreach($brand as $s)
								<option value="{{ $s->id }}">{{ $s->brand_name }}</option>
								@endforeach


							</select>

						</div>
					</div>


					<div class="form-group col-md-3">
						<label class="mb-1">Category Name: </label>
						<div class="input-group mb-2">
							<select class="form-control" name="category_id" id=
							"category_id" onchange="return getcatproduct();">

							<option value="">- - - - -</option>

							@foreach($category as $s)
							<option value="{{ $s->id }}">{{ $s->category_name }}</option>
							@endforeach


						</select>

					</div>
				</div>





				<div class="col-md-9">
					<div class="row">




						<div class="col-md-12">


							<div class="row">
								<div class="form-group col-md-12">
									<label class="mb-1">Product Name: </label>
									<div class="input-group mb-2">

										<select class="form-control myselect" name="product_id" id=
										"product_id"  onchange="return purchasecurrentcart()">
										<option value="">- - - - -</option>

										@foreach($product as $p)
										<option value="{{ $p->id }}">{{ $p->product_name }}</option>
										@endforeach



									</select>

								</div>
							</div>



						</div>

					</div>
				</div>


				<div class="col-md-12 p-0">
					<table class="table table-bordered">
						<thead class="bg-primary text-white">
							<tr>
								<th width="50">SL</th>
								<th width="150">Product</th>
								<th width="100">Carton</th>
								<th width="80">Piece</th>
								<th width="80">Free</th>
								<th width="100">Price</th>
								<th width="100">Total</th>
								<th width="10">Action</th>

							</tr>
						</thead>

					</table>
				</div>



				<div class="col-md-12 p-0" style="height: 600px!important; overflow: auto; overflow-x: hidden;">
					<table class="table table-bordered">
						
						<tbody id="showdata">

						</tbody>

					</table>
				</div>




			</div>




			<div class="col-md-3">
				<div class="ibox-head myhead2 p-0">
					<div class="ibox-title2 bg-primary p-2 text-white"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Account</div>
				</div>

				<div class="col-md-12 bg-light p-3">



					<div class="form-group">
						<label class="mb-1">Sub Total:</label>
						<div class="input-group mb-2">

							<input type="text" id="totalamount" name="totalamount" class="form-control"  readonly="">

						</div>
					</div>




					<div class="form-group">
						<label class="mb-1">Discount:</label>
						<div class="input-group mb-2">

							<input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" onkeyup="calculatediscount();" value="0" autocomplete="off">

						</div>
					</div>


					<div class="form-group">
						<label class="mb-1">Transport Cost:</label>
						<div class="input-group mb-2">

							<input type="text" id="transport_cost" name="transport_cost" class="form-control" onkeyup="calculatediscount();" value="0" autocomplete="off" required="">

						</div>
					</div>



					<div class="form-group">
						<label class="mb-1">Grand Total:</label>
						<div class="input-group mb-2">

							<input type="text" id="grandtotal" name="grandtotal" class="form-control"  readonly="">

						</div>
					</div>


					<div class="form-group">
						<label class="mb-1">Paid:</label>
						<div class="input-group mb-2">

							<input type="text" id="paid" name="paid" class="form-control" onkeyup="return paidcalculated();">

						</div>
					</div>



					<div class="form-group">
						<label class="mb-1">Due:</label>
						<div class="input-group mb-2">
							<input type="text" id="due" name="due" class="form-control"  readonly="">
						</div>
					</div>



					<div class="form-group">
						<label class="mb-1">Payment By:</label>
						<div class="input-group mb-2">
							<select class="form-control" name="transaction_type" id="transaction_type">
								<option value="Bank">Bank</option>
								<option value="Cash">Cash</option>
								<option value="Mobile Banking">Mobile Banking</option>

							</select>

						</div>
					</div>

				</div>

			</div>

		</div>


		<div class="col-12 border p-4 mt-4" id="submit">
			<center>
				<input type="submit" name="submitbutton" id="invoicebutton"  value="Submit Now" class="btn btn-dark text-white" style="width: 150px; font-weight: bold; border-radius: 30px;">&nbsp;
			</center>
		</div>


		<div class="col-12 border p-4 mt-4" id="loading">
			<center>
				<input disabled="" name="submitbutton" id="invoicebutton"  value="Loading..." class="btn btn-dark text-white" style="width: 150px; font-weight: bold; border-radius: 30px;">&nbsp;
			</center>
		</div>



	</form>



</div> <!-- end card body-->
</div> <!-- end card -->
</div><!-- end col-->

</div>
</div>




<script type="text/javascript">


	function getcatproduct(){

		var category_id = $("#category_id").val();

		$.ajax({
			url: "{{ url("getcatproduct") }}/"+category_id,
			type: "get",
			data:{},
			success: function (data) {

				$("#product_id").html(data);
				$("#brand_id").val('');
			}
		});


	}


	function getbrandproduct(){

		var brand_id = $("#brand_id").val();


		$.ajax({
			url: "{{ url("getbrandproduct") }}/"+brand_id,
			type: "get",
			data:{},
			success: function (data) {

				showpurchasecurrentcart();

			},
			error:function(errors){
				alert("Product Already Added");
			}
		});


	}


	showpurchasecurrentcart();

	function purchasecurrentcart(){
		let id = $("#product_id").val();

		$.ajax({
			url: "{{ url('purchasecurrentcart') }}/"+id,
			type: 'GET',
			success: function (data)
			{

				Command:toastr["success"]("Product Added Done")
				toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": false,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "3000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}


				showpurchasecurrentcart();

				$("#product_id").val('');


			},
			error:function(errors){
				alert("Product Already Added");
			}
		});

	}



	function showpurchasecurrentcart(){

		$.ajax({
			url: "{{ url('showpurchasecurrentcart') }}",
			type: 'get',
			data:{},
			success: function (data)
			{
				$("#showdata").html(data);
				
				var totalpurchaseamount = parseFloat($("#totalpurchaseamount").val());
				$("#totalamount").val(totalpurchaseamount.toFixed(2));
				$("#grandtotal").val(totalpurchaseamount.toFixed(2));
				$("#paid").val(totalpurchaseamount.toFixed(2));
				$("#due").val(0);
				
			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function purchasecartonupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let carton = $("#carton"+id).val();


		$.ajax({
			url: "{{ url('purchasecartonupdate') }}/"+id,
			type: 'get',
			data:{carton:carton},
			success: function (data)
			{

				Command:toastr["success"]("Product Quentity Update")
				toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": false,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "3000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}

				showpurchasecurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function purchasepieceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let piece = $("#piece"+id).val();


		$.ajax({
			url: "{{ url('purchasepieceupdate') }}/"+id,
			type: 'get',
			data:{piece:piece},
			success: function (data)
			{

				Command:toastr["success"]("Product Quentity Update")
				toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": false,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "3000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}

				showpurchasecurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}








	function purchasefreeupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let free = $("#free"+id).val();


		$.ajax({
			url: "{{ url('purchasefreeupdate') }}/"+id,
			type: 'get',
			data:{free:free},
			success: function (data)
			{

				Command:toastr["success"]("Product Quentity Update")
				toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": false,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "3000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}

				showpurchasecurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function purchasepriceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let price = $("#price"+id).val();


		$.ajax({
			url: "{{ url('purchasepriceupdate') }}/"+id,
			type: 'get',
			data:{price:price},
			success: function (data)
			{

				Command:toastr["success"]("Product Quentity Update")
				toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": false,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "3000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}

				showpurchasecurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}



	function salesproductdiscount(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let discount = $("#discount"+id).val();

		$.ajax({
			url: "{{ url('salesproductdiscount') }}/"+id,
			type: 'POST',
			data:{discount:discount},
			success: function (data)
			{
				Command:toastr["success"]("Product Discount Update")
				toastr.options = {
					"closeButton": true,
					"debug": false,
					"newestOnTop": false,
					"progressBar": true,
					"positionClass": "toast-top-right",
					"preventDuplicates": false,
					"onclick": null,
					"showDuration": "300",
					"hideDuration": "1000",
					"timeOut": "3000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "linear",
					"showMethod": "fadeIn",
					"hideMethod": "fadeOut"
				}

				showsalesproductcart();
			},
			error:function(errors){
				alert("errors")
			}
		});

	}



	function calculatediscount(){
		let total           = parseFloat($("#totalamount").val());
		let discount        = parseFloat($("#discount").val());
		let transport_cost  = parseFloat($("#transport_cost").val());
		

		let totaldiscount  = ((parseFloat(total)+parseFloat(transport_cost))-parseFloat(discount));
		$("#grandtotal").val(parseFloat(totaldiscount.toFixed(2)));
		$("#paid").val(parseFloat(totaldiscount.toFixed(2)));

		let paid           = parseFloat($("#paid").val());

		let due = (parseFloat(totaldiscount)-parseFloat(paid));
		$("#due").val(parseFloat(due.toFixed(2)));



	}



	function paidcalculated(){
		let total          = parseFloat($("#totalamount").val());
		let discount       = parseFloat($("#discount").val());
		let transport_cost  = parseFloat($("#transport_cost").val());
		let totaldiscount  = ((parseFloat(total)+parseFloat(transport_cost))-parseFloat(discount));
		let grandtotal     = $("#grandtotal").val(parseFloat(totaldiscount));
		let paid           = parseFloat($("#paid").val());

		let due = (parseFloat(totaldiscount)-parseFloat(paid));
		$("#due").val(parseFloat(due.toFixed(2)));


	}




	$("#loading").hide();


	$(".btn-submit").submit(function(e){
		e.preventDefault();

		$("#loading").show();
		$("#submit").hide();


		var data = $(this).serialize();
		$.ajax({
			url:'{{ url('purchaseledger') }}',
			method:'POST',
			data:data,

			success:function(response){

				window.open('{{URL::to('/purchaseinvoice')}}'+'/'+response, "_blank");
				location.reload();

				$("#loading").hide();
				$("#submit").show();

				

			},

			error:function(error){
				console.log(error)
			}
		});
	});




	

</script>

@endsection


