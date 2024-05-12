@extends('backend.staffdashboard.index')
@section('content')

<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All Shop <a href="{{ route("shop.create") }}"  class="float-right btn btn-dark btn-sm">Add Shop</a></h4>



					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Shop Name</th>
									<th>Number</th>
									<th>Address</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>
								@php $i =1; @endphp
								@if(isset($shop))
								@foreach($shop as $d)



								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ $d->shop_name }}</td>
									<td>{{ $d->shop_number }}</td>
									<td>{{ $d->shop_address }}</td>

									<td>
										<div class="dropdown">
											<button class="btn btn-primary text-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Select Option
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="{{ route("shop.edit",$d->id) }}">Edit</a>

												<a class="dropdown-item" href="{{ url("deleteshop/".$d->id) }}" onclick="return confirm('Are you sure?')">Delete</a>

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