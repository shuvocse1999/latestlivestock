@extends('backend.staffdashboard.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;Shop Payment<a href="{{ url('allshoppayment') }}" class="float-right btn btn-dark btn-sm">Manage Shop Payment</a></h4><br>

					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif

					@if(Session::has('message'))
					<h5 class="alert alert-success">{{ Session::get('message') }}</h5>
					@endif
					


					<div class="basic-form">
						<form method="post" class="row" action="{{ url("shoppaymententry") }}" enctype="multipart/form-data">

							@csrf




							<div class="form-group col-md-3">
								<label class="mb-1">Date: <span class="text-danger" style="font-size: 15px;">*</span></label>
								<input type="date" name="date" id="date" class="form-control" required="">
							</div>

							
							
							<div class="form-group col-md-9">
								<label class="mb-1">Shop Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group mb-2">
									<select class="form-control myselect" name="shop_id" id=
									"shop_id" required="" onchange="return getshopdue()">

									<option value="">- - - - -</option>

									@foreach($shop as $s)
									<option value="{{ $s->id }}">{{ $s->shop_name }} - {{ $s->shop_number }}</option>
									@endforeach


								</select>

							</div>
						</div>



						<div class="form-group col-md-3">
							<label>Due <span class="text-danger">*</span></label>
							<input type="text" name="due" id="due" class="form-control bg-danger text-white" readonly="" style="font-size: 20px;">
						</div>



						<div class="form-group col-md-5">
							<label>Paid <span class="text-danger">*</span></label>
							<input type="text" name="payment" id="payment" class="form-control" required="">
						</div>


						<div class="form-group col-md-4">
							<label>Discount:</label>
							<input type="text" name="discount" id="discount" class="form-control">
						</div>


						<div class="form-group col-md-8">
							<label>Note:</label>
							<input type="text" name="note" id="note" class="form-control">
						</div>


						<div class="form-group col-md-4">
							<label class="mb-1">Payment By:</label>
							<div class="input-group mb-2">
								<select class="form-control" name="payment_type" id="payment_type">
									<option value="Cash">Cash</option>
									<option value="Bank">Bank</option>
									<option value="Mobile Banking">Mobile Banking</option>

								</select>

							</div>
						</div>



						<div class="form-group col-md-12">
							<button type="submit" class="btn btn-primary">Save Now</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
</div>



<script type="text/javascript">
	function getshopdue(){


		var shop_id = $("#shop_id").val();

		$.ajax({
			url: "{{ url("getshopdue") }}/"+shop_id,
			type: "get",
			success: function (response) {

				$("#due").val(response);
			},
			error:function(errors){

				$("#due").val(0);

			}
		});


	}

</script>


@endsection


