@extends('layouts.master')
@section('content')
<ol class="breadcrumb">
    <li>{{ HTML::link('home', 'Home') }}</li>
    <li>{{ HTML::link('keyword', 'Keywords') }}</li>
    <li class="active">Filter</li>
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
<h1 class="page-header" style="margin-top:0;">Filter Keywords</h1>

<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url'=>'keyword/filter', 'class'=>'form-horizontal')) }}
        @foreach ($criteria as $criterion)
        <div class="form-group">
            <label for="field" class="col-sm-3 control-label pull-left">What "<i>{{$criterion->criterion}}</i>" do you want?</label>
            <div class="col-sm-3">
                <?php $default = Session::has('filter.range.'.$criterion->field) ? 'range' : Session::get('filter.type.'.$criterion->field); ?>
                {{ Form::select($criterion->field.'-select', $options[$criterion->criterion], $default, array('id'=>$criterion->field.'-select', 'class'=>'form-control', 'autocomplete'=>'off')) }}
                <div id="{{$criterion->field.'-range'}}" style="display:{{Session::has('filter.range.'.$criterion->field) ? 'true' : 'none'}};margin-top:10px;">
                    {{ Form::text($criterion->field.'-range', Session::get('filter.range.'.$criterion->field), array('class'=>'form-control', 'placeholder'=>'Range')) }}
                    <i><small>Allowed format : </small> <kbd>x</kbd>, <kbd>>x</kbd>, <kbd>x-y</kbd>, <kbd>>y</kbd></i>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $('#{{$criterion->field}}-select').on('change',function(){
                if( $(this).val()==="range"){
                    $("#{{$criterion->field}}-range").show()
                }
                else{
                    $("#{{$criterion->field}}-range").hide()
                }
            });
        </script>
        @endforeach        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-asterisk"></i> Filter</button>
                <!-- <a href="" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Reset</a> -->
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop