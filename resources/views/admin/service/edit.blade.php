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
                    <div class="card">
						<div class="card-header">Edit Service Form</div>
						<div class='card-body'>
							<form action="{{url('service/update/'.$service->id)}}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="form-group mb-2">
									<label for="service_name">Service Name</label>
									<input type="text" class="form-control" name="service_name" 
                                        value="{{$service->service_name}}">	
									@error('service_name')
										<span class='text-danger'>{{$message}}</span>
									@enderror
								</div>
                                <div class="form-group mb-3">
									<label for="service_image">Service Image</label>
									<input type="file" class="form-control" name="service_image"
                                        value="{{$service->service_image}}">	
									@error('service_image')
										<span class='text-danger'>{{$message}}</span>
									@enderror
								</div>
                                <input type="hidden" name="old_image" value="{{$service->service_image}}">
                                <div class="form-group mb-3">
                                    <img src="{{asset($service->service_image)}}" alt="" width='300px' height="300px">
								</div>
								<input type="submit" class="btn btn-primary" value="Update">
							</form>
						</div>
					</div>	
				</div>	
			</div>
		</div>
	</div>
</x-app-layout>
