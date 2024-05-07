		@php
		$i = 1;
		$totalpurchaseamount = 0;
		@endphp

		@if(isset($product))
		@foreach($product as $d)


		<tr id="tr{{ $d->id }}">
			<td width="50">{{ $i++ }}</td>
			<td width="150">{{ $d->product_name }}</td>
			<td width="100">
				<div class="input-group">
					<input type="text" name="carton" id="carton{{ $d->id }}" class="form-control text-center" value="{{ $d->carton }}" onchange="return purchasecartonupdate('{{ $d->id }}')">

					
				</div>
				
			</td>
			<td width="80">
				<div class="input-group">
					<input type="text" name="piece" id="piece{{ $d->id }}" class="form-control text-center" value="{{ $d->piece }}" onchange="purchasepieceupdate('{{ $d->id }}')">

					
				</div>
				
			</td>


			<td width="80">
				<div class="input-group">
					<input type="text" name="free" id="free{{ $d->id }}" class="form-control text-center" value="{{ $d->free }}" onchange="purchasefreeupdate('{{ $d->id }}')">

				</div>
				
			</td>





			<td width="100">
				<div class="input-group">
					<input type="text" name="price" id="price{{ $d->id }}" class="form-control text-center"  value="{{ $d->purchase_price }}" onchange="purchasepriceupdate('{{ $d->id }}')">
					

				</div>
			</td>




			<td width="100">
				<div class="input-group">
					<input type="text" class="form-control" readonly="" id="subtotal" name="subtotal">

				</div>
			</td>




			<td width="10">
				<a  class="delete btn btn-danger btn-sm  border-0 text-white" data-id="{{ $d->id }}"><i class="fa fa-times" aria-hidden="true"></i></a>
			</td>
		</tr>


		@endforeach
		@endif



		<tr>
			<input type="hidden" name="totalpurchaseamount" id="totalpurchaseamount" value="{{ $totalpurchaseamount }}">
			<th colspan="6" class="text-right">Total</th>
			<th colspan="2">{{ number_format($totalpurchaseamount,2) }}/-</th>
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
							url: "{{ url('deletepurchasecartproduct') }}/"+id,
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

								showpurchaseproductcart();
								// window.location.href="";
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

