@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;Edit Admin <a href="{{ route('admin.index') }}" class="float-right btn btn-dark btn-sm">Manage Admin</a></h4><br>

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
						<form method="post" class="row" action="{{ route("admin.update",$User) }}" enctype="multipart/form-data">

							@csrf
							@method('PUT')



							<div class="form-group col-md-12">
								<label>Name <span class="text-danger">*</span></label>
								<input type="text" name="name" class="form-control" required="" value="{{ $User->name }}">
							</div>

							<div class="form-group col-md-6">
								<label>Email <span class="text-danger">*</span></label>
								<input type="email" name="email" class="form-control" required="" value="{{ $User->email }}">
							</div>


							<div class="form-group col-md-6">
								<label>Password <span class="text-danger">*</span></label>
								<input type="text" name="password" class="form-control" required="" value="{{ $User->set_password }}">
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


