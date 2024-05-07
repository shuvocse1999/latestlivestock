		@php
		$i = 1;
		$totalsalesamount = 0;
		@endphp

		@if(isset($product))
		@foreach($product as $d)


		<tr id="tr{{ $d->id }}">
			<td>{{ $i++ }}</td>
			<td>{{ $d->product_name }}</td>
			<td>
				
				<div class="p-2 row">
					<div class="input-group col-6 p-0">
						<input type="text" name="carton" id="carton{{ $d->id }}" class="form-control text-center" value="{{ $d->carton }}" onchange="return editdsrsalescartonupdate('{{ $d->id }}')">


					</div>

					<div class="input-group col-6 p-0">
						<input type="text" name="piece" id="piece{{ $d->id }}" class="form-control text-center" value="{{ $d->piece }}" onchange="editdsrsalespieceupdate('{{ $d->id }}')">


					</div>
				</div>
				
			</td>







			<td>
				<div class="input-group">
					<input type="text" name="price" id="price{{ $d->id }}" class="form-control text-center"  value="{{ $d->sales_price }}" onchange="editdsrsalespriceupdate('{{ $d->id }}')">
					

				</div>
			</td>




			<td style="width: 100px;">
				@php
				$product = DB::table("products")->where("id",$d->product_id)->first();
				$piece_price = $d->sales_price/$product->unit_per_group;
				$damageprice = $piece_price*$d->damage;
				$totalpieceprice = $piece_price*$d->piece;
				$returnscartonprice = $d->returnscarton*$d->sales_price;
				$returnspieceprice = $d->returnspiece*$piece_price;

				$subtotal = (($d->carton*$d->sales_price)+$totalpieceprice)-($damageprice+$returnscartonprice+$returnspieceprice);
				$totalsalesamount = $totalsalesamount+$subtotal;
				@endphp
				<div class="input-group">
					<input type="text" class="form-control text-center" readonly="" value="{{ number_format($subtotal,2) }}">

				</div>
			</td>




		</tr>


		@endforeach
		@endif



		<tr>
			<input type="hidden" name="totalsalesamount" id="totalsalesamount" value="{{ $totalsalesamount }}">
			<th colspan="4" class="text-right">Total</th>
			<th colspan="2">{{ number_format($totalsalesamount,2) }}/-</th>
		</tr>



		<script type="text/javascript">
			$(".delete").click(function(){
				let id = $(this).data('id');
				let invoice_no = $("#invoice_no").val();


				Swal.fire({
					title: "Product Remove From Cart",
					showDenyButton: true,
					confirmButtonText: "Yes",
					denyButtonText: `Cancel`
				}).then((result) => {


					if (result.isConfirmed) {

						$.ajax(
						{
							url: "{{ url('deleteeditdsrsalescartproduct') }}/"+id+"/"+invoice_no,
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

								showeditdsrsalescurrentcart();
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

