@extends('backend.staffdashboard.index')
@section('content')

<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">

			<div class="card">
				<div class="card-body">

					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;Sales</h4><br>


					<form method="post" class="btn-submit" enctype="multipart/form-data">
						@csrf

						<div class="col-md-12 p-0 row">


							<div class="form-group col-md-4">
								<label class="mb-1">Date:<span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group mb-2">

									<input type="date" name="invoice_date" class="form-control"  required="" autocomplete="off" required="">

								</div>
							</div>



							<div class="form-group col-md-8">
								<label class="mb-1">Shop Name: </label>
								<div class="input-group mb-2">
									<select class="form-control myselect" name="shop_id" id=
									"shop_id">

									<option value="">- - - - -</option>

									@foreach($shop as $s)
									<option value="{{ $s->id }}">{{ $s->shop_name }} - {{ $s->shop_number }}</option>
									@endforeach


								</select>

							</div>
						</div>


{{-- 


							<div class="form-group col-md-3">
								<label class="mb-1">Brand Name: </label>
								<div class="input-group mb-2">
									<select class="form-control myselect" name="brand_id" id=
									"brand_id" onchange="return getbrandproductsales()">

									<option value="">- - - - -</option>

									@foreach($brand as $s)
									<option value="{{ $s->id }}">{{ $s->brand_name }}</option>
									@endforeach


								</select>

							</div>
						</div> --}}
					</div>

		{{-- 			<div class="form-group col-md-3">
						<label class="mb-1">Category Name: </label>
						<div class="input-group mb-2">
							<select class="form-control" name="category_id" id=
							"category_id" onchange="return getcatproduct();">

							<option value="0">- - - - -</option>

							@foreach($category as $s)
							<option value="{{ $s->id }}">{{ $s->category_name }}</option>
							@endforeach


						</select>

					</div>
				</div>
				--}}




				<div class="col-md-12 p-0">
					<div class="row">




						<div class="col-md-12">


							<div class="row">
								<div class="form-group col-md-12">
									<label class="mb-1">Product Name: </label>
									<div class="input-group mb-2">

										<select class="form-control myselect" name="product_id" id=
										"product_id"  onchange="return salesdsrcurrentcart()">
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
						<thead class="bg-primary text-white text-center">
							<tr>
								<th width="50">SL</th>
								<th width="150">Product</th>
								<th width="120">Carton/Piece</th>
								<th width="80">Free</th>
								<th width="80">Price</th>
								<th width="100">Total</th>


							</tr>
						</thead>
					</table>
				</div>


				<div class="col-md-12 p-0">
					<table class="table">

						<tbody id="showdata">

						</tbody>
					</table>
				</div>




			</div>




			<div class="col-md-12">
				<div class="ibox-head myhead2 p-0">
					<div class="ibox-title2 bg-primary p-2 text-white"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Account</div>
				</div>

				<div class="col-md-12 p-0 mt-3 row">



					<div class="form-group col-md-3">
						<label class="mb-1">Sub Total:</label>
						<div class="input-group mb-2">

							<input type="text" id="totalamount" name="totalamount" class="form-control"  readonly="">

						</div>
					</div>




					

					<div class="form-group col-md-3">
						<label class="mb-1">Discount:</label>
						<div class="input-group mb-2">
							<input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" onkeyup="calculatediscount();" value="0" autocomplete="off">
							
						</div>
					</div>


					<input type="hidden" id="transport_cost" name="transport_cost" class="form-control" onkeyup="calculatediscount();" value="0" autocomplete="off" required="">

					<div class="form-group col-md-3 d-none">
						<label class="mb-1">Transport Cost:</label>
						<div class="input-group mb-2">

							

						</div>
					</div>


					<input type="hidden" id="dsr_cost" name="dsr_cost" class="form-control" onkeyup="calculatediscount();" value="0" autocomplete="off" required="">

					<div class="form-group col-md-3 d-none">
						<label class="mb-1">DSR Cost:</label>
						<div class="input-group mb-2">

							

						</div>
					</div>



					<div class="form-group col-md-3">
						<label class="mb-1">Grand Total:</label>
						<div class="input-group mb-2">

							<input type="text" id="grandtotal" name="grandtotal" class="form-control"  readonly="">

						</div>
					</div>

					<input type="hidden" id="paid" name="paid" class="form-control" onkeyup="return paidcalculated();">

					<div class="form-group col-md-3 d-none">
						<label class="mb-1">Paid:</label>
						<div class="input-group mb-2">

							

						</div>
					</div>



					<div class="form-group col-md-3">
						<label class="mb-1">Due:</label>
						<div class="input-group mb-2">
							<input type="text" id="due" name="due" class="form-control"  readonly="">
						</div>
					</div>



					<div class="form-group col-md-3">
						<label class="mb-1">Payment By:</label>
						<div class="input-group mb-2">
							<select class="form-control" name="transaction_type" id="transaction_type">
								<option value="Cash">Cash</option>
								<option value="Bank">Bank</option>
								<option value="Mobile Banking">Mobile Banking</option>

							</select>

						</div>
					</div>

				</div>

			</div>

		</div>


		<div class="col-12 border p-4 mt-4" id="submit">
			<center>
				<input type="submit" name="submitbutton" id="invoicebutton"  value="Submit Now" class="btn btn-primary text-white" style="width: 150px; font-weight: bold; border-radius: 30px;">&nbsp;
			</center>
		</div>


		<div class="col-12 border p-4 mt-4" id="loading">
			<center>
				<input disabled="" name="submitbutton" id="invoicebutton"  value="Loading..." class="btn btn-primary text-white" style="width: 150px; font-weight: bold; border-radius: 30px;">&nbsp;
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


	function getbrandproductsales(){

		var brand_id = $("#brand_id").val();


		$.ajax({
			url: "{{ url("getbrandproductsales") }}/"+brand_id,
			type: "get",
			data:{},
			success: function (data) {

				showdsrsalescurrentcart();

			},
			error:function(errors){
				alert("Product Already Added");
			}
		});


	}


	showdsrsalescurrentcart();

	function salesdsrcurrentcart(){
		let id = $("#product_id").val();

		$.ajax({
			url: "{{ url('salesdsrcurrentcart') }}/"+id,
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


				showdsrsalescurrentcart();

				$("#product_id").val('');


			},
			error:function(errors){
				alert("Product Already Added");
			}
		});

	}



	function showdsrsalescurrentcart(){

		$.ajax({
			url: "{{ url('showdsrsalescurrentcart') }}",
			type: 'get',
			data:{},
			success: function (data)
			{
				$("#showdata").html(data);
				var totalsalesamount = $("#totalsalesamount").val();
				$("#totalamount").val(totalsalesamount);
				$("#grandtotal").val(totalsalesamount);
				$("#paid").val(0);
				$("#due").val(totalsalesamount);
				
			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function dsrsalescartonupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let carton = $("#carton"+id).val();


		$.ajax({
			url: "{{ url('dsrsalescartonupdate') }}/"+id,
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

				showdsrsalescurrentcart();




			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function dsrsalespieceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let piece = $("#piece"+id).val();


		$.ajax({
			url: "{{ url('dsrsalespieceupdate') }}/"+id,
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

				showdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}








	function salesfreeupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let free = $("#free"+id).val();


		$.ajax({
			url: "{{ url('salesfreeupdate') }}/"+id,
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

				showdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function dsrsalesreturncartonupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let returnscarton = $("#returnscarton"+id).val();


		$.ajax({
			url: "{{ url('dsrsalesreturncartonupdate') }}/"+id,
			type: 'get',
			data:{returnscarton:returnscarton},
			success: function (data)
			{

				Command:toastr["success"]("Return Carton Update")
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

				showdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function dsrsalesreturnpieceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let returnspiece = $("#returnspiece"+id).val();


		$.ajax({
			url: "{{ url('dsrsalesreturnpieceupdate') }}/"+id,
			type: 'get',
			data:{returnspiece:returnspiece},
			success: function (data)
			{

				Command:toastr["success"]("Return Piece Update")
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

				showdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function dsrsalesdamageupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let damage = $("#damage"+id).val();


		$.ajax({
			url: "{{ url('dsrsalesdamageupdate') }}/"+id,
			type: 'get',
			data:{damage:damage},
			success: function (data)
			{

				Command:toastr["success"]("Damage Update")
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

				showdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function dsrsalespriceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let price = $("#price"+id).val();


		$.ajax({
			url: "{{ url('dsrsalespriceupdate') }}/"+id,
			type: 'get',
			data:{price:price},
			success: function (data)
			{

				Command:toastr["success"]("Price Update")
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

				showdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function dsrsalesproductdiscount(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let discount = $("#discount"+id).val();

		$.ajax({
			url: "{{ url('dsrsalesproductdiscount') }}/"+id,
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
		let dsr_cost        = parseFloat($("#dsr_cost").val());

		
		

		let totaldiscount  = (parseFloat(total))-(parseFloat(discount)+parseFloat(transport_cost)+parseFloat(dsr_cost));
		$("#grandtotal").val(parseFloat(totaldiscount));
		$("#paid").val(parseFloat(totaldiscount));

		let paid           = parseFloat($("#paid").val());

		let due = (parseFloat(totaldiscount)-parseFloat(paid));
		$("#due").val(parseFloat(totaldiscount));



	}



	function paidcalculated(){
		let total          = parseFloat($("#totalamount").val());
		let discount       = parseFloat($("#discount").val());
		let transport_cost = parseFloat($("#transport_cost").val());
		let dsr_cost       = parseFloat($("#dsr_cost").val());

		let totaldiscount  = (parseFloat(total))-(parseFloat(discount)+parseFloat(transport_cost)+parseFloat(dsr_cost));


		let grandtotal     = $("#grandtotal").val(parseFloat(totaldiscount));
		let paid           = parseFloat($("#paid").val());

		let due = (parseFloat(totaldiscount)-parseFloat(paid));
		$("#due").val(parseFloat(due));


	}




	$("#loading").hide();


	$(".btn-submit").submit(function(e){
		e.preventDefault();

		$("#loading").show();
		$("#submit").hide();


		var data = $(this).serialize();
		$.ajax({
			url:'{{ url('dsrsalesledger') }}',
			method:'POST',
			data:data,

			success:function(response){

				window.open('{{URL::to('/pendingalldsrsalesledger')}}');
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


<style type="text/css">
	
	input:focus{
		border-color: red!important;
	}
</style>


@endsection


