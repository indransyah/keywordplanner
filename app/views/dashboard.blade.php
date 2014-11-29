@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li><a href="#fakelink">Home</a></li>
    <li class="active">{{ Auth::check() ? 'Dashboard' : 'How to Use'}}</li>
</ol>
@if(Session::has('success'))
<div class="alert alert-info alert-bold-border fade in alert-dismissable">
    <strong>Welcome {{ Auth::user()->username; }}!</strong>
    {{ Session::get('success') }}
</div>
@endif
<h1 class="page-header" style="margin-top:0;">How to Use</h1>
<div class="row">
    <div class="col-lg-4">
    	<strong class="text-center">1. Export your keyword from Google AdWords Keyword Planner as a csv file</strong>
        <img style="width:100%;" src="{{ asset('assets/images/download-csv.png')}}">

    	</br>
    	</br>
    	<p class="text-center">
            Find keyword ideas from Google AdWords Keyword Planner Tool and than export them. Exported keywords must be <strong>min 10 keywords</strong> and <strong>just closely related keyword allowed</strong>. 
            {{ HTML::link('help', 'Read more...') }}
    	</p>
    </div>
    <div class="col-lg-4">
    	<strong class="pull-left">2. Import your csv file to this app</strong>
    	</br>
    	</br>
    	<img style="width:100%;" src="{{ asset('assets/images/import.png')}}">
    	</br>
    	</br>
    	<p class="text-center">
    		{{ HTML::link('keyword/import', 'Import your exported csv file') }} from Google AdWords Keyword Planner Tool to this app. Csv file must be a valid csv exported from Google AdWords Keyword Planner Tool.
    	</p>
    </div>
    <div class="col-lg-4">
    	<strong>3. See the keywords result and export them</strong>
    	</br>
    	</br>
    	<img style="width:100%;" src="{{ asset('assets/images/export.png')}}">
    	</br>
    	</br>
    	<p class="text-center">
    		Export the "<i>Recommended Keywords</i>" suggested by this app as a txt file or copy it to your clipboard. Use suggested keywords as your campaign's keywords in the Google AdWords Campaign.
    	</p>
    </div>
</div>

<!-- <h1 class="page-header" style="margin-top:0;">How to get csv file from Keyword Planner</h1>
<div class="row">
    <div class="col-lg-4">
        <strong class="text-center">1. First of all, visit <a>https://adwords.google.com/ko/KeywordPlanner/Home</a> and choose "<i>Search for new keyword and ad group ideas</i>". Enter your keyword in the "<i>your product or service</i>" form!</strong>
        <img style="width:100%;" src="{{ asset('assets/images/guide/keyword-planner/1.png')}}">
        </br>
        </br>
        <strong class="text-center">Change the "<i>Keyword Options</i>" to "<i>Only show ideas closely relate to my search terms</i>".</strong>
        <img style="width:100%;" src="{{ asset('assets/images/guide/keyword-planner/2.png')}}">
    </div>
    <div class="col-lg-4">
        <strong class="text-center">2. In the results, go to "<i>Keyword Ideas</i>" tab.</strong>
        <img style="width:100%;" src="{{ asset('assets/images/guide/keyword-planner/3b.png')}}">
        </br>
        </br>
        <strong class="text-center">Download the keyword with "<i>Download</i>" button.</strong>
        <img style="width:100%;" src="{{ asset('assets/images/guide/keyword-planner/3c.png')}}">
    </div>
    <div class="col-lg-4">
        <strong class="text-center">3. Set to "<i>Excel CSV</i>" and then click "<i>Download</i>" button.</strong>
        <img style="width:100%;" src="{{ asset('assets/images/guide/keyword-planner/4.png')}}">
        </br>
        </br>
        <strong class="text-center">Save file to your computer.</strong>
        <img style="width:100%;" src="{{ asset('assets/images/guide/keyword-planner/5.png')}}">
    </div>
</div> -->
@stop