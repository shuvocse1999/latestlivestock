@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp; Product <a href="{{ route('product.index') }}" class="float-right btn btn-dark btn-sm">Manage Product</a></h4><br>

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
						<form method="post" class="row" action="{{ route("product.store") }}" enctype="multipart/form-data">

							@csrf



							<div class="form-group col-md-8">
								<label>Product Name <span class="text-danger">*</span></label>
								<input type="text" name="product_name" class="form-control" required="">
							</div>



							<div class="form-group col-md-4">
								<label>Category <span class="text-danger">*</span></label>
								<select class="form-control" name="category_id" required="">
									<option value="">- - - - -</option>
									@foreach($category as $c)
									<option value="{{ $c->id }}">{{ $c->category_name }}</option>
									@endforeach
								</select>
							</div>

							<input type="hidden" name="brand_id" value="1">

{{-- 
							<div class="form-group col-md-3">
								<label>Brand <span class="text-danger">*</span></label>
								<select class="form-control" name="brand_id" required="">
									<option value="">- - - - -</option>
									@foreach($brand as $c)
									<option value="{{ $c->id }}">{{ $c->brand_name }}</option>
									@endforeach
								</select>
							</div>
 --}}


							<div class="form-group col-md-3">
								<label>Group Unit <span class="text-danger">*</span></label>
								<select class="form-control" name="group_unit" required="">
									<option value="">- - - - -</option>
									<option value="CARTON">CARTON</option>
									<option value="DOZEN">DOZEN</option>
									<option value="PCS">PCS</option>
									<option value="BOX">BOX</option>
									<option value="KG">KG</option>
									<option value="BAG">BAG</option>
									<option value="PACKET">PACKET</option>

									
								</select>
							</div>


							<div class="form-group col-md-3">
								<label>Unit Per Group: <span class="text-danger">*</span></label>
								<input type="number" name="unit_per_group" class="form-control" required="">
							</div>

							<div class="form-group col-md-2">
								<label>Single Unit <span class="text-danger">*</span></label>
								<select class="form-control" name="single_unit" required="">
									<option value="">- - - - -</option>
									<option value="CARTON">CARTON</option>
									<option value="DOZEN">DOZEN</option>
									<option value="PCS">PCS</option>
									<option value="BOX">BOX</option>
									<option value="KG">KG</option>
									<option value="BAG">BAG</option>
									<option value="PACKET">PACKET</option>

									
								</select>
							</div>


							<div class="form-group col-md-2">
								<label>Purchase Price <span class="text-danger">*</span></label>
								<input type="text" name="purchase_price" class="form-control" required="">
							</div>

							<div class="form-group col-md-2">
								<label>Sales Price <span class="text-danger">*</span></label>
								<input type="text" name="sales_price" class="form-control" required="">
							</div>

							<div class="form-group col-md-3 d-none">
								<label>Opening Stocks:</label>
								
							</div>

							<input type="hidden" name="opening_stock" class="form-control" value="0">










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


