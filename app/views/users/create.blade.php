@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('user', 'User') }}</li>
    <li class="active">Add</li>
</ol>
@if (Session::has('error'))
<div class="alert alert-danger square fade in alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('error') }}</strong>
    {{ HTML::ul($errors->all()) }}
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Add User</h1>
<!-- User -->
<div class="row">
    <div class="col-lg-6">
        {{ Form::open(array('url'=>'user/create', 'class'=>'form-horizontal')) }}
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'User\'s name', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
                {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Username', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'User\'s email', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
               {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password', 'required'=>'true')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password</label>
            <div class="col-sm-10">
                {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Password Confirmation', 'required'=>'true')) }}
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
<!-- / User -->
@stop