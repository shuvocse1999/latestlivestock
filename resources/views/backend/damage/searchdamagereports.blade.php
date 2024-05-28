
@extends('backend.reports.layouts.index')
@section('content')

<title>Stocks Reports</title>

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
			<td colspan="7" style="text-align:center;font-size: 15px;text-transform: capitalize;font-weight: bold; letter-spacing: 1px; padding: 10px;"><b>
				<br>Damage Reports</b>
				@if($startdate != null) {{ date('d M Y',strtotime($startdate)) }} @endif @if($to_date != null)- - - {{ date('d M Y',strtotime($to_date)) }} @endif

			</td>
		</tr>




		<!-- <thead> -->
			<tr class="bg-light " style="font-weight: bold; letter-spacing: 0.6px;">

				<td>SL.</td>
				<td width="400">Product</td>
				<td>Damage (P)</td>
				<td>Purchase (P)</td>
				<td>Total Purchase</td>
				<td>Sales (P)</td>
				<td>Total Sales</td>

			</tr>
			<!-- </thead> -->



			<tbody>


				@php $i =1; $damagevalue = 0; $totalpurchase = 0; $totalsales = 0; @endphp
				@if(isset($product))
				@foreach($product as $d)

				@php

				if ($to_date == null) {

					$damage = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->sum("damage");


				}else{

					$damage = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($startdate,$to_date))->sum("damage");
				}

				$totalpurchase += $damage*($d->purchase_price/$d->unit_per_group);
				$totalsales    += $damage*($d->sales_price/$d->unit_per_group);

				@endphp

				@if($damage > 0)

				<tr>
					<td>{{ $i++ }}</td>
					<td class="text-left">{{ $d->product_name }}<br><span style="font-size: 12px;">{{ $d->unit_per_group }} {{ $d->single_unit }} {{ $d->group_unit }}</span></td>
					<td>{{ $damage }}</td>
					<td>{{ number_format($d->purchase_price/$d->unit_per_group,2) }}</td>
					<td>{{ number_format($damage*($d->purchase_price/$d->unit_per_group),2) }}</td>
					<td>{{ number_format($d->sales_price/$d->unit_per_group,2) }}</td>
					<td>{{ number_format($damage*($d->sales_price/$d->unit_per_group),2) }}</td>
				</tr>

				@endif



				

				@endforeach
				@endif

				

			</tbody>

			

			<tr>
				<th colspan="4" class="text-right">Damage Purchase Value</th>
				<th>{{ number_format($totalpurchase,2) }} /-</th>
				<th class="text-right">Damage Sales Value</th>
				<th>{{ number_format($totalsales,2) }} /-</th>
			</tr>


		</table>




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
		<center><a href="#" class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</a></center>
		<br>

	</div>



	@endsection



