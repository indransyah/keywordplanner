@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('judgment', 'Judgment') }}</li>
    <li class="active">Subcriteria</li>
</ol>
@if (Session::has('success'))
<div class="alert alert-success square fade in alert-dismissable text-left">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('success') }}</strong>
</div>
@endif
<h1 class="page-header" style="margin-top:0;">Subriteria Judgments</h1>
@if(count($subcriteria)<2)
<div class="alert alert-info alert-bold-border fade in alert-dismissable text-center">
    <strong>Subcriteria must be at least 2 criteria!</strong>
</div>
@else
<div class="row">
    <div class="col-lg-8">
        {{ Form::open(array('url'=>'pairwisecomparison/process/'.$criterion_id, 'class'=>'form-horizontal')) }}
        <div class="the-box full">
            <div class="table-responsive">
                <table class="table table-info table-hover table-th-block">
                    <thead>
                        <tr>
                            <th>Subriteria</th>
                            <th>Jugdment</th>
                            <th>Subriteria</th>
                            <th style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($subcriteria); $i++)
                        @for ($j = $i+1; $j < count($subcriteria); $j++)
                        <tr>
                            <td id="label|{{ $subcriteria[$i]->subcriterion_id.'-'.$subcriteria[$j]->subcriterion_id }}">{{ $subcriteria[$i]->subcriterion }}</td>
                            <td>{{ Form::select($subcriteria[$i]->subcriterion_id.'-'.$subcriteria[$j]->subcriterion_id, $options, null, array('class'=>'form-control','id'=>$subcriteria[$i]->subcriterion_id.'-'.$subcriteria[$j]->subcriterion_id)) }}
                            </td>
                            <td id="label|{{ $subcriteria[$j]->subcriterion_id.'-'.$subcriteria[$i]->subcriterion_id }}">{{ $subcriteria[$j]->subcriterion }}</td>
                            <td class="text-center">
                                <a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Reverse the subcriterion" onclick="reverse({{$subcriteria[$i]->subcriterion_id}},{{$subcriteria[$j]->subcriterion_id}})">
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
@stop