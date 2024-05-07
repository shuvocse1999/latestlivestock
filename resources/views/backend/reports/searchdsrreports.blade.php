
@extends('backend.reports.layouts.index')
@section('content')

<title>DSR Reports</title>

@php
use NumberToWords\NumberToWords;
$numberToWords = new NumberToWords();
$numberTransformer = $numberToWords->getNumberTransformer('en');

@endphp




<div class="invoice">
{{-- 
	<center><img src="{{ url($company_info->banner) }}" id="header_image" class="img-fluid" style="max-height: 130px;"></center> --}}

	<br>


	<table class="table table-bordered w-100">
		<tr class="bg-light">
			<td colspan="11" style="text-align:center;font-size: 14px;text-transform: capitalize;letter-spacing: 1px; padding: 10px;"><b>Didar Enterprise Limited - Olympic
				<br>DSR Sales Reports</b>
				<br>
				@if($from_date != null) {{ date('d M Y',strtotime($from_date)) }} @endif @if($to_date != null)- - - {{ date('d M Y',strtotime($to_date)) }} @endif

			</td>
		</tr>




		<!-- <thead> -->
			<tr class="bg-light text-center" style="font-weight: bold; letter-spacing: 0.6px;">

				<td>SL.</td>
				<td>DSR Info.</td>
				<td>Invoice</td>
				<td>Total</td>
				<td>Discount</td>
				<td>Transport Cost</td>
				<td>DSR Cost</td>
				<td>Grand Total</td>
				<td>Paid</td>
				<td>Due</td>

			</tr>
			<!-- </thead> -->



			<tbody>


				@php $i =1; $dtotal = 0; $ddiscount=0; $dtransportcost=0; $ddsrcost=0; $dgrandtotal=0; $dpaid=0; $ddue=0; @endphp
				@if(isset($ledger))
				@foreach($ledger as $d)

				@php
				$dtotal += $d->total;
				$ddiscount += $d->discount;
				$dtransportcost += $d->transport_cost;
				$ddsrcost += $d->dsr_cost;
				$dgrandtotal += $d->grandtotal;
				$dpaid += $d->paid;
				$ddue += $d->due;
				@endphp


				<tr class="text-center">
					<td>{{ $i++ }}</td>
					<td>{{ $d->staff_name }}</td>
					<td>{{ $d->invoice_no }}<br>{{ date('d M Y',strtotime($d->invoice_date)) }}</td>
					<td>{{ number_format($d->total,2) }}</td>
					<td>{{ number_format($d->discount,2) }}</td>
					<td>{{ number_format($d->transport_cost,2) }}</td>
					<td>{{ number_format($d->dsr_cost,2) }}</td>
					<td>{{ number_format($d->grandtotal,2) }}</td>
					<td>{{ number_format($d->paid,2) }}</td>
					<td>{{ number_format($d->due,2) }}</td>
					
					
				</tr>



				@endforeach
				@endif

				

			</tbody>

			<tr class="text-center" style="font-size: 15px;">
				<th colspan="3" class="text-right">Total - </th>
				<th>{{ number_format($dtotal,2) }}</th>
				<th>{{ number_format($ddiscount,2) }}</th>
				<th>{{ number_format($dtransportcost,2) }}</th>
				<th>{{ number_format($ddsrcost,2) }}</th>
				<th>{{ number_format($dgrandtotal,2) }}</th>
				<th>{{ number_format($dpaid,2) }}</th>
				<th>{{ number_format($ddue,2) }}</th>
			</tr>




		</table>


		<br>

		<table class="table table-bordered w-100">
			<tr class="bg-light">
				<td colspan="11" style="text-align:center;font-size: 14px;text-transform: capitalize; letter-spacing: 1px; padding: 10px;"><b>Due Payment Reports</b>
					<br>
					@if($from_date != null) {{ date('d M Y',strtotime($from_date)) }} @endif @if($to_date != null)- - - {{ date('d M Y',strtotime($to_date)) }} @endif

				</td>
			</tr>




			<!-- <thead> -->
				<tr class="bg-light text-center" style="font-weight: bold; letter-spacing: 0.6px;">

					<th>SL.</th>
					<th>DSR Name</th>
					<th>Date</th>
					<th>Payment Type</th>
					<th>Note</th>
					<th>Discount</th>
					<th>Paid</th>
					

				</tr>
				<!-- </thead> -->



				<tbody>


					@php $i =1; $ddiscountp = 0; $dpaidp = 0; @endphp
					@if(isset($duepayment))
					@foreach($duepayment as $d)

					@php
					$ddiscountp += $d->discount;
					$dpaidp += $d->payment;
					@endphp


					<tr class="text-center">
						<td>{{ $i++ }}</td>
						<td>{{ $d->staff_name }}</td>
						<td>{{ date('d M Y',strtotime($d->payment_date)) }}</td>
						<td>{{ $d->payment_type }}</td>
						<td>{{ $d->note }}</td>
						<td>{{ number_format($d->discount,2) }} </td>
						<td>{{ number_format($d->payment,2) }} </td>
						



					</tr>

					@endforeach
					@endif


				</tbody>

				<tr class="text-center" style="font-size: 15px;">
					<th colspan="5" class="text-right">Total - </th>
					<th>{{ number_format($ddiscountp,2) }}</th>
					<th>{{ number_format($dpaidp,2) }}</th>
				</tr>
				



			</table>

			<br>
			
			<div style="max-width: 500px; margin: 0 auto; ">
				<table class="table table-bordered text-center">
					<tr class="bg-light" style="font-size: 15px;">
						<th colspan="2">Calculation</th>
					</tr>

					<tr style="font-size: 15px;">
						<th>Total Sales</th>
						<th>{{ number_format($dgrandtotal,2) }}</th>
					</tr>

					<tr style="font-size: 15px;">
						<th>Total Paid</th>
						<th>{{ number_format($dpaid+$dpaidp,2) }}</th>
					</tr>

					<tr style="font-size: 15px;">
						<th>Total Discount</th>
						<th>{{ number_format($ddiscountp,2) }}</th>
					</tr>

					<tr style="font-size: 15px;">
						<th>Total Due</th>
						<th>{{ number_format($dgrandtotal - ($dpaid+$dpaidp+$ddiscountp),2) }}</th>
					</tr>
				</table>
			</div>




			<br>
			<br>

			<div class="row" style="font-size: 14px;">
				<div class="col-4">
					--------------------<br>
					Manager Signature
				</div>
				<div class="col-4" style="text-align:center;">
					--------------------<br>
					Prepared By
				</div>
				<div class="col-4" style="text-align:right;">
					--------------------<br>
					Authorized  Signature
				</div>
			</div>
			<br>
			<center><span style="font-size: 13px; color: gray;">Developer By SoftwarefarmBD. <br>Phone: 01788283580</span></center>
			<br>
			<center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
			<br>

		</div>




		@endsection
