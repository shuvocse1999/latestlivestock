@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All Admin <a href="{{ route("staff.create") }}"  class="float-right btn btn-dark btn-sm">Add Admin</a></h4>



					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Name</th>
									<th>Email</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>

								@php $i =1; @endphp
								@if(isset($user))
								@foreach($user as $d)

								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ $d->name }}</td>
									<td>{{ $d->email }}</td>

									<td>
										<div class="dropdown">
											<button class="btn btn-primary text-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Select Option
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item p-2" href="{{ route("admin.edit",$d->id) }}">Edit</a>
												<a class="dropdown-item p-2" href="{{ url("deleteadmin/".$d->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
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