		@php
		$i = 1;
		$totalsalesamount = 0;
		@endphp

		@if(isset($product))
		@foreach($product as $d)

		@php

		$session_id   = Session::getId();

		$check = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('product_id',$d->product_id)
		->first();

		$rqty = DB::table("stocks")->where("product_id",$check->product_id)
		->where('status',Null)
		->where("dsr_id",Auth('guest')->user()->id)
		->sum("qty");


		$sqty = DB::table("dsrstocks")
		->where("product_id",$check->product_id)
		->where('status',Null)
		->where("staff_id",Auth('guest')->user()->id)
		->sum("qty");


		$returnqty = DB::table("stocks")
		->where("product_id",$check->product_id)
		->where("dsr_id",Auth('guest')->user()->id)
		->where('status',Null)
		->sum("returnqty");

		$piecesPerCarton = DB::table("products")
		->where('id',$check->product_id)
		->first();


		$finalsalesqty = $sqty - $returnqty;
		$available = $rqty- $finalsalesqty;


		$availablecartons = floor($available / $piecesPerCarton->unit_per_group);
		$availableremainingPieces = $available % $piecesPerCarton->unit_per_group;


		@endphp




		<tr id="tr{{ $d->id }}">
			<td>{{ $i++ }}</td>
			<td>{{ $d->product_name }}<br> 
				
				<span class="btn btn-primary text-white btn-sm">{{ $available }} P = {{ $availablecartons }} : {{ $availableremainingPieces }}</span></td>
				}
			<td>
				
				<div class="p-2 row">
					<div class="input-group col-6 p-0">
						<input type="text" name="carton" id="carton{{ $d->id }}" class="form-control text-center" value="{{ $d->carton }}" onchange="return dsrsalescartonupdate('{{ $d->id }}')">


					</div>

					<div class="input-group col-6 p-0">
						<input type="text" name="piece" id="piece{{ $d->id }}" class="form-control text-center" value="{{ $d->piece }}" onchange="dsrsalespieceupdate('{{ $d->id }}')">


					</div>

					
				</div>
				
			</td>



			<td>
				<div class="input-group">
					<input type="text" name="free" id="free{{ $d->id }}" class="form-control text-center" value="{{ $d->free }}" onchange="salesfreeupdate('{{ $d->id }}')" readonly="">

				</div>
				
			</td>








			<td>
				<div class="input-group">
					<input type="text" name="price" id="price{{ $d->id }}" class="form-control text-center"  value="{{ $d->sales_price }}" onchange="dsrsalespriceupdate('{{ $d->id }}')">
					

				</div>
			</td>




			<td>
				@php
				$product = DB::table("products")->where("id",$d->product_id)->first();
				$piece_price = $d->sales_price/$product->unit_per_group;
				$damageprice = $piece_price*$d->damage;
				$totalpieceprice = $piece_price*$d->piece;
				$returnscartonprice = $d->returnscarton*$d->sales_price;
				$returnspieceprice = $d->returnspiece*$piece_price;

				$subtotal =(($d->carton*$d->sales_price)+$totalpieceprice)-($damageprice+$returnscartonprice+$returnspieceprice);
				$totalsalesamount = $totalsalesamount+$subtotal;
				@endphp
				<div class="input-group">
					<input type="text" class="form-control text-center" readonly="" value="{{ number_format($subtotal,2) }}">

				</div>
			</td>

		


			<td>
				<a class="delete btn btn-danger btn-sm  border-0 text-white" data-id="{{ $d->id }}"><i class="fa fa-times" aria-hidden="true"></i></a>
			</td>



		
		</tr>


		@endforeach
		@endif



		<tr>
			<input type="hidden" name="totalsalesamount" id="totalsalesamount" value="{{ $totalsalesamount }}">
			<th colspan="5" class="text-right">Total</th>
			<th colspan="2">{{ number_format($totalsalesamount,2) }}/-</th>
		</tr>



		<script type="text/javascript">
			$(".delete").click(function(){
				let id = $(this).data('id');


				Swal.fire({
					title: "Product Remove From Cart",
					showDenyButton: true,
					confirmButtonText: "Yes",
					denyButtonText: `Cancel`
				}).then((result) => {


					if (result.isConfirmed) {

						$.ajax(
						{
							url: "{{ url('deletedsrsalescartproduct') }}/"+id,
							type: 'get',
							success: function()
							{
								$('#tr'+id).hide();

								Command:toastr["success"]("Product Remove Done")
								toastr.options = {
									"closeButton": true,
									"debug": false,
									"newestOnTop": false,
									"progressBar": true,
									"positionClass": "toast-top-right",
									"preventDuplicates": false,
									"onclick": null,
									"showDuration": "300",
									"hideDuration": "1000",
									"timeOut": "3000",
									"extendedTimeOut": "1000",
									"showEasing": "swing",
									"hideEasing": "linear",
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut"
								}

								showdsrsalescurrentcart();
							
							},
							errors:function(){
								Command:toastr["danger"]("Product Remove Unsuccessfully")


							}


						});


					}
					else if(result.isDenied) {

					}
				});
			});




	// End Delete Data
</script>

