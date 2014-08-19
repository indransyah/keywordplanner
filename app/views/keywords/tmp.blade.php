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
@if ($consistency==true)
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
                    @foreach($criteria as $key => $criterion)
                    <td>{{ Ahp::subcriteriaWeight($criterion->criterion_id, $value) }}</td>
                    @endforeach
                    <td>{{ $value['score'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.table-responsive -->
</div><!-- /.the-box full -->
@else
<div class="alert alert-danger square alert-block fade in alert-dismissable text-center">
    <strong>Criteria / subcriteria judgments not consistent. Please set the judgments first!</strong>
</div>
@endif
<!-- / Keyword -->
@stop