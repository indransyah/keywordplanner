@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>
        {{ HTML::link('home', 'Home') }}
    </li>
    <li>
        {{ HTML::link('user', 'User') }}
    </li>
    <li class="active">Profile</li>
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
<h1 class="page-header" style="margin-top:0;">Profile</h1>
<div class="row">
    <div class="col-lg-6">
        {{ Form::open(array('url'=>'user/profile', 'class'=>'form-horizontal')) }}
        <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                {{ Form::text('name', Auth::user()->name, array('class'=>'form-control', 'placeholder'=>'Name', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                {{ Form::email('email', Auth::user()->email, array('class'=>'form-control', 'placeholder'=>'Email', 'required'=>'true', 'id'=>'email')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
                {{ Form::text('username', Auth::user()->username, array('class'=>'form-control', 'disabled'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i> Change</button>
                {{ HTML::link('user/password', 'Change your password?', array('class'=>'pull-right')) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop