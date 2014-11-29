@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('keyword', 'Keywords') }}</li>
    <li class="active">Import</li>
</ol>
@if (Session::has('error'))
<div class="alert alert-danger fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('error') }}</strong>
    {{ HTML::ul($errors->all()) }}
</div>
@elseif (Ahp::allConsistency())
<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Make sure you import csv file from <a href="http://adwords.google.com" class="alert-link">Google AdWords Keyword Planner!</a></strong>
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Import Keywords</h1>
<!-- Impor Keyword -->
@if (!Ahp::criteriaExistency())
<div class="alert alert-warning square fade in alert-dismissable text-center">
    <strong>Criteria < 3</strong>. <a class="alert-link" href="{{ URL::to('criteria/create') }}">Please add criterion first!</a>
</div>
@elseif(!Ahp::subcriteriaExistency())
<div class="alert alert-warning square fade in alert-dismissable text-center">
    <strong>There is a criterion with subcriteria less than 3</strong>. <a class="alert-link" href="{{ URL::to('criteria') }}">Please add subcriterion first!</a>
</div>
@elseif (Ahp::allConsistency())
<div class="row">
    <div class="col-lg-6">
        {{ Form::open(array('url'=>'keyword/store', 'class'=>'form-horizontal', 'files'=>'true')) }}
        {{ Form::file('csv', array('class'=>'filestyle', 'data-buttonText'=>'Browse', 'required'=>'true')) }}
        <br />
        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Import</button>
        {{ Form::close() }}
        </br>
        <strong><i>Note</i></strong>
        <small><i>
            <p style="margin:0;">- Csv file must be a valid exported csv file from Google AdWords Keyword Planner Tool.</p>
            <p style="margin:0;">- Just use keyword ideas from Keyword Planner that closely related keyword.</p>
            <p style="margin:0;">- Keywords inside the csv file must be more than 10 keywords.</p>
        </i></small>
    </div>
    <div class="col-lg-6 pull-right">
        <strong>Help</strong>
        <p>Use Google AdWords Keyword Planner Tool to get keyword ideas and than export the keyword ideas as a csv file. {{ HTML::link('help', 'Follow this instructions to get csv file from Google AdWords Keyword Planner Tool.') }}</p>
    </div>
</div>
@else
<div class="alert alert-warning square fade in alert-dismissable text-center">
    <strong>Criteria / subcriteria judgments not consistent. Please set the judgments first!</strong>
</div>
@endif
<!-- / Impor Keyword -->
@stop