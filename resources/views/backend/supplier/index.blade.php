@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All Supplier <a href="{{ route("supplier.create") }}"  class="float-right btn btn-dark btn-sm">Add Supplier</a></h4>
					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Name</th>
									<th>Contact Person</th>
									<th>Phone</th>
									<th>Address</th>
									<th>Opening Balance</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>

								@php $i =1; @endphp
								@if(isset($supplier))
								@foreach($supplier as $d)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ $d->supplier_name }}</td>
									<td>{{ $d->contact_person }}</td>
									<td>{{ $d->phone }}</td>
									<td>{{ $d->address }}</td>
									<td>{{ $d->opening_balance }}/-</td>

									<td>
										<div class="dropdown">
											<button class="btn btn-primary text-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Select Option
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="{{ route("supplier.edit",$d->id) }}">Edit</a>

												 @if(Auth::user()->type == 1)

												<a class="dropdown-item" href="{{ url("deletesupplier/".$d->id) }}" onclick="return confirm('Are you sure?')">Delete</a>

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