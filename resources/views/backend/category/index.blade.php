@extends('backend.layouts.index')
@section('content')


<div class="content-body">
	<div class="container-fluid mt-3">


		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><a href="{{ url('dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;All Categories <a href="#modal-overflow" uk-toggle class="float-right btn btn-dark btn-sm">Add Categories</a></h4>
					<div class="table-responsive">
						<table class="table table-striped table-bordered zero-configuration">
							<thead>
								<tr class="bg-primary text-white">
									<th>SL.</th>
									<th>Category Name</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>

								@php $i =1; @endphp
								@if(isset($category))
								@foreach($category as $d)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ $d->category_name }}</td>
									
									<td>
										<div class="dropdown">
											<button class="btn btn-primary text-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Select Option
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

												 @if(Auth::user()->type == 1)
												
												<a class="dropdown-item" href="{{ url("deletecategory/".$d->id) }}" onclick="return confirm('Are you sure?')">Delete</a>

												@endif
											</div>
										</div>
										
									</td>

								</tr>

								@endforeach
								@endif

							</table>
						</div>
					</div>
				</div>
			</div>




		</div>
	</div>


	<div id="modal-overflow" uk-modal>
		<div class="uk-modal-dialog">

			<button class="uk-modal-close-default" type="button" uk-close></button>

			<div class="uk-modal-header">
				<h5 class="uk-modal-title" style="font-size: 20px;"><b>Category</b></h5>
			</div>

			<div class="uk-modal-body" uk-overflow-auto>

				<form class="uk-grid-small" uk-grid  action="{{ route("category.store") }}" method="post">

					@csrf


					<div class="uk-width-1-0@s">
						<label>Category Name:</label>
						<input class="uk-input" type="text" name="category_name" aria-label="50" required="">
					</div>
					


				</div>

				<div class="uk-modal-footer uk-text-right">
					<button class="uk-button uk-button-primary" type="submit">Save</button>
				</div>



			</form>

		</div>
	</div>



	@endsection