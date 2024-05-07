@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All DSR <a href="{{ route("staff.create") }}"  class="float-right btn btn-dark btn-sm">Add DSR</a></h4>



					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Joining Date</th>
									<th>Staff Info.</th>
									<th>Salary</th>
									<th>Phone</th>
									<th>Address</th>
									<th>Due</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>

								@php $i =1; @endphp
								@if(isset($staff))
								@foreach($staff as $d)

								@php

								$staff_id = $d->id;

								$invoicedue = DB::table("sales_ledger")
								->where("staff_id",$staff_id)
								->sum("due");

								$paiddue = DB::table("sales_payment")
								->where("staff_id",$staff_id)
								->where("invoice_no","duepayment")
								->sum("payment");

								$discount = DB::table("sales_payment")
								->where("staff_id",$staff_id)
								->where("invoice_no","duepayment")
								->sum("discount");

								$due = $invoicedue - ($paiddue+$discount);
								@endphp


								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ date('d M Y',strtotime($d->joining_date)) }}</td>
									<td>
										<span class="btn btn-primary text-white btn-sm">Name: {{ $d->staff_name }}</span><br>
										Father: {{ $d->father_name }}<br>
										Mother: {{ $d->mother_name }}<br>
										NID: {{ $d->nid }}

									</td>
									<td>{{ number_format($d->salary) }}/-</td>
									<td>{{ $d->phone }}</td>
									<td>{{ $d->address }}</td>
									<td>

										@if($due >= 0)
										<span class="btn btn-success text-white font-weight-bold w-100">{{ number_format($due,2) }} </span>
										@else
										 <span class="btn btn-danger text-white font-weight-bold w-100">{{ number_format($due,2) }} </span>
										@endif

									</td>
									

									<td>
										<div class="dropdown">
											<button class="btn btn-primary text-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Select Option
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item" href="{{ route("staff.edit",$d->id) }}">Edit</a>

												 @if(Auth::user()->type == 1)
												<a class="dropdown-item" href="{{ url("deletestaff/".$d->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
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