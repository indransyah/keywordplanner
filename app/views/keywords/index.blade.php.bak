@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li class="active">Keyword</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success square fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
{{ HTML::ul($errors->all()) }}
<h1 class="page-header" style="margin-top:0;">Keywords</h1>
<!-- Keyword -->
<div class="the-box full">
    <div class="table-responsive">
        <table class="table table-info table-hover table-th-block">
            <thead>
                <tr>
                    <!-- <th>Group</th> -->
                    <th>Keyword</th>
                    <!-- <th>Currency</th> -->
                    <th>Search</th>
                    <th>Competition</th>
                    <th>BID</th>
                    <!-- <th>Impression</th> -->
                    <!-- <th>Account</th> -->
                    <!-- <th>Plan</th> -->
                    <!-- <th>Extract</th> -->
                    <!-- <th>Word</th> -->
                    <th style="width:5%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keywords as $key => $value)
                <tr>
                    <!-- <td>{{ $value->group }}</td> -->
                    <td>{{ $value->keyword }}</td>
                    <!-- <td>{{ $value->currency }}</td> -->
                    <td>{{ $value->search }}</td>
                    <td>{{ $value->competition }}</td>
                    <td>{{ $value->bid }}</td>
                    <!-- <td>{{ $value->impression }}</td> -->
                    <!-- <td>{{ $value->account }}</td> -->
                    <!-- <td>{{ $value->plan }}</td> -->
                    <!-- <td>{{ $value->extract }}</td> -->
                    <!-- <td>{{ $value->word }}</td> -->
                    <td>
                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $value->keyword_id }}">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                        <div class="modal fade" id="deleteModal-{{ $value->keyword_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">DELETE CONFIRMATION</h4>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure to delete <strong>{{ $value->keyword }}</strong> from your database ?
                                    </div>
                                    <div class="modal-footer">
                                        {{ Form::open(array('url'=>'keyword/destroy/'.$value->keyword_id, 'method'=>'DELETE')) }}
                                        <button type="submit" class="btn btn-danger">Delete
                                        </button>
                                        {{ Form::close() }}
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
{{$keywords->links()}}
<!-- / Keyword -->
@stop