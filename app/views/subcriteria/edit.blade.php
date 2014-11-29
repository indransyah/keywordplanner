@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('subcriteria', 'Subcriteria') }}</li>
    <li class="active">Edit</li>
</ol>
@if (Session::has('error'))
<div class="alert alert-danger fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('error') }}</strong>
    {{ HTML::ul($errors->all()) }}
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Edit Subcriterion</h1>
<div class="row">
    <div class="col-lg-6">
        {{ Form::model($subcriterion, array('url'=> 'subcriteria/'.$subcriterion->subcriterion_id.'/edit/'.$criterion_id, 'method' => 'PUT', 'class'=>'form-horizontal')) }}
        <div class="form-group">
            <label for="criteria" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                {{ Form::text('subcriterion', null, array('class'=>'form-control', 'placeholder'=>'Subcriteria\'s name', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                {{ Form::textarea('description', null, array('class'=>'form-control', 'placeholder'=>'Description', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="range" class="col-sm-2 control-label">Range</label>
            <div class="col-sm-10">
                {{ Form::text('range', null, array('class'=>'form-control', 'placeholder'=>'Range', 'required'=>'true')) }}
                <small><i>Range of criterion field that belongs to subcriterion.</i></small>
                <small><i>Allowed format :</br></small> <kbd>x</kbd>, <kbd>>x</kbd>, <kbd>x-y</kbd>, <kbd>>y</kbd></i>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop