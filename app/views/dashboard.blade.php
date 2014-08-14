@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li><a href="#fakelink">Home</a></li>
    <li class="active">Dashboard</li>
</ol>
@if(Session::has('success'))
<div class="alert alert-info alert-bold-border fade in alert-dismissable">
    <strong>Welcome {{ Auth::user()->username; }}!</strong>
    {{ Session::get('success') }}
</div>
@endif
@stop