@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;Edit Product <a href="{{ route('product.index') }}" class="float-right btn btn-dark btn-sm">Manage Product</a></h4><br>

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
						<form method="post" class="row" action="{{ route("product.update",$product) }}" enctype="multipart/form-data">

							@csrf
							@method('PUT')



							<div class="form-group col-md-6">
								<label>Product Name <span class="text-danger">*</span></label>
								<input type="text" name="product_name" class="form-control" required="" value="{{ $product->product_name }}">
							</div>



							<div class="form-group col-md-3">
								<label>Category <span class="text-danger">*</span></label>
								<select class="form-control" name="category_id" required="">
									<option value="">- - - - -</option>
									@foreach($category as $c)
									<option value="{{ $c->id }}" @if($c->id == $product->category_id) selected="" @endif>{{ $c->category_name }}</option>
									@endforeach
								</select>
							</div>


							<div class="form-group col-md-3">
								<label>Brand <span class="text-danger">*</span></label>
								<select class="form-control" name="brand_id" required="">
									<option value="">- - - - -</option>
									@foreach($brand as $c)
									<option value="{{ $c->id }}" @if($c->id == $product->brand_id) selected="" @endif>{{ $c->brand_name }}</option>
									@endforeach
								</select>
							</div>



							<div class="form-group col-md-3">
								<label>Group Unit <span class="text-danger">*</span></label>
								<select class="form-control" name="group_unit" required="">
									<option value="">- - - - -</option>
									<option value="Carton" @if($product->group_unit == "Carton") selected="" @endif>Carton</option>
									<option value="Jar" @if($product->group_unit == "Jar") selected="" @endif>Jar</option>
									<option value="Dozen" @if($product->group_unit == "Dozen") selected="" @endif>Dozen</option>
									<option value="Packet" @if($product->group_unit == "Packet") selected="" @endif>Packet</option>
									<option value="Box" @if($product->group_unit == "Box") selected="" @endif>Box</option>
									
								</select>
							</div>


							<div class="form-group col-md-3">
								<label>Unit Per Group: <span class="text-danger">*</span></label>
								<input type="number" name="unit_per_group" class="form-control" value="{{ $product->unit_per_group }}" required="">
							</div>

							<div class="form-group col-md-2">
								<label>Single Unit <span class="text-danger">*</span></label>
								<select class="form-control" name="single_unit" required="">
									<option value="">- - - - -</option>
									<option value="Piece" @if($product->single_unit == "Piece") selected="" @endif>Piece</option>
									<option value="Packet" @if($product->single_unit == "Packet") selected="" @endif>Packet</option>
									<option value="KG" @if($product->single_unit == "KG") selected="" @endif>KG</option>
									<option value="Bucket" @if($product->single_unit == "Bucket") selected="" @endif>Bucket</option>
									
								</select>
							</div>


							<div class="form-group col-md-2">
								<label>Purchase Price <span class="text-danger">*</span></label>
								<input type="text" name="purchase_price" class="form-control" required="" value="{{ $product->purchase_price }}">
							</div>

							<div class="form-group col-md-2">
								<label>Sales Price <span class="text-danger">*</span></label>
								<input type="text" name="sales_price" class="form-control" required="" value="{{ $product->sales_price }}">
							</div>

							<div class="form-group col-md-3">
								<label>Opening Stocks:</label>
								<input type="number" name="opening_stock" class="form-control"  value="{{ $product->opening_stock }}">
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


