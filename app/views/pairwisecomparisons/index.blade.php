@extends('layouts.master')
@section('content')

<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <!-- <li>{{ HTML::link('pairwisecomparison', 'Pairwise Comparisons') }}</li> -->
    <li class="active">Pairwise Comparisons</li>
</ol>
<!-- <h1 class="page-header" style="margin-top:0;">Pairwise Comparisons</h1> -->
<h1 class="page-header" style="margin-top:0;">Criteria</h1>
@if(count($criteria)<3)
<div class="alert alert-warning square fade in alert-dismissable text-center">
    <strong>Criteria must be at least 3 criteria!</strong>
</div>
@else
<div class="row">
    <div class="col-lg-8">
        <div class="the-box full">
            <div class="table-responsive">
                <table class="table table-info table-th-block">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 40%">Criteria</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th style="width: 5%;">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($criteria as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td data-toggle="tooltip" data-placement="top" title="{{ $value->description }}">{{ $value->criterion }}</td>
                            <td class="text-center">
                                <a class="btn {{$value->consistency=='Consistent' ? 'btn-success' : 'btn-danger' }} btn-sm active" data-toggle="tooltip" data-placement="right" title="Subcriteria judgments {{$value->consistency}}">
                                    {{$value->consistency}}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-default btn-sm" href="{{ URL::to('pairwisecomparison/subcriteria/' . $value->criterion_id) }}" data-toggle="tooltip" data-placement="left" title="Show subcriteria judgments">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                        <!-- <i class="glyphicon glyphicon-th-list"></i> -->

                                    </a>
                                    <!-- <a class="btn {{$value->consistency=='Consistent' ? 'btn-success' : 'btn-danger' }} btn-sm active" data-toggle="tooltip" data-placement="right" title="Subcriteria judgments {{$value->consistency}}">
                                        {{$value->consistency}}
                                     </a>-->
                                </div>
                            </td>
                            
                        </tr>
                        @endforeach					
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /.the-box full -->
    </div>
</div>
@endif
@stop