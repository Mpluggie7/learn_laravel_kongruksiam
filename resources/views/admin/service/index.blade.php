<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Hello, {{Auth::user()->name}}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					@if(session('success'))
						<div class="alert alert-success">{{session('success')}}</div>
					@endif
					<div class="card p-2">
						<div class="card-header">Service table</div>
						{{-- {{$departments}} --}}
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">No.</th>
									<th scope="col">Image</th>
									<th scope="col">Service Name</th>
									<th scope="col">Create At</th>
									<th scope="col">Edit</th>
									<th scope="col">Delete</th>
								</tr>
							</thead>
							<tbody>
								@foreach($services as $row)
								<tr>
									<th scope="row">{{$services->firstItem()+$loop->index}}</th>
									<td>
										<img src="{{asset($row->service_image)}}" alt="" width='100px' height='100px'>
									</td>
									<td>{{$row->service_name}}</td>
									<td>
										@if ($row->created_at == NULL)
											N/A
										@else
											{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
										@endif
									</td>
									<td>
										<a href="{{url('/service/edit/'.$row->id)}}" class='btn btn-primary'>Edit</a>
									</td>
									<td>
										<a href="{{url('/service/delete/'.$row->id)}}" 
											class='btn btn-danger'
											onclick="return confirm('Do you want to delete?')">Delete</a>
									</td>
								</tr>
								  @endforeach
							</tbody>
						</table>
						{{$services->links()}}
					</div>
				</div>	

				<div class="col-md-4">
					<div class="card">
						<div class="card-header">Service Form</div>
						<div class='card-body'>
							<form action="{{route('addService')}}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="form-group mb-2">
									<label for="service_name">Service Name</label>
									<input type="text" class="form-control" name="service_name">	
									@error('service_name')
										<span class='text-danger'>{{$message}}</span>
									@enderror
								</div>
                                <div class="form-group mb-2">
									<label for="service_image">Service Image</label>
									<input type="file" class="form-control" name="service_image">	
									@error('service_image')
										<span class='text-danger'>{{$message}}</span>
									@enderror
								</div>
								<input type="submit" class="btn btn-primary" value="Save">
							</form>
						</div>
					</div>	
				</div>	
			</div>
		</div>
	</div>
</x-app-layout>
