@extends('backend.layouts.index')
@section('content')






<div class="content-body">
	<div class="container-fluid mt-3">





		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;Stocks</h4>
					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration text-center">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Product</th>
									<th>Recieved</th>
									<th>Sales</th>
									<th>Return</th>
									<th>Final Sales</th>
									<th>Damage</th>
									<th>Free</th>
									<th>Available</th>

								</tr>
							</thead>
							<tbody>

								@php $i =1; @endphp
								@if(isset($product))
								@foreach($product as $d)

								@php
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

								@if($rqty > 0 || $damage>0)


								<tr>
									<th>{{ $i++ }}</th>
									<th class="text-left">{{ $d->product_name }}<br><span style="font-size: 12px;">{{ $d->unit_per_group }} {{ $d->single_unit }} {{ $d->group_unit }}</span></th>
									<th>{{ $rqty }} P <br> <span class="btn btn-primary w-100 text-white"> {{ $recievecartons }} : {{ $recieveremainingPieces }}</span></th>

									<th>{{ $sqty }} P <br> <span class="btn btn-danger btn-sm w-100 text-white"> {{ $salescartons }} : {{ $salesremainingPieces }}</span></th>

									<th>{{ $returnqty }} P <br> <span class="btn btn-danger btn-sm w-100 text-white"> {{ $returncartons }} : {{ $returnremainingPieces }}</span></th>

									<th>{{ $finalsalesqty }} P <br> <span class="btn btn-primary w-100 text-white"> {{ $finalsalescartons }} : {{ $finalsalesremainingPieces }}</span></th>

									<th>{{ $damage }} P</th>
									<th>{{ $availablefree }} P</th>

									<th>{{ $available }} P<br> <span class="btn btn-primary w-100 text-white"> {{ $availablecartons }} : {{ $availableremainingPieces }}</span></th>
								</tr>

								@endif


								@endforeach
								@endif

								
							</tbody>

							</table>
						</div>
					</div>
				</div>
			</div>




		</div>
	</div>



	@endsection