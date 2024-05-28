
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
			<td colspan="7" style="text-align:center;font-size: 15px;text-transform: capitalize;font-weight: bold; letter-spacing: 1px; padding: 10px;">Stock Reports</b>
				<br>
				@if($to_date != null) {{ date('d M Y',strtotime($startdate)) }} @endif @if($to_date != null)- - - {{ date('d M Y',strtotime($to_date)) }} @endif

			</td>
		</tr>




		<!-- <thead> -->
			<tr class="bg-light " style="font-weight: bold; letter-spacing: 0.6px;">

				<td>SL.</td>
				<td style="width:500px;">Product</td>
				{{-- <td>Recieved qty</td>
				<td>Sales qty</td> --}}
				<td>R. Carton/Piece</td>
				<td>S. Carton/Piece</td>
				<td>Free</td>
				<td>Available</td>

			</tr>
			<!-- </thead> -->



			<tbody>


				@php $i =1; $stockvalue = 0; $salesvalue = 0; $damagevalue =0; $prevsalesvalue = 0; @endphp
				@if(isset($product))
				@foreach($product as $d)

				@php

				if ($to_date == null) {

					$rcarton = DB::table("stocks")->where("product_id",$d->id)->where('status',"purchase")->sum("carton");
					$rpiece = DB::table("stocks")->where("product_id",$d->id)->where('status',"purchase")->sum("piece");

					$rqty = DB::table("stocks")->where("product_id",$d->id)->where('status',"purchase")->sum("qty");
					$rfree = DB::table("stocks")->where("product_id",$d->id)->where('status',"purchase")->sum("free");

					$scarton = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->sum("carton");
					$spiece = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->sum("piece");

					$sqty = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->sum("qty");

					$returnqty = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->sum("returnqty");

					$damage = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->sum("damage");
					$sfree = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->sum("free");
					
				}else{
					$rcarton = DB::table("stocks")->where("product_id",$d->id)->where('status',"purchase")->sum("carton");
					$rpiece = DB::table("stocks")->where("product_id",$d->id)->where('status',"purchase")->sum("piece");

					$rqty = DB::table("stocks")->where("product_id",$d->id)->where('status',"purchase")->sum("qty");
					$rfree = DB::table("stocks")->where("product_id",$d->id)->where('status',"purchase")->sum("free");

					$scarton = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($startdate,$to_date))->sum("carton");
					$spiece = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($startdate,$to_date))->sum("piece");

					$sqty = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($startdate,$to_date))->sum("qty");

					$returnqty = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($startdate,$to_date))->sum("returnqty");



					$damage = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($startdate,$to_date))->sum("damage");
				

					$sfree = DB::table("stocks")->where("product_id",$d->id)->where('status',Null)->whereBetween(substr('created_at', 0,10),array($startdate,$to_date))->sum("free");
				}
				

				$availablecarton = $rcarton-$scarton;
				$availablepiece  = $rpiece-$spiece;

				$piecesPerCarton = $d->unit_per_group;



				$returncartons = floor($returnqty / $piecesPerCarton);
				$returnremainingPieces = $returnqty % $piecesPerCarton;

				$recievecartons = floor($rqty / $piecesPerCarton);
				$recieveremainingPieces = $rqty % $piecesPerCarton;

				$salescartons = floor($sqty / $piecesPerCarton);
				$salesremainingPieces = $sqty % $piecesPerCarton;

				$finalsalesqty = $sqty - $returnqty;
				$finalsalescartons = floor($finalsalesqty / $piecesPerCarton);
				$finalsalesremainingPieces = $finalsalesqty % $piecesPerCarton;


				$available = $rqty- $finalsalesqty;
				$pieces = $available;

				$availablecartons = floor($pieces / $piecesPerCarton);
				$availableremainingPieces = $pieces % $piecesPerCarton;

				$availablefree = $rfree - $sfree;

				$picespurchasepricee = $d->purchase_price/$piecesPerCarton;
				$picessalespricee = $d->sales_price/$piecesPerCarton;

				$stockvalue += ($availablecartons*$d->purchase_price) + ($availableremainingPieces*$picespurchasepricee);

				$salesvalue += ($availablecartons*$d->sales_price) + ($availableremainingPieces*$picessalespricee);

				$damagevalue += $damage*($d->purchase_price/$piecesPerCarton);

				$prevsalesvalue += $finalsalesqty*$picessalespricee;


				@endphp


	
			
				<tr class="">
					<td>{{ $i++ }}</td>
					<td class="text-left">{{ $d->product_name }}<br><span style="font-size: 12px;">{{ $d->unit_per_group }} {{ $d->single_unit }} {{ $d->group_unit }}</span></td>
					{{-- <td>{{ $rqty }} P</td>
					<td>{{ $finalsalesqty }} P </td> --}}
					<td>{{ $recievecartons }} : {{ $recieveremainingPieces }}</td>
					<td>{{ $finalsalescartons }} : {{ $finalsalesremainingPieces }}</td>
					<th>{{ $availablefree }} P</th>
					<td class="font-weight-bold">{{ $pieces }}P<br>{{ $availablecartons }} : {{ $availableremainingPieces }}</td>
				</tr>

			
				

				@endforeach
				@endif

				

			</tbody>

			<tr>
				<th colspan="5" class="text-right">Previous Sales Value</th>
				<th>{{ number_format($prevsalesvalue,2) }} /-</th>
			</tr>


			<tr>
				<th colspan="5" class="text-right">Available Stock Value</th>
				<th>{{ number_format($stockvalue,2) }} /-</th>
			</tr>

			<tr>
				<th colspan="5" class="text-right">Available Sales Value</th>
				<th>{{ number_format($salesvalue,2) }} /-</th>
			</tr>

		{{-- 	<tr class="text-center">
				<th colspan="6" class="text-right">Profit</th>
				<th>{{ number_format($salesvalue-$stockvalue) }}</th>
			</tr>
 --}}



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



