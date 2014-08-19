@extends('layouts.master')
@section('content')

<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li class="active">Criteria</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success square fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger square fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('error') }}</strong>
</div>
@endif
@if(count($criteria)!=0)
    @if($consistency == true)
    <div class="btn-group pull-right">
        <a href="{{ URL::to('pairwisecomparison/criteria') }}" class="btn btn-success btn-sm btn-rounded-lg" data-toggle="tooltip" data-placement="left" title="Criteria judgments consistent. Click to show pairwise comparisons.">
            CONSISTENT
        </a>
    </div>
    @else
    <div class="btn-group pull-right">
        <a href="{{ URL::to('judgment/criteria') }}" class="btn btn-danger btn-sm btn-rounded-lg" data-toggle="tooltip" data-placement="left" title="Criteria judgments not consistent. Click to show criteria judgments.">
            NOT CONSISTENT
        </a>
    </div>
    @endif
@endif
<h1 class="page-header" style="margin-top:0;">Criteria</h1>
<!-- Kriteria -->
@if(count($criteria)==0)
<div class="alert alert-info alert-bold-border fade in alert-dismissable text-center">
    <strong>There is no criterion. {{ HTML::link('criteria/create', 'Add criterion?', array('class'=>'alert-link')) }}</strong>
</div>
@else
<!-- <div class="row"> -->
    <!-- <div class="col-lg-6"> -->
        <div class="the-box full">
            <div class="table-responsive">
                <table class="table table-info table-hover table-th-block">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <!-- <th>ID</th> -->
                            <th style="width: 15%;">Criteria</th>
                            <th style="width: 45%;">Description</th>
                            <th style="width: 10%;">Used Field</th>
                            <th style="width: 10%;">TPV</th>
                            <th class="text-center" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($criteria as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <!-- <td>{{ $value->criterion_id }}</td> -->
                            <!-- <td class="clickableRow" href="{{ URL::to('criteria/' . $value->criterion_id) }}" style="cursor:pointer;">{{ $value->criteria }}</td> -->
                            <!-- <td data-toggle="tooltip" data-placement="top" title="{{ $value->description }}">{{ $value->criterion }}</td> -->
                            <td>{{ $value->criterion }}</td>
                            <td>{{ $value->description }}</td>
                            <td>{{ $value->field }}</td>
                            <td>{{ $value->tpv }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a class="btn btn-default btn-sm" href="{{ URL::to('criteria/' . $value->criterion_id) }}" data-toggle="tooltip" data-placement="left" title="Show subcriterias">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                                    <a class="btn btn-info btn-sm" href="{{ URL::to('criteria/' . $value->criterion_id. '/edit') }}" data-toggle="tooltip" data-placement="top" title="Edit criteria">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $value->criterion_id }}" data-toggle="tooltip" data-placement="right" title="Delete criteria">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                    <div class="modal fade" id="deleteModal-{{ $value->criterion_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel">DELETE CONFIRMATION</h4>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure to delete <strong>{{ $value->criterion }}</strong> from your database ?
                                                </div>
                                                <div class="modal-footer">
                                                    {{ Form::open(array('url'=>'criteria/'.$value->criterion_id, 'method'=>'DELETE',)) }}
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
            <a class="btn btn-success pull-left" href="{{ URL::to('criteria/create') }}"><i class="glyphicon glyphicon-plus"></i> Add</a>
        </div><!-- /.the-box full -->
    <!-- </div> -->
<!-- </div> -->
@endif
<!-- / Kriteria -->
@stop