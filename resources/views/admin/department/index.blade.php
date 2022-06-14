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
						<div class="card-header">Department Data table</div>
						{{-- {{$departments}} --}}
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">No.</th>
									<th scope="col">Department Name</th>
									<th scope="col">User Register</th>
									<th scope="col">Create At</th>
									<th scope="col">Edit</th>
									<th scope="col">Delete</th>
								</tr>
							</thead>
							<tbody>
								@foreach($departments as $row)
								<tr>
									<th scope="row">{{$departments->firstItem()+$loop->index}}</th>
									<td>{{$row->department_name}}</td>
									<td>{{$row->user->name}}</td>
									<td>
										@if ($row->created_at == NULL)
											N/A
										@else
											{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
										@endif
									</td>
									<td>
										<a href="{{url('/department/edit/'.$row->id)}}" class='btn btn-primary'>Edit</a>
									</td>
									<td>
										<a href="{{url('/department/softdelete/'.$row->id)}}" class='btn btn-danger'>Delete</a>
									</td>
								</tr>
								  @endforeach
							</tbody>
						</table>
						{{$departments->links()}}
					</div>

					@if (count($trashDepartments) > 0)
					<div class="card my-2 p-2">
						<div class="card-header">Trash table</div>
						{{-- {{$departments}} --}}
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">No.</th>
									<th scope="col">Department Name</th>
									<th scope="col">User Register</th>
									<th scope="col">Create At</th>
									<th scope="col">Restore</th>
									<th scope="col">Permanent Delete</th>
								</tr>
							</thead>
							<tbody>
								@foreach($trashDepartments as $row)
								<tr>
									<th scope="row">{{$trashDepartments->firstItem()+$loop->index}}</th>
									<td>{{$row->department_name}}</td>
									<td>{{$row->user->name}}</td>
									<td>
										@if ($row->created_at == NULL)
											N/A
										@else
											{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
										@endif
									</td>
									<td>
										<a href="{{url('/department/restore/'.$row->id)}}" class='btn btn-primary'>Restore</a>
									</td>
									<td>
										<a href="{{url('/department/delete/'.$row->id)}}" class='btn btn-danger'>Permanent Delete</a>
									</td>
								</tr>
								  @endforeach
							</tbody>
						</table>
						{{$trashDepartments->links()}}
					</div>
					@endif
					
				</div>	

				<div class="col-md-4">
					<div class="card">
						<div class="card-header">Form</div>
						<div class='card-body'>
							<form action="{{route('addDepartment')}}" method="POST">
								@csrf
								<div class="form-group mb-2">
									<label for="department_name">Department Name</label>
									<input type="text" class="form-control" name="department_name">	
									@error('department_name')
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
