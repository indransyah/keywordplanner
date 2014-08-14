@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('criteria', 'Criteria') }}</li>
    <li class="active">Add</li>
</ol>
@if (Session::has('error'))
<div class="alert alert-danger square fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('error') }}</strong>
    {{ HTML::ul($errors->all()) }}
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Add Criterion</h1>
<!-- Kriteria -->
<div class="row">
    <div class="col-lg-6">
        {{ Form::open(array('url'=>'criteria', 'class'=>'form-horizontal')) }}
        <div class="form-group">
            <label for="criterion" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                {{ Form::text('criterion', null, array('class'=>'form-control', 'placeholder'=>'Criterion\'s name', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                {{ Form::textarea('description', null, array('class'=>'form-control', 'placeholder'=>'Criterion\'s description', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<!-- / Kriteria -->
@stop