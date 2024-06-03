
@extends('backend.reports.layouts.index')
@section('content')

<title>Stocks Reports</title>

@php
use NumberToWords\NumberToWords;
$numberToWords = new NumberToWords();
$numberTransformer = $numberToWords->getNumberTransformer('en');

@endphp


<div class="invoice">

	<h4><center><b>{{ $staff_name->staff_name }} Stock Reports</b></center></h4><br>


	<table class="table table-bordered w-100 text-center">
	

		<thead>
			<tr class="bg-primary text-white">
				<th>SL.</th>
				<th>Product</th>
				<th>Recieved</th>
				<th>Final Sales</th>
				<th>Available</th>

			</tr>
		</thead>
		<tbody>

			@php $i =1; @endphp
			@if(isset($product))
			@foreach($product as $d)

			@php

			$rcarton = DB::table("stocks")
			->where("product_id",$d->id)
			->where("dsr_id",$dsr_id)
			->sum("carton");

			$rpiece = DB::table("stocks")
			->where("product_id",$d->id)
			->where("dsr_id",$dsr_id)
			->sum("piece");

			$rqty = DB::table("stocks")
			->where("product_id",$d->id)
			->where("dsr_id",$dsr_id)
			->sum("qty");

			$rfree = DB::table("stocks")
			->where("product_id",$d->id)
			->where("dsr_id",$dsr_id)
			->sum("free");

			$scarton = DB::table("dsrstocks")
			->where("product_id",$d->id)
			->where('status',Null)
			->where("staff_id",$dsr_id)
			->sum("carton");

			$spiece = DB::table("dsrstocks")
			->where("product_id",$d->id)
			->where('status',Null)
			->where("staff_id",$dsr_id)
			->sum("piece");

			$sqty = DB::table("dsrstocks")
			->where("product_id",$d->id)
			->where('status',Null)
			->where("staff_id",$dsr_id)
			->sum("qty");

			$returnqty = DB::table("dsrstocks")
			->where("product_id",$d->id)
			->where('status',Null)
			->where("staff_id",$dsr_id)
			->sum("returnqty");

			$damage = DB::table("dsrstocks")
			->where("product_id",$d->id)
			->where('status',Null)
			->where("staff_id",$dsr_id)
			->sum("damage");

			$sfree = DB::table("dsrstocks")
			->where("product_id",$d->id)
			->where('status',Null)
			->where("staff_id",$dsr_id)
			->sum("free");

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


			@endphp

			@if($rqty > 0)

			<tr>
				<th>{{ $i++ }}</th>
				<th class="text-left">{{ $d->product_name }}<br><span style="font-size: 12px;">{{ $d->unit_per_group }} {{ $d->single_unit }} {{ $d->group_unit }}</span></th>
				<th>{{ $rqty }} P <br> <span class="btn btn-primary btn-sm w-100 text-white"> {{ $recievecartons }} : {{ $recieveremainingPieces }}</span></th>



				<th>{{ $finalsalesqty }} P <br> <span class="btn btn-primary btn-sm w-100 text-white"> {{ $finalsalescartons }} : {{ $finalsalesremainingPieces }}</span></th>


				<th>{{ $available }} P<br> <span class="btn btn-primary btn-sm w-100 text-white"> {{ $availablecartons }} : {{ $availableremainingPieces }}</span></th>
			</tr>

			@endif


			@endforeach
			@endif


		</tbody>


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



