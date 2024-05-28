@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All Sales Lists <a href="{{ url("sales") }}" class="float-right btn btn-dark btn-sm">New Sales</a></h4>
					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Date</th>
									<th>Invoice</th>
									<th>DSR</th>
									<th>Grand Total</th>
									<th>Paid</th>
									<th>Due</th>
									<th>Type</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>

								@php $i =1; @endphp
								@if(isset($data))
								@foreach($data as $d)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ date('d M Y',strtotime($d->invoice_date)) }}<br><span class="btn btn-success btn-sm text-white">{{ $d->name }}</span></td>
									<td>{{ $d->invoice_no }}</td>
									<td>{{ $d->staff_name }}</td>
									<td>{{ number_format($d->grandtotal,2) }}</td>
									<td>{{ number_format($d->paid,2) }}</td>
									<td>{{ number_format($d->due,2) }}</td>
									<td>{{ $d->transaction_type }}</td>
									
									<td>
										<div class="dropdown">
											<button class="btn btn-primary text-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Select Option
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

											
												<a class="dropdown-item p-2" href="{{ url("finalsalesinvoice/".$d->invoice_no) }}" target="blank">Final Invoice</a>

													<a class="dropdown-item p-2" href="{{ url("editsales/".$d->id) }}">Edit</a>
										
												
												<a class="dropdown-item p-2" href="{{ url("deletesalesledger/".$d->id) }}" onclick="return confirm('Are you sure?')">Delete</a>

											


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