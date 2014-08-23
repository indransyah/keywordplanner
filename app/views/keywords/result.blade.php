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

@if (Ahp::allConsistency())
<a class="btn btn-success pull-right" data-toggle="modal" data-target="#recommendedKeywordModal" data-toggle="tooltip" data-placement="right" title="Show recommended keywords!">
    Show recommended keywords!
</a>
<div class="modal fade" id="recommendedKeywordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">RECOMMENDED KEYWORDS</h4>
            </div>
            <div class="modal-body">
                <textarea name="clipboard-text" id="clipboard-text" class="form-control" rows="10">
@for ($i = 0; $i < 20; $i++)
{{ $keywords[$i]['keyword'] }}
@endfor
                </textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="target-to-copy" data-clipboard-target="clipboard-text">Copy</button>
            </div>
        </div>
    </div>
</div>
@endif

<h1 class="page-header" style="margin-top:0;">Keywords</h1>
<!-- Keyword -->
@if (Ahp::allConsistency())
<div class="the-box full">
    <div class="table-responsive">
        <table class="table table-info table-hover table-th-block">
            <thead>
                <tr>
                    <!-- <th>Group</th> -->
                    <th>Keyword</th>
                    @foreach($criteria as $key => $value)
                    <th>{{ $value->criterion }}</th>
                    @endforeach
                    <!-- <th>Currency</th> -->
                    <!-- <th>Search</th> -->
                    <!-- <th>Competition</th> -->
                    <!-- <th>BID</th> -->
                    <!-- <th>Impression</th> -->
                    <!-- <th>Account</th> -->
                    <!-- <th>Plan</th> -->
                    <!-- <th>Extract</th> -->
                    <!-- <th>Word</th> -->
                    <th style="width:10%;">Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keywords as $key => $value)
                <tr>
                    <!-- <td>{{ $value->group }}</td> -->
                    <td>{{ $value->keyword }}</td>
                    @foreach($criteria as $key => $criterion)
                    <td>{{ Ahp::subcriteriaWeight($criterion->criterion_id, $value) }}</td>
                    @endforeach
                    <td>{{ $value->score }}</td>
                    <!-- <td>{{ $value->currency }}</td> -->
                    <!-- <td>{{ $value->search }}</td> -->
                    <!-- <td>{{ $value->competition }}</td> -->
                    <!-- <td>{{ $value->bid }}</td> -->
                    <!-- <td>{{ $value->impression }}</td> -->
                    <!-- <td>{{ $value->account }}</td> -->
                    <!-- <td>{{ $value->plan }}</td> -->
                    <!-- <td>{{ $value->extract }}</td> -->
                    <!-- <td>{{ $value->word }}</td> -->
                    <!-- <td>
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
                    </td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.table-responsive -->
</div><!-- /.the-box full -->
{{$keywords->links()}}
@else
<div class="alert alert-danger square alert-block fade in alert-dismissable text-center">
    <strong>Criteria / subcriteria judgments not consistent. Please set the judgments first!</strong>
</div>
@endif
<!-- / Keyword -->

// Script
{{ HTML::script('assets/plugins/zero-clipboard/ZeroClipboard.js') }}
{{ HTML::script('assets/plugins/zero-clipboard/main.js') }}

@stop