@extends('backend.staffdashboard.index')
@section('content')

<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All Recieved Lists </h4>
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
									<td>{{ date('d M Y',strtotime($d->invoice_date)) }}</td>
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

											
												<a class="dropdown-item p-2" href="{{ url("dsrpurchaseinvoice/".$d->invoice_no) }}" target="blank">View Invoice</a>

											


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