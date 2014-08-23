@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>
        {{ HTML::link('home', 'Home') }}
    </li>
    <li>
        {{ HTML::link('user', 'User') }}
    </li>
    <li class="active">Password</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('error') }}</strong>
    {{ HTML::ul($errors->all()) }}
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Change Password</h1>
<div class="row">
    <div class="col-lg-6">
        {{ Form::open(array('url'=>'user/password', 'class'=>'form-horizontal')) }}
        <div class="form-group">
            <label class="col-sm-4 control-label">Current Password</label>
            <div class="col-sm-8">
                {{ Form::password('current_password', array('class'=>'form-control', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">New Password</label>
            <div class="col-sm-8">
                {{ Form::password('password', array('class'=>'form-control', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Confirm Password</label>
            <div class="col-sm-8">
                {{ Form::password('password_confirmation', array('class'=>'form-control', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i> Change</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop