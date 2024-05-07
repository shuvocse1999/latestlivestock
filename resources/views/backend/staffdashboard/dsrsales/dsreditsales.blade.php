@extends('backend.staffdashboard.index')
@section('content')

<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">

			<div class="card">
				<div class="card-body">

					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;Final Sales</h4><br>


					<form method="post" class="btn-submit" enctype="multipart/form-data">
						@csrf

						<div class="col-md-12 p-0 row">

							<input type="hidden" value="{{ $sales->invoice_no }}" name="invoice_no" id="invoice_no">


							<div class="form-group col-md-3">
								<label class="mb-1">Date:<span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group mb-2">

									<input type="date" name="invoice_date" class="form-control" value="{{ $sales->invoice_date }}" required="" autocomplete="off" required="" >

								</div>
							</div>


							<div class="form-group col-md-5">
								<label class="mb-1">Shop Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
								<input type="text" name="shop_name" class="form-control"  required="" autocomplete="off" required="" value="{{ $sales->shop_name }}">
								

							</div>


							<div class="form-group col-md-4">
								<label class="mb-1">Shop Number: <span class="text-danger" style="font-size: 15px;">*</span></label>
								<input type="text" name="shop_number" class="form-control"  required="" autocomplete="off" required="" value="{{ $sales->shop_number }}">
								

							</div>







		{{-- 				<div class="form-group col-md-3">
							<label class="mb-1">Market: <span class="text-danger" style="font-size: 15px;">*</span></label>
							<div class="input-group mb-2">
								<select class="form-control myselect" name="market" id=
								"market" required="">

								<option value="{{ $sales->market }}">{{ $sales->market }}</option>
								<option value="Dagonbhuiyan">Dagonbhuiyan</option>
								<option value="Rajapur">Rajapur</option>
								<option value="Gojaria">Gojaria</option>
								<option value="Sebar Hat">Sebar Hat</option>
								<option value="Boiragir Hat">Boiragir Hat</option>
								<option value="Nobipur">Nobipur</option>
								<option value="Selonia">Selonia</option>
								<option value="Beker Bazar">Beker Bazar</option>
								<option value="Kutir Hat">Kutir Hat</option>
								<option value="Fajiler Gat">Fajiler Gat</option>
								<option value="Namar Bazar">Namar Bazar</option>
								<option value="Dorbesher Hat">Dorbesher Hat</option>




							</select>

						</div>
					</div> --}}



