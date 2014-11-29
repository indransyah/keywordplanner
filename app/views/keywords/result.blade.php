@extends('layouts.master')
@section('content')

<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('keyword', 'Keywords') }}</li>
    <li class="active">Result</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
{{ HTML::ul($errors->all()) }}

@if (Ahp::allConsistency())
<div class="btn-toolbar pull-right">
    <div class="btn-group">
        <a class="btn {{Session::has('filter') ? 'btn-info' : 'btn-danger'}} btn-rounded-lg" data-toggle="modal" data-target="#filterModal" data-toggle="tooltip" data-placement="left" title="Show keyword filters!">
        Filter : {{Session::has('filter') ? 'On' : 'Off'}}
        </a>
    </div>
    @if(count($keywords) > 0)
    <div class="btn-group">
        <a class="btn btn-success btn-rounded-lg pull-right" data-toggle="modal" data-target="#recommendedKeywordModal" data-toggle="tooltip" data-placement="right" title="Show recommended keywords!">
        Export Keywords
        </a>
    </div>
    @endif
</div>
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">KEYWORD FILTERS</h4>
            </div>
            <div class="modal-body">
                @if(Session::has('filter.type'))
                    @foreach (Session::get('filter.type') as $key => $id)
                        <?php
                        $type = Subcriterion::find($id);
                        $criterion = Criterion::find($type->criterion_id);
                        ?>
                        <h4><strong>{{$criterion->criterion}}</strong> : {{$type->subcriterion}} ({{$type->range}})</h4>
                    @endforeach
                @endif
                @if(Session::has('filter.range'))
                    @foreach (Session::get('filter.range') as $key => $range)
                        <?php
                        $criterion = Criterion::where('field', $key)->first();
                        ?>
                        <h4><strong>{{$criterion->criterion}}</strong> : {{$range}}</h4>
                    @endforeach
                @endif
                @if(!Session::has('filter'))
                <h4>No keyword filters.</h4>
                @endif
            </div>
            <div class="modal-footer">
                {{HTML::link('keyword/filter', 'Change', array('class' => 'btn btn-success'))}}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
@if(count($keywords) > 0)
<div class="modal fade" id="recommendedKeywordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">RECOMMENDED KEYWORDS</h4>
            </div>
            <div class="modal-body">
                <textarea class="form-control" rows="10">
@foreach ($recommendedKeywords as $recommendedKeyword)
{{ $recommendedKeyword }}
@endforeach
                </textarea>
            </div>
            <div class="modal-footer">
                {{HTML::link('uploads/guest/result-'.$fileName.'.txt', 'Export to .txt', array('class' => 'btn btn-success', 'target' => "_blank"))}}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endif

<h1 class="page-header" style="margin-top:0;">Keyword Results</h1>
<!-- Keyword -->
@if (count($keywords) != 0 && Ahp::allConsistency())
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
                    <td>{{ $value['keyword'] }}</td>
                    @foreach($criteria as $criterion)
                    <td class="text-center">{{ $values[$value['keyword']][$criterion->field] .' </br><strong>('. $classes[$value['keyword']][$criterion->field] .' : '. $weights[$value['keyword']][$criterion->field] .')</strong>' }}</td>
                    
                    @endforeach
                    <td>{{ $value['score'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.table-responsive -->
</div><!-- /.the-box full -->
@elseif(count($keywords) == 0)
<div class="alert alert-danger square alert-block fade in alert-dismissable text-center">
    <strong>There is no keyword with your criteria</strong>
</div>
@else
<div class="alert alert-danger square alert-block fade in alert-dismissable text-center">
    <strong>Criteria / subcriteria judgments not consistent. Please set the judgments first!</strong>
</div>
@endif
<!-- / Keyword -->
@stop
