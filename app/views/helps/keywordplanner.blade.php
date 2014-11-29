@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li><a href="#fakelink">Home</a></li>
    <li class="active">Helps</li>
</ol>
<h1 class="page-header" style="margin-top:0;">How to get csv file from Keyword Planner</h1>
<div class="row">
    <div class="col-lg-4">
        <strong class="text-center">1. First of all, visit <a href="https://adwords.google.com/KeywordPlanner" target="blank">https://adwords.google.com/KeywordPlanner</a> and choose "<i>Search for new keyword and ad group ideas</i>". Enter your keyword in the "<i>your product or service</i>" form!</strong>
        <img style="width:100%;" src="{{ URL::to('assets/images/help/keyword-planner/1a.png')}}">
        </br>
        </br>
        <strong class="text-center">Change the "<i>Keyword Options</i>" to "<i>Only show ideas closely relate to my search terms</i>".</strong>
        <img style="width:100%;" src="{{ URL::to('assets/images/help/keyword-planner/2.png')}}">
    </div>
    <div class="col-lg-4">
        <strong class="text-center">2. In the results, go to "<i>Keyword Ideas</i>" tab.</strong>
        <img style="width:100%;" src="{{ URL::to('assets/images/help/keyword-planner/3b.png')}}">
        </br>
        </br>
        <strong class="text-center">Download the keyword with "<i>Download</i>" button.</strong>
        <img style="width:100%;" src="{{ URL::to('assets/images/help/keyword-planner/3c.png')}}">
    </div>
    <div class="col-lg-4">
        <strong class="text-center">3. Set to "<i>Excel CSV</i>" and then click "<i>Download</i>" button.</strong>
        <img style="width:100%;" src="{{ URL::to('assets/images/help/keyword-planner/4.png')}}">
        </br>
        </br>
        <strong class="text-center">Save file to your computer.</strong>
        <img style="width:100%;" src="{{ URL::to('assets/images/help/keyword-planner/5.png')}}">
    </div>
</div>
@stop