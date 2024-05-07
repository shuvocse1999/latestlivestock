
@extends('backend.reports.layouts.index')
@section('content')

<title>Profit Reports</title>

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
				<br>Profit Reports</b>
				<br>
				{{ date('d M Y',strtotime($from_date)) }} @if($to_date != null)- - - {{ date('d M Y',strtotime($to_date)) }} @endif

			</td>
		</tr>
	</table>


	<div class="row">

		<div class="col-12">
			<table class="table table-bordered w-100">

				<tr class="text-center">
					<th colspan="5">Product Sales</th>
				</tr>


				<!-- <thead> -->
					<tr class="bg-light text-center" style="font-weight: bold; letter-spacing: 0.6px;">

						<td>SL.</td>
						<td>Product Name</td>
						<td>Carton/Pices</td>
						<td>QTY</td>
						<td>Taka</td>

					</tr>
					<!-- </thead> -->



					<tbody>


						@php $i =1; $sdiscount=0; $spayment=0; $prevsalesvalue =0; @endphp
						@if(isset($data['sales']))
						@foreach($data['sales'] as $d)

						@php

						if ($to_date == null) {

							$scarton = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->where(substr('created_at', 0,10),$from_date)->sum("carton");
							$spiece = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->where(substr('created_at', 0,10),$from_date)->sum("piece");

							$sqty = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->where(substr('created_at', 0,10),$from_date)->sum("qty");

							$returnqty = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->where(substr('created_at', 0,10),$from_date)->sum("returnqty");

						}else{

							$scarton = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($from_date,$to_date))->sum("carton");

							$spiece = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($from_date,$to_date))->sum("piece");

							$sqty = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($from_date,$to_date))->sum("qty");


							$returnqty = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($from_date,$to_date))->sum("returnqty");


						}


						$piecesPerCarton = $d->unit_per_group;

						$salescartons = floor($sqty / $piecesPerCarton);
						$salesremainingPieces = $sqty % $piecesPerCarton;

						$finalsalesqty = $sqty - $returnqty;
						$finalsalescartons = floor($finalsalesqty / $piecesPerCarton);
						$finalsalesremainingPieces = $finalsalesqty % $piecesPerCarton;

						$picessalespricee = $d->sales_price/$piecesPerCarton;

						$prevsalesvalue += $finalsalesqty*$picessalespricee;

						@endphp

						@if($finalsalesqty > 0)

						<tr class="text-center">
							<td>{{ $i++ }}</td>
							<td>{{ $d->product_name }}</td>
							<td>{{ $finalsalescartons }} - {{ $finalsalesremainingPieces }}</td>
							<td>{{ $finalsalesqty }}</td>
							<td>{{ number_format($finalsalesqty*$picessalespricee,2) }}</td>
						</tr>


						@endif

						@endforeach
						@endif



					</tbody>

					<tr class="text-center" style="font-size: 15px;">
						<th colspan="4" class="text-right">Total - </th>
						<th>{{ number_format($prevsalesvalue,2) }}</th>
					</tr>




				</table>




				<table class="table table-bordered w-100">

					<tr class="text-center">
						<th colspan="4">Income</th>
					</tr>


					<!-- <thead> -->
						<tr class="bg-light text-center" style="font-weight: bold; letter-spacing: 0.6px;">

							<td>SL.</td>
							<td>Date</td>
							<td>Title</td>
							<td>Payment</td>

						</tr>
						<!-- </thead> -->



						<tbody>


							@php $i =1;  $ipayment=0; @endphp
							@if(isset($data['income']))
							@foreach($data['income'] as $d)

							@php
							$ipayment  += $d->amount;
							@endphp


							<tr class="text-center">
								<td>{{ $i++ }}</td>
								<td>{{ date('d M Y',strtotime($d->dates)) }}</td>
								<td>{{ $d->title }}</td>
								<td>{{ number_format($d->amount,2) }}</td>

							</tr>



							@endforeach
							@endif



						</tbody>

						<tr class="text-center" style="font-size: 15px;">
							<th colspan="3" class="text-right">Total - </th>
							<th>{{ number_format($ipayment,2) }}</th>
						</tr>




					</table>




				<table class="table table-bordered w-100">

					<tr class="text-center">
						<th colspan="4">Expense</th>
					</tr>


					<!-- <thead> -->
						<tr class="bg-light text-center" style="font-weight: bold; letter-spacing: 0.6px;">

							<td>SL.</td>
							<td>Date</td>
							<td>Title</td>
							<td>Payment</td>

						</tr>
						<!-- </thead> -->



						<tbody>


							@php $i =1;  $epayment=0; @endphp
							@if(isset($data['expense']))
							@foreach($data['expense'] as $d)

							@php
							$epayment  += $d->amount;
							@endphp


							<tr class="text-center">
								<td>{{ $i++ }}</td>
								<td>{{ date('d M Y',strtotime($d->dates)) }}</td>
								<td>{{ $d->title }}</td>
								<td>{{ number_format($d->amount,2) }}</td>

							</tr>



							@endforeach
							@endif



						</tbody>

						<tr class="text-center" style="font-size: 15px;">
							<th colspan="3" class="text-right">Total - </th>
							<th>{{ number_format($epayment,2) }}</th>
						</tr>




					</table>




				</div>
			</div>



			<br>
			<div class="col-md-12" style="max-width: 500px; margin: 0 auto;">
				<table class="table table-bordered">
					<tr class="text-center bg-light">
						<th colspan="2">Calculation</th>
					</tr>


					<tr style="font-size:15px;">
						<td>Total Sales</td>
						<td>{{ number_format(($prevsalesvalue),2) }}/-</td>
					</tr>


					<tr style="font-size:15px;">
						<td>Comission (4.5%)</td>
						<td>

							@php
							$comission = ($prevsalesvalue*4.5)/100;
							@endphp

							{{ number_format(($comission),2) }}/-
						</td>
					</tr>

					<tr style="font-size:15px;">
						<td>Company Comission (1%)</td>
						<td>
							@php
							$comapny_comission = ($prevsalesvalue*1)/100;
							@endphp
							{{ number_format(($comapny_comission),2) }}/-
						</td>
					</tr>



					<tr style="font-size:15px;">
						<td>Other Income</td>
						<td>{{ number_format($ipayment,2) }}/-</td>
					</tr>



					<tr style="font-size:15px;">
						<td>Expense/Transport</td>
						<td>{{ number_format($epayment,2) }}/-</td>
					</tr>


					<tr style="font-size:15px;">
						<td>DSR Cost</td>
						<td>{{ number_format(($dcost),2) }}/-</td>
					</tr>


					<tr style="font-size:15px;" style="font-size: 16px;">

						@php
						$profit = ($comission + $comapny_comission + $ipayment) -($epayment + $dcost);
						@endphp

						<th>Total Profit</th>
						<th>{{ number_format($profit,2) }}/-</th>
					</tr>
				</table>
			</div>




			<br>



			<br>
			<br>

			<div class="row" style="font-size: 14px;">
				<div class="col-4">
					--------------------<br>
					Manager Signature
				</div>
				<div class="col-4" style="text-align:center;">

					{{ Auth()->user()->name }}<br>
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