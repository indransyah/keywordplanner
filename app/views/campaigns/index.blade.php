@extends('layouts.master')
@section('content')

<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li class="active">Campaigns</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Campaigns</h1>
@if (Ahp::campaignExistency())
<!-- <div class="row"> -->
    <!-- <div class="col-lg-8"> -->
        <div class="the-box full">
            <div class="table-responsive">
                <table class="table table-info table-th-block">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 40%">Campaign</th>
                            <th style="width: 40%;" class="text-center">CSV</th>
                            <th style="width: 10%;">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $value->campaign }}</td>
                            <td>{{ $value->csv }}</td>
                            <td>

                                <div class="btn-group">
                                    <a class="btn btn-default btn-sm" href="{{ URL::to('keyword/show/' . $value->campaign_id) }}">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $value->campaign_id }}" data-toggle="tooltip" data-placement="right" title="Delete criteria">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                                <div class="modal fade" id="deleteModal-{{ $value->campaign_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">DELETE CONFIRMATION</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure to delete <strong>{{ $value->campaign }}</strong> from your database ?
                                            </div>
                                            <div class="modal-footer">
                                                {{ Form::open(array('url'=>'campaign/destroy/'.$value->campaign_id, 'method'=>'DELETE',)) }}
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
        </div><!-- /.the-box full -->
    <!-- </div> -->
<!-- </div> -->
@else
<div class="alert alert-warning square fade in alert-dismissable text-center">
    <strong>There is no campaign.</strong> <a class="alert-link" href="{{ URL::to('keyword/import') }}">Please upload csv first!</a>
</div>
@endif
@stop