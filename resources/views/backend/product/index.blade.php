@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All Product <a href="{{ route("product.create") }}"  class="float-right btn btn-dark btn-sm">Add Product</a></h4>
					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Product</th>
									<th>Category</th>
									<th>Brand</th>
									<th>Measurement</th>
									
									<th>Purchase</th>
									<th>Sales</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>

								@php $i =1; @endphp
								@if(isset($product))
								@foreach($product as $d)
								<tr>
									<td>{{ $i++ }}</td>
									<th>{{ $d->product_name }}</th>
									<td>{{ $d->category_name }}</td>
									<td>{{ $d->brand_name }}</td>
									<td>{{ $d->group_unit }}<br>{{ $d->unit_per_group }} {{ $d->single_unit }}</td>
									
									<td>{{ $d->purchase_price }}/-</td>
									<td>{{ $d->sales_price }}/-</td>
									
									<td>
										<div class="dropdown">
											<button class="btn btn-primary text-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Select Option
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="{{ route("product.edit",$d->id) }}" >Edit</a>

												 @if(Auth::user()->type == 1)
												<a class="dropdown-item" href="{{ url("deleteproduct/".$d->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
												@endif
											</div>
										</div>
										
									</td>

								</tr>

								@endforeach
								@endif

							</table>
						</div>
					</div>
				</div>
			</div>




		</div>
	</div>




	@endsection