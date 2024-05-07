@extends('backend.staffdashboard.index')
@section('content')

<style type="text/css">
	input{
		background: #fff!important;
		border: none!important;
		border-bottom: 2px dashed #e1e1e1!important;
		font-weight: bold;
		padding: 0!important;
	}

	select{
		background: #fff!important;
		border: none!important;
		border-bottom: 2px dashed #e1e1e1!important;
	}
</style>


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="row">


			<div class="col-lg-3 col-sm-6">
				<div class="card gradient-1">
					<div class="card-body p-4">
						<h3 class="card-title text-white">Sales</h3>
						<div class="d-inline-block">
							<h2 class="text-white font-weight-bold"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
					</div>
				</div>
			</div>



			<div class="col-lg-3 col-sm-6">
				<div class="card gradient-4">
					<div class="card-body p-4">
						<h3 class="card-title text-white">Purchase</h3>
						<div class="d-inline-block">
							<h2 class="text-white font-weight-bold"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>

					</div>
				</div>
			</div>




			<div class="col-lg-3 col-sm-6">
				<div class="card gradient-4">
					<div class="card-body p-4">
						<h3 class="card-title text-white">Category</h3>
						<div class="d-inline-block">
							<h2 class="text-white font-weight-bold"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fa fa-bookmark-o"></i></span>

					</div>
				</div>
			</div>




			<div class="col-lg-3 col-sm-6">
				<div class="card gradient-4">
					<div class="card-body p-4">
						<h3 class="card-title text-white">Products</h3>
						<div class="d-inline-block">
							<h2 class="text-white font-weight-bold"></h2>
						</div>
						<span class="float-right display-5 opacity-5"><i class="fa fa-product-hunt"></i></span>

					</div>
				</div>
			</div>






		</div>





	</div>
</div>




@endsection