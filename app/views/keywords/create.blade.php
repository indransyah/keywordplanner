@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('keyword', 'Keyword') }}</li>
    <li class="active">Import</li>
</ol>
@if (Session::has('error'))
<div class="alert alert-danger square fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('error') }}</strong>
    {{ HTML::ul($errors->all()) }}
</div>
@else
<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Make sure you import csv file from <a href="http://adwords.google.com" class="alert-link">Google AdWords Keyword Planner!</a></strong>
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Import Keywords</h1>
<!-- Impor Keyword -->
<div class="row">
    <div class="col-lg-6">
        {{ Form::open(array('url'=>'keyword/store', 'class'=>'form-horizontal', 'files'=>'true')) }}
        {{ Form::file('csv', array('class'=>'filestyle', 'data-buttonText'=>'Browse', 'required'=>'true')) }}
        <br />
        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Import</button>
        {{ Form::close() }}
    </div>
</div>
<!-- / Impor Keyword -->
@stop