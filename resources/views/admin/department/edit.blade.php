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
						<div class="card-header">Edit Form</div>
						<div class='card-body'>
							<form action="{{url('department/update/'.$department->id)}}" method="POST">
								@csrf
								<div class="form-group mb-2">
									<label for="department_name">Department Name</label>
									<input type="text" class="form-control" name="department_name" 
                                        value="{{$department->department_name}}">	
									@error('department_name')
										<span class='text-danger'>{{$message}}</span>
									@enderror
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
