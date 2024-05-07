@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;DSR Reports</h4><br>

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
						<form method="get" class="row" target="blank" action="{{ url("searchdsrreports") }}" enctype="multipart/form-data">

							
							<div class="form-group col-md-3">
								<label class="mb-1">DSR Name: <span class="text-danger" style="font-size: 15px;">*</span></label>
								<div class="input-group mb-2">
									<select class="form-control myselect" name="staff_id" id=
									"staff_id" required="">

									<option value="all">All DSR</option>

									@foreach($staff as $s)
									<option value="{{ $s->id }}">{{ $s->staff_name }}</option>
									@endforeach


								</select>

							</div>
						</div>



						<div class="form-group col-md-3">
							<label>From Date </label>
							<input type="date" name="from_date" id="from_date" class="form-control" >
						</div>

						<div class="form-group col-md-3">
							<label>To Date</label>
							<input type="date" name="to_date" id="to_date" class="form-control">
						</div>




						<div class="form-group col-md-12">
							<button type="submit" class="btn btn-primary text-white">Search Now</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
</div>




@endsection


