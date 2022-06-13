<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Hello, {{Auth::user()->name}}
			<p class="float-end">Users in Sys: {{count($users)}}</p>
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="container">
			<div class="row bg-white p-2 shadow rounded">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Username</th>
							<th scope="col">Email</th>
							<th scope="col">Registered</th>
						</tr>
					</thead>
					<tbody>
						@php($i = 1)
						@foreach($users as $row)
						<tr>
							<th scope="row">{{$i++}}</th>
							<td>{{$row->name}}</td>
							<td>{{$row->email}}</td>
							<td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
						</tr>
					  	@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</x-app-layout>
