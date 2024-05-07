@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;Edit DSR <a href="{{ route('staff.index') }}" class="float-right btn btn-dark btn-sm">Manage DSR</a></h4><br>

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
						<form method="post" class="row" action="{{ route("staff.update",$staff) }}" enctype="multipart/form-data">

							@csrf
							@method('PUT')



							<input type="hidden" name="designation" value="dsr">

							<div class="form-group col-md-6">
								<label>Name <span class="text-danger">*</span></label>
								<input type="text" name="staff_name" class="form-control" required="" value="{{ $staff->staff_name }}">
							</div>

							<div class="form-group col-md-6">
								<label>NID</label>
								<input type="text" name="nid" class="form-control" value="{{ $staff->nid }}">
							</div>


							<div class="form-group col-md-6">
								<label>Phone <span class="text-danger">*</span></label>
								<input type="number" name="phone" class="form-control" required="" value="{{ $staff->phone }}">
							</div>

							<div class="form-group col-md-6">
								<label>Password <span class="text-danger">*</span></label>
								<input type="text" name="password" class="form-control" required="" value="{{ $staff->set_password }}">
							</div>



							<div class="form-group col-md-4">
								<label>Father Name:</label>
								<input type="text" name="father_name" class="form-control" value="{{ $staff->father_name }}">
							</div>


							<div class="form-group col-md-4">
								<label>Mother Name:</label>
								<input type="text" name="mother_name" class="form-control" value="{{ $staff->mother_name }}">
							</div>

							<div class="form-group col-md-4">
								<label>Joining Date:</label>
								<input type="date" name="joining_date" class="form-control" value="{{ $staff->joining_date }}">
							</div>

	

							<div class="form-group col-md-4">
								<label>Address <span class="text-danger">*</span></label>
								<input type="text" name="address" class="form-control" required="" value="{{ $staff->address }}">
							</div>


							<div class="form-group col-md-4">
								<label>Salary:</label>
								<input type="number" name="salary" class="form-control" value="{{ $staff->salary }}">
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


