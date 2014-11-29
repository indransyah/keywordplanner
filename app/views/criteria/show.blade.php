@extends('layouts.master')
@section('content')

<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('criteria', 'Criteria') }}</li>
    <li class="active">Subcriteria</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
@if(count($subcriteria)!=0)
    @if(Ahp::subcriteriaConsistency($criterion_id))
    <div class="btn-group pull-right">
        <a href="{{ URL::to('pairwisecomparison/subcriteria/'.$criterion_id) }}" class="btn btn-success btn-sm btn-rounded-lg" data-toggle="tooltip" data-placement="left" title="Subcriteria judgments consistent. Click to show pairwise comparisons.">
            CONSISTENT
        </a>
    </div>
    @else
    <div class="btn-group pull-right">
        <a href="{{ URL::to('judgment/subcriteria/'.$criterion_id) }}" class="btn btn-danger btn-sm btn-rounded-lg" data-toggle="tooltip" data-placement="left" title="Subcriteria judgments not consistent. Click to show subcriteria judgments.">
            NOT CONSISTENT
        </a>
    </div>
    @endif
@endif
<h1 class="page-header" style="margin-top:0;">{{$criterion->criterion}}'s subcriteria</h1>
@if(count($subcriteria)==0)
<div class="alert alert-warning square fade in alert-dismissable text-center">
    <strong>There is no subcriterion. {{ HTML::link('subcriteria/create/'.$criterion_id, 'Add subcriterion?', array('class'=>'alert-link')) }}</strong>
    <br />	
</div>
@else
<!-- <div class="row"> -->
    <!-- <div class="col-lg-8"> -->
        <div class="the-box full">
            <div class="table-responsive">
                <table class="table table-info table-hover table-th-block">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <!-- <th>ID</th> -->
                            <th style="width: 15%;">Subriteria</th>
                            <th style="width: 30%;">Description</th>
                            <th style="width: 10%;">Range</th>
                            <th style="width:10%;">TPV</th>
                            <th style="width:10%;">Rating</th>
                            <th style="width:10%;">Weight</th>
                            <th style="width:15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subcriteria as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <!-- <td>{{ $value->subcriteria_id }}</td> -->
                            <!-- <td data-toggle="tooltip" data-placement="top" title="{{ $value->description }}">{{ $value->subcriterion }}</td> -->
                            <td>{{ $value->subcriterion }}</td>
                            <td>{{ $value->description }}</td>
                            <td>{{ $value->range }}</td>
                            <td>{{ $value->tpv }}</td>
                            <td>{{ $value->rating }}</td>
                            <td>{{ $value->weight }}</td>
                            <td>
                            	<div class="btn-group">
	                                <a class="btn btn-info btn-sm" href="{{ URL::to('subcriteria/'.$value->subcriterion_id.'/edit/'.$criterion_id) }}" title="Edit subcriterion">
	                                    <i class="glyphicon glyphicon-pencil"></i>
	                                </a>
	                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $value->subcriterion_id }}" title="Delete subcriteria">
	                                    <i class="glyphicon glyphicon-trash"></i>
	                                </a>
	                                <div class="modal fade" id="deleteModal-{{ $value->subcriterion_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	                                    <div class="modal-dialog">
	                                        <div class="modal-content">
	                                            <div class="modal-header">
	                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                                                <h4 class="modal-title" id="myModalLabel">DELETE CONFIRMATION</h4>
	                                            </div>
	                                            <div class="modal-body">
	                                                Are you sure to delete <strong>{{ $value->subcriterion }}</strong> from your database ?
	                                            </div>
	                                            <div class="modal-footer">
	                                                {{ Form::open(array('url'=>'subcriteria/'.$value->subcriterion_id.'/'.$criterion_id, 'method'=>'DELETE',)) }}
	                                                <button type="submit" class="btn btn-danger">Delete</button>
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
            <a class="btn btn-success pull-left" href="{{ URL::to('subcriteria/create/'.$criterion_id) }}"><i class="glyphicon glyphicon-plus"></i> Add</a>
        </div><!-- /.the-box full -->
    <!-- </div> -->
<!-- </div> -->
@endif
@stop