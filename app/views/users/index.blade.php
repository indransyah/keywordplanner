@extends('layouts.master')
@section('content')

<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li class="active">Users</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Users</h1>
<!-- User -->
<div class="the-box full">
	<div class="table-responsive">
		<table class="table table-info table-th-block">
			<thead>
				<tr>
					<th style="width: 10%;">#</th>
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th class="text-center" style="width: 5%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $key => $value)
				<tr>
					<td>{{ $key+1 }}</td>
					<td>{{ $value->name }}</td>
					<td>{{ $value->username }}</td>
					<td>{{ $value->email }}</td>
					<td>
						<div class="btn-group">
						<a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $value->user_id }}" data-toggle="tooltip" data-placement="right" title="Delete criteria">
								<i class="glyphicon glyphicon-trash"></i>
							</a>
							<div class="modal fade" id="deleteModal-{{ $value->user_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel">DELETE CONFIRMATION</h4>
										</div>
										<div class="modal-body">
											Are you sure to delete <strong>{{ $value->username }}</strong> from your database ?
										</div>
										<div class="modal-footer">
											{{ Form::open(array('url'=>'user/destroy/'.$value->user_id, 'method'=>'DELETE',)) }}
											<button type="submit" class="btn btn-danger">Delete
											</button>
											{{ Form::close() }}
										</div>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				@endforeach					
			</tbody>
		</table>
	</div><!-- /.table-responsive -->
	<a class="btn btn-success pull-left" href="{{ URL::to('user/create') }}"><i class="glyphicon glyphicon-plus"></i> Add</a>
</div><!-- /.the-box full -->
<!-- / User -->
@stop