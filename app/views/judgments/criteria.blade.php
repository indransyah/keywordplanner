@extends('layouts.master')
@section('content')

<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('judgment', 'Judgment') }}</li>
    <li class="active">Criteria</li>
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
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Criteria Judgments</h1>
<!-- Kriteria -->
@if(count($criteria)<3)
<div class="alert alert-warning square fade in alert-dismissable text-center">
    <strong>Criteria must be at least 3 criteria!</strong>
</div>
@else
<div class="row">
    <div class="col-lg-8">
        {{ Form::open(array('url'=>'pairwisecomparison/process', 'class'=>'form-horizontal')) }}
        <div class="the-box full">
            <div class="table-responsive">
                <table class="table table-info table-hover table-th-block">
                    <thead>
                        <tr>
                            <th>Criteria</th>
                            <th>Jugdment</th>
                            <th>Criteria</th>
                            <th style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($criteria); $i++)
                        @for ($j = $i+1; $j < count($criteria); $j++)
                        <tr>
                            <td id="label|{{ $criteria[$i]->criterion_id.'-'.$criteria[$j]->criterion_id }}">{{ $criteria[$i]->criterion }}</td>
                            <td>{{ Form::select($criteria[$i]->criterion_id.'-'.$criteria[$j]->criterion_id, $options, null, array('class'=>'form-control','id'=>$criteria[$i]->criterion_id.'-'.$criteria[$j]->criterion_id)) }}</td>
                            <td id="label|{{ $criteria[$j]->criterion_id.'-'.$criteria[$i]->criterion_id }}">{{ $criteria[$j]->criterion }}</td>
                            <td class="text-center">
                                <a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Reverse the criterion" onclick="reverse({{$criteria[$i]->criterion_id}},{{$criteria[$j]->criterion_id}})">
                                    <i class="glyphicon glyphicon-transfer"></i>
                                </a>
                            </td>
                        </tr>
                        @endfor
                        @endfor
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-success pull-left"><i class="glyphicon glyphicon-save"></i> Save</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
<script type="text/javascript">
            function reverse(i, j){
            var x = i + "-" + j;
                    var selectName = document.getElementById(i + "-" + j).name;
                    if (x == selectName) {
            document.getElementById(i + "-" + j).name = j + "-" + i;
            } else {
            document.getElementById(i + "-" + j).name = i + "-" + j;
            }
            var tmp = document.getElementById("label|" + i + "-" + j).innerHTML;
                    document.getElementById("label|" + i + "-" + j).innerHTML = document.getElementById("label|" + j + "-" + i).innerHTML;
                    document.getElementById("label|" + j + "-" + i).innerHTML = tmp;
            }
</script>
@endif
<!-- / Kriteria -->
@stop