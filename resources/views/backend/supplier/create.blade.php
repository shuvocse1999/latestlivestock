@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp; Supplier <a href="{{ route('supplier.index') }}" class="float-right btn btn-dark btn-sm">Manage Supplier</a></h4><br>

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
						<form method="post" class="row" action="{{ route("supplier.store") }}" enctype="multipart/form-data">

							@csrf



							<div class="form-group col-md-6">
								<label>Supplier Name <span class="text-danger">*</span></label>
								<input type="text" name="supplier_name" class="form-control" required="">
							</div>



							<div class="form-group col-md-3">
								<label>Contact Person</label>
								<input type="text" name="contact_person" class="form-control" required="">
							</div>

							<div class="form-group col-md-3">
								<label>Phone <span class="text-danger">*</span></label>
								<input type="number" name="phone" class="form-control" required="">
							</div>

							<div class="form-group col-md-6">
								<label>Address</label>
								<input type="text" name="address" class="form-control">
							</div>


							<div class="form-group col-md-3">
								<label>Opening Balance:</label>
								<input type="number" name="opening_balance" class="form-control" value="0">
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

@endsection


