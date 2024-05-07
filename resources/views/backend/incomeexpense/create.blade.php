@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp; Income/Expense <a href="{{ url('allincomeexpense') }}" class="float-right btn btn-dark btn-sm">Manage Income/Expense</a></h4><br>

					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif

					@if(Session::has('message'))
					<h5 class="alert alert-success">{{ Session::get('message') }}</h5>
					@endif
					


					<div class="basic-form">
						<form method="post" class="row" action="{{ url("insertincomeexpense") }}" enctype="multipart/form-data">

							@csrf


							

								<div class="form-group col-md-3">
									<label>Date <span class="text-danger">*</span></label>
									<input type="date" name="date" class="form-control" required="">
								</div>




								<div class="form-group col-md-6">

									<label>Title <span class="text-danger">*</span></label>
									<input type="text" name="title" class="form-control" required="">
								</div>



								<div class="form-group col-md-3">
									<label>Type <span class="text-danger">*</span></label>
									
									<select class="form-control" name="type" required="">
										<option value="">- - -</option>
										<option value="expense">Expense</option>
										<option value="income">Income</option>
										
									</select>
								</div>


								<div class="form-group col-md-3">
									<label>Amount <span class="text-danger">*</span></label>
									<input type="number" name="amount" class="form-control" required="">
								</div>



								<div class="form-group col-md-12">
									<button type="submit" class="btn btn-primary">Save Now</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	@endsection