{{-- 
					<div class="form-group col-md-3">
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




				<div class="col-md-12">
					<div class="row">




						<div class="col-md-12">


							<div class="row">
								<div class="form-group col-md-12">
									<label class="mb-1">Product Name: </label>
									<div class="input-group mb-2">

										<select class="form-control myselect" name="product_id" id=
										"product_id"  onchange="return editsalescurrentcart()">
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
					<table class="table">
						<thead class="bg-primary text-white">
							<tr>
								<th>SL</th>
								<th>Product</th>
								<th>Carton/Piece</th>
								<th>Price</th>
								<th style="width: 200px;">Total</th>
								

							</tr>
						</thead>

						<tbody id="showdata">

						</tbody>
					</table>
				</div>




			</div>




			<div class="col-md-12 mt-5">
				<div class="ibox-head myhead2 p-0">
					<div class="ibox-title2 bg-primary p-2 text-white"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Account</div>
				</div>

				<div class="col-md-12 row mt-4 p-0">



					<div class="form-group col-md-3">
						<label class="mb-1">Sub Total:</label>
						<div class="input-group mb-2">

							<input type="text" id="totalamount" name="totalamount" class="form-control"  readonly="" value="{{ $sales->total }}">

						</div>
					</div>




					<div class="form-group col-md-3">
						<label class="mb-1">Discount:</label>
						<div class="input-group mb-2">

							<input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" onkeyup="calculatediscount();" value="{{ $sales->discount }}" autocomplete="off" >

						</div>
					</div>


		{{-- 			<div class="form-group col-md-3">
						<label class="mb-1">Transport Cost:</label>
						<div class="input-group mb-2">

							<input type="text" id="transport_cost" name="transport_cost" class="form-control" onkeyup="calculatediscount();" value="0" autocomplete="off" required="">

						</div>
					</div>


					<div class="form-group col-md-3">
						<label class="mb-1">Other Cost:</label>
						<div class="input-group mb-2">

							<input type="text" id="dsr_cost" name="dsr_cost" class="form-control" onkeyup="calculatediscount();" value="0" autocomplete="off" required="">

						</div>
					</div>
 --}}


					<div class="form-group col-md-3">
						<label class="mb-1">Grand Total:</label>
						<div class="input-group mb-2">

							<input type="text" id="grandtotal" name="grandtotal" value="{{ $sales->grandtotal }}"  class="form-control"  readonly="">

						</div>
					</div>


					<div class="form-group col-md-3">
						<label class="mb-1">Paid:</label>
						<div class="input-group mb-2">

							<input type="text" id="paid" name="paid" class="form-control" value="{{ $sales->paid }}" onkeyup="return paidcalculated();">

						</div>
					</div>



					<div class="form-group col-md-3">
						<label class="mb-1">Due:</label>
						<div class="input-group mb-2">
							<input type="text" id="due" name="due" value="{{ $sales->due }}" class="form-control"  readonly="">
						</div>
					</div>



					<div class="form-group col-md-3">
						<label class="mb-1">Payment By:</label>
						<div class="input-group mb-2">
							<select class="form-control" name="transaction_type" id="transaction_type">
								<option value="Cash" @if($sales->transaction_type == "Cash") selected="" @endif>Cash</option>
								<option value="Bank" @if($sales->transaction_type == "Bank") selected="" @endif>Bank</option>
								<option value="Mobile Banking" @if($sales->transaction_type == "Mobile Banking") selected="" @endif>Mobile Banking</option>

							</select>

						</div>
					</div>

				</div>

			</div>

		</div>

		

		<div class="col-md-3 mt-5" style="margin: 0 auto;">
			<center>
				<label>Change Status:</label>
				<select class="form-control myselect" id="confirm" name="status" onchange="return confirmfunction()">
					<option value="">- - -</option>
					<option value="2">Edit Sales</option>
					<option value="1">Confirm Sales</option>
					
				</select>
			</center>
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

<br>



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

				showeditdsrsalescurrentcart();

			},
			error:function(errors){
				alert("Product Already Added");
			}
		});


	}


	showeditdsrsalescurrentcart();

	function editsalescurrentcart(){
		let id = $("#product_id").val();
		let invoice_no = $("#invoice_no").val();

		$.ajax({
			url: "{{ url('editsalescurrentcart') }}/"+id+"/"+invoice_no,
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


				showeditdsrsalescurrentcart();

				$("#product_id").val('');


			},
			error:function(errors){
				alert("Product Already Added");
			}
		});

	}



	function showeditdsrsalescurrentcart(){

		let invoice_no = $("#invoice_no").val();

		$.ajax({
			url: "{{ url('showeditdsrsalescurrentcart') }}/"+invoice_no,
			type: 'get',
			data:{},
			success: function (data)
			{
				$("#showdata").html(data);
				var totalsalesamount = $("#totalsalesamount").val();
				$("#totalamount").val(totalsalesamount);
				$("#grandtotal").val(totalsalesamount);
				$("#paid").val(totalsalesamount);
				$("#due").val(0);
				
			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function editsalescartonupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let carton = $("#carton"+id).val();
		let invoice_no = $("#invoice_no").val();


		$.ajax({
			url: "{{ url('editsalescartonupdate') }}/"+id+"/"+invoice_no,
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

				showeditdsrsalescurrentcart();




			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function editsalespieceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let piece = $("#piece"+id).val();
		let invoice_no = $("#invoice_no").val();


		$.ajax({
			url: "{{ url('editsalespieceupdate') }}/"+id+"/"+invoice_no,
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

				showeditdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}








	function editsalesfreeupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let free = $("#free"+id).val();
		let invoice_no = $("#invoice_no").val();


		$.ajax({
			url: "{{ url('editsalesfreeupdate') }}/"+id+"/"+invoice_no,
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

				showeditdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function editsalesreturncartonupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let returnscarton = $("#returnscarton"+id).val();
		let invoice_no = $("#invoice_no").val();




		$.ajax({
			url: "{{ url('editsalesreturncartonupdate') }}/"+id+"/"+invoice_no,
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

				showeditdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function editsalesreturnpieceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let returnspiece = $("#returnspiece"+id).val();
		let invoice_no = $("#invoice_no").val();


		$.ajax({
			url: "{{ url('editsalesreturnpieceupdate') }}/"+id+"/"+invoice_no,
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

				showeditdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}






	function editsalesdamageupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let damage = $("#damage"+id).val();
		let invoice_no = $("#invoice_no").val();


		$.ajax({
			url: "{{ url('editsalesdamageupdate') }}/"+id+"/"+invoice_no,
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

				showeditdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function editsalespriceupdate(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let price = $("#price"+id).val();
		let invoice_no = $("#invoice_no").val();


		$.ajax({
			url: "{{ url('editsalespriceupdate') }}/"+id+"/"+invoice_no,
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

				showeditdsrsalescurrentcart();



			},
			error:function(errors){
				alert("errors")
			}
		});

	}




	function editsalesproductdiscount(id){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		let discount = $("#discount"+id).val();
		let invoice_no = $("#invoice_no").val();

		$.ajax({
			url: "{{ url('editsalesproductdiscount') }}/"+id+"/"+invoice_no,
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
		$("#grandtotal").val(parseFloat(totaldiscount.toFixed(2)));
		$("#paid").val(parseFloat(totaldiscount.toFixed(2)));

		let paid           = parseFloat($("#paid").val());

		let due = (parseFloat(totaldiscount)-parseFloat(paid));
		$("#due").val(parseFloat(due.toFixed(2)));



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
		$("#due").val(parseFloat(due.toFixed(2)));


	}




	$("#loading").hide();
	$("#submit").hide();
	

	$(".btn-submit").submit(function(e){
		e.preventDefault();

		$("#loading").show();
		$("#submit").hide();

		let invoice_no = $("#invoice_no").val();
		var status = $("#confirm").val();


		var data = $(this).serialize();
		$.ajax({
			url:'{{ url('editdsrsalesledger') }}/'+invoice_no,
			method:'POST',
			data:data,

			success:function(response){

				if (status == "1") {

					window.open('{{URL::to('/finaldsrsalesinvoice')}}'+'/'+response, "blank");
					location.href=('{{URL::to('/alldsrsalesledger')}}');

				}else{
					window.open('{{URL::to('/dsrsalesinvoice')}}'+'/'+response, "blank");
					location.href=('{{URL::to('/pendingalldsrsalesledger')}}');
				}

				

				$("#loading").hide();
				$("#submit").show();

				

			},

			error:function(error){
				console.log(error)
			}
		});
	});



	function confirmfunction(){

		var status = $("#confirm").val();

		if (status == "1" || status == "2") {
			$("#submit").show();
		}else{
			$("#submit").hide();
		}
	}

	

</script>


<style type="text/css">
	
	input:focus{
		border-color: red!important;
	}
</style>


@endsection


