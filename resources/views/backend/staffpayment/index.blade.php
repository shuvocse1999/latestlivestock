@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All DSR Payment <a href="{{ url("staffpayment") }}"  class="float-right btn btn-dark btn-sm">Add DSR Payment</a></h4>
					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Date</th>
									<th>Name</th>
									<th>Paid</th>
									<th>Discount</th>
									<th>Payment Type</th>
									<th>Note</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>

								@php $i =1; @endphp
								@if(isset($data))
								@foreach($data as $d)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ date('d M Y',strtotime($d->payment_date)) }}</td>
									<td>{{ $d->staff_name }}</td>
									<td>{{ number_format($d->payment,2) }} </td>
									<td>{{ number_format($d->discount,2) }} </td>
									<td>{{ $d->payment_type }}</td>
									<td>{{ $d->note }}</td>

									<td>
										<div class="dropdown">
											<button class="btn btn-primary text-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Select Option
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item p-2" href="{{ url("deletestaffpayment/".$d->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
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